<?php
session_start();
require_once 'conexion.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rol = $_POST['rol'] ?? '';
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido_paterno = trim($_POST['apellido_paterno'] ?? '');
    $apellido_materno = trim($_POST['apellido_materno'] ?? '');
    $identificador = trim($_POST['boleta'] ?? $_POST['num_empleado'] ?? '');
    $correo = trim($_POST['correo_institucional'] ?? '');
    $usuario = trim($_POST['usuario'] ?? '');
    $contrasena = password_hash($_POST['contrasena'] ?? '', PASSWORD_BCRYPT);

 // 1. Si el usuario ya existe en estado 'pendiente'
    if ($existente) {
        if ($existente['estado'] === 'pendiente') {
            $token = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $expiracion = date('Y-m-d H:i:s', strtotime('+15 minutes'));

            $updateStmt = $pdo->prepare("
                UPDATE usuarios 
                SET token_verificacion = ?, token_expira = ?, contrasena = ? 
                WHERE id = ?
            ");
            $updateStmt->execute([$token, $expiracion, $contrasena, $existente['id']]);

            $_SESSION['correo_verificacion'] = $correo;
            
            // --- DESACTIVAR ENVÍO DE CORREO TEMPORALMENTE ---
            // enviarCorreoToken($correo, $nombre, $token); 

            // Redirige directamente a la pantalla del token
            header("Location: validarToken.php");
            exit();
        } else {
            die("El correo institucional o el nombre de usuario ya se encuentra registrado.");
        }
    }

    // 2. Si es un registro nuevo
    $token = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    $expiracion = date('Y-m-d H:i:s', strtotime('+15 minutes'));

    try {
        $stmt = $pdo->prepare("
            INSERT INTO usuarios 
            (rol, nombre, apellido_paterno, apellido_materno, identificador, correo_institucional, usuario, contrasena, token_verificacion, token_expira, estado) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pendiente')
        ");
        
        $stmt->execute([
            $rol, $nombre, $apellido_paterno, $apellido_materno, 
            $identificador, $correo, $usuario, $contrasena, $token, $expiracion
        ]);

        $_SESSION['correo_verificacion'] = $correo;

        // --- DESACTIVAR ENVÍO DE CORREO TEMPORALMENTE ---
        // enviarCorreoToken($correo, $nombre, $token); 

        // Redirige directamente a la pantalla del token
        header("Location: validarToken.php");
        exit();

    } catch (PDOException $e) {
        die("Error en la base de datos: " . $e->getMessage());
    }
}

// Función auxiliar para enviar el correo mediante PHPMailer
function enviarCorreoToken($correo, $nombre, $token) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'tu_correo@gmail.com'; 
        $mail->Password   = 'tu_contrasena_de_aplicacion'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom('tu_correo@gmail.com', 'PlataformaTT ESCOM');
        $mail->addAddress($correo, $nombre);

        $mail->isHTML(true);
        $mail->Subject = 'Código de Verificación - PlataformaTT';
        $mail->Body    = "
            <div style='font-family: Arial, sans-serif; padding: 20px;'>
                <h2 style='color: #0f2c59;'>PlataformaTT - ESCOM IPN</h2>
                <p>Hola <strong>" . htmlspecialchars($nombre) . "</strong>,</p>
                <p>Tu código de verificación es:</p>
                <h1 style='background-color: #f1f5f9; padding: 10px 20px; color: #0f2c59; display: inline-block; letter-spacing: 5px;'>{$token}</h1>
                <p>Este código expira en 15 minutos.</p>
            </div>
        ";

        $mail->send();
    } catch (Exception $e) {
        die("Error al enviar el correo: " . $mail->ErrorInfo);
    }
}