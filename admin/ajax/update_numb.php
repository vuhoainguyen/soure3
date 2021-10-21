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
	
	if(isset($_POST["i"])){
        $table = htmlspecialchars($_POST['t']);
        $id = htmlspecialchars($_POST['i']);
        $value = htmlspecialchars($_POST['v']);
        $data['numb'] = $value;
		$d->where('id', $id);
		if($d->update($table, $data)){
			$res['status'] = 200;
		}else{
			$res['status'] = 201;
		}
		echo json_encode($res);
	}
?>