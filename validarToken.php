<?php
session_start();

$exito = isset($_GET['status']) && $_GET['status'] === 'exito';

// Si no hay sesión activa y tampoco viene de un registro exitoso, mandar al registro
if (!isset($_SESSION['correo_verificacion']) && !$exito) {
    header("Location: registro.html");
    exit();
}

$correo_destino = $_SESSION['correo_verificacion'] ?? '';

$datos_vista = [
    'correoDestino' => $correo_destino,
    'exito' => $exito,
    'error' => $_GET['error'] ?? null,
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Token - PlataformaTT</title>
    <link rel="stylesheet" href="assets/main.css">
</head>
<body>
    <div id="root" data-view="validarToken"></div>
    <script type="application/json" id="php-data"><?php echo json_encode($datos_vista, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP); ?></script>
    <script type="module" src="assets/main.js"></script>
</body>
</html>
