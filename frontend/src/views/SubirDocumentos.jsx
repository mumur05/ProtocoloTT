import SubPagina, { Panel, EstadoVacio, subStyles as s } from '../components/SubPagina.jsx';

const ENTREGABLES = [
  { nombre: 'Protocolo de Trabajo Terminal', periodo: 'TT1', estado: 'Pendiente' },
  { nombre: 'Reporte de avance 1', periodo: 'TT1', estado: 'Pendiente' },
  { nombre: 'Reporte de avance 2', periodo: 'TT2', estado: 'Pendiente' },
  { nombre: 'Reporte final', periodo: 'TT2', estado: 'Pendiente' },
];

export default function SubirDocumentos({ nombre = '' }) {
  return (
    <SubPagina
      accent="#0f2c59"
      tituloHeader="PlataformaTT | ESCOM"
      etiquetaUsuario="Alumno:"
      nombre={nombre}
      volverHref="inicio_alumno.php"
      titulo={'Subir Documentación'}
      descripcion={
        'Carga aquí los entregables de tu Trabajo Terminal en formato PDF. Cada archivo queda registrado en tu expediente con fecha y hora.'
      }
    >
      <Panel titulo="Cargar un archivo">
        <div className={s.vacio}>
          <strong>Arrastra un PDF o selecci&oacute;nalo desde tu equipo</strong>
          <span>Tama&ntilde;o m&aacute;ximo sugerido: 20 MB</span>
          <div style={{ marginTop: '1.2rem' }}>
            <button type="button" className={s.btn} disabled>
              Seleccionar archivo
            </button>
          </div>
        </div>
      </Panel>

      <Panel titulo="Entregables del programa">
        <table className={s.tabla}>
          <thead>
            <tr>
              <th>Entregable</th>
              <th>Periodo</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody>
            {ENTREGABLES.map((e) => (
              <tr key={e.nombre}>
                <td>{e.nombre}</td>
                <td>{e.periodo}</td>
                <td>
                  <span className={`${s.chip} ${s.chipPendiente}`}>{e.estado}</span>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </Panel>

      <Panel titulo="Archivos cargados">
        <EstadoVacio
          titulo="A&uacute;n no has subido ning&uacute;n documento"
          detalle="Los archivos que cargues apareceran en esta lista."
        />
      </Panel>
    </SubPagina>
  );
}
