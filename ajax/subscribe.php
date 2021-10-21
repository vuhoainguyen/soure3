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
	$phone = htmlspecialchars($_POST['p']);
	$type = htmlspecialchars($_POST['t']);
	$item_email  =  $d->rawQueryOne("select phone from #_newsletters where phone=?",array($phone));
	if($item_email){
		$result['status'] = 201;
		$result['message'] = 'Số điện thoại này đã có trong hệ thống';
	}else{
		if($_SESSION['count-sub']<3){
			// $data['email'] = ($email!='') ? $email:'';
			$data['phone'] = $phone;
			$data['status'] = 'hienthi';
			$data['type'] = $type;
			$data['createdAt'] = $d->now();
			$id_insert = $d->insert('newsletters', $data);
			if ($id_insert) {
				$_SESSION['count-sub'] = $_SESSION['count-sub'] + 1;
			    $result['status'] = 200;
				$result['message'] = 'Đã thêm dữ liệu thành công';
			}
		}else{
		    $result['status'] = 201;
			$result['message'] = 'Vui lòng dừng ngay việc này, bạn gửi quá nhiều lần. Trân trọng!!';
		}
	}
	echo json_encode($result);
?>