import SubPagina, { Panel, EstadoVacio, subStyles as s } from '../components/SubPagina.jsx';

const DOCUMENTOS = [
  { documento: 'Acta de registro de protocolo', rol: 'Director de TT' },
  { documento: 'Dictamen de sinodal', rol: 'Sinodal' },
  { documento: 'Liberación de TT1', rol: 'Director de TT' },
  { documento: 'Liberación de TT2', rol: 'Director de TT' },
];

export default function FirmasElectronicas({ nombre = '' }) {
  return (
    <SubPagina
      accent="#1e3a8a"
      tituloHeader="PlataformaTT | Panel Docente ESCOM"
      etiquetaUsuario="Profesor(a):"
      nombre={nombre}
      volverHref="inicio_profesor.php"
      titulo={'Firmas Electrónicas'}
      descripcion={
        'Gestiona tu firma electrónica y atiende las actas y liberaciones de Trabajo Terminal que requieren tu validación.'
      }
    >
      <Panel titulo="Estado de tu firma">
        <EstadoVacio
          titulo={'No has registrado una firma electrónica'}
          detalle={'Necesitaras registrarla antes de poder validar actas.'}
        />
        <div style={{ marginTop: '1.2rem', textAlign: 'center' }}>
          <button type="button" className={s.btn} disabled>
            Registrar firma
          </button>
        </div>
      </Panel>

      <Panel titulo="Documentos por firmar">
        <EstadoVacio
          titulo={'No hay documentos esperando tu firma'}
          detalle={'Las actas apareceran aquí conforme avancen los trabajos que diriges.'}
        />
      </Panel>

      <Panel titulo="Documentos que puedes firmar según tu rol">
        <table className={s.tabla}>
          <thead>
            <tr>
              <th>Documento</th>
              <th>Rol requerido</th>
            </tr>
          </thead>
          <tbody>
            {DOCUMENTOS.map((d) => (
              <tr key={d.documento}>
                <td>{d.documento}</td>
                <td>
                  <span className={s.chip}>{d.rol}</span>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </Panel>
    </SubPagina>
  );
}
