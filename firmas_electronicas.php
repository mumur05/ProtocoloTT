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

$datos_vista = [
    'nombre' => $_SESSION['nombre'],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Firmas Electrónicas - PlataformaTT</title>
    <link rel="stylesheet" href="assets/main.css">
</head>
<body>
    <div id="root" data-view="firmasElectronicas"></div>
    <script type="application/json" id="php-data"><?php echo json_encode($datos_vista, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP); ?></script>
    <script type="module" src="assets/main.js"></script>
</body>
</html>
