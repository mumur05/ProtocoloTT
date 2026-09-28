import SplitLayout from '../components/SplitLayout.jsx';
import styles from './IniciarSesion.module.css';

const ERRORES = {
  credenciales: 'El usuario o la contraseña son incorrectos.',
  campos_vacios: 'Por favor, llena todos los campos.',
};

export default function IniciarSesion() {
  const error = new URLSearchParams(window.location.search).get('error');
  const mensajeError = ERRORES[error];

  return (
    <SplitLayout>
      <div className={styles.formContainer}>
        <p className={styles.tagline}>Acceso Institucional</p>
        <h1 className={styles.welcomeTitle}>BIENVENIDO</h1>
        <p className={styles.description}>Ingresa con tus credenciales para visualizar tu proceso.</p>

        {mensajeError && <div className={styles.alertError}>{mensajeError}</div>}

        <form action="login.php" method="POST">
          <label className={styles.inputLabel} htmlFor="usuario">
            Usuario o Correo Institucional
          </label>
          <input
            className={styles.inputField}
            type="text"
            id="usuario"
            name="usuario"
            placeholder="harumijm o usuario@ipn.mx"
            required
          />

          <label className={styles.inputLabel} htmlFor="password">
            Contrase&ntilde;a
          </label>
          <input
            className={styles.inputField}
            type="password"
            id="password"
            name="contrasena"
            placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;"
            required
          />

          <div className={styles.buttonsGroup}>
            <button type="submit" className={styles.btnSubmit}>
              Iniciar sesi&oacute;n
            </button>
            <a href="inicio.html" className={styles.btnBack}>
              Regresar al Inicio
            </a>
          </div>
        </form>

        <div className={styles.registerLink}>
          &iquest;No tienes una cuenta? <a href="registro.html">reg&iacute;strate aqu&iacute;</a>
        </div>
      </div>
    </SplitLayout>
  );
}
