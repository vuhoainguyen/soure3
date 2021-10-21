<?php 
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @author  AP CAO
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */
	$url_type = (isset($_GET['table'])) ? '&table='.htmlspecialchars($_GET['table']):'';
	$url_type .= (isset($_GET['type'])) ? '&type='.htmlspecialchars($_GET['type']):'';
	$url_type .= (isset($_GET['id_list'])) ? '&id_list='.htmlspecialchars($_GET['id_list']):'';

	if($_GET['table']=='products'){
		$path = _upload_product;
	}elseif($_GET['table']=='posts'){
		$path = _upload_post;
	}else{
		$path = _upload_photo;
	}

	switch ($act) {
        case 'man':
        	getListPage();
			get_items();
			$templates = 'cats/items';
			break;
		case 'add':
			getListPage();
			$templates = 'cats/item_add';
			break;
		case 'edit':
			getListPage();
			get_item();
			$templates = 'cats/item_add';
			break;
		case 'save':
			save_item();
			$templates = 'cats/item_add';
			break;
		case 'delete':
			delete_item();
			break;
		default:
			$templates = 'cats/items';
			break;
	}
	function getListPage(){
		global $d,$items_list;
		$table = htmlspecialchars($_GET['table']);
		$type = htmlspecialchars($_GET['type']);
		$param = array($type,$table);
		$items_list = $d->rawQuery("SELECT * from #_lists where type=? and tmp_table=? order by numb asc, id desc",$param);
	}
	function get_items(){
		global $d,$config,$items,$page,$paging,$func,$url_type;
	   	$table = htmlspecialchars($_GET['table']);
		$type = htmlspecialchars($_GET['type']);
		$param = array($type,$table);
	   	if($_GET['id_list'] && $_GET['id_list']!=0){
	   		$where .= " and id_list=".(int)$_GET['id_list'];
	   	}
	    if($config['paging-table']==true){
		    $items = $d->rawQuery("SELECT * from #_cats where type=? and tmp_table=? $where order by numb asc, id desc",$param);
		}else{
			$per_page = 10;
	        $startpoint = ($page * $per_page) - $per_page;
	        $limit = ' limit '.$startpoint.','.$per_page;
	        $sql = "SELECT * from #_cats where type=? and tmp_table=? $where order by numb asc, id desc ".$limit;
	        $items = $d->rawQuery($sql,$param);
	        $sqlq = "SELECT COUNT(*) as `num` from #_cats where type=? and tmp_table=? $where order by numb asc, id desc";
	        $count = $d->rawQueryOne($sqlq,$param);
	       	$total = $count['num'];
	        $url = 'index.html?com=cats&act=man'.$url_type;
			$paging = $func->pagination($total,$per_page,$page,$url);
		}
	}
	function get_item(){
		global $d,$item;
		$id = (int)$_GET['id'];
		$item  =  $d->rawQueryOne("select * from #_cats where id=?",array($id));
		if(empty($item)){
			$func->transfer('Không nhận được dữ liệu','index.html');
		}
	}
	function save_item(){
		global $d,$config,$func,$url_type,$path,$setting;
		$message = '';
		$id = (int)$_GET['id'];
		$table = (string)$_GET['table'];
		$type = (string)$_GET['type'];
		$set = $setting[$table][$type];
		
		$data = $_POST['data'];
    	if($_POST){
    		foreach ($data as $k => $v) {
				$data[$k] = htmlspecialchars($v);
			}
    	}
    	$file = $_FILES['photo'];
    	if($id){
    		if($file['error']==0){
	    		$photo = $func->uploadImg($id,'photo','thumb',$file,$path,'cats',$set['cat-thumb-w'],$set['cat-thumb-h'],$set['cat-thumb-r'],$set['cat-thumb-b']);
	    		$data['photo'] = $photo['photo'];
	    		$data['thumb'] = $photo['thumb'];
	    	}
    	}else{
    		if($file['error']==0){
	    		$photo = $func->uploadImg(0,'photo','thumb',$file,$path,'cats',$set['cat-thumb-w'],$set['cat-thumb-h'],$set['cat-thumb-r'],$set['cat-thumb-b']);
	    		$data['photo'] = $photo['photo'];
	    		$data['thumb'] = $photo['thumb'];
	    	}
    	}

    	if($id){
    		$data['updatedAt'] = $d->now();
			$data['edit_count'] = $d->inc(1);
    		$d->where('id', $id);
			if ($d->update('cats', $data)) {
			    $result['status'] = 200;
				$result['message'] = 'Đã cập nhật thông tin thành công id#'.$id;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=cats&act=edit'.$url_type.'&id='.$id.'&message='.$message);
			} else {
			  	$func->transfer('Không nhận được dữ liệu','index.html?com=cats&act=man'.$url_type);
			}
    	}else{
    		$data['status'] = 'hienthi';
    		$data['tmp_table'] = htmlspecialchars($_GET['table']);
    		$data['type'] = htmlspecialchars($_GET['type']);
    		$data['createdAt'] = $d->now();
    		$data['author_id'] = $_SESSION['login']['id'];
    		$id_insert = $d->insert('cats', $data);
			if ($id_insert) {
			    $result['status'] = 200;
				$result['message'] = 'Đã thêm dữ liệu thành công id#'.$id_insert;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=cats&act=add'.$url_type.'&message='.$message);
			}
    	}
	}
	function delete_item(){
		global $d,$func,$url_type,$path;
		$id = (int)$_GET['id'];
		if(isset($_GET['id'])){
			$item  =  $d->rawQueryOne("select id,photo,thumb from #_cats where id=?",array($id));
			if($item){
				$func->deleteFile($path.$item['photo']);
				$func->deleteFile($path.$item['thumb']);

				$d->where('id', $item['id']);
				$d->delete('cats');
	        	$result['status'] = 200;
				$result['message'] = 'Đã xóa dữ liệu thành công id#'.$id;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=cats&act=man'.$url_type.'&message='.$message);
			}else{
				$func->transfer('Không nhận được dữ liệu','index.html');
			}
		}elseif(isset($_GET['listid'])){
			$listid = explode(",",$_GET['listid']);
			if(count($listid)){
				$result['message'] = 'Đã xóa dữ liệu thành công id#';
				foreach ($listid as $k => $v) {
					$id = (int)$v;
					$item  =  $d->rawQueryOne("select id,photo,thumb from #_cats where id=?",array($id));
					if($item){
						$func->deleteFile($path.$item['photo']);
						$func->deleteFile($path.$item['thumb']);
						$d->where('id', $item['id']);
						$d->delete('cats');
						$result['message'] .= $id.',';
					}
				}
				$result['message'] = substr($result['message'], 0, -1);
				$result['status'] = 200;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=cats&act=man'.$url_type.'&message='.$message);
			}else{
				$func->transfer('Không nhận được dữ liệu','index.html?com=cats&act=man');
			}
		}
	}
?>