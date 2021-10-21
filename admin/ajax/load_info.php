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

	$item  =  $d->rawQueryOne("select * from #_customers where id=?",array($i));
	if($item){
		$dist  =  $d->rawQuery("select * from #_place_dists where id_city=? order by numb asc, id desc",array($item['id_city']));
		$str_dist = '';
			$str_dist .= '<option>Chọn quận / huyện</option>';
		for($i=0;$i<count($dist);$i++){
			$selected = ($dist[$i]['id']==$item['id_dist']) ? 'selected':'';
			$str_dist .= '<option value="'.$dist[$i]['id'].'" '.$selected.'>'.trim($dist[$i]['code'].' '.$dist[$i]['name_vi']).'</option>';
		}
		$result['status'] = 200;
		$result['item'] = $item;
		$result['dist'] = $dist;
		$result['dist_option'] = $str_dist;
	}else{
		$result['item']['email'] = '';
		$result['item']['phone'] = '';
		$result['item']['address'] = '';
		$result['item']['fullname'] = '';
		$result['item']['id_city'] = 1;
		$result['status'] = 201;
	}
	echo json_encode($result);
?>