<?php

require_once dirname(__DIR__). '/vendor/autoload.php';


// Ajuste de ruta: Verifica que llegue a la carpeta vendor
//require_once __DIR__ . '/../../vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\Encoding\Encoding;
// Esta es la clase clave en la versión 5.x
use Endroid\QrCode\ErrorCorrectionLevel;

// 1. Parámetros
$formato   = $_GET['formato'] ?? 'svg';
$contenido = isset($_GET['contenido']) ? urldecode($_GET['contenido']) : 'Hola Mundo';
$calidad   = strtoupper($_GET['calidad'] ?? 'M');
$tamanio   = (int)($_GET['tamanio'] ?? 300);
$borde     = (int)($_GET['borde'] ?? 10);

// 2. Mapeo de Calidad (FORMA CORRECTA v5.1)
// Usamos los métodos estáticos de la clase ErrorCorrectionLevel
$errorCorrection = match ($calidad) {
    'L' => ErrorCorrectionLevel::Low,
    'Q' => ErrorCorrectionLevel::Quartile,
    'H' => ErrorCorrectionLevel::High,
    default => ErrorCorrectionLevel::Medium,
};

try {
    // 3. Crear el QR
    $qrCode = QrCode::create($contenido)
        ->setEncoding(new Encoding('UTF-8'))
        ->setErrorCorrectionLevel($errorCorrection)
        ->setSize($tamanio)
        ->setMargin($borde);

    // 4. Seleccionar Writer
    if (strtolower($formato) === 'png') {
        $writer = new PngWriter();
        header('Content-Type: image/png');
    } else {
        $writer = new SvgWriter();
        header('Content-Type: image/svg+xml');
    }

    // 5. Salida
    $result = $writer->write($qrCode);
    echo $result->getString();

} catch (\Exception $e) {
    header('Content-Type: text/plain');
    echo "Error: " . $e->getMessage();
}