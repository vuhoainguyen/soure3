<?php
	$name = $_GET['id'];
	require_once("../libraries/qrcode.php");
	$qr = QRCode::getMinimumQRCode($name, QR_ERROR_CORRECT_LEVEL_L);
	$im = $qr->createImage(4, 3);
	header("Content-type: image/gif");
	imagegif($im);
	imagedestroy($im);
?>