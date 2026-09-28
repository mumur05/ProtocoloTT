import Panel from './Panel.jsx';

const TARJETAS = [
  {
    titulo: 'Registrar Protocolo TT',
    texto: 'Registra el título, resumen y los integrantes de tu proyecto de Trabajo Terminal.',
    href: 'registrar_protocolo.php',
    accion: 'Comenzar Registro',
  },
  {
    titulo: 'Subir Documentación',
    texto: 'Carga reportes de avance y entregables en formato PDF.',
    href: 'subir_documentos.php',
    accion: 'Ver Archivos',
  },
  {
    titulo: 'Estado del Expediente',
    texto:
      'Consulta las observaciones y evaluaciones realizadas por tus asesores o sinodales.',
    href: 'estado_expediente.php',
    accion: 'Consultar Estatus',
  },
];

export default function PanelAlumno({ nombre = '' }) {
  return (
    <Panel
      accent="#0f2c59"
      tituloHeader="PlataformaTT | ESCOM"
      etiquetaUsuario="Alumno:"
      nombre={nombre}
      bienvenida={`Bienvenido, ${nombre}`}
      descripcion="Sección de gestión de Trabajo Terminal para Alumnos (@alumno.ipn.mx)."
      tarjetas={TARJETAS}
    />
  );
}
