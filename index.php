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
	$_SESSION['ONWEB'] = true;
	defined( '_root' ) ?:  define( '_root', __DIR__);
	defined( '_ds' ) ?:  define( '_ds', DIRECTORY_SEPARATOR );
    defined( '_lib' ) ?:  define( '_lib', _root._ds.'libraries'._ds );
    defined( '_sources' ) ?:  define( '_sources', _root._ds.'sources'._ds );
    defined( '_templates' ) ?:  define( '_templates', _root._ds.'templates'._ds );
    defined( '_layouts' ) ?:  define( '_layouts', _templates._ds.'layouts'._ds );

    $lang = $_SESSION['lang'] = (!isset($_SESSION['lang']) || $_SESSION['lang']=='') ? 'vi':$_SESSION['lang'];

    require_once _lib.'config.php';
	require_once _lib.'autoload.php';
	require_once _lib.'langWeb/lang_'.$lang.'.php';
	new autoload();
	$d = new PDODb($config['database']);
	$func = new functions($d);
	$breadcrumbs = new breadCrumbs($d,$func);
	$counter = new statistic($d);
	$apiCart = new cartFrontEnd($d,$config);
	$apiPlace = new place($d);
	$json_schema = new jsonSchema($d,$func);
	
	if(!defined('AJAX')){
		require_once _lib."controller.php";
		require_once _templates."app.php";
	} else {
		if(!isset($_SESSION['ONWEB'])){ DIE("You have no permission to here ! ");}
	}
?>