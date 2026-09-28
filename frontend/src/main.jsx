import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';

import './styles/global.css';

import Inicio from './views/Inicio.jsx';
import IniciarSesion from './views/IniciarSesion.jsx';
import Registro from './views/Registro.jsx';
import ValidarToken from './views/ValidarToken.jsx';
import PanelAlumno from './views/PanelAlumno.jsx';
import PanelProfesor from './views/PanelProfesor.jsx';
import RegistrarProtocolo from './views/RegistrarProtocolo.jsx';
import SubirDocumentos from './views/SubirDocumentos.jsx';
import EstadoExpediente from './views/EstadoExpediente.jsx';
import ProyectosAsesorados from './views/ProyectosAsesorados.jsx';
import EvaluarTrabajos from './views/EvaluarTrabajos.jsx';
import FirmasElectronicas from './views/FirmasElectronicas.jsx';

const VIEWS = {
  inicio: Inicio,
  iniciarSesion: IniciarSesion,
  registro: Registro,
  validarToken: ValidarToken,
  panelAlumno: PanelAlumno,
  panelProfesor: PanelProfesor,
  registrarProtocolo: RegistrarProtocolo,
  subirDocumentos: SubirDocumentos,
  estadoExpediente: EstadoExpediente,
  proyectosAsesorados: ProyectosAsesorados,
  evaluarTrabajos: EvaluarTrabajos,
  firmasElectronicas: FirmasElectronicas,
};

const container = document.getElementById('root');
const View = VIEWS[container.dataset.view];

// Datos que el PHP inyecta en la pagina (sesion, flags de exito, etc.)
const dataTag = document.getElementById('php-data');
const props = dataTag ? JSON.parse(dataTag.textContent) : {};

createRoot(container).render(
  <StrictMode>
    <View {...props} />
  </StrictMode>
);
