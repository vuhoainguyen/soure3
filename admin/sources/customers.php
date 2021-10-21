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
	$type = (isset($_GET['type'])) ? htmlspecialchars($_GET['type']):'';
	$path = _upload_avatar;
	switch ($act) {
        case 'man':
			get_items();
			$templates = 'customers/items';
			break;
		case 'add':
			$templates = 'customers/item_add';
			break;
		case 'edit':
			get_item();
			$templates = 'customers/item_add';
			break;
		case 'save':
			save_item();
			$templates = 'customers/item_add';
			break;
		case 'delete':
			delete_item();
			break;
        
		default:
			$templates = 'index';
			break;
	}
	function get_items(){
	    global $d,$items,$type;
	    $items = $d->rawQuery("SELECT * from #_customers where type=? order by id desc",array($type));
	}
	function get_item(){
		global $d,$item,$type;
		$id = (int)$_GET['id'];
		$item  =  $d->rawQueryOne("select * from #_customers where id=? and type=?",array($id,$type));
		if(empty($item)){
			$func->transfer('Không nhận được dữ liệu','index.html');
		}
	}
	function save_item(){
		global $d,$config,$func,$type,$url_type,$setting,$path;
		$message = '';
		$id = (int)$_GET['id'];
		$table = 'customers';
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
		    		$photo = $func->uploadImg($id,'photo','thumb',$file,$path,'customers',$set['thumb-w'],$set['thumb-h'],$set['thumb-r'],$set['thumb-b']);
		    		$data['photo'] = $photo['photo'];
		    		$data['thumb'] = $photo['thumb'];
		    	}
	    	}else{
	    		if($file['error']==0){
		    		$photo = $func->uploadImg(0,'photo','thumb',$file,$path,'customers',$set['thumb-w'],$set['thumb-h'],$set['thumb-r'],$set['thumb-b']);
		    		$data['photo'] = $photo['photo'];
		    		$data['thumb'] = $photo['thumb'];
		    	}
	    	}
    	}
		if($id){
			if(!empty($data['password'])){
				$data['password'] = $func->encryptPassword($config['website']['secret'],$data['password'],$config['website']['salt']);
			}else{
				$item  =  $d->rawQueryOne("select password from #_customers where id=?",array($id));
				$data['password'] = $item['password'];
			}
			$data['updatedAt'] = $d->now();
			$data['edit_count'] = $d->inc(1);
    		$d->where('id', $id);
			if ($d->update('customers', $data)) {
			    $result['status'] = 200;
				$result['message'] = 'Đã cập nhật thông tin thành công id#'.$id;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=customers&act=edit'.$url_type.'&id='.$id.'&message='.$message);
			} else {
			  	$func->transfer('Không nhận được dữ liệu','index.html?com=customers&act=man'.$url_type);
			}
		}else{
			$email = $data['email'];
	    	$item_email  =  $d->rawQueryOne("select email from #_customers where email=?",array($email));
	    	if($item_email){
	    		$result['status'] = 201;
				$result['message'] = 'Email không được trùng';
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=customers&act=add'.$url_type.'&message='.$message);
	    	}else{
	    		$data['secret'] = $d->func('SHA1(?)',array($func->randString(20)));
				$data['activation'] = $d->func('SHA1(?)',array($func->randString(20)));
			    $data['status'] = 'hienthi';
				$data['type'] = $type;
				$data['password'] = $func->encryptPassword($config['website']['secret'],$data['password'],$config['website']['salt']);
				$data['createdAt'] = $d->now();
				$id_insert = $d->insert('customers', $data);
				if ($id_insert) {

					$datai['userid'] = 'USER'.str_pad($id_insert, 6, "0", STR_PAD_LEFT);
					$d->where('id', $id);
					$d->update('customers', $datai);

				    $result['status'] = 200;
					$result['message'] = 'Đã thêm dữ liệu thành công id#'.$id_insert;
					$message = base64_encode(json_encode($result));
					$func->redirect('index.html?com=customers&act=man'.$url_type.'&message='.$message);
				} else {
				    
				}
	    	}

			
		}
	}
	function delete_item(){
		global $d,$func,$url_type;
		$id = (int)$_GET['id'];

		if(isset($_GET['id'])){
			$item  =  $d->rawQueryOne("select id from #_customers where id=?",array($id));
			if($item){
				$d->where('id', $item['id']);
				$d->delete('customers');
	        	$result['status'] = 200;
				$result['message'] = 'Đã xóa dữ liệu thành công id#'.$id;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=customers&act=man'.$url_type.'&message='.$message);
			}else{
				$func->transfer('Không nhận được dữ liệu','index.html?com=customers&act=man'.$url_type);
			}
		}elseif(isset($_GET['listid'])){
			$listid = explode(",",$_GET['listid']);
			if(count($listid)){
				$result['message'] = 'Đã xóa dữ liệu thành công id#';
				foreach ($listid as $k => $v) {
					$id = (int)$v;
					$item  =  $d->rawQueryOne("select id from #_customers where id=?",array($id));
					if($item){
						$d->where('id', $item['id']);
						$d->delete('customers');
						$result['message'] .= $id.',';
					}
				}
				$result['message'] = substr($result['message'], 0, -1);
				$result['status'] = 200;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=customers&act=man'.$url_type.'&message='.$message);
			}else{
				$func->transfer('Không nhận được dữ liệu','index.html?com=customers&act=man'.$url_type);
			}
		}

	}
?>