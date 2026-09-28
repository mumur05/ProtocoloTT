import SplitLayout from '../components/SplitLayout.jsx';
import styles from './ValidarToken.module.css';

const ERRORES = {
  invalido: 'El código ingresado es incorrecto.',
  expirado: 'El código ha expirado. Registrate nuevamente.',
};

export default function ValidarToken({ correoDestino = '', exito = false, error = null }) {
  const mensajeError = ERRORES[error];

  const modal = exito ? (
    <div className={styles.modalOverlay}>
      <div className={styles.modalBox}>
        <div className={styles.iconCircle}>&#10003;</div>
        <h2 className={styles.modalTitle}>&iexcl;Correo Autenticado!</h2>
        <p className={styles.modalDesc}>
          Tu cuenta ha sido verificada con &eacute;xito. Ya puedes iniciar sesi&oacute;n con tus
          credenciales.
        </p>
        <a href="iniciarSesion.html" className={styles.btnLogin}>
          Iniciar Sesi&oacute;n
        </a>
      </div>
    </div>
  ) : null;

  return (
    <SplitLayout
      quote={
        '"Confirmación de seguridad para la habilitación de firma electrónica y seguimiento de expediente."'
      }
      quoteSize="1.4rem"
      showGrid={false}
      footerColor="#5a6a85"
      footerSpacing="normal"
      rightPadding="2.5rem"
      overlay={modal}
    >
      <div className={styles.formContainer}>
        <p className={styles.tagline}>Seguridad</p>
        <h1 className={styles.welcomeTitle}>C&Oacute;DIGO DE VERIFICACI&Oacute;N</h1>
        <p className={styles.infoText}>
          Ingresa el c&oacute;digo registrado para:
          <br />
          <strong>{correoDestino}</strong>
        </p>

        {mensajeError && <div className={styles.alertError}>{mensajeError}</div>}

        <form action="verificar_token.php" method="POST">
          <input
            className={styles.tokenInput}
            type="text"
            name="token"
            maxLength={6}
            pattern="\d{6}"
            placeholder="000000"
            required
            autoFocus
            autoComplete="off"
          />
          <button type="submit" className={styles.btnSubmit}>
            Verificar C&oacute;digo
          </button>
        </form>
      </div>
    </SplitLayout>
  );
}
