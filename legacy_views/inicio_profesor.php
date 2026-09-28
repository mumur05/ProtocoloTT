<?php
session_start();

// Verificar autenticación
if (!isset($_SESSION['usuario_id'])) {
    header("Location: iniciarSesion.html");
    exit();
}

// Validar que sea docente/coordinador por el dominio del correo
if (!str_ends_with(strtolower($_SESSION['correo']), '@ipn.mx') || str_ends_with(strtolower($_SESSION['correo']), '@alumno.ipn.mx')) {
    header("Location: inicio_alumno.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Docente - PlataformaTT</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { background-color: #f8fafc; color: #1e293b; }
        
        header { background-color: #1e3a8a; color: #ffffff; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        header h1 { font-size: 1.2rem; }
        header .user-info { font-size: 0.9rem; color: #cbd5e1; }
        header a { color: #f87171; text-decoration: none; margin-left: 1rem; font-weight: 600; }

        .container { max-width: 1100px; margin: 2rem auto; padding: 0 1rem; }
        .welcome-card { background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 2rem; }
        
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; }
        .card { background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 1.5rem; transition: transform 0.2s; }
        .card:hover { transform: translateY(-3px); border-color: #1e3a8a; }
        .card h3 { color: #1e3a8a; margin-bottom: 0.5rem; }
        .card p { font-size: 0.875rem; color: #64748b; margin-bottom: 1rem; }
        .btn { display: inline-block; background-color: #1e3a8a; color: white; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; }
    </style>
</head>
<body>

    <header>
        <h1>PlataformaTT | Panel Docente ESCOM</h1>
        <div class="user-info">
            Profesor(a): <strong><?php echo htmlspecialchars($_SESSION['nombre']); ?></strong>
            <a href="logout.php">Cerrar Sesión</a>
        </div>
    </header>

    <div class="container">
        <div class="welcome-card">
            <h2>Bienvenido(a), Prof. <?php echo htmlspecialchars($_SESSION['nombre']); ?></h2>
            <p>Sección de revisión, evaluación y seguimiento de Trabajos Terminales (@ipn.mx).</p>
        </div>

        <div class="grid">
            <div class="card">
                <h3>Proyectos Asesorados</h3>
                <p>Revisa los avances y solicitudes de los grupos que tienes a tu cargo.</p>
                <a href="#" class="btn">Ver Proyectos</a>
            </div>
            <div class="card">
                <h3>Evaluación de Sinodalías</h3>
                <p>Dictamina protocolos y propuestas asignadas como sinodal.</p>
                <a href="#" class="btn">Evaluar Trabajos</a>
            </div>
            <div class="card">
                <h3>Firmas Electrónicas</h3>
                <p>Gestiona y firma las actas o liberaciones de Trabajo Terminal de tus alumnos.</p>
                <a href="#" class="btn">Gestionar Firmas</a>
            </div>
        </div>
    </div>

</body>
</html>