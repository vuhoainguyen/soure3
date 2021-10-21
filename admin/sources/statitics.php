<?php 
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @author  AP CAO
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */
	$url_type .= (isset($_GET['type'])) ? '&type='.htmlspecialchars($_GET['type']):'';


	switch ($act) {
        case 'man':
			get_items();
			$templates = 'statitics/items';
			break;
		
		default:
			$templates = 'statitics/items';
			break;
	}
	
	function get_items(){
		global $d,$config,$items,$page,$paging,$func,$url_type;
	   
	}
	
?>