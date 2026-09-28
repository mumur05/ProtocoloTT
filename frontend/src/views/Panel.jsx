import styles from './Panel.module.css';

export default function Panel({ accent, tituloHeader, etiquetaUsuario, nombre, bienvenida, descripcion, tarjetas }) {
  return (
    <div className={styles.body} style={{ '--accent': accent }}>
      <header className={styles.header}>
        <h1>{tituloHeader}</h1>
        <div className={styles.userInfo}>
          {etiquetaUsuario} <strong>{nombre}</strong>
          <a href="logout.php">Cerrar Sesi&oacute;n</a>
        </div>
      </header>

      <div className={styles.container}>
        <div className={styles.welcomeCard}>
          <h2>{bienvenida}</h2>
          <p>{descripcion}</p>
        </div>

        <div className={styles.grid}>
          {tarjetas.map((t) => (
            <div className={styles.card} key={t.titulo}>
              <h3>{t.titulo}</h3>
              <p>{t.texto}</p>
              <a href={t.href} className={styles.btn}>
                {t.accion}
              </a>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}
