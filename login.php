<?php
session_start();
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_o_correo = trim($_POST['usuario'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';

    if (empty($usuario_o_correo) || empty($contrasena)) {
        header("Location: iniciarSesion.html?error=campos_vacios");
        exit();
    }

    // 1. Buscar usuario por su nombre de usuario O por su correo institucional
    $stmt = $pdo->prepare("
        SELECT id, nombre, apellido_paterno, correo_institucional, contrasena, estado 
        FROM usuarios 
        WHERE usuario = ? OR correo_institucional = ?
    ");
    $stmt->execute([$usuario_o_correo, $usuario_o_correo]);
    $user = $stmt->fetch();

    // 2. Verificar existencia y contraseña
    if ($user && password_verify($contrasena, $user['contrasena'])) {
        
        // Si no ha verificado su token aún, redirigir a validar_token.php
        if ($user['estado'] !== 'activo') {
            $_SESSION['correo_verificacion'] = $user['correo_institucional'];
            header("Location: validar_token.php");
            exit();
        }

        // Crear variables de sesión
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['nombre'] = $user['nombre'] . ' ' . $user['apellido_paterno'];
        $_SESSION['correo'] = $user['correo_institucional'];

        // 3. Evaluar el correo para decidir a qué pantalla enviarlo
        $correo = strtolower($user['correo_institucional']);

        if (str_ends_with($correo, '@alumno.ipn.mx')) {
            header("Location: inicio_alumno.php");
            exit();
        } else if (str_ends_with($correo, '@ipn.mx')) {
            header("Location: inicio_profesor.php");
            exit();
        } else {
            // Caso por defecto
            header("Location: inicio_alumno.php");
            exit();
        }

    } else {
        header("Location: iniciarSesion.html?error=credenciales");
        exit();
    }
} else {
    header("Location: iniciarSesion.html");
    exit();
}