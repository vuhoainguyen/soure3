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
    error_reporting(E_ALL & ~E_NOTICE & ~8192);
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	
	defined( '_root' ) ?:  define( '_root', __DIR__);
	defined( '_ds' ) ?:  define( '_ds', DIRECTORY_SEPARATOR );
    defined( '_lib' ) ?:  define( '_lib', '..'._ds.'..'._ds.'libraries'._ds );

    defined( '_libraries' ) ?:  define( '_libraries', _root._ds.'libraries'._ds );
    
    $login_name = "BmwebCOLTD";

    require_once _lib.'config.php';
	require_once _lib.'autoload.php';
	new autoload();

	$d = new PDODb($config['database']);
	$func = new functions($d);
	$cart = new cartAdmin($d,$func);
?>