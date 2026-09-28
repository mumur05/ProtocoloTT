import SubPagina, { Panel, EstadoVacio, subStyles as s } from '../components/SubPagina.jsx';

export default function ProyectosAsesorados({ nombre = '' }) {
  return (
    <SubPagina
      accent="#1e3a8a"
      tituloHeader="PlataformaTT | Panel Docente ESCOM"
      etiquetaUsuario="Profesor(a):"
      nombre={nombre}
      volverHref="inicio_profesor.php"
      titulo={'Proyectos Asesorados'}
      descripcion={
        'Grupos de Trabajo Terminal que diriges. Desde aquí podras revisar avances, dejar observaciones y atender solicitudes.'
      }
    >
      <Panel titulo="Solicitudes de asesoría">
        <EstadoVacio
          titulo={'No tienes solicitudes pendientes'}
          detalle={'Cuando un equipo te proponga como director de TT, la solicitud llegara aquí.'}
        />
      </Panel>

      <Panel titulo="Proyectos activos">
        <table className={s.tabla}>
          <thead>
            <tr>
              <th>Proyecto</th>
              <th>Integrantes</th>
              <th>Periodo</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colSpan={4} style={{ padding: 0, borderBottom: 'none' }}>
                <EstadoVacio
                  titulo={'Sin proyectos asignados'}
                  detalle={'Los trabajos que dirijas se listaran en esta tabla.'}
                />
              </td>
            </tr>
          </tbody>
        </table>
      </Panel>
    </SubPagina>
  );
}
