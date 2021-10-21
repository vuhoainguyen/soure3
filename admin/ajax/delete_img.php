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

	$i = (int)htmlspecialchars($_POST['i']);
	$t = htmlspecialchars($_POST['t']);
	$p = htmlspecialchars($_POST['p']);
	$f = ($_POST['f']) ? ','.htmlspecialchars($_POST['f']):'';

	$item  =  $d->rawQueryOne("select id,photo,thumb $f from #_$t where id=?",array($i));
	if($item){
		if($_POST['f']){
			$ex = explode(',',htmlspecialchars($_POST['f']));
			if(count($ex)){
				foreach ($ex as $k => $v) {
					if($v!='id_parent'){
						$func->deleteFile('../'.$p.$item[$v]);
						$data[$v] = '';
					}
				}
			}
		}else{
			$func->deleteFile('../'.$p.$item['photo']);
			$func->deleteFile('../'.$p.$item['thumb']);
			$data['photo'] = '';
			$data['thumb'] = '';
		}

		$d->where('id', $i);
		$d->update($t, $data);

		if($t=='multi_photos' || $t=='product_photos' || $t=='product_photo_properties'){
			if($t=='multi_photos'){
				if($item['id_parent']!=0){
					$d->where('id', $i);
					$d->delete($t);
				}
			}else{
				$d->where('id', $i);
				$d->delete($t);
			}
		}
		
    	$result['status'] = 200;
		$result['message'] = 'Đã xóa hình ảnh thành công';
		echo $message =json_encode($result);
	}else{

		$result['status'] = 201;
		$result['message'] = 'Xóa hình ảnh thất bại';
		echo $message =json_encode($result);
	}
?>