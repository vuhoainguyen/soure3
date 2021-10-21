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
	$path = _upload_photo;
	switch ($act) {
        case 'man':
			get_items();
			$templates = 'sends/items';
			break;
		case 'add':
			$templates = 'sends/item_add';
			break;
		case 'edit':
			get_item();
			$templates = 'sends/item_add';
			break;
		case 'save':
			save_item();
			$templates = 'sends/item_add';
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
	    $items = $d->rawQuery("SELECT * from #_sends where type=? order by id desc",array($type));
	}
	function get_item(){
		global $d,$item,$type;
		$id = (int)$_GET['id'];
		$item  =  $d->rawQueryOne("select * from #_sends where id=? and type=?",array($id,$type));
		if(empty($item)){
			$func->transfer('Không nhận được dữ liệu','index.html');
		}
	}
	function save_item(){
		global $d,$config,$func,$type,$url_type,$setting,$path;
		$message = '';
		$id = (int)$_GET['id'];
		$table = 'sends';
		$set = $setting[$table][$type];

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
			if ($d->update('sends', $data)) {
			    $result['status'] = 200;
				$result['message'] = 'Đã cập nhật thông tin thành công id#'.$id;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=sends&act=edit'.$url_type.'&id='.$id.'&message='.$message);
			} else {
			  	$func->transfer('Không nhận được dữ liệu','index.html?com=sends&act=man'.$url_type);
			}
		}else{
			$email = $data['email'];
	    	$item_email  =  $d->rawQueryOne("select email from #_sends where email=?",array($email));
	    	if($item_email){
	    		$result['status'] = 201;
				$result['message'] = 'Email không được trùng';
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=sends&act=add'.$url_type.'&message='.$message);
	    	}else{
			    $data['status'] = 'hienthi';
				$data['type'] = $type;
				$data['createdAt'] = $d->now();
				$id_insert = $d->insert('sends', $data);
				if ($id_insert) {
				    $result['status'] = 200;
					$result['message'] = 'Đã thêm dữ liệu thành công id#'.$id_insert;
					$message = base64_encode(json_encode($result));
					$func->redirect('index.html?com=sends&act=man'.$url_type.'&message='.$message);
				}
	    	}
		}
	}
	function delete_item(){
		global $d,$func,$url_type;
		$id = (int)$_GET['id'];

		if(isset($_GET['id'])){
			$item  =  $d->rawQueryOne("select id from #_sends where id=?",array($id));
			if($item){
				$d->where('id', $item['id']);
				$d->delete('sends');
	        	$result['status'] = 200;
				$result['message'] = 'Đã xóa dữ liệu thành công id#'.$id;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=sends&act=man'.$url_type.'&message='.$message);
			}else{
				$func->transfer('Không nhận được dữ liệu','index.html?com=sends&act=man'.$url_type);
			}
		}elseif(isset($_GET['listid'])){
			$listid = explode(",",$_GET['listid']);
			if(count($listid)){
				$result['message'] = 'Đã xóa dữ liệu thành công id#';
				foreach ($listid as $k => $v) {
					$id = (int)$v;
					$item  =  $d->rawQueryOne("select id from #_sends where id=?",array($id));
					if($item){
						$d->where('id', $item['id']);
						$d->delete('sends');
						$result['message'] .= $id.',';
					}
				}
				$result['message'] = substr($result['message'], 0, -1);
				$result['status'] = 200;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=sends&act=man'.$url_type.'&message='.$message);
			}else{
				$func->transfer('Không nhận được dữ liệu','index.html?com=sends&act=man'.$url_type);
			}
		}

	}
	
?>