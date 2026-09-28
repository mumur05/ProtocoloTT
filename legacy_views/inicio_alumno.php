<?php
session_start();

// Verificar autenticación
if (!isset($_SESSION['usuario_id'])) {
    header("Location: iniciarSesion.html");
    exit();
}

// Validar que sea alumno por el dominio del correo
if (!str_ends_with(strtolower($_SESSION['correo']), '@alumno.ipn.mx')) {
    header("Location: inicio_profesor.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Alumno - PlataformaTT</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { background-color: #f8fafc; color: #1e293b; }
        
        header { background-color: #0f2c59; color: #ffffff; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        header h1 { font-size: 1.2rem; }
        header .user-info { font-size: 0.9rem; color: #cbd5e1; }
        header a { color: #f87171; text-decoration: none; margin-left: 1rem; font-weight: 600; }

        .container { max-width: 1100px; margin: 2rem auto; padding: 0 1rem; }
        .welcome-card { background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 2rem; }
        
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; }
        .card { background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 1.5rem; transition: transform 0.2s; }
        .card:hover { transform: translateY(-3px); border-color: #0f2c59; }
        .card h3 { color: #0f2c59; margin-bottom: 0.5rem; }
        .card p { font-size: 0.875rem; color: #64748b; margin-bottom: 1rem; }
        .btn { display: inline-block; background-color: #0f2c59; color: white; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; }
    </style>
</head>
<body>

    <header>
        <h1>PlataformaTT | ESCOM</h1>
        <div class="user-info">
            Alumno: <strong><?php echo htmlspecialchars($_SESSION['nombre']); ?></strong>
            <a href="logout.php">Cerrar Sesión</a>
        </div>
    </header>

    <div class="container">
        <div class="welcome-card">
            <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></h2>
            <p>Sección de gestión de Trabajo Terminal para Alumnos (@alumno.ipn.mx).</p>
        </div>

       <div class="grid">
            <div class="card">
                <h3>Registrar Protocolo TT</h3>
                <p>Registra el título, resumen y los integrantes de tu proyecto de Trabajo Terminal.</p>
                <!-- Redirige a la interfaz con el formulario y la gráfica de IA -->
                <a href="registrar_protocolo.php" class="btn">Comenzar Registro</a>
            </div>
            <div class="card">
                <h3>Subir Documentación</h3>
                <p>Carga reportes de avance y entregables en formato PDF.</p>
                <a href="subir_documentos.php" class="btn">Ver Archivos</a>
            </div>
            <div class="card">
                <h3>Estado del Expediente</h3>
                <p>Consulta las observaciones y evaluaciones realizadas por tus asesores o sinodales.</p>
                <a href="estado_expediente.php" class="btn">Consultar Estatus</a>
            </div>
        </div>
    </div>

</body>
</html>