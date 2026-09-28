<?php
session_start();

$exito = isset($_GET['status']) && $_GET['status'] === 'exito';

// Si no hay sesión activa y tampoco viene de un registro exitoso, mandar al registro
if (!isset($_SESSION['correo_verificacion']) && !$exito) {
    header("Location: registro.html");
    exit();
}

$correo_destino = $_SESSION['correo_verificacion'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Token - PlataformaTT</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { display: flex; height: 100vh; width: 100vw; background-color: #ffffff; overflow: hidden; position: relative; }
        
        .left-panel {
            flex: 1; background: linear-gradient(135deg, #0f2c59 0%, #071630 100%);
            color: #ffffff; padding: 4rem; display: flex; flex-direction: column; justify-content: space-between;
        }
        .brand-text h2 { font-size: 1.4rem; font-weight: 700; }
        .brand-text p { font-size: 0.75rem; color: #a0aec0; }
        .quote-text { font-size: 1.4rem; font-style: italic; color: #e2e8f0; font-weight: 300; }
        
        .right-panel { width: 45%; display: flex; justify-content: center; align-items: center; padding: 2.5rem; }
        .form-container { width: 100%; max-width: 400px; text-align: center; }
        
        .tagline { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1.5px; color: #718096; margin-bottom: 0.4rem; font-weight: 600; }
        .welcome-title { font-size: 1.8rem; font-weight: 700; color: #000000; margin-bottom: 1rem; }
        .info-text { font-size: 0.9rem; color: #4a5568; margin-bottom: 2rem; line-height: 1.5; }
        .info-text strong { color: #0f2c59; }

        .token-input {
            width: 100%; letter-spacing: 12px; font-size: 2rem; text-align: center;
            padding: 12px; border: 2px solid #cbd5e1; border-radius: 8px; outline: none;
            font-weight: 700; color: #0f2c59; margin-bottom: 1.5rem;
        }
        .token-input:focus { border-color: #0f2c59; box-shadow: 0 0 0 3px rgba(15, 44, 89, 0.1); }

        .btn-submit {
            width: 100%; background-color: #0f2c59; color: #ffffff; border: none;
            padding: 13px; border-radius: 8px; font-size: 0.95rem; font-weight: 600;
            cursor: pointer; transition: background-color 0.2s;
        }
        .btn-submit:hover { background-color: #0a1f3f; }
        
        .alert-error {
            background-color: #fef2f2; color: #991b1b; border: 1px solid #fecaca;
            padding: 10px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 1rem;
        }

        /* --- Estilos para la Ventana Modal --- */
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px);
            display: flex; justify-content: center; align-items: center; z-index: 1000;
        }

        .modal-box {
            background: #ffffff; padding: 2.5rem; border-radius: 12px;
            text-align: center; max-width: 400px; width: 90%;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            animation: fadeIn 0.3s ease-out;
        }

        .icon-circle {
            width: 60px; height: 60px; background-color: #dcfce7; color: #16a34a;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 2rem; margin: 0 auto 1.5rem auto; font-weight: bold;
        }

        .modal-title { font-size: 1.3rem; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem; }
        .modal-desc { font-size: 0.9rem; color: #64748b; margin-bottom: 1.8rem; line-height: 1.4; }

        .btn-login {
            display: inline-block; width: 100%; background-color: #0f2c59; color: #ffffff;
            text-decoration: none; padding: 12px; border-radius: 8px; font-weight: 600;
            font-size: 0.95rem; transition: background-color 0.2s;
        }
        .btn-login:hover { background-color: #0a1f3f; }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body>

    <div class="left-panel">
        <div class="brand-text">
            <h2>PlataformaTT</h2>
            <p>ESCOM - INSTITUTO POLITÉCNICO NACIONAL</p>
        </div>
        <p class="quote-text">"Confirmación de seguridad para la habilitación de firma electrónica y seguimiento de expediente."</p>
        <div style="font-size: 0.8rem; color: #5a6a85;">TT 2026-B077 • V0.1 PROTOTIPO</div>
    </div>

    <div class="right-panel">
        <div class="form-container">
            <p class="tagline">Seguridad</p>
            <h1 class="welcome-title">CÓDIGO DE VERIFICACIÓN</h1>
            <p class="info-text">
                Ingresa el código registrado para:<br>
                <strong><?php echo htmlspecialchars($correo_destino); ?></strong>
            </p>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert-error">
                    <?php 
                        if ($_GET['error'] === 'invalido') echo 'El código ingresado es incorrecto.';
                        if ($_GET['error'] === 'expirado') echo 'El código ha expirado. Registrate nuevamente.';
                    ?>
                </div>
            <?php endif; ?>

            <form action="verificar_token.php" method="POST">
                <input class="token-input" type="text" name="token" maxlength="6" pattern="\d{6}" placeholder="000000" required autofocus autocomplete="off">
                <button type="submit" class="btn-submit">Verificar Código</button>
            </form>
        </div>
    </div>

  <!-- Ventana emergente (Modal) -->
    <?php if ($exito): ?>
        <div class="modal-overlay">
            <div class="modal-box">
                <div class="icon-circle">✓</div>
                <h2 class="modal-title">¡Correo Autenticado!</h2>
                <p class="modal-desc">Tu cuenta ha sido verificada con éxito. Ya puedes iniciar sesión con tus credenciales.</p>
                <a href="iniciarSesion.html" class="btn-login">Iniciar Sesión</a>
            </div>
        </div>
    <?php endif; ?>

</body>
</html>