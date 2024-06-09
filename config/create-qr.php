<?php
include 'connect.php';
require_once('../vendor/autoload.php');

session_start();
date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");
$user = $_SESSION['user']['userID'];


use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelMedium;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

if (isset($_POST['download-qr'])){
    $equip_id = mysqli_real_escape_string($connect,$_POST['equip-id']);
    $name= mysqli_real_escape_string($connect,$_POST['name']);
    $link = "qr-record.php?id=" . $equip_id;
$writer = new PngWriter();
$s=500;

// Create QR code
$qrCode = QrCode::create($link)
    ->setEncoding(new Encoding('UTF-8'))
    ->setErrorCorrectionLevel(new ErrorCorrectionLevelMedium())
    ->setSize(500)
    ->setMargin(30)
;

// Create generic logo
// $logo = Logo::create(__DIR__ . '/assets/symfony.png')
//     ->setResizeToWidth(50)
//     ->setPunchoutBackground(true);

// Create label
$label = Label::create($name)
    ->setTextColor(new Color(255, 0, 0));

$result = $writer->write($qrCode,null,$label);

// Directly output the QR code
// echo $result->getString();
    
$filename = $name.'.png';
// $qrCode->save($filename);
header('Content-Type: application/octet-stream');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Content-Type: ' . $result->getMimeType());
echo $result->getString();
exit;
}
?>