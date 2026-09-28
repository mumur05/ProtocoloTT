import SplitLayout from '../components/SplitLayout.jsx';
import styles from './Inicio.module.css';

export default function Inicio() {
  return (
    <SplitLayout>
      <div className={styles.menuContainer}>
        <p className={styles.tagline}>Gesti&oacute;n de Trabajo Terminal</p>
        <h1 className={styles.welcomeTitle}>INICIO</h1>
        <p className={styles.description}>Selecciona una opci&oacute;n para acceder a la plataforma.</p>

        <div className={styles.actionsGroup}>
          <a href="iniciarSesion.html" className={`${styles.btnAction} ${styles.btnLogin}`}>
            Iniciar sesi&oacute;n
          </a>
          <a href="registro.html" className={`${styles.btnAction} ${styles.btnRegister}`}>
            Registrarse
          </a>
        </div>
      </div>
    </SplitLayout>
  );
}
