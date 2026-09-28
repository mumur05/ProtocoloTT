import Panel from './Panel.jsx';

const TARJETAS = [
  {
    titulo: 'Proyectos Asesorados',
    texto: 'Revisa los avances y solicitudes de los grupos que tienes a tu cargo.',
    href: 'proyectos_asesorados.php',
    accion: 'Ver Proyectos',
  },
  {
    titulo: 'Evaluación de Sinodalías',
    texto: 'Dictamina protocolos y propuestas asignadas como sinodal.',
    href: 'evaluar_trabajos.php',
    accion: 'Evaluar Trabajos',
  },
  {
    titulo: 'Firmas Electrónicas',
    texto: 'Gestiona y firma las actas o liberaciones de Trabajo Terminal de tus alumnos.',
    href: 'firmas_electronicas.php',
    accion: 'Gestionar Firmas',
  },
];

export default function PanelProfesor({ nombre = '' }) {
  return (
    <Panel
      accent="#1e3a8a"
      tituloHeader="PlataformaTT | Panel Docente ESCOM"
      etiquetaUsuario="Profesor(a):"
      nombre={nombre}
      bienvenida={`Bienvenido(a), Prof. ${nombre}`}
      descripcion="Sección de revisión, evaluación y seguimiento de Trabajos Terminales (@ipn.mx)."
      tarjetas={TARJETAS}
    />
  );
}
