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
	

	function login(){
		global $d,$func,$config,$login_name;
		if(!empty($_POST)){
			$data = $_POST;
			$username = htmlspecialchars($data['username_log']);
			$password = htmlspecialchars($data['password_log']);
			$remember = (int) $data['remember'];


			$ip = $func->getRealIPAddress();
			
			$sql = "select id,login_ip,login_attempts,attempt_time,locked_time from #_users_limit where login_ip=? order by id desc limit 1 ";
			$row_check = $d->rawQuery($sql,array($ip));
			if(!empty($row_check)){
				$id_login = $row_check[0]['id'];			
			    $time_now = time();
			    //Kiểm tra thời gian bị khóa đăng nhập
			    if($row_check[0]['locked_time']>0){
				    $locked_time = $row_check[0]['locked_time'];		   
				    $delay_time = $config['login-admin']['delay'];
				    $interval = $time_now  - $locked_time;
				    if($interval <= $delay_time*60){
				    	$time_remain = $delay_time*60 - $interval;
				        $msg = "Xin lỗi..! Vui lòng thử lại sau ". round($time_remain/60)." phút..!";
				        $result['status'] = 201;
						$result['message'] = $msg;
			        }else{
			        	$sql="update #_users_limit set login_attempts = 0, attempt_time = '$time_now', locked_time = 0 where id = '$id_login'";
						$d->rawQuery($sql);
			        }
		        }
			}
			

			$password = $func->encryptPassword($config['website']['secret'],$password,$config['website']['salt']);
			$row  =  $d->rawQueryOne("select * from #_users where username=? and password=?",array($username,$password));
			if(!empty($row)){
				
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


				$timenow = time();
				$id_user = $row['id'];
				$user_agent = $_SERVER['HTTP_USER_AGENT'];
				
				//Ghi log truy cập thành công
				$sql="insert into #_users_log (id_user,ip,timelog,user_agent) values ('$id_user','$ip','$timenow','$user_agent')";
				$d->rawQuery($sql);

				//Tạo token và login session			
				$cookiehash = md5(sha1($row['password'].$row['username']));
				$token = md5(time());
				$sql = "update #_users SET login_session= '$cookiehash', lastlogin = '$timenow', user_token = '$token' WHERE id ='$id_user'";
				$d->rawQuery($sql);	
				$_SESSION['login_session'] = $cookiehash;
				$_SESSION['login_token'] = $token;

				//Login thành công thì reset số lần login sai và thời gian khóa
				$sql = "select id,login_ip,login_attempts,attempt_time,locked_time from #_users_limit where login_ip =  '$ip'  order by  id desc limit 1";
				$row_limitlogin = $d->rawQuery($sql);
				if(!empty($row_limitlogin)){
					
			        $id_login = $row_limitlogin[0]['id'];
			        $sql="update #_users_limit set login_attempts = 0,locked_time = 0 where id = '$id_login'";
					$d->rawQuery($sql);
			   	}

				$result['status'] = 200;
				$result['message'] = 'Đăng nhập thành công';
				$result['url'] = 'index.html';
			}else{
				$sql = "select id,login_ip,login_attempts,attempt_time,locked_time from #_users_limit where login_ip =  '$ip'  order by  id desc limit 1";
				$row_check = $d->rawQuery($sql);			
				if(!empty($row_check)){//Trường hơp đã tồn tại trong database				
					$id_login = $row_check[0]['id'];
					$attempt =$row_check[0]['login_attempts'];//Số lần thực hiện
	         		$noofattmpt = $config['login-admin']['attempt'];//Số lần giới hạn
	         		 if($attempt<$noofattmpt){//Trường hợp còn trong giới hạn
						$attempt = $attempt +1;
						$sql="update #_users_limit set login_attempts = '$attempt' where id = '$id_login'";
						$d->rawQuery($sql);
						$no_ofattmpt =  $noofattmpt+1;
						$remain_attempt = $no_ofattmpt - $attempt;
						$msg = 'Sai thông tin. Còn '.$remain_attempt.' lần thử!';
						$result['status'] = 202;
	         		 }else{//Trường hợp vượt quá giới hạn
	         		 	if($row_check[0]['locked_time']==0){
			                  $attempt = $attempt +1;
			                  $timenow = time();
			                  $sql="update #_users_limit set login_attempts = '$attempt' ,locked_time = '$timenow' where id = '$id_login'";
							  $d->rawQuery($sql);
		                 }else{
			                  $attempt = $attempt +1;	                  
			                  $sql="update #_users_limit set login_attempts = '$attempt' where id = '$id_login'";
							  $d->rawQuery($sql);
		                 }

		                $delay_time = $config['login-admin']['delay'];
		                $result['status'] = 204;
	                 	$msg = "Bạn đã hết lần thử. Vui lòng thử lại sau ".$delay_time." phút!";
	         		 }
				}else{//Trường hợp IP lần đầu tiên đăng nhập sai
					$timenow = time();
					$sql="insert into #_users_limit (login_ip,login_attempts,attempt_time,locked_time) values('$ip',1,'$timenow',0)";
					$d->rawQuery($sql);
			       	$remain_attempt = $config['login-admin']['attempt'];
			        $msg = 'Sai thông tin. Còn '.$remain_attempt.' lần thử!';
			        $result['status'] = 203;
				}
				$result['message'] = $msg;
			}
			echo json_encode($result);
		}
	}

	login();
?>