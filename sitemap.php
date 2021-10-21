<?php 
	session_start();
    
	$_SESSION['ONWEB'] = true;
	defined( '_root' ) ?:  define( '_root', __DIR__);
	defined( '_ds' ) ?:  define( '_ds', DIRECTORY_SEPARATOR );
    defined( '_lib' ) ?:  define( '_lib', _root._ds.'libraries'._ds );

    defined( '_sources' ) ?:  define( '_sources', _root._ds.'sources'._ds );
    defined( '_templates' ) ?:  define( '_templates', _root._ds.'templates'._ds );
    defined( '_layouts' ) ?:  define( '_layouts', _templates._ds.'layouts'._ds );

    require_once _lib.'config.php';
	require_once _lib.'autoload.php';
	new autoload();
	$d = new PDODb($config['database']);

	if(!isset($_SESSION['lang'])){
        $_SESSION['lang'] = 'vi';
    }
    $lang = $_SESSION['lang'];

	$func = new functions($d);

	$attr_page = array(
	    array("tbl"=>"lists","field"=>"idl","source"=>"products","com"=>"san-pham","type"=>"san-pham"),
	    array("tbl"=>"cats","field"=>"idc","source"=>"products","com"=>"san-pham","type"=>"san-pham"),
	    array("tbl"=>"products","field"=>"id","source"=>"products","com"=>"san-pham","type"=>"san-pham"),
	    array("tbl"=>"posts","field"=>"id","source"=>"posts","com"=>"tin-tuc","type"=>"tin-tuc"),
	    array("tbl"=>"posts","field"=>"id","source"=>"posts","com"=>"huong-dan-mua-hang","type"=>"huong-dan-mua-hang"),
	    array("tbl"=>"posts","field"=>"id","source"=>"posts","com"=>"chinh-sach","type"=>"chinh-sach"),
	    array("tbl"=>"posts","field"=>"id","source"=>"posts","com"=>"ho-tro-khach-hang","type"=>"ho-tro-khach-hang"),
	    array("tbl"=>"pages","field"=>"id","source"=>"pages","com"=>"gioi-thieu","type"=>"gioi-thieu"),
	    array("tbl"=>"contacts","field"=>"id","source"=>"contacts","com"=>"lien-he","type"=>"lien-he")
	);

	$time_sitemap = time();
	
	function urlElement($url,$pri,$time) {
		global $config_base; 
		$url = $config_base.$url;
		$str_sitemap='<url><loc>'.$url.'</loc><lastmod>'.date("c",$time).'</lastmod><changefreq>weekly</changefreq><priority>'.$pri.'</priority></url>';
		echo $str_sitemap;
	} 
	function CreateXML($tbl='',$type='',$priority=1){
		global $d,$lang;
		if($tbl=='') return false;
		$sql = "SELECT alias_$lang as alias,UNIX_TIMESTAMP(createdAt) as dateCreate FROM #_$tbl where type='".$type."' and find_in_set('hienthi',status) order by id desc";
		$result_data = $d->rawQuery($sql);
		foreach ($result_data as $key => $v) {
			urlElement($v['alias'],$priority,$v['dateCreate']);
		}
	}
	header("Content-Type: application/xml; charset=utf-8"); 
	echo '<?xml version="1.0" encoding="UTF-8"?>'; 
	echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">'; 
	urlElement('','1.0',$time_sitemap); 
	foreach ($attr_page as $k => $v) {
		$priority = $v['field']=='id' ? "1.0" : "0.8";
		if($v['field']=='id'){
			urlElement($v['com'],$priority,$time_sitemap); 
		}
		if($v['tbl']!='info'){
			CreateXML($v['tbl'],$v['type'],$priority);
		}
	}
	echo '</urlset>';
?>