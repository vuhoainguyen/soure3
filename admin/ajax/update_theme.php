<?php 
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @author  AP CAO
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */
	require_once 'config.php';
	$v = htmlspecialchars($_POST['v']);
	$c = htmlspecialchars($_POST['c']);

	$data['theme_admin'] = $v;
	$data['color_admin'] = $c;
	$d->where('setting_id', 2006);
	$d->update('settings', $data);
?>