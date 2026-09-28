import styles from './SubPagina.module.css';

export { styles as subStyles };

export function EstadoVacio({ titulo, detalle }) {
  return (
    <div className={styles.vacio}>
      <strong>{titulo}</strong>
      <span>{detalle}</span>
    </div>
  );
}

export function Panel({ titulo, children }) {
  return (
    <section className={styles.panel}>
      {titulo && <h2 className={styles.panelTitulo}>{titulo}</h2>}
      {children}
    </section>
  );
}

export default function SubPagina({
  accent,
  tituloHeader,
  etiquetaUsuario,
  nombre,
  volverHref,
  titulo,
  descripcion,
  acciones,
  children,
}) {
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
        <a href={volverHref} className={styles.volver}>
          &larr; Volver al panel
        </a>

        <div className={styles.titleRow}>
          <h2 className={styles.titulo}>{titulo}</h2>
          {acciones}
        </div>
        <p className={styles.descripcion}>{descripcion}</p>

        <div className={styles.aviso}>
          Vista preliminar. La funcionalidad de esta secci&oacute;n a&uacute;n no est&aacute;
          conectada a la base de datos.
        </div>

        {children}
      </div>
    </div>
  );
}
