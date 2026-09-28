import { useState } from 'react';
import SplitLayout from '../components/SplitLayout.jsx';
import styles from './Registro.module.css';

const CONFIG_ROL = {
  alumno: {
    labelIdentificador: 'Boleta',
    nameIdentificador: 'boleta',
    placeholderIdentificador: 'Ej. 2026630077',
    patternIdentificador: '\\d{10}',
    placeholderCorreo: 'usuario@alumno.ipn.mx',
    dominio: '@alumno.ipn.mx',
  },
  profesor: {
    labelIdentificador: 'Número de Empleado',
    nameIdentificador: 'num_empleado',
    placeholderIdentificador: 'Ej. 2012098765',
    patternIdentificador: undefined,
    placeholderCorreo: 'usuario@ipn.mx',
    dominio: '@ipn.mx',
  },
};

export default function Registro() {
  const [rol, setRol] = useState('alumno');
  const [correo, setCorreo] = useState('');
  const [error, setError] = useState('');

  const cfg = CONFIG_ROL[rol];

  function switchRole(nuevoRol) {
    setRol(nuevoRol);
    setError('');
  }

  function validateEmailDomain(e) {
    const email = correo.trim().toLowerCase();

    if (rol === 'alumno' && !email.endsWith('@alumno.ipn.mx')) {
      e.preventDefault();
      setError(
        'Como alumno, debes ingresar un correo institucional válido terminado en @alumno.ipn.mx'
      );
      return;
    }

    if (rol === 'profesor' && (!email.endsWith('@ipn.mx') || email.endsWith('@alumno.ipn.mx'))) {
      e.preventDefault();
      setError(
        'Como profesor, debes ingresar un correo institucional válido terminado en @ipn.mx'
      );
      return;
    }

    setError('');
  }

  return (
    <SplitLayout
      quoteSize="1.5rem"
      quoteWidth="480px"
      quoteLineHeight="1.6"
      gridColor="rgba(255, 255, 255, 0.02)"
      gridSize="40px"
      footerColor="#5a6a85"
      rightPadding="2.5rem 4rem"
      rightOverflow="auto"
    >
      <div className={styles.formContainer}>
        <p className={styles.tagline}>Nuevo Expediente</p>
        <h1 className={styles.welcomeTitle}>REGISTRO USUARIO</h1>

        <div className={styles.roleTabs}>
          <button
            type="button"
            className={`${styles.tabBtn} ${rol === 'alumno' ? styles.tabBtnActive : ''}`}
            onClick={() => switchRole('alumno')}
          >
            Alumno
          </button>
          <button
            type="button"
            className={`${styles.tabBtn} ${rol === 'profesor' ? styles.tabBtnActive : ''}`}
            onClick={() => switchRole('profesor')}
          >
            Profesor
          </button>
        </div>

        {error && <div className={styles.errorToast}>{error}</div>}

        <form action="registrar.php" method="POST" onSubmit={validateEmailDomain}>
          <input type="hidden" name="rol" value={rol} />

          <div className={styles.rowGridNames}>
            <div className={styles.formGroup}>
              <label className={styles.inputLabel} htmlFor="nombre">
                Nombre
              </label>
              <input
                className={styles.inputField}
                type="text"
                id="nombre"
                name="nombre"
                placeholder="Tu(s) nombre(s)"
                required
              />
            </div>
            <div className={styles.formGroup}>
              <label className={styles.inputLabel} htmlFor="apellido_pat">
                Apellido pat
              </label>
              <input
                className={styles.inputField}
                type="text"
                id="apellido_pat"
                name="apellido_paterno"
                placeholder="Paterno"
                required
              />
            </div>
            <div className={styles.formGroup}>
              <label className={styles.inputLabel} htmlFor="apellido_mat">
                Apellido mat
              </label>
              <input
                className={styles.inputField}
                type="text"
                id="apellido_mat"
                name="apellido_materno"
                placeholder="Materno"
              />
            </div>
          </div>

          <div className={styles.formGroup}>
            <label className={styles.inputLabel} htmlFor="identificador">
              {cfg.labelIdentificador}
            </label>
            <input
              className={styles.inputField}
              type="text"
              id="identificador"
              name={cfg.nameIdentificador}
              pattern={cfg.patternIdentificador}
              maxLength={10}
              placeholder={cfg.placeholderIdentificador}
              required
            />
          </div>

          <div className={styles.formGroup}>
            <label className={styles.inputLabel} htmlFor="correo">
              Correo institucional
            </label>
            <input
              className={styles.inputField}
              type="email"
              id="correo"
              name="correo_institucional"
              placeholder={cfg.placeholderCorreo}
              value={correo}
              onChange={(e) => setCorreo(e.target.value)}
              required
            />
            <span className={styles.emailDomainHint}>
              Dominio requerido: <strong>{cfg.dominio}</strong>
            </span>
          </div>

          <div className={styles.formGroup}>
            <label className={styles.inputLabel} htmlFor="usuario">
              Usuario
            </label>
            <input
              className={styles.inputField}
              type="text"
              id="usuario"
              name="usuario"
              placeholder="Crea un usuario &uacute;nico"
              required
            />
          </div>

          <div className={styles.formGroup}>
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
          </div>

          <div className={styles.buttonsGroup}>
            <button type="submit" className={styles.btnSubmit}>
              Registrar
            </button>
            <a href="inicio.html" className={styles.btnBack}>
              Regresar al Inicio
            </a>
          </div>
        </form>
      </div>
    </SplitLayout>
  );
}
