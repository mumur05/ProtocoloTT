<?php
session_start();
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token_ingresado = trim($_POST['token'] ?? '');
    $correo = $_SESSION['correo_verificacion'] ?? '';

    if (empty($correo)) {
        header("Location: registro.html");
        exit();
    }

    // 1. Consultar el usuario en la BD
    $stmt = $pdo->prepare("
        SELECT id, token_expira 
        FROM usuarios 
        WHERE correo_institucional = ? AND token_verificacion = ? AND estado = 'pendiente'
    ");
    $stmt->execute([$correo, $token_ingresado]);
    $usuario = $stmt->fetch();

    if ($usuario) {
        // 2. Validar si el token expiró
        $ahora = date('Y-m-d H:i:s');
        if ($ahora > $usuario['token_expira']) {
            header("Location: validarToken.php?error=expirado");
            exit();
        }

        // 3. Activar la cuenta y limpiar el token
        $updateStmt = $pdo->prepare("
            UPDATE usuarios 
            SET estado = 'activo', token_verificacion = NULL, token_expira = NULL 
            WHERE id = ?
        ");
        $updateStmt->execute([$usuario['id']]);

        // Limpiar la sesión de verificación
        unset($_SESSION['correo_verificacion']);

        // Redirigir a validar_token.php indicando éxito para abrir la ventana emergente
        header("Location: validarToken.php?status=exito");
        exit();

    } else {
        header("Location: validarToken.php?error=invalido");
        exit();
    }
} else {
    header("Location: registro.html");
    exit();
}
