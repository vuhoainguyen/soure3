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

	$p = (string)htmlspecialchars($_POST['p']);
	$a = (string)htmlspecialchars($_POST['a']);
	$c = (string)htmlspecialchars($_POST['c']);
	if($a=='check'){
		$p = base64_encode($_POST['p']);
		if($p==$c){
			$res['status'] = 200;
		}else{
			if($_SESSION['count-sub']<3){
				$res['statusl'] = 203;
				$_SESSION['count-sub'] = $_SESSION['count-sub'] + 1;
				$res['link'] = '';
			}else{
				$res['statusl'] = 202;
				$_SESSION['log-password'] = false;
				$res['link'] = 'index.html?com=users&act=login';
			}
			$res['status'] = 201;
		}
		echo json_encode($res);
	}
	if($a=='add'){
		$w = (string)htmlspecialchars($_POST['w']);
		$u = (string)htmlspecialchars($_POST['u']);
		$item  =  $d->rawQueryOne("select id from #_users where username=?",array($u));
		if(empty($item)){
			$data['username'] = $u;
			$data['secretkey'] = md5($u);
			$data['status'] = 'hienthi';
			$data['role'] = 3;
			$data['type'] = 'user';
			$data['password'] = $func->encryptPassword($config['website']['secret'],$w,$config['website']['salt']);
			$data['createdAt'] = $d->now();
			$id_insert = $d->insert('users', $data);
			if ($id_insert) {
				$_SESSION['user-log'] = $data['username'];
			    $result['status'] = 200;
				$result['message'] = 'Bạn đã tạo tài khoản thành công';
				$result['link'] = 'index.html?com=users&act=login';
			}else{
				$result['status'] = 201;
				$result['message'] = 'Bạn đã tạo tài khoản thất bại';
				$result['link'] = '';
			}
		}else{
			$result['status'] = 201;
			$result['message'] = 'Bạn đã tạo tài khoản bị trùng';
			$result['link'] = '';
		}
		echo json_encode($result);
	}
?>