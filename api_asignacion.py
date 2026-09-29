from fastapi import FastAPI, UploadFile, File
from sentence_transformers import SentenceTransformer, util
from pypdf import PdfReader
import time
import io
import re

from glosario_academias import ACADEMIAS_ESCOM

app = FastAPI()

print("Cargando modelo Transformer...")
model = SentenceTransformer('paraphrase-multilingual-MiniLM-L12-v2')

# El modelo solo lee 128 tokens por texto, así que el protocolo se divide en
# fragmentos de pocas palabras (con traslape) para que no se ignore nada.
PALABRAS_POR_FRAGMENTO = 70
TRASLAPE_PALABRAS = 20
PAGINAS_A_LEER = 5
# Cuántos fragmentos (los más afines) se promedian para calificar cada academia;
# en textos cortos se usan menos para que la portada no pese igual que el contenido
FRAGMENTOS_TOP = 3

# Cada frase del glosario (descripción + temas) se vectoriza una sola vez al
# arrancar; frase_academia[i] indica a qué academia pertenece la frase i.
frases_glosario = []
frase_academia = []
for idx, academia in enumerate(ACADEMIAS_ESCOM):
    for frase in [academia["descripcion"], *academia["temas"]]:
        frases_glosario.append(frase)
        frase_academia.append(idx)

print(f"Vectorizando glosario ({len(frases_glosario)} frases, {len(ACADEMIAS_ESCOM)} academias)...")
embeddings_glosario = model.encode(frases_glosario, convert_to_tensor=True, normalize_embeddings=True)


# Texto de portada que aparece en todos los protocolos y no aporta al tema
TEXTO_INSTITUCIONAL = re.compile(
    r"instituto polit[eé]cnico nacional|escuela superior de c[oó]mputo|\bescom\b|\bipn\b"
    r"|ciudad de m[eé]xico|\bcdmx\b|m[eé]xico|trabajo terminal|protocolo",
    re.IGNORECASE,
)


def dividir_en_fragmentos(texto):
    texto = TEXTO_INSTITUCIONAL.sub(" ", texto)
    palabras = re.sub(r"\s+", " ", texto).strip().split(" ")
    paso = PALABRAS_POR_FRAGMENTO - TRASLAPE_PALABRAS
    fragmentos = []
    for inicio in range(0, len(palabras), paso):
        fragmento = palabras[inicio:inicio + PALABRAS_POR_FRAGMENTO]
        if len(fragmento) >= 8 or not fragmentos:  # descarta colas muy cortas
            fragmentos.append(" ".join(fragmento))
        if inicio + PALABRAS_POR_FRAGMENTO >= len(palabras):
            break
    return fragmentos


@app.post("/analizar_documento")
async def analizar_documento(file: UploadFile = File(...)):
    start_time = time.perf_counter()

    # 1. Leer PDF
    pdf_bytes = await file.read()
    pdf_reader = PdfReader(io.BytesIO(pdf_bytes))

    texto_pdf = ""
    for page in pdf_reader.pages[:PAGINAS_A_LEER]:
        texto_pdf += (page.extract_text() or "") + "\n"

    if not texto_pdf.strip():
        return {"error": "No se pudo extraer texto del documento."}

    # 2. Vectorizar fragmentos y compararlos contra cada frase del glosario
    fragmentos = dividir_en_fragmentos(texto_pdf)
    embeddings_fragmentos = model.encode(fragmentos, convert_to_tensor=True, normalize_embeddings=True)
    similitudes = util.cos_sim(embeddings_fragmentos, embeddings_glosario)  # [fragmentos x frases]

    # 3. Calificar cada academia: por fragmento se toma su frase más afín y
    #    luego se promedian los fragmentos con mejor puntaje
    k = max(1, min(FRAGMENTOS_TOP, len(fragmentos) // 3))
    resultados = []
    for idx, academia in enumerate(ACADEMIAS_ESCOM):
        columnas = [i for i, a in enumerate(frase_academia) if a == idx]
        mejor_por_fragmento = similitudes[:, columnas].max(dim=1).values
        score = mejor_por_fragmento.topk(k).values.mean()
        resultados.append({
            "academia": academia["academia"],
            "carreras": academia["carreras"],
            "porcentaje": round(max(float(score), 0.0) * 100, 2)
        })

    # Ordenar de mayor a menor afinidad
    resultados.sort(key=lambda x: x["porcentaje"], reverse=True)

    end_time = time.perf_counter()
    tiempo_ms = round((end_time - start_time) * 1000, 2) # Tiempo en ms

    return {
        "tiempo_analisis_ms": tiempo_ms,
        "academias": resultados
    }
