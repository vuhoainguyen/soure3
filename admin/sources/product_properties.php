<?php 
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @author  AP CAO
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */
	$url_type = (isset($_GET['id_product'])) ? '&id_product='.htmlspecialchars($_GET['id_product']):'';
	$url_type .= (isset($_GET['type'])) ? '&type='.htmlspecialchars($_GET['type']):'';
	$path = _upload_properties;
	switch ($act) {
        case 'man':
			get_items();
			$templates = 'product_properties/items';
			break;
		case 'add':
			$templates = 'product_properties/item_add';
			break;
		case 'edit':
			get_item();
			$templates = 'product_properties/item_add';
			break;
		case 'save':
			save_item();
			$templates = 'product_properties/item_add';
			break;
		case 'delete':
			delete_item();
			break;
       
		default:
			$templates = 'product_properties/items';
			break;
	}

	function get_items(){
		global $d,$config,$items,$page,$paging,$func,$url_type;
		$id_product = htmlspecialchars($_GET['id_product']);
		$type = htmlspecialchars($_GET['type']);
		$param = array($type,$id_product);

		if($config['paging-table']==true){
		    $items = $d->rawQuery("SELECT * from #_product_properties where type=? and id_product=? order by numb asc, id desc",$param);
		}else{
			$per_page = 10;
	        $startpoint = ($page * $per_page) - $per_page;
	        $limit = ' limit '.$startpoint.','.$per_page;
	        $sql = "SELECT * from #_product_properties where type=? and id_product=? order by numb asc, id desc ".$limit;
	        $items = $d->rawQuery($sql,$param);
	        $sqlq = "SELECT COUNT(*) as `num` from #_product_properties where type=? and id_product=? order by numb asc, id desc";
	        $count = $d->rawQueryOne($sqlq,$param);
	       	$total = $count['num'];
	        $url = 'index.html?com=product_properties&act=man'.$url_type;
			$paging = $func->pagination($total,$per_page,$page,$url);
		}
	}
	function get_item(){
		global $d,$item,$items_photo;
		$id = (int)$_GET['id'];
		$id_product = (int)$_GET['id_product'];
		$type = (string)$_GET['type'];
		$item  =  $d->rawQueryOne("select * from #_product_properties where id=?",array($id));
		if(empty($item)){
			$func->transfer('Không nhận được dữ liệu','index.html');
		}
		$items_photo = $d->rawQuery("SELECT * from #_product_photo_properties where id_product=? and type=? order by numb asc, id desc",array($id,$type));
	}
	function save_item(){
		global $d,$config,$func,$url_type,$path,$setting;
		$message = '';
		$id = (int)$_GET['id'];
		$com = (string)$_GET['com'];
		$type = (string)$_GET['type'];
		$set = $setting[$com][$type];
		
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
	    			$photo = $func->uploadImg($id,'photo','thumb',$file,$path,'product_properties',$set['thumb-w'],$set['thumb-h'],$set['thumb-r'],$set['thumb-b']);
		    		$data['photo'] = $photo['photo'];
		    		$data['thumb'] = $photo['thumb'];
	    		}
	    	}else{
	    		if($file['error']==0){
	    			$photo = $func->uploadImg(0,'photo','thumb',$file,$path,'product_properties',$set['thumb-w'],$set['thumb-h'],$set['thumb-r'],$set['thumb-b']);
		    		$data['photo'] = $photo['photo'];
		    		$data['thumb'] = $photo['thumb'];
	    		}
	    	}
    	}

    	$data['id_product'] = (int)$_GET['id_product'];
    	if($data['price']){
			$data['price'] = str_replace(',', '', $data['price']);
		}
		if($data['qty']){
			$data['qty'] = $data['qty'];
		}
    	if($id){
    		$data['updatedAt'] = $d->now();
			$data['edit_count'] = $d->inc(1);
    		$d->where('id', $id);
			if ($d->update('product_properties', $data)) {

				if (!empty($_FILES['files']) && count($_FILES['files'])>0) {
		            if (isset($_FILES['files'])) {
		            	for($i=0;$i<count($_FILES['files']['name']);$i++){
		            		if($_FILES['files']['error'][$i]!=4){
		            			$files['name'] = $_FILES['files']['name'][$i];
								$files['type'] = $_FILES['files']['type'][$i];
								$files['tmp_name'] = $_FILES['files']['tmp_name'][$i];
								$files['error'] = $_FILES['files']['error'][$i];
								$files['size'] = $_FILES['files']['size'][$i];
								$photo_multi = $func->uploadImg(0,'photo','thumb',$files,$path,'product_photo_properties',$set['thumb-wm'],$set['thumb-hm'],$set['thumb-rm'],$set['thumb-bm']);
					    		$data_x['photo'] = $photo_multi['photo'];
					    		$data_x['thumb'] = $photo_multi['thumb'];
					    		$data_x['id_product'] = $id;
					    		$data_x['status'] = 'hienthi';
					    		$data_x['type'] = $type;
					    		$data_x['createdAt'] = $d->now();
					    		$data_x['author_id'] = $_SESSION['login']['id'];
					    		$id_insert_multi = $d->insert('product_photo_properties', $data_x);
		            		}
		            	}
		            }
		        }

			    $result['status'] = 200;
				$result['message'] = 'Đã cập nhật thông tin thành công id#'.$id;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=product_properties&act=edit'.$url_type.'&id='.$id.'&message='.$message);
			} else {
			  	$func->transfer('Không nhận được dữ liệu','index.html?com=product_properties&act=man'.$url_type);
			}
    	}else{
    		$data['status'] = 'hienthi';
    		$data['type'] = htmlspecialchars($_GET['type']);
    		$data['createdAt'] = $d->now();
    		$data['author_id'] = $_SESSION['login']['id'];
    		$id_insert = $d->insert('product_properties', $data);
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
								$photo_multi = $func->uploadImg(0,'photo','thumb',$files,$path,'product_photo_properties',$set['thumb-wm'],$set['thumb-hm'],$set['thumb-rm'],$set['thumb-bm']);
					    		$data_x['photo'] = $photo_multi['photo'];
					    		$data_x['thumb'] = $photo_multi['thumb'];
					    		$data_x['id_product'] = $id_insert;
					    		$data_x['type'] = $type;
					    		$data_x['status'] = 'hienthi';
					    		$data_x['createdAt'] = $d->now();
					    		$data_x['author_id'] = $_SESSION['login']['id'];
					    		$id_insert_multi = $d->insert('product_photo_properties', $data_x);
		            		}
		            	}
		            }
		        }

			    $result['status'] = 200;
				$result['message'] = 'Đã thêm dữ liệu thành công id#'.$id_insert;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=product_properties&act=man'.$url_type.'&message='.$message);
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
			$item  =  $d->rawQueryOne("select id from #_product_properties where id=?",array($id));
			if($item){
				$d->where('id', $item['id']);
				$d->delete('product_properties');
	        	$result['status'] = 200;
				$result['message'] = 'Đã xóa dữ liệu thành công id#'.$id;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=product_properties&act=man'.$url_type.'&message='.$message);
			}else{
				$func->transfer('Không nhận được dữ liệu','index.html?com=product_properties&act=man'.$url_type);
			}
		}elseif(isset($_GET['listid'])){
			$listid = explode(",",$_GET['listid']);
			if(count($listid)){
				$result['message'] = 'Đã xóa dữ liệu thành công id#';
				foreach ($listid as $k => $v) {
					$id = (int)$v;
					$item  =  $d->rawQueryOne("select id from #_product_properties where id=?",array($id));
					if($item){
						$d->where('id', $item['id']);
						$d->delete('product_properties');
						$result['message'] .= $id.',';
					}
				}
				$result['message'] = substr($result['message'], 0, -1);
				$result['status'] = 200;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=product_properties&act=man'.$url_type.'&message='.$message);
			}else{
				$func->transfer('Không nhận được dữ liệu','index.html?com=product_properties&act=man'.$url_type);
			}
		}

	}
?>