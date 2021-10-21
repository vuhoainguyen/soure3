<?php
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @author  AP CAO
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */
	session_start();
	defined( '_root' ) ?:  define( '_root', __DIR__);
	defined( '_ds' ) ?:  define( '_ds', DIRECTORY_SEPARATOR );
    defined( '_lib' ) ?:  define( '_lib', '..'._ds.'libraries'._ds );

    defined( '_libraries' ) ?:  define( '_libraries', _root._ds.'libraries'._ds );
    defined( '_sources' ) ?:  define( '_sources', _root._ds.'sources'._ds );
    defined( '_templates' ) ?:  define( '_templates', _root._ds.'templates'._ds );
    defined( '_layouts' ) ?:  define( '_layouts', _templates._ds.'layouts'._ds );
    $login_name = "BmwebCOLTD";
    require_once _lib.'config.php';
	require_once _lib.'autoload.php';
	new autoload();

	require_once _lib.'PHPExcel/PHPExcel.php';
	require_once _lib.'Mailer/class.phpmailer.php';
	
	$d = new PDODb($config['database']);
	$func = new functions($d);
	$logs = new writeLog(_upload_logs);
	$cart = new cartAdmin($d,$func);
	$apiPlace = new place($d);
	require_once _lib.'permissionAttr.php';
	 
	/* Khởi tạo và xóa ngôn ngữ dư thừa
		require_once _lib.'langAttr.php';
		$lan = new langConfig($config,$d,$func,$lang_attr);
		$lan->initLang();
		$lan->deleteLang('fr');
	*/
	require_once _libraries."type.php";
    require_once _libraries."controller.php";
    require_once _templates."app.php";
    
?>