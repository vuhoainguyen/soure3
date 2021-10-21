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
        $field = htmlspecialchars($_POST['f']);

        $co = htmlspecialchars($_POST['co']);
        $ty = htmlspecialchars($_POST['ty']);
        $ac = htmlspecialchars($_POST['ac']);
        
        if($func->permissionPage($co,$ty,$ac,$_SESSION['login']['quyen'])==0 && $_SESSION['login']['role']==1){
			$result['status'] = 0;
		}else{
			$data[$field] = $value;
			$d->where('id', $id);
			if($d->update($table, $data)){
				$result['status'] = 1;
			}else{
				$result['status'] = 0;
			}
		}
		echo json_encode($result);
	}
?>