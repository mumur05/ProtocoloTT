<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['protocolo_pdf'])) {
    echo json_encode(['success' => false, 'error' => 'Archivo no recibido.']);
    exit();
}

$pdfFile = $_FILES['protocolo_pdf'];

if ($pdfFile['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'error' => 'Error al subir el archivo PDF.']);
    exit();
}

// Preparar el archivo para enviarlo mediante cURL a Python
$cFile = new CURLFile($pdfFile['tmp_name'], $pdfFile['type'], $pdfFile['name']);
$payload = ['file' => $cFile];

$ch = curl_init('http://127.0.0.1:8000/analizar_documento');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200 && $response) {
    echo $response;
} else {
    echo json_encode(['error' => 'No se pudo conectar con el motor de IA en Python.']);
}