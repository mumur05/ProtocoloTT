from fastapi import FastAPI, UploadFile, File
from sentence_transformers import SentenceTransformer, util
from pypdf import PdfReader
import time
import io

app = FastAPI()

print("Cargando modelo Transformer...")
model = SentenceTransformer('paraphrase-multilingual-MiniLM-L12-v2')

# Academias de la ESCOM IPN y sus descriptores temáticos
ACADEMIAS_ESCOM = [
    {
        "academia": "Sistemas Móviles y Web",
        "descripcion": "Desarrollo de aplicaciones móviles Android, iOS, Kotlin, Swift, mapas, geolocalización, APIs REST y plataformas web."
    },
    {
        "academia": "Ingeniería de Software",
        "descripcion": "Metodologías de desarrollo, arquitectura de software, calidad, patrones de diseño y gestión de proyectos."
    },
    {
        "academia": "Inteligencia Artificial",
        "descripcion": "Machine learning, redes neuronales, aprendizaje profundo, procesamiento de lenguaje natural, visión por computadora y minería de datos."
    },
    {
        "academia": "Sistemas Distribuidos",
        "descripcion": "Redes de computadoras, cloud computing, ciberseguridad, protocolos de comunicación y sistemas operativos."
    },
    {
        "academia": "Sistemas Digitales y Microelectrónica",
        "descripcion": "Sistemas embebidos, Internet de las Cosas (IoT), microcontroladores, robótica y arquitectura de computadoras."
    },
    {
        "academia": "Ciencias de la Computación",
        "descripcion": "Algoritmos avanzados, estructuras de datos, optimización matemática, teoría de grafos y computación gráfica."
    }
]

@app.post("/analizar_documento")
async def analizar_documento(file: UploadFile = File(...)):
    start_time = time.perf_counter()

    # 1. Leer PDF
    pdf_bytes = await file.read()
    pdf_reader = PdfReader(io.BytesIO(pdf_bytes))
    
    texto_pdf = ""
    for page in pdf_reader.pages[:3]: # Primeras 3 páginas
        texto_pdf += page.extract_text() or ""

    if not texto_pdf.strip():
        return {"error": "No se pudo extraer texto del documento."}

    # 2. Vectorización y cálculo de similitud con el Transformer
    embedding_pdf = model.encode(texto_pdf, convert_to_tensor=True)
    textos_academias = [a["descripcion"] for a in ACADEMIAS_ESCOM]
    embeddings_academias = model.encode(textos_academias, convert_to_tensor=True)

    scores = util.cos_sim(embedding_pdf, embeddings_academias)[0]

    # 3. Mapear resultados
    resultados = []
    for score, academia in zip(scores, ACADEMIAS_ESCOM):
        resultados.append({
            "academia": academia["academia"],
            "porcentaje": round(float(score) * 100, 2)
        })

    # Ordenar de mayor a menor afinidad
    resultados.sort(key=lambda x: x["porcentaje"], reverse=True)

    end_time = time.perf_counter()
    tiempo_ms = round((end_time - start_time) * 1000, 2) # Tiempo en ms

    return {
        "tiempo_analisis_ms": tiempo_ms,
        "academias": resultados
    }