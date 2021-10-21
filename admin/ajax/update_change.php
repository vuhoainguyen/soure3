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
	
	if(isset($_POST["val"])){
        $table = htmlspecialchars($_POST['table']);
        $id = htmlspecialchars($_POST['id']);
        $val = htmlspecialchars($_POST['val']);
        $field = htmlspecialchars($_POST['field']);
        $data[$field] = $val;
		$d->where('id', $id);
		if($d->update($table, $data)){
			echo 1;
		}else{
			echo 0;
		}
	}
?>