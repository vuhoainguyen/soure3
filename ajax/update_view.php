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
	$id = (int)htmlspecialchars($_POST['id']);
	$table = htmlspecialchars($_POST['table']);
	$data = array();
	$d->rawQuery("update #_$table set view=view+1 where id=?",array($id));
	$check = $d->rawQueryOne("select view from #_$table where id=?",array($id));
	echo 'Lượt xem: '.$check['view'];
?>