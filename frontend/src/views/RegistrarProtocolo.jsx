import { useEffect, useRef, useState } from 'react';
import Chart from 'chart.js/auto';
import styles from './RegistrarProtocolo.module.css';

export default function RegistrarProtocolo() {
  const [resultado, setResultado] = useState(null);
  const canvasRef = useRef(null);
  const chartRef = useRef(null);

  useEffect(() => {
    if (!resultado || !canvasRef.current) return;

    chartRef.current?.destroy();
    chartRef.current = new Chart(canvasRef.current.getContext('2d'), {
      type: 'bar',
      data: {
        labels: resultado.academias.map((a) => a.academia),
        datasets: [
          {
            label: '% de Similitud Semántica',
            data: resultado.academias.map((a) => a.porcentaje),
            backgroundColor: 'rgba(15, 44, 89, 0.85)',
            borderColor: '#0f2c59',
            borderWidth: 1,
            borderRadius: 6,
          },
        ],
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        scales: { x: { beginAtZero: true, max: 100 } },
        plugins: { legend: { display: false } },
      },
    });

    return () => {
      chartRef.current?.destroy();
      chartRef.current = null;
    };
  }, [resultado]);

  async function handleSubmit(e) {
    e.preventDefault();
    const formData = new FormData(e.currentTarget);
    setResultado(null);

    try {
      const response = await fetch('analizar_pdf.php', { method: 'POST', body: formData });
      const data = await response.json();

      if (data.error) {
        alert(data.error);
        return;
      }

      setResultado(data);
    } catch (err) {
      alert('Error al conectar con el servidor.');
    }
  }

  return (
    <div className={styles.body}>
      <div className={styles.container}>
        <h1 className={styles.title}>Prueba de An&aacute;lisis Sem&aacute;ntico (ESCOM IPN)</h1>
        <p className={styles.subtitle}>
          Sube el documento PDF de tu Trabajo Terminal para analizar su contenido con el
          Transformer.
        </p>

        <form onSubmit={handleSubmit}>
          <div className={styles.formGroup}>
            <label htmlFor="protocolo_pdf">Selecciona el documento en formato PDF</label>
            <input
              className={styles.fileInput}
              type="file"
              id="protocolo_pdf"
              name="protocolo_pdf"
              accept=".pdf"
              required
            />
          </div>
          <button type="submit" className={styles.btnAnalizar}>
            Analizar Documento
          </button>
        </form>

        {resultado && (
          <>
            <div className={styles.metricCard}>
              <span>Tiempo de procesamiento del Transformer:</span>
              <strong>
                {resultado.tiempo_analisis_ms} ms (
                {(resultado.tiempo_analisis_ms / 1000).toFixed(2)}s)
              </strong>
            </div>

            <div className={styles.resultsGrid}>
              <div className={styles.chartBox}>
                <h3 className={styles.boxTitle}>Afinidad por Academia (%)</h3>
                <canvas ref={canvasRef}></canvas>
              </div>

              <div className={styles.academiasBox}>
                <h3 className={styles.boxTitle}>Academias Sugeridas para el TT</h3>
                <div>
                  {resultado.academias.map((item, index) => (
                    <div className={styles.academiaItem} key={item.academia}>
                      <span>
                        <strong>{index + 1}.</strong> {item.academia}
                      </span>
                      <span className={styles.badge}>{item.porcentaje}%</span>
                    </div>
                  ))}
                </div>
              </div>
            </div>
          </>
        )}
      </div>
    </div>
  );
}
