<?php 
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @author  AP CAO
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */
	
	switch ($act) {
		case 'login':
			// login();
			$templates = 'users/login';
			break;
		case "logout":
            logout();
            break;
        case 'man':
			get_items();
			$templates = 'users/items';
			break;
		case 'add':
			getLoad();
			$templates = 'users/item_add';
			break;
		case 'edit':
			getLoad();
			get_item();
			$templates = 'users/item_add';
			break;
		case 'save':
			save_item();
			$templates = 'users/item_add';
			break;
		case 'delete':
			delete_item();
			break;
        case 'profile':
			profile();
			$templates = 'users/profile';
			break;
		default:
			$templates = 'index';
			break;
	}
	function getLoad(){
		global $d,$permissions;
		$permissions = $d->rawQuery("SELECT * from #_permissions where status='hienthi' order by id desc");
	}
	function get_items(){
	    global $d,$items;
	    
	    $items = $d->rawQuery("SELECT * from #_users where role!=3 order by id desc");
	}
	function get_item(){
		global $d,$item;
		$id = (int)$_GET['id'];
		$item  =  $d->rawQueryOne("select * from #_users where id=?",array($id));
		if(empty($item)){
			$func->transfer('Không nhận được dữ liệu','index.html');
		}
	}
	function save_item(){
		global $d,$config,$func;
		$message = '';
		$id = (int)$_GET['id'];
		$data = $_POST['data'];
    	if($_POST){
    		foreach ($data as $k => $v) {
				$data[$k] = htmlspecialchars($v);
			}
    	}
		if($id){
			if(!empty($data['password'])){
				$data['password'] = $func->encryptPassword($config['website']['secret'],$data['password'],$config['website']['salt']);
			}else{
				$item  =  $d->rawQueryOne("select password from #_users where id=?",array($id));
				$data['password'] = $item['password'];
			}
			$data['updatedAt'] = $d->now();
			$data['edit_count'] = $d->inc(1);
    		$d->where('id', $id);
			if ($d->update('users', $data)) {
			    $result['status'] = 200;
				$result['message'] = 'Đã cập nhật thông tin thành công id#'.$id;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=users&act=edit&id='.$id.'&message='.$message);
			} else {
			  	$func->transfer('Không nhận được dữ liệu','index.html?com=users&act=man');
			}
		}else{
			$item  =  $d->rawQueryOne("select id from #_users where username=?",array($data['username']));
			if(empty($item)){
				$data['status'] = 'hienthi';
				$data['role'] = 1;
				$data['type'] = 'user';
				$data['password'] = $func->encryptPassword($config['website']['secret'],$data['password'],$config['website']['salt']);
				$data['createdAt'] = $d->now();
				$id_insert = $d->insert('users', $data);
				if ($id_insert) {
				    $result['status'] = 200;
					$result['message'] = 'Đã thêm dữ liệu thành công id#'.$id_insert;
					$message = base64_encode(json_encode($result));
					$func->redirect('index.html?com=users&act=man&message='.$message);
				}
			}else{
				$result['status'] = 201;
				$result['message'] = 'Bạn đã trùng username';
				$message = base64_encode(json_encode($result));
				$func->transfer('Bạn đã trùng username','index.html?com=users&act=add');
			}
		    
		}
	}
	function delete_item(){
		global $d,$func;
		$id = (int)$_GET['id'];

		if(isset($_GET['id'])){
			$item  =  $d->rawQueryOne("select id from #_users where id=?",array($id));
			if($item){
				$d->where('id', $item['id']);
				$d->delete('users');
	        	$result['status'] = 200;
				$result['message'] = 'Đã xóa dữ liệu thành công id#'.$id;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=users&act=man&message='.$message);
			}else{
				$func->transfer('Không nhận được dữ liệu','index.html');
			}
		}elseif(isset($_GET['listid'])){
			$listid = explode(",",$_GET['listid']);
			if(count($listid)){
				$result['message'] = 'Đã xóa dữ liệu thành công id#';
				foreach ($listid as $k => $v) {
					$id = (int)$v;
					$item  =  $d->rawQueryOne("select id from #_users where id=?",array($id));
					if($item){
						$d->where('id', $item['id']);
						$d->delete('users');
						$result['message'] .= $id.',';
					}
				}
				$result['message'] = substr($result['message'], 0, -1);
				$result['status'] = 200;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=users&act=man&message='.$message);
			}else{
				$func->transfer('Không nhận được dữ liệu','index.html?com=users&act=man');
			}
		}

	}
	function login(){
		global $d,$func,$config,$login_name;
		if(!empty($_POST)){
			$data = $_POST;
			$username = htmlspecialchars($data['username_log']);
			$password = htmlspecialchars($data['password_log']);
			$remember = (int) $data['remember'];
			$row  =  $d->rawQueryOne("select * from #_users where username=:username",array('username'=>$username));
			if(!empty($row)){
				
				$password = $func->encryptPassword($config['website']['secret'],$password,$config['website']['salt']);
				if($password==$row['password']){

					$_SESSION[$login_name] = true;
                    $_SESSION['isLoggedIn'] = true;
                    $_SESSION['login'] = array();
					$_SESSION['login']['username'] = $row['username'];
					$_SESSION['login']['id'] = $row['id'];
					$_SESSION['login']['role'] = $row['role'];
					$_SESSION['login']['permissions'] = $row['id_permission'];
					
					if($remember==1){
						$randomNumber = rand(99,999999999);
						$token = dechex(($randomNumber*$randomNumber));
						$salt = sha1($token . $username);
						$time = time()+60*60*24*365; 
						$row_remember = $d->rawQueryOne("select * from #_users_remember where username=:username",array('username'=>$username));
						$param_query = array($username,$token,$salt,$time);
						if($row_remember){
							$query = "update #_users_remember set username = ?, token = ?, salt = ?, time = ?";
						}else{
							$query = "insert into #_users_remember (username, token, salt, time) VALUES (?,?,?,?)";
						}
						$d->rawQuery($query,$param_query);
						setcookie('remember', $username.'.'.$salt, $time);
					}

					$result['status'] = 200;
					$result['message'] = 'Đăng nhập thành công';
				}else{
					$result['status'] = 202;
					$result['message'] = 'Mật khẩu không đúng.';
				}
			}else{
				$result['status'] = 201;
				$result['message'] = 'Không tồn tại tài khoản bạn vừa đăng nhập';
			}
			echo json_encode($result);
		}
	}

	function logout(){
        global $login_name,$func;
        unset($_SESSION['login']);
        $_SESSION[$login_name] = false;
        $_SESSION['isLoggedIn'] = false;
        setcookie("remember", "", time()-60*60*24*365);
        $func->transfer("Đăng xuất thành công", "index.html?com=users&act=login");
    }

    function profile(){
    	global $d,$func,$item,$result,$config;
    	$item  =  $d->rawQueryOne("select * from #_users where id=?",array($_SESSION['login']['id']));
    	$data = $_POST['data'];
    	if($_POST){
    		foreach ($data as $k => $v) {
				$data[$k] = htmlspecialchars($v);
			}
    	}
    	if(!empty($item)){
    		$result = array();
    		if($_POST['edit-profile']==1){
    			$data['updatedAt'] = $d->now();
    			$data['edit_count'] = $d->inc(1);
    			$d->where('id', $item['id']);
				if ($d->update('users', $data)) {
				    $result['status'] = 200;
				    $result['message'] = 'Đã cập nhật thông tin thành công';
				} else {
				    $result['status'] = 201;
				    $result['message'] = 'Đã cập nhật thông tin thất bại';
				}
    		}
    		if($_POST['edit-password']==1){
    			$password_old = $func->encryptPassword($config['website']['secret'],htmlspecialchars($_POST['password-old']),$config['website']['salt']);
    			$password_confirm = $func->encryptPassword($config['website']['secret'],htmlspecialchars($_POST['password-confirm']),$config['website']['salt']);
    			$data['password'] = $func->encryptPassword($config['website']['secret'],$data['password'],$config['website']['salt']);
    			if($item['password']==$password_old){
    				if($data['password']!=$password_old){
	    				if($data['password']==$password_confirm){
	    					$data['edit_count'] = $d->inc(1);
	    					$data['updatedAt'] = $d->now();
			    			$d->where('id', $item['id']);
							if ($d->update('users', $data)) {
							    $result['status'] = 200;
							    $result['message'] = 'Đã thay đổi mật khẩu thành công';
							    logout();
							} else {
							    $result['status'] = 203;
							    $result['message'] = 'Đã thay đổi mật khẩu thất bại';
							}
	    				}else{
	    					$result['status'] = 202;
					    	$result['message'] = 'Mật khẩu mới và mật khẩu xác nhận không trùng khớp';
	    				}
	    			}else{
	    				$result['status'] = 201;
					    $result['message'] = 'Mật khẩu mới và mật khẩu cũ không được trùng';
	    			}
    			}else{
					$result['status'] = 204;
			    	$result['message'] = 'Mật khẩu cũ không đúng';
    			}
    		}
    	}else{
    		$func->transfer('Không nhận được dữ liệu','index.html');
    	}
    }
?>