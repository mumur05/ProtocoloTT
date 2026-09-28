import SubPagina, { Panel, EstadoVacio, subStyles as s } from '../components/SubPagina.jsx';

const CRITERIOS = [
  'Planteamiento del problema y justificación',
  'Objetivos y alcance',
  'Estado del arte',
  'Metodología propuesta',
  'Viabilidad técnica y cronograma',
];

export default function EvaluarTrabajos({ nombre = '' }) {
  return (
    <SubPagina
      accent="#1e3a8a"
      tituloHeader="PlataformaTT | Panel Docente ESCOM"
      etiquetaUsuario="Profesor(a):"
      nombre={nombre}
      volverHref="inicio_profesor.php"
      titulo={'Evaluación de Sinodalías'}
      descripcion={
        'Protocolos y propuestas que te fueron asignados como sinodal. Cada dictamen queda registrado en el expediente del equipo.'
      }
    >
      <Panel titulo="Pendientes de dictamen">
        <EstadoVacio
          titulo={'No tienes protocolos por evaluar'}
          detalle={'La coordinación te asignara trabajos según la academia de cada proyecto.'}
        />
      </Panel>

      <Panel titulo="Criterios de evaluación">
        <table className={s.tabla}>
          <thead>
            <tr>
              <th>Criterio</th>
              <th>Dictamen</th>
            </tr>
          </thead>
          <tbody>
            {CRITERIOS.map((c) => (
              <tr key={c}>
                <td>{c}</td>
                <td>
                  <span className={s.chip}>Sin evaluar</span>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </Panel>

      <Panel titulo="Historial de dictamenes">
        <EstadoVacio
          titulo={'Aún no has emitido dictamenes'}
          detalle={'Los trabajos que evalues quedaran registrados aquí.'}
        />
      </Panel>
    </SubPagina>
  );
}
