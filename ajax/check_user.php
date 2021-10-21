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
	$email = htmlspecialchars($_POST['v']);
	$item_email  =  $d->rawQueryOne("select id from #_customers where email=?",array($email));
	if(!empty($item_email)){
		$res['status'] = 201;
		$res['message'] = 'Email này đã tồn tại. Vui lòng chọn email khác';
	}else{
		$res['status'] = 200;
		$res['message'] = 'Bạn có thể chọn email này.';
	}
	echo json_encode($res);
?>