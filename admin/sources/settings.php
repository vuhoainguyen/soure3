<?php 
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @author  AP CAO
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */

	switch($act){
		case "update":
			get_item();
			$templates = "settings/item_add";
			break;
		case "save":
			save();
			break;
		default:
			$templates = "index";
	}

	function get_item(){
		global $d, $item;
		$item = $d->getOne("settings");
	}
	function save(){
		global $d,$config,$func,$logs;
		$message = '';
		$data = $_POST['data'];
    	if($_POST){
    		foreach ($data as $k => $v) {
				$data[$k] = htmlspecialchars($v);
			}
    	}
    	
    	$file = $_FILES['favicon'];
    	if($file){
    		$handle = new Upload($file);
	    	if($file['error']!=4){
	    		if ($handle->uploaded) {
	    			$handle->file_new_name_body = $func->imagesName($handle->file_src_name_body);
	    			$data['favicon'] = $handle->file_new_name_body.'.'.$handle->file_src_name_ext;
	    			$handle->process(_upload_photo);
                    if ($handle->processed) {
                    	$item = $d->getOne("settings");
	                	$item['favicon'];
	                	$func->deleteFile(_upload_photo.$item['favicon']);
                        $msg_upload = true;
                    }
	    		}
	    	}
    	}
    	
    	$d->where('setting_id', 2006);
		if ($d->update('settings', $data)) {
		    $result['status'] = 200;
			$result['message'] = 'Đã cập nhật thông tin thành công';
			$message = base64_encode(json_encode($result));
			$logs->write($result['message']);
			$func->redirect('index.html?com=settings&act=update&message='.$message);
		} else {
			$result['status'] = 201;
			$result['message'] = 'Đã cập nhật thông tin thất bại';
			$logs->write($result['message']);
		  	$func->transfer('Không nhận được dữ liệu','index.html?com=settings&act=update');
		}
	}

?>