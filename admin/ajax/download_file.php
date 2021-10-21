<?php 
    /**
     * Application Main Page That Will Serve All Requests
     * @package PRO CODE BMWEB FRAMEWORK
     * @author  AP CAO
     * @version 1.0.0
     * @license https://bmweb.vn
     * @PHP >=5.6
     */
	$filePath = base64_decode($_GET['file']);
	if(file_exists($filePath)) {
        $fileName = basename($filePath);
        $fileSize = filesize($filePath);
        header("Cache-Control: private");
        header("Content-Type: application/stream");
        header("Content-Length: ".$fileSize);
        header("Content-Disposition: attachment; filename=".$fileName);
        readfile ($filePath);                   
        exit();
    }
    else {
        die('The provided file path is not valid.');
    }
?>