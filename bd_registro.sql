-- Esquema de la base de datos de PlataformaTT.
-- Las columnas corresponden a las usadas en registrar.php, login.php y verificar_token.php.

CREATE DATABASE IF NOT EXISTS bd_registro
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE bd_registro;

CREATE TABLE IF NOT EXISTS usuarios (
  id                  INT AUTO_INCREMENT PRIMARY KEY,
  rol                 VARCHAR(20)  NOT NULL,
  nombre              VARCHAR(100) NOT NULL,
  apellido_paterno    VARCHAR(100) NOT NULL,
  apellido_materno    VARCHAR(100) DEFAULT NULL,
  identificador       VARCHAR(20)  NOT NULL,
  correo_institucional VARCHAR(150) NOT NULL UNIQUE,
  usuario             VARCHAR(50)  NOT NULL UNIQUE,
  contrasena          VARCHAR(255) NOT NULL,
  token_verificacion  VARCHAR(6)   DEFAULT NULL,
  token_expira        DATETIME     DEFAULT NULL,
  estado              ENUM('pendiente','activo') NOT NULL DEFAULT 'pendiente',
  creado_en           TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
