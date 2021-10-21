<?php 
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @author  AP CAO
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */
    //session_destroy();
	$com = (isset($_GET['com'])) ? addslashes($_GET['com']) : "";
    $act = (isset($_GET['act'])) ? addslashes($_GET['act']) : "";
    $type = (isset($_GET['type'])) ? addslashes($_GET['type']) : "null";
	$page = (int)(!isset($_GET["p"]) ? 1 : $_GET["p"]);
    if(!isset($_SESSION['log-password'])){
        $_SESSION['log-password'] = true;
    }
	if($page <= 0) $page = 1;
	if(!$com){ $com = 'index'; $templates = 'index'; }
	if (isset($_COOKIE['remember'])) {
        $rememberme = explode(".", $_COOKIE["remember"]);
        $cookie_username = $rememberme[0];
        $cookie_key = $rememberme[1];
        $query_remember = "SELECT * FROM #_users_remember WHERE username=:username";
        $row_user_remember = $d->rawQueryOne($query_remember,array('username'=>$cookie_username));
        $token = $row_user_remember['token'];
        $salt = $row_user_remember['salt'];
        $key_login = sha1($token . $cookie_username);
        if ($key_login == $salt){
        	$query_user = "SELECT id,username,first_name,last_name,username,role,id_permission FROM #_users WHERE username=:username";
        	$row_user = $d->rawQueryOne($query_user,array('username'=>$cookie_username));
            $_SESSION[$login_name] = true;
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['login'] = array();
            $_SESSION['login']['username'] = $row_user['username'];
            $_SESSION['login']['id'] = $row_user['id'];
            $_SESSION['login']['role'] = $row_user['role'];
            $_SESSION['login']['permissions'] = $row_user['id_permission'];
        }
    }
    
    if((!isset($_SESSION[$login_name]) || $_SESSION[$login_name]==false) && $act!="login"){
        $func->redirect("index.html?com=users&act=login");
    }
    $sql_setting = "SELECT theme_admin,color_admin from #_settings limit 0,1";
    $setting_themes = $d->rawQueryOne($sql_setting);
    if($_SESSION['login']['role']==1 && $_GET['com']!='' && $_GET['act']!='logout' && $_GET['act']!='login'){
        if($func->permissionPage($com,$act,$type,$_SESSION['login']['permissions'])==0  && $_SESSION['login']['role']==1){
            $_SESSION['edit']['permissions'] = 'false';
            $func->transfer("Bạn Không có quyền vào đây !","index.html");
        }else{
            $_SESSION['edit']['permissions'] = 'true';
        }
    }
    require_once _sources.$com.'.php';
?>