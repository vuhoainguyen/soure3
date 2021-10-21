<?php
/**
 * Application Main Page That Will Serve All Requests
 * @package PRO CODE BMWEB FRAMEWORK
 * @author  AP CAO
 * @version 1.0.0
 * @license https://bmweb.vn
 * @PHP >=5.6
 */

class breadCrumbs{
	private $db;
	private $func;
	public function __construct($db,$func){
		$this->db = $db;
		$this->func = $func;
	}
	public function getUrl($title,$arr=array()){
		global $config_base;
		$breadcumb .='<ol id="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';
		$breadcumb .='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="'.$config_base.'"><span itemprop="name">'.$title.'</span></a><meta itemprop="position" content="1" /></li>';
		$k = 1;
		for ($i=0; $i < count($arr); $i++) { 
			$breadcumb .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
							<a itemprop="item" href="'.$config_base.$arr[$i]['alias'].'">
								<span itemprop="name">'.$arr[$i]['name'].'</span>
							</a>
							<meta itemprop="position" content="'.($k+1).'" />
						</li>';
			$k++;
		}
	    
	    $breadcumb .='</ol>';

	    return $this->Minify_Html($breadcumb);

	}
	static function Minify_Html($Html){
		$Search = array(
			'/(\n|^)(\x20+|\t)/',
			'/(\n|^)\/\/(.*?)(\n|$)/',
			'/\n/',
			'/\<\!--.*?-->/',
			'/(\x20+|\t)/',
			'/\>\s+\</',
			'/(\"|\')\s+\>/',
			'/=\s+(\"|\')/'
		);

		$Replace = array(
			"\n",
			"\n",
			" ",
			"",
			" ",
			"><",
			"$1>",
			"=$1"
		);
		$Html = preg_replace($Search,$Replace,$Html);
		return $Html;
	}
}
?>