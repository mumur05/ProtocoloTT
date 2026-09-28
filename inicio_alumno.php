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

$datos_vista = [
    'nombre' => $_SESSION['nombre'],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Alumno - PlataformaTT</title>
    <link rel="stylesheet" href="assets/main.css">
</head>
<body>
    <div id="root" data-view="panelAlumno"></div>
    <script type="application/json" id="php-data"><?php echo json_encode($datos_vista, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP); ?></script>
    <script type="module" src="assets/main.js"></script>
</body>
</html>
