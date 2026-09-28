<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análisis de Protocolo - PlataformaTT</title>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { background-color: #f8fafc; color: #1e293b; padding: 2rem; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 2rem; border-radius: 12px; border: 1px solid #e2e8f0; }
        h1 { color: #0f2c59; font-size: 1.6rem; margin-bottom: 0.5rem; }
        p.subtitle { color: #64748b; font-size: 0.9rem; margin-bottom: 1.5rem; }

        .form-group { margin-bottom: 1.2rem; }
        label { display: block; font-weight: 600; margin-bottom: 0.4rem; font-size: 0.9rem; }
        input[type="file"] { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; }

        .btn-analizar { background-color: #0f2c59; color: white; border: none; padding: 12px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s; }
        .btn-analizar:hover { background-color: #0a1f3f; }

        /* Tarjeta de métricas */
        .metric-card { background: #eff6ff; border: 1px solid #bfdbfe; padding: 1rem; border-radius: 8px; margin-top: 1.5rem; display: flex; justify-content: space-between; align-items: center; }
        .metric-card span { font-size: 0.9rem; color: #1e40af; font-weight: 600; }
        .metric-card strong { font-size: 1.4rem; color: #1e3a8a; }

        /* Layout de resultados */
        .results-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1.5rem; display: none; }
        .chart-box, .academias-box { border: 1px solid #e2e8f0; padding: 1.2rem; border-radius: 8px; background: #fafafa; }
        
        .academia-item { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e2e8f0; font-size: 0.88rem; }
        .academia-item:last-child { border-bottom: none; }
        .badge { background: #dcfce7; color: #166534; font-weight: 700; padding: 2px 8px; border-radius: 12px; font-size: 0.8rem; }
    </style>
</head>
<body>

<div class="container">
    <h1>Prueba de Análisis Semántico (ESCOM IPN)</h1>
    <p class="subtitle">Sube el documento PDF de tu Trabajo Terminal para analizar su contenido con el Transformer.</p>

    <form id="analisisForm">
        <div class="form-group">
            <label for="protocolo_pdf">Selecciona el documento en formato PDF</label>
            <input type="file" id="protocolo_pdf" name="protocolo_pdf" accept=".pdf" required>
        </div>
        <button type="submit" class="btn-analizar">Analizar Documento</button>
    </form>

    <div id="metricBox" class="metric-card" style="display: none;">
        <span>Tiempo de procesamiento del Transformer:</span>
        <strong id="tiempoEjecucion">0 ms</strong>
    </div>

    <div id="resultsGrid" class="results-grid">
        <!-- Gráfica de Tiempo/Afinidad -->
        <div class="chart-box">
            <h3 style="font-size: 1rem; color: #0f2c59; margin-bottom: 1rem;">Afinidad por Academia (%)</h3>
            <canvas id="afinidadChart"></canvas>
        </div>

        <!-- Lista de Academias Sugeridas -->
        <div class="academias-box">
            <h3 style="font-size: 1rem; color: #0f2c59; margin-bottom: 1rem;">Academias Sugeridas para el TT</h3>
            <div id="listaAcademias"></div>
        </div>
    </div>
</div>

<script>
let afinidadChartInstance = null;

document.getElementById('analisisForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const metricBox = document.getElementById('metricBox');
    const resultsGrid = document.getElementById('resultsGrid');
    const tiempoLabel = document.getElementById('tiempoEjecucion');
    const listaAcademias = document.getElementById('listaAcademias');

    metricBox.style.display = 'none';
    resultsGrid.style.display = 'none';

    try {
        const response = await fetch('analizar_pdf.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.error) {
            alert(data.error);
            return;
        }

        // 1. Mostrar Tiempo de Ejecución
        tiempoLabel.innerText = `${data.tiempo_analisis_ms} ms (${(data.tiempo_analisis_ms / 1000).toFixed(2)}s)`;
        metricBox.style.display = 'flex';

        // 2. Llenar Lista de Academias
        listaAcademias.innerHTML = '';
        const labels = [];
        const scores = [];

        data.academias.forEach((item, index) => {
            labels.push(item.academia);
            scores.push(item.porcentaje);

            listaAcademias.innerHTML += `
                <div class="academia-item">
                    <span><strong>${index + 1}.</strong> ${item.academia}</span>
                    <span class="badge">${item.porcentaje}%</span>
                </div>
            `;
        });

        // 3. Renderizar Gráfica
        renderChart(labels, scores);
        resultsGrid.style.display = 'grid';

    } catch (err) {
        alert('Error al conectar con el servidor.');
    }
});

function renderChart(labels, scores) {
    const ctx = document.getElementById('afinidadChart').getContext('2d');

    if (afinidadChartInstance) {
        afinidadChartInstance.destroy();
    }

    afinidadChartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: '% de Similitud Semántica',
                data: scores,
                backgroundColor: 'rgba(15, 44, 89, 0.85)',
                borderColor: '#0f2c59',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            indexAxis: 'y', // Barras horizontales para mejor lectura
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true,
                    max: 100
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
}
</script>

</body>
</html>