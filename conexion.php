<?php
$host = '127.0.0.1'; // Si no funciona con 'localhost', usa '127.0.0.1'
$db   = 'bd_registro'; // Reemplaza por el nombre real de tu base de datos
$user = 'root';
$pass = ''; // Por defecto en XAMPP viene vacío
$port = '3306'; // Puerto por defecto de MySQL

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}
?>