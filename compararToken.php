<?php
session_start();
// Incluye tu conexión a la BD aquí (ej. include 'conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token_ingresado = trim($_POST['token'] ?? '');

    if (!isset($_SESSION['registro_pendiente'])) {
        header("Location: inicio.html");
        exit();
    }

    $datos_usuario = $_SESSION['registro_pendiente'];

    // Validar expiración del token
    if (time() > $datos_usuario['expira']) {
        unset($_SESSION['registro_pendiente']);
        header("Location: validar_token.php?error=expirado");
        exit();
    }

    // Comprobar coincidencia del token
    if ($token_ingresado === $datos_usuario['token']) {
        
        /* 
           AQUÍ INSERTAS LOS DATOS EN TU BASE DE DATOS:
           $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, paterno, materno, correo, usuario, password, rol) VALUES (?, ?, ?, ?, ?, ?, ?)");
           $stmt->execute([...]);
        */

        // Limpiar la variable temporal de registro
        unset($_SESSION['registro_pendiente']);

        // Redirigir al login o al dashboard con éxito
        header("Location: inicio.html?status=registro_exitoso");
        exit();
    } else {
        // Token incorrecto
        header("Location: validar_token.php?error=invalido");
        exit();
    }
}