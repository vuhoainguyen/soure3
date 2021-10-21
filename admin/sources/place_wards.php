<?php 
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @author  AP CAO
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */
	$id_city = (isset($_GET['id_city'])) ? (int)$_GET['id_city']:'';
	$id_dist = (isset($_GET['id_dist'])) ? (int)$_GET['id_dist']:'';
	$url_link .= (isset($_GET['id_city'])) ? '&id_city='.(int)$_GET['id_city']:'';
	$url_link .= (isset($_GET['id_dist'])) ? '&id_dist='.(int)$_GET['id_dist']:'';
	switch ($act) {
        case 'man':
        	getPlaceA();
			get_items();
			$templates = 'place_wards/items';
			break;
		case 'add':
			getPlaceA();
			$templates = 'place_wards/item_add';
			break;
		case 'edit':
			get_item();
			getPlaceA();
			$templates = 'place_wards/item_add';
			break;
		case 'save':
			save_item();
			$templates = 'place_wards/item_add';
			break;
		case 'delete':
			delete_item();
			break;
       
		default:
			$templates = 'place_wards/items';
			break;
	}
	function getPlaceA(){
		global $d,$item_citys,$id_city,$item,$item_dists;
		$item_citys  =  $d->rawQuery("select * from #_place_citys order by numb asc");
		if($id_city || $item){
			$id_city = (!empty($item)) ? $item['id_city']:$id_city;
			$item_dists  =  $d->rawQuery("select * from #_place_dists where id_city=? order by numb asc", array($id_city));
		}
		
	}
	function get_items(){
		global $d,$config,$items,$page,$paging,$func,$url_link,$id_city,$id_dist;

		if($id_city!=''){
			$where .= ' and id_city='.$id_city;
		}
		if($id_dist!=''){
			$where .= ' and id_dist='.$id_dist;
		}

		$per_page = 10;
        $startpoint = ($page * $per_page) - $per_page;
        $limit = ' limit '.$startpoint.','.$per_page;
        $sql = "SELECT * from #_place_wards where id<>0 $where order by id_city asc, id_dist asc, numb asc, id desc ".$limit;
        $items = $d->rawQuery($sql,$param);
        $sqlq = "SELECT COUNT(*) as `num` from #_place_wards where id<>0 $where order by id_city asc, id_dist asc, numb asc, id desc";
        $count = $d->rawQueryOne($sqlq,$param);
       	$total = $count['num'];
        $url = 'index.html?com=place_wards&act=man'.$url_link;
		$paging = $func->pagination($total,$per_page,$page,$url);

	}
	function get_item(){
		global $d,$item;
		$id = (int)$_GET['id'];
		$item  =  $d->rawQueryOne("select * from #_place_wards where id=?",array($id));
		if(empty($item)){
			$func->transfer('Không nhận được dữ liệu','index.html');
		}
	}
	function save_item(){
		global $d,$config,$func,$url_type;
		$message = '';
		$id = (int)$_GET['id'];
		$data = $_POST['data'];
    	if($_POST){
    		foreach ($data as $k => $v) {
				$data[$k] = htmlspecialchars($v);
			}
    	}
    	if($id){
    		$data['updatedAt'] = $d->now();
			$data['edit_count'] = $d->inc(1);
    		$d->where('id', $id);
			if ($d->update('place_wards', $data)) {
			    $result['status'] = 200;
				$result['message'] = 'Đã cập nhật thông tin thành công id#'.$id;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=place_wards&act=edit&id='.$id.'&message='.$message);
			} else {
			  	$func->transfer('Không nhận được dữ liệu','index.html?com=place_wards&act=man');
			}
    	}else{
    		$data['status'] = 'hienthi';
    		$data['createdAt'] = $d->now();
    		$data['author_id'] = $_SESSION['login']['id'];
    		$id_insert = $d->insert('place_wards', $data);
			if ($id_insert) {
			    $result['status'] = 200;
				$result['message'] = 'Đã thêm dữ liệu thành công id#'.$id_insert;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=place_wards&act=man&message='.$message);
			}
    	}
	}
	function delete_item(){
		global $d,$func,$url_type,$path;
		$id = (int)$_GET['id'];

		if(isset($_GET['id'])){
			$item  =  $d->rawQueryOne("select id from #_place_wards where id=?",array($id));
			if($item){
				$d->where('id', $item['id']);
				$d->delete('place_wards');
	        	$result['status'] = 200;
				$result['message'] = 'Đã xóa dữ liệu thành công id#'.$id;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=place_wards&act=man&message='.$message);
			}else{
				$func->transfer('Không nhận được dữ liệu','index.html');
			}
		}elseif(isset($_GET['listid'])){
			$listid = explode(",",$_GET['listid']);
			if(count($listid)){
				$result['message'] = 'Đã xóa dữ liệu thành công id#';
				foreach ($listid as $k => $v) {
					$id = (int)$v;
					$item  =  $d->rawQueryOne("select id from #_place_wards where id=?",array($id));
					if($item){
						$d->where('id', $item['id']);
						$d->delete('place_wards');
						$result['message'] .= $id.',';
					}
				}
				$result['message'] = substr($result['message'], 0, -1);
				$result['status'] = 200;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=place_wards&act=man&message='.$message);
			}else{
				$func->transfer('Không nhận được dữ liệu','index.html?com=place_wards&act=man');
			}
		}

	}
?>