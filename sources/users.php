<?php 
	switch ($act) {
		case 'dang-ky':
			register();
			break;
		case 'dang-nhap':
			if($func->isLogin()){
				$func->redirect($config_base);
			}
			login();
			break;
		case 'quen-mat-khau';
			if($func->isLogin()){
				$func->redirect($config_base);
			}
			forgot();
			break;
		case 'thong-tin-tai-khoan':
			if(!$func->isLogin()){
				$func->redirect($config_base);
			}
			profile();
			break;
		case 'doi-mat-khau':
			if(!$func->isLogin()){
				$func->redirect($config_base);
			}
			reset_pass();
			break;

		case 'dang-xuat':
			if(!$func->isLogin()){
				$func->redirect($config_base);
			}
			logout();
			break;

		case 'so-dia-chi':
			if(!$func->isLogin()){
				$func->redirect($config_base);
			}
			$action = (isset($_REQUEST['action'])) ? addslashes($_REQUEST['action']) : "";
			address_list();
			switch ($action) {
				case 'add':
					$title = $title_seo = 'Thêm địa chỉ';
					$template = 'accounts/add_address';
					break;
				case 'edit':
					edit_address();
					$title = $title_seo = 'Sửa địa chỉ';
					$template = 'accounts/add_address';
					break;
				case 'save':
					save_address();
					break;
				case 'delete':
					delete_address();
					break;
				default:
					$template = 'accounts/address_list';
					break;
			}
			break;
		case 'danh-sach-don-hang':
			if(!$func->isLogin()){
				$func->redirect($config_base);
			}
			$action = (isset($_REQUEST['action'])) ? addslashes($_REQUEST['action']) : "";
			order_list();
			switch ($action) {
				case 'edit':
					edit_order();
					$title = $title_seo = 'Chi tiết đơn hàng';
					$template = 'accounts/add_order';
					break;
				case 'return':
					return_order();
					break;
				default:
					$template = 'accounts/order_list';
					break;
			}
			break;
		case 'don-hang-doi-tra':
			if(!$func->isLogin()){
				$func->redirect($config_base);
			}
			order_return_list();
			break;
		case 'don-hang-huy':
			if(!$func->isLogin()){
				$func->redirect($config_base);
			}
			order_cancel_list();
			break;
		default:
			
			break;
	}
	function login(){
		global $d,$func,$config_base,$config,$error;
		if(!empty($_POST)){
			$error['status'] = 200;
			$data = $_POST['data'];
			
			if(isset($_GET['return'])){
				$return = base64_decode($_GET['return']);
			}else{
				$return = $config_base;
			}
			$data['email'] = htmlspecialchars($data['email']);
			$data['password'] = htmlspecialchars($data['password']);
			if($error['status'] == 200){
				$password = $func->encryptPassword($config['website']['secret'],$data['password'],$config['website']['salt']);
				$sql = "select * from #_customers where email=? and password=? and type=? and find_in_set ('hienthi',status)";
				$row_user = $d->rawQueryOne($sql,array($data['email'],$password,'member'));
				
				if(!empty($row_user)){
					$_SESSION['signin']['id'] = $row_user['id'];
					$_SESSION['signin']['email'] = $row_user['email'];
					$_SESSION['signin']['fullname'] = $row_user['fullname'];
					$_SESSION['signin']['address'] = $row_user['address'];
					$_SESSION['signin']['phone'] = $row_user['phone'];
					$_SESSION['signin']['status'] = $row_user['status'];
					$_SESSION['signin']['id_city'] = $row_user['id_city'];
					$_SESSION['signin']['id_dist'] = $row_user['id_dist'];
					if($_POST['remember'] == 1){
						setcookie('email', $row_user['email'], time()+60*60*24*365);
						setcookie('password', $row_user['password'], time()+60*60*24*365);
					}
					$func->redirect($return);
				}else{
					$error['status'] = 202;
					$error['message'] = _sai_dang_nhap;
				}
			}else{
				$error['status'] = 201;
				$error['message'] = _du_lieu_khong_thoa_dieu_kien;
			}
		}
	}
	function logout(){
		global $config_base;
		unset($_SESSION['signin']); setcookie("email", "", time()-60*60*24*365); setcookie("pass", "", time()-60*60*24*365);
		header("location: ".$config_base);
	}
	function profile(){
		global $d,$func,$config_base,$config,$error,$row_user;
		$sql = "select * from #_customers where id=? and type=? and find_in_set ('hienthi',status)";
		$row_user = $d->rawQueryOne($sql,array($_SESSION['signin']['id'],'member'));

		if(!empty($_POST)){
			$data = $_POST['data'];
	    	if($_POST){
	    		foreach ($data as $k => $v) {
					$data[$k] = htmlspecialchars($v);
				}
	    	}
	    	$data['birthday'] = (int)$_POST['ngay'].'-'.(int)$_POST['thang'].'-'.(int)$_POST['nam'];
	    	$data['updatedAt'] = $d->now();
			$data['edit_count'] = $d->inc(1);
    		$d->where('id', $_SESSION['signin']['id']);
			if ($d->update('customers', $data)) {
			    $result['status'] = 200;
				$result['message'] = _da_cap_nhat_thanh_cong.' id#'.$id;
				$func->redirect($config_base.'account/thong-tin-tai-khoan');
			}
		}
	}
	function reset_pass(){
		global $d,$func,$config_base,$config,$error_pass,$row_user;
		$sql = "select * from #_customers where id=? and type=? and find_in_set ('hienthi',status)";
		$row_user = $d->rawQueryOne($sql,array($_SESSION['signin']['id'],'member'));

		if(!empty($_POST)){
			$data_request = $_POST['data'];
			$error_pass['status'] = 200;
			$data = array();
			if($_POST){
	    		foreach ($data_request as $k => $v) {
	    			if($k!='password-old' && $k!='password-confirm'){
	    				$data[$k] = htmlspecialchars($v);
	    			}
				}
	    	}
			$password_old = $row_user['password'];
			$password = $func->encryptPassword($config['website']['secret'],$data['password'],$config['website']['salt']);
			if($password_old==$password){
				$error_pass['status'] = 201;
				$error_pass['message'] = _mat_khau_cu_va_moi_trung;
			}
			if($error_pass['status']==200){
				$data['password'] = $password;
		    	$data['updatedAt'] = $d->now();
				$data['edit_count'] = $d->inc(1);
	    		$d->where('id', $_SESSION['signin']['id']);
				if ($d->update('customers', $data)) {
				    $error_pass['status'] = 200;
					$error_pass['message'] = _da_thay_doi_mat_khau;
					unset($_SESSION['signin']); setcookie("email", "", time()-60*60*24*365); setcookie("pass", "", time()-60*60*24*365);
					$func->redirect($config_base.'account/dang-nhap');
				}
			}
		}
	}
	function register(){
		global $d,$func,$row_setting,$config_base,$config;
		$form = $_POST['data'];
		$row_user = $d->rawQueryOne("select * from #_customers where email=?", array($form['email']));
		if(empty($row_user)){
			if(!empty($_POST)){
				$data = array();
				$activation = $d->func('SHA1(?)',array($func->randString(20)));
				$secret = $d->func('SHA1(?)',array($func->randString(20)));
				if($_POST){
		    		foreach ($form as $k => $v) {
		    			if($k != 'password-confirm'){
		    				$data[$k] = htmlspecialchars($v);
		    			}
		    			if($k=='password'){
		    				$data['password'] = $func->encryptPassword($config['website']['secret'],$v['password'],$config['website']['salt']);
		    			}
					}
		    	}
				$ex_email = explode('@', $form['email']);
				$data['username'] = $ex_email[0];
				$data['numb'] = 1;
		        $data['createdAt'] = $d->now();
				$data['type'] = 'member';
				$data['secret'] = $secret;
				$data['activation'] = $activation;
				$id_insert = $d->insert('customers', $data);
				if ($id_insert) {
				    $user_id = 'member'.str_pad($id_insert, 5, "0", STR_PAD_LEFT);
				    $d->rawQuery("update #_customers set userid='$user_id' where id=?", array($id_insert));

				    $body = '<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" style="background-color:#f2f2f2;font-family:Helvetica,Arial,sans-serif;table-layout:fixed">
			                    <tbody>
			                        <tr>
			                            <td align="center" style="padding-top:30px;padding-bottom:30px">
			                                <a target="_blank">
			                                    '.$row_setting['name'].'
			                                </a>
			                            </td>
			                        </tr>
			                        <tr>
			                            <td>
			                                <center>
			                                    <table border="0" cellpadding="0" cellspacing="0" style="width:600px">
			                                        <tbody>
			                                            <tr>
			                                                <td style="background:#f8f8f8;text-align:center;color:#8d8d8d;font-size:14px;padding-top:18px;padding-bottom:18px;font-family:Helvetica,Arial,sans-serif">'._email_tu_dong.'</td>
			                                            </tr>
			                                            <tr>
			                                                <td align="center" style="padding-top:50px;padding-left:70px;padding-right:70px;background-color:#fff">

			                                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color:#fff;font-weight:200">
			                                                        <tbody>

			                                                            <tr>
			                                                                <td style="padding:5px 0" align="center">
			                                                                    <img src="'.$config_base.'images/success.png" height="163" alt="">
			                                                                </td>
			                                                            </tr>
			                                                            <tr>
			                                                                <td style="padding:35px 0">
			                                                                    <h1 style="font-size:30px;line-height:36px;color:#606060!important;margin:0;font-weight:bold;text-align:center;font-family:Helvetica,Arial,sans-serif;text-transform: uppercase;">
			                                                                        '._tao_tai_khoan.'
			                                                                    </h1>
			                                                                </td>
			                                                            </tr>
			                                                            <tr>
			                                                                <td style="padding:10px 0">
			                                                                    <p style="font-size:15px;line-height:22px;color:#606060!important;font-family:Helvetica,Arial,sans-serif;margin:0;padding:0;text-align:center">
			                                                                        '._ban_da_yeu_cau_tao_tai_khoan.'
			                                                                        <br>
			                                                                        <strong><a style="color:#0099FF!important; text-decoration: none;" href="mailto:'.$form['email'].'" target="_blank">'.$form['email'].'</a></strong>
			                                                                        <br>
			                                                                        <br>'._de_kich_hoat_nhan_link_duoi.'
			                                                                    </p>
			                                                                </td>
			                                                            </tr>
			                                                            <tr>
			                                                                <td style="padding:25px 0 25px">
			                                                                    <div style="text-align:center">
			                                                                        <a href="'.$config_base.'account/activation&active='.$activation.'" style="display:inline-block;color:#fff;background-color:#4fc0e8;border-top:20px solid #4fc0e8;border-bottom:20px solid #4fc0e8;border-right:55px solid #4fc0e8;border-left:55px solid #4fc0e8;font-size:20px;font-weight:500;line-height:18px;text-decoration:none; cursor: pointer; border-radius:3px;font-family:Helvetica,Arial,sans-serif"
			                                                                        target="_blank">
			                                                                            '._kich_hoat.'
			                                                                        </a>
			                                                                    </div>
			                                                                </td>
			                                                            </tr>

			                                                            <tr>
			                                                                <td style="padding:20px 0 20px">
			                                                                    <p style="font-size:15px;line-height:22px;color:#606060!important;font-family:Helvetica,Arial,sans-serif;margin:0;padding:0">
			                                                                        '._lien_he_dich_vu_247.': <a style="color:#4fc0e8" href="mailto:'.$row_setting['email'].'" target="_blank">'.$row_setting['email'].'</a>
			                                                                    </p>
			                                                                </td>
			                                                            </tr>
			                                                            <tr>
			                                                                <td style="padding:20px 0 50px;background:#fff">
			                                                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
			                                                                        <tbody>
			                                                                            <tr>
			                                                                                <td style="background-color:#e2e7eb;padding-left:10px;padding-right:10px;padding-top:15px;padding-bottom:15px;text-align:center;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:500;line-height:18px">
			                                                                                    '._de_cap_den_id_khi_lien_he.': <strong>'.$user_id.'</strong>
			                                                                                </td>
			                                                                            </tr>
			                                                                        </tbody>
			                                                                    </table>
			                                                                </td>
			                                                            </tr>
			                                                        </tbody>
			                                                    </table>
			                                                </td>
			                                            </tr>

			                                            <tr>
			                                                <td align="justify" style="padding:20px 15px 5px">
			                                                    <table width="100%" style="text-align:center;font-size:11px;border-top:1px solid #13c1c9;border-bottom:1px solid #13c1c9">
			                                                        <tbody>
			                                                            <tr>
			                                                                <td style="padding:10px 0">
			                                                                    <a href="'.$config_base.'lien-he" style="text-decoration:none;font-weight:bold;color:#262626;font-family:Helvetica,Arial,sans-serif">SUPPORT</a>
			                                                                </td>
			                                                                <td style="padding:10px 0">
			                                                                    <a href="'.$row_setting['fanpage'].'" style="text-decoration:none;font-weight:bold;color:#262626;font-family:Helvetica,Arial,sans-serif">FACEBOOK</a>
			                                                                </td>
			                                                            </tr>
			                                                        </tbody>
			                                                    </table>
			                                                </td>
			                                            </tr>
			                                            <tr>
			                                            </tr>
			                                            <tr>
			                                                <td style="padding:5px 70px 0px">
			                                                    <p style="font-size:14px;color:#9a9a9a;line-height:22px;text-align:center;margin-bottom:15px;font-family:Helvetica,Arial,sans-serif">
			                                                        © '.date('Y').' '.$row_setting['name'].'
			                                                    </p>
			                                                </td>
			                                            </tr>
			                                            <tr>
			                                                <td>
			                                                    <table width="100%" style="text-align:center;font-size:11px;padding-bottom:30px">
			                                                        <tbody>
			                                                            <tr>
			                                                                <td style="padding-left:90px;padding-right:10px">
			                                                                    <a href="'.$config_base.'" style="text-decoration:none;color:#9a9a9a;font-family:Helvetica,Arial,sans-serif">'.$row_setting['website'].'</a>
			                                                                </td>
			                                                                <td style="padding-right:10px">
			                                                                    <a href="'.$config_base.'dieu-khoan-su-dung" style="text-decoration:none;color:#9a9a9a;font-family:Helvetica,Arial,sans-serif">'._dieukhoansudung.'</a>
			                                                                </td>
			                                                                <td style="padding-right:90px">
			                                                                    <ahref="'.$config_base.'chinh-sach-bao-mat" style="text-decoration:none;color:#9a9a9a;font-family:Helvetica,Arial,sans-serif">'._chinhsachbaomat.'</a>
			                                                                </td>
			                                                            </tr>
			                                                        </tbody>
			                                                    </table>
			                                                </td>
			                                            </tr>

			                                        </tbody>
			                                    </table>
			                                </center>
			                            </td>
			                        </tr>
			                    </tbody>
			                </table>';

			        $mail_send = array();
	                $mail_send[0] = $form['email'];
	                if($func->sendMailIndex($row_setting['email'],_thong_bao_dang_ky_thanh_vien,$body,$mail_send,null,null)){
	                    $func->transfer(_thong_bao_dang_ky_thanh_vien_thanh_cong, $config_base);
	                }else{
	                    $func->transfer(_thong_bao_email_that_bai, $config_base.'account/dang-ky');
	                } 
				}
			}
		}
	}

	function forgot(){
		global $d,$func,$row_setting,$config_base,$config;
		$form = $_POST['data'];
		$form['email'] = htmlspecialchars($form['email']);
		
		$sql = "select * from #_customers where email=?";
		$row_user = $d->rawQueryOne($sql,array($form['email']));
		
		if(!empty($row_user)){
			$password = $func->randString(8);
			$data['password'] = $func->encryptPassword($config['website']['secret'],$password,$config['website']['salt']);
			$data['updatedAt'] = $d->now();
			$data['edit_count'] = $d->inc(1);
    		$d->where('id', $row_user['id']);
			if ($d->update('customers', $data)) {

				$body = '<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" style="background-color:#f2f2f2;font-family:Helvetica,Arial,sans-serif;table-layout:fixed">
                        <tbody>
                            <tr>
                                <td align="center" style="padding-top:30px;padding-bottom:30px">
                                    <a target="_blank">
                                        '.$row_setting['name'].'
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <center>
                                        <table border="0" cellpadding="0" cellspacing="0" style="width:600px">
                                            <tbody>
                                                <tr>
                                                    <td style="background:#f8f8f8;text-align:center;color:#8d8d8d;font-size:14px;padding-top:18px;padding-bottom:18px;font-family:Helvetica,Arial,sans-serif">'._email_tu_dong.'</td>
                                                </tr>
                                                <tr>
                                                    <td align="center" style="padding-top:50px;padding-left:70px;padding-right:70px;background-color:#fff">

                                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color:#fff;font-weight:200">
                                                            <tbody>

                                                                <tr>
                                                                    <td style="padding:5px 0" align="center">
                                                                        <img src="'.$config_base.'images/success.png" height="163" alt="">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding:35px 0">
                                                                        <h1 style="font-size:30px;line-height:36px;color:#606060!important;margin:0;font-weight:bold;text-align:center;font-family:Helvetica,Arial,sans-serif;text-transform: uppercase;">
                                                                            '._thay_doi.' '._mat_khau.'
                                                                        </h1>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding:10px 0">
                                                                        <p style="font-size:15px;line-height:22px;color:#606060!important;font-family:Helvetica,Arial,sans-serif;margin:0;padding:0;text-align:center">
                                                                            '._yeu_cau_thay_doi_mat_khau.'
                                                                            <br>
                                                                            <strong><a style="color:#0099FF!important; text-decoration: none;" href="mailto:'.$form['email'].'" target="_blank">'.$form['email'].'</a></strong>
                                                                            <br>
                                                                            <br>'._mat_khau_thay_doi_la.': '.$password.'
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td style="padding:20px 0 20px">
                                                                        <p style="font-size:15px;line-height:22px;color:#606060!important;font-family:Helvetica,Arial,sans-serif;margin:0;padding:0">
                                                                            '._lien_he_dich_vu_247.': <a style="color:#4fc0e8" href="mailto:'.$row_setting['email'].'" target="_blank">'.$row_setting['email'].'</a>
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding:20px 0 50px;background:#fff">
                                                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="background-color:#e2e7eb;padding-left:10px;padding-right:10px;padding-top:15px;padding-bottom:15px;text-align:center;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:500;line-height:18px">
                                                                                        '._de_cap_den_id_khi_lien_he.': <strong>'.$row_user['userid'].'</strong>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td align="justify" style="padding:20px 15px 5px">
                                                        <table width="100%" style="text-align:center;font-size:11px;border-top:1px solid #13c1c9;border-bottom:1px solid #13c1c9">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="padding:10px 0">
                                                                        <a href="'.$config_base.'lien-he" style="text-decoration:none;font-weight:bold;color:#262626;font-family:Helvetica,Arial,sans-serif">SUPPORT</a>
                                                                    </td>
                                                                    <td style="padding:10px 0">
                                                                        <a href="'.$row_setting['fanpage'].'" style="text-decoration:none;font-weight:bold;color:#262626;font-family:Helvetica,Arial,sans-serif">FACEBOOK</a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                </tr>
                                                <tr>
                                                    <td style="padding:5px 70px 0px">
                                                        <p style="font-size:14px;color:#9a9a9a;line-height:22px;text-align:center;margin-bottom:15px;font-family:Helvetica,Arial,sans-serif">
                                                            © 2017 '.$row_setting['name'].'
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table width="100%" style="text-align:center;font-size:11px;padding-bottom:30px">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="padding-left:90px;padding-right:10px">
                                                                        <a href="'.$config_base.'" style="text-decoration:none;color:#9a9a9a;font-family:Helvetica,Arial,sans-serif">'.$row_setting['website'].'</a>
                                                                    </td>
                                                                    <td style="padding-right:10px">
                                                                        <a href="'.$config_base.'dieu-khoan-su-dung" style="text-decoration:none;color:#9a9a9a;font-family:Helvetica,Arial,sans-serif">'._dieukhoansudung.'</a>
                                                                    </td>
                                                                    <td style="padding-right:90px">
                                                                        <ahref="'.$config_base.'chinh-sach-bao-mat" style="text-decoration:none;color:#9a9a9a;font-family:Helvetica,Arial,sans-serif">'._chinhsachbaomat.'</a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </center>
                                </td>
                            </tr>
                        </tbody>
                    </table>';

			    $mail_send = array();
                $mail_send[0] = $form['email'];
                if($func->sendMailIndex($row_setting['email'],_thong_bao_thay_doi_mat_khau_thanh_vien,$body,$mail_send,null,null)){
                    $func->transfer(_thong_bao_thay_doi_mat_khau_thanh_vien_thanh_cong, $config_base);
                }else{
                    $func->transfer(_thong_bao_email_that_bai, $config_base.'account/dang-ky');
                } 
				
			}else{
				$func->transfer(_email_khong_ton_tai, $config_base);
			}
		}
	}
	function address_list(){
		global $d,$lists;
		$sql = "select * from #_customer_address where id_user=? and find_in_set ('hienthi',status)";
		$lists = $d->rawQuery($sql,array($_SESSION['signin']['id']));
	}
	function edit_address(){
		global $d,$item;
		$sql = "select * from #_customer_address where id=?";
		$item = $d->rawQueryOne($sql,array($_GET['id']));
	}
	function save_address(){
		global $d,$func,$row_setting,$config_base,$config;
		$form = $_POST['data'];
		$id = (int)$_GET['id'];
		$data = array();
		if($_POST){
    		foreach ($form as $k => $v) {
    			$data[$k] = htmlspecialchars($v);
			}
    	}
		if($id){
			$data['updatedAt'] = $d->now();
			$data['edit_count'] = $d->inc(1);
    		$d->where('id', $id);
			if ($d->update('customer_address', $data)) {
				$error_pass['status'] = 200;
				$error_pass['message'] = _cap_nhat_dia_chi_thanh_cong;
				$func->redirect($config_base.'account/so-dia-chi');
			}
		}else{
			$data['id_user'] = $_SESSION['signin']['id'];
			$data['numb'] = 1;
			$data['status'] = 'hienthi';
	        $data['createdAt'] = $d->now();
			$id_insert = $d->insert('customer_address', $data);
			if ($id_insert) {
				$error_pass['status'] = 200;
				$error_pass['message'] = _them_dia_chi_thanh_cong;
				$func->redirect($config_base.'account/so-dia-chi');
			}
		}
	}
	function delete_address(){
		global $d,$item,$func,$config_base;
		$sql = "delete from #_customer_address where id=?";
		$item = $d->rawQueryOne($sql,array($_GET['id']));
		$func->redirect($config_base.'account/so-dia-chi');
	}
	function order_list(){
		global $d,$lists;
		$sql = "select * from #_orders where id_customer=? order by id desc";
		$lists = $d->rawQuery($sql,array($_SESSION['signin']['id']));
	}
	function edit_order(){
		global $d,$item,$lists;
		$sql = "select * from #_orders where id=?";
		$item = $d->rawQueryOne($sql,array($_GET['id']));

		$sql_order = "select * from #_order_details where id_order=?";
		$lists = $d->rawQuery($sql_order,array($_GET['id']));
	}
	function return_order(){
		global $d,$result,$func,$config_base;
		$sql = "select * from #_orders where id=?";
		$item = $d->rawQueryOne($sql,array($_GET['id']));

		if($item){
			$order_n = date('dmY').'TH';
			$order_new = $d->rawQueryOne("select id,code from #_order_returns where code like '$order_n%'  order by id desc limit 0,1");

			if(empty($order_new['id'])){ $order_rand = 1001; }else{ $order_rand =  substr($order_new['code'],10)+1; }
			$order_code = date('dmY').'TH'.$order_rand;

			$item_th = $d->rawQueryOne("SELECT * from #_order_returns where id_order=? order by id desc",array($_GET['id']));
			if(empty($item_th)){
				$data['id_order'] = (int)htmlspecialchars($_GET['id']);
				$data['code'] = $order_code;
				$data['total_price'] = $item['total_price'];
				$data['sale_off'] = $item['sale_off'];
				$data['status'] = 'datra';
				$data['id_customer'] = $_SESSION['signin']['id'];
				$id_insert = $d->insert('order_returns', $data);
				if ($id_insert) {
					$result['status'] = 200;
					$result['message'] = _da_tra_hang_thanh_cong;
				}else{
					$result['status'] = 202;
					$result['message'] = _da_tra_hang_that_bai;
				}
			}else{
				die('x');
				$data['id_customer'] = $_SESSION['signin']['id'];
				$data['updatedAt'] = $d->now();
				$data['edit_count'] = $d->inc(1);
				$d->where('id', $item_th['id']);
				if ($d->update('order_returns', $data)) {
					$result['status'] = 200;
					$result['message'] = _don_hang_da_duoc_tra;
				}else{
					print_r($d->getLastError());
					
				}
			}
			$func->transfer($result['message'],$config_base.'account/danh-sach-don-hang');
		}
	}
	function order_return_list(){
		global $d,$lists;
		$sql = "select * from #_order_returns where id_customer=? order by id desc";
		$lists = $d->rawQuery($sql,array($_SESSION['signin']['id']));
	}
	function order_cancel_list(){
		global $d,$lists;
		$sql = "select * from #_orders where id_customer=? and order_status=? order by id desc";
		$lists = $d->rawQuery($sql,array($_SESSION['signin']['id'],4));
	}
?>