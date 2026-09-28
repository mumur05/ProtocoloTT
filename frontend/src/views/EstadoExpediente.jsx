import SubPagina, { Panel, EstadoVacio, subStyles as s } from '../components/SubPagina.jsx';

const ETAPAS = [
  { etapa: 'Registro de protocolo', responsable: 'Alumno', estado: 'Pendiente', chip: s.chipPendiente },
  { etapa: 'Asignación de academia', responsable: 'Coordinación', estado: 'Pendiente', chip: s.chipPendiente },
  { etapa: 'Dictamen de sinodales', responsable: 'Sinodales', estado: 'Pendiente', chip: s.chipPendiente },
  { etapa: 'Liberación de TT1', responsable: 'Director de TT', estado: 'Pendiente', chip: s.chipPendiente },
  { etapa: 'Liberación de TT2', responsable: 'Director de TT', estado: 'Pendiente', chip: s.chipPendiente },
];

export default function EstadoExpediente({ nombre = '' }) {
  return (
    <SubPagina
      accent="#0f2c59"
      tituloHeader="PlataformaTT | ESCOM"
      etiquetaUsuario="Alumno:"
      nombre={nombre}
      volverHref="inicio_alumno.php"
      titulo={'Estado del Expediente'}
      descripcion={
        'Sigue el avance de tu Trabajo Terminal etapa por etapa y consulta las observaciones de tus asesores y sinodales.'
      }
    >
      <Panel titulo="Avance del proceso">
        <table className={s.tabla}>
          <thead>
            <tr>
              <th>Etapa</th>
              <th>Responsable</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody>
            {ETAPAS.map((e) => (
              <tr key={e.etapa}>
                <td>{e.etapa}</td>
                <td>{e.responsable}</td>
                <td>
                  <span className={`${s.chip} ${e.chip}`}>{e.estado}</span>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </Panel>

      <Panel titulo="Datos del Trabajo Terminal">
        <EstadoVacio
          titulo={'Todavía no has registrado un protocolo'}
          detalle={'Cuando lo registres, aquí apareceran el título, los integrantes y la academia asignada.'}
        />
      </Panel>

      <Panel titulo="Observaciones recibidas">
        <EstadoVacio
          titulo={'Sin observaciones por ahora'}
          detalle={'Los comentarios de asesores y sinodales se mostraran en esta sección.'}
        />
      </Panel>
    </SubPagina>
  );
}
