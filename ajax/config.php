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
    defined( '_lib' ) ?:  define( '_lib', _root._ds.'../'._ds.'libraries'._ds );
    defined( '_sources' ) ?:  define( '_sources', _root._ds.'../'._ds.'sources'._ds );
    if(!isset($_SESSION['lang'])){
        $_SESSION['lang'] = 'vi';
    }
    $lang = $_SESSION['lang'];
    require_once _lib.'config.php';
	require_once _lib.'autoload.php';
	require_once _lib.'langWeb/lang_'.$lang.'.php';
	new autoload();
	
    
	$d = new PDODb($config['database']);
	$func = new functions($d);
	$apiPlace = new place($d);

	$row_setting = $d->rawQueryOne("select *, address_$lang as address, company_$lang as company, slogan_$lang as slogan, title_$lang as title, keywords_$lang as keywords, description_$lang as description from #_settings limit 0,1");
?>