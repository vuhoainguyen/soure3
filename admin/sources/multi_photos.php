<?php 
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @author  AP CAO
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */
	$url_type .= (isset($_GET['type'])) ? '&type='.htmlspecialchars($_GET['type']):'';
	$path = _upload_photo;
	
	switch ($act) {
        case 'man':
			get_items();
			$templates = 'multi_photos/items';
			break;
		case 'add':
			getListPage();
			$templates = 'multi_photos/item_add';
			break;
		case 'edit':
			get_item();
			getListPage();
			$templates = 'multi_photos/item_add';
			break;
		case 'save':
			save_item();
			$templates = 'multi_photos/item_add';
			break;
		case 'delete':
			delete_item();
			break;
		default:
			$templates = 'multi_photos/items';
			break;
	}
	function getListPage(){
		global $d,$items_photo,$item;
		$id = (int)$_GET['id'];
		$type = htmlspecialchars($_GET['type']);
		$param = array($id,$type);
		if($id){
			$items_photo = $d->rawQuery("SELECT * from #_multi_photos where id_parent=? and type=? order by numb asc, id desc",$param);
		}
	}
	function get_items(){
		global $d,$config,$items,$page,$paging,$func,$url_type;
		$type = htmlspecialchars($_GET['type']);
		$param = array($type);
	    if($config['paging-table']==true){
		    $items = $d->rawQuery("SELECT * from #_multi_photos where type=? and id_parent=0 order by numb asc, id desc",$param);
		}else{
			$per_page = 10;
	        $startpoint = ($page * $per_page) - $per_page;
	        $limit = ' limit '.$startpoint.','.$per_page;
	        $sql = "SELECT * from #_multi_photos where type=? and id_parent=0 order by numb asc, id desc ".$limit;
	        $items = $d->rawQuery($sql,$param);
	        $sqlq = "SELECT COUNT(*) as `num` from #_multi_photos where type=? and id_parent=0 order by numb asc, id desc";
	        $count = $d->rawQueryOne($sqlq,$param);
	       	$total = $count['num'];
	        $url = 'index.html?com=multi_photos&act=man'.$url_type;
			$paging = $func->pagination($total,$per_page,$page,$url);
		}
	}
	function get_item(){
		global $d,$item;
		$id = (int)$_GET['id'];
		$item  =  $d->rawQueryOne("select * from #_multi_photos where id=?",array($id));
		if(empty($item)){
			$func->transfer('Không nhận được dữ liệu','index.html');
		}
	}
	function save_item(){
		global $d,$config,$func,$url_type,$path,$setting;
		$message = '';
		$id = (int)$_GET['id'];
		$table = 'multi_photos';
		$type = (string)$_GET['type'];
		$set = $setting[$table][$type];
		
		$data = $_POST['data'];
    	if($_POST){
    		foreach ($data as $k => $v) {
				$data[$k] = htmlspecialchars($v);
			}
    	}
    	$file = $_FILES['photo'];
    	if($file){
    		if($id){
	    		if($file['error']==0){
	    			$photo = $func->uploadImg($id,'photo','thumb',$file,$path,'multi_photos',$set['thumb-w'],$set['thumb-h'],$set['thumb-r'],$set['thumb-b']);
		    		$data['photo'] = $photo['photo'];
		    		$data['thumb'] = $photo['thumb'];
	    		}
	    	}else{
	    		if($file['error']==0){
	    			$photo = $func->uploadImg(0,'photo','thumb',$file,$path,'multi_photos',$set['thumb-w'],$set['thumb-h'],$set['thumb-r'],$set['thumb-b']);
		    		$data['photo'] = $photo['photo'];
		    		$data['thumb'] = $photo['thumb'];
	    		}
	    	}
    	}

    	$file_icon = $_FILES['icon'];
    	if($file_icon){
    		if($id){
	    		if($file_icon['error']==0){
	    			$photo = $func->uploadImg($id,'icon','icon_thumb',$file_icon,$path,'multi_photos',$set['thumb-iw'],$set['thumb-ih'],$set['thumb-ir'],$set['thumb-ib']);
		    		$data['icon'] = $photo['icon'];
		    		$data['icon_thumb'] = $photo['icon_thumb'];
	    		}
	    	}else{
	    		if($file_icon['error']==0){
	    			$photo = $func->uploadImg(0,'icon','icon_thumb',$file_icon,$path,'multi_photos',$set['thumb-iw'],$set['thumb-ih'],$set['thumb-ir'],$set['thumb-ib']);
		    		$data['icon'] = $photo['icon'];
		    		$data['icon_thumb'] = $photo['icon_thumb'];
	    		}
	    	}
    	}
    	
        if($data['price']){
			$data['price'] = str_replace(',', '', $data['price']);
		}
		if($data['price_old']){
    		$data['price_old'] = str_replace(',', '', $data['price_old']);
    	}
    	if($id){
    		$data['updatedAt'] = $d->now();
			$data['edit_count'] = $d->inc(1);
    		$d->where('id', $id);
			if ($d->update('multi_photos', $data)) {
				if (!empty($_FILES['files']) && count($_FILES['files'])>0) {
		            if (isset($_FILES['files'])) {
		            	for($i=0;$i<count($_FILES['files']['name']);$i++){
		            		if($_FILES['files']['error'][$i]!=4){
		            			$files['name'] = $_FILES['files']['name'][$i];
								$files['type'] = $_FILES['files']['type'][$i];
								$files['tmp_name'] = $_FILES['files']['tmp_name'][$i];
								$files['error'] = $_FILES['files']['error'][$i];
								$files['size'] = $_FILES['files']['size'][$i];
								$photo_multi = $func->uploadImg(0,'photo','thumb',$files,$path,'multi_photos',$set['thumb-w'],$set['thumb-h'],$set['thumb-r'],$set['thumb-b']);
					    		$data_x['photo'] = $photo_multi['photo'];
					    		$data_x['thumb'] = $photo_multi['thumb'];
					    		$data_x['id_parent'] = $id;
					    		$data_x['status'] = 'hienthi';
					    		$data_x['numb'] = $_POST['numb'][$i];
					    		$data_x['alt_vi'] = $_POST['alt_vi'][$i];
					    		$data_x['type'] = $type;
					    		$data_x['createdAt'] = $d->now();
					    		$data_x['author_id'] = $_SESSION['login']['id'];
					    		$id_insert_multi = $d->insert('multi_photos', $data_x);
		            		}
		            	}
		            }
		        }

			    $result['status'] = 200;
				$result['message'] = 'Đã cập nhật thông tin thành công id#'.$id;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=multi_photos&act=edit'.$url_type.'&id='.$id.'&message='.$message);
			} else {
				print_r($d->getLastError());
				die;
			  	$func->transfer('Không nhận được dữ liệu','index.html?com=multi_photos&act=man'.$url_type);
			}
    	}else{
    		$data['status'] = 'hienthi';
    		$data['type'] = htmlspecialchars($_GET['type']);
    		$data['createdAt'] = $d->now();
    		$data['author_id'] = $_SESSION['login']['id'];
    		$id_insert = $d->insert('multi_photos', $data);
			if ($id_insert) {
				if (!empty($_FILES['files']) && count($_FILES['files'])>0) {
		            if (isset($_FILES['files'])) {
		            	for($i=0;$i<count($_FILES['files']['name']);$i++){
		            		if($_FILES['files']['error'][$i]!=4){
		            			$files['name'] = $_FILES['files']['name'][$i];
								$files['type'] = $_FILES['files']['type'][$i];
								$files['tmp_name'] = $_FILES['files']['tmp_name'][$i];
								$files['error'] = $_FILES['files']['error'][$i];
								$files['size'] = $_FILES['files']['size'][$i];
								$photo_multi = $func->uploadImg(0,'photo','thumb',$files,$path,'multi_photos',$set['thumb-w'],$set['thumb-h'],$set['thumb-r'],$set['thumb-b']);
					    		$data_x['photo'] = $photo_multi['photo'];
					    		$data_x['thumb'] = $photo_multi['thumb'];
					    		$data_x['numb'] = $_POST['numb'][$i];
					    		$data_x['alt_vi'] = $_POST['alt_vi'][$i];
					    		$data_x['id_parent'] = $id_insert;
					    		$data_x['type'] = $type;
					    		$data_x['status'] = 'hienthi';
					    		$data_x['createdAt'] = $d->now();
					    		$data_x['author_id'] = $_SESSION['login']['id'];
					    		$id_insert_multi = $d->insert('multi_photos', $data_x);
		            		}
		            	}
		            }
		        }

			    $result['status'] = 200;
				$result['message'] = 'Đã thêm dữ liệu thành công id#'.$id_insert;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=multi_photos&act=man'.$url_type.'&message='.$message);
			}else{
				print_r($d->getLastError());
				die;
			}
    	}
	}
	function delete_item(){
		global $d,$func,$url_type,$path;
		$id = (int)$_GET['id'];
		if(isset($_GET['id'])){
			$item  =  $d->rawQueryOne("select id,photo,thumb,icon,icon_thumb from #_multi_photos where id=?",array($id));
			if($item){
				$func->deleteFile($path.$item['photo']);
				$func->deleteFile($path.$item['thumb']);

				$func->deleteFile($path.$item['icon']);
				$func->deleteFile($path.$item['icon_thumb']);

				$d->where('id', $item['id']);
				$d->delete('multi_photos');
	        	$result['status'] = 200;
				$result['message'] = 'Đã xóa dữ liệu thành công id#'.$id;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=multi_photos&act=man'.$url_type.'&message='.$message);
			}else{
				$func->transfer('Không nhận được dữ liệu','index.html');
			}
		}elseif(isset($_GET['listid'])){
			$listid = explode(",",$_GET['listid']);
			if(count($listid)){
				$result['message'] = 'Đã xóa dữ liệu thành công id#';
				foreach ($listid as $k => $v) {
					$id = (int)$v;
					$item  =  $d->rawQueryOne("select id,photo,thumb,icon,icon_thumb from #_multi_photos where id=?",array($id));
					if($item){
						$func->deleteFile($path.$item['photo']);
						$func->deleteFile($path.$item['thumb']);

						$func->deleteFile($path.$item['icon']);
						$func->deleteFile($path.$item['icon_thumb']);

						$d->where('id', $item['id']);
						$d->delete('multi_photos');
						$result['message'] .= $id.',';
					}
				}
				$result['message'] = substr($result['message'], 0, -1);
				$result['status'] = 200;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=multi_photos&act=man'.$url_type.'&message='.$message);
			}else{
				$func->transfer('Không nhận được dữ liệu','index.html?com=multi_photos&act=man');
			}
		}
	}
?>