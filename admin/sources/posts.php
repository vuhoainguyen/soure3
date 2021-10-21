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
	$url_type .= (isset($_GET['id_list'])) ? '&id_list='.htmlspecialchars($_GET['id_list']):'';
	$url_type .= (isset($_GET['id_cat'])) ? '&id_cat='.htmlspecialchars($_GET['id_cat']):'';
	$url_type .= (isset($_GET['id_item'])) ? '&id_item='.htmlspecialchars($_GET['id_item']):'';
	$url_type .= (isset($_GET['id_sub'])) ? '&id_sub='.htmlspecialchars($_GET['id_sub']):'';
	$url_type .= (isset($_GET['id_service'])) ? '&id_service='.htmlspecialchars($_GET['id_service']):'';
	$url_type .= (isset($_GET['keyword'])) ? '&keyword='.htmlspecialchars($_GET['keyword']):'';
	$path = _upload_post;
	
	switch ($act) {
        case 'man':
			get_items();
			$templates = 'posts/items';
			break;
		case 'add':
			getListPage();
			$templates = 'posts/item_add';
			break;
		case 'edit':
			get_item();
			getListPage();
			$templates = 'posts/item_add';
			break;
		case 'save':
			save_item();
			$templates = 'posts/item_add';
			break;
		case 'delete':
			delete_item();
			break;
		default:
			$templates = 'posts/items';
			break;
	}
	function getListPage(){
		global $d,$items_list,$items_cat,$items_item,$items_sub,$item,$items_tags_type,$setting,$items_dv,$items_photo;
		$id = (int)$_GET['id'];
		$com = htmlspecialchars($_GET['com']);
		$type = htmlspecialchars($_GET['type']);
		$param_list = array($type,$com);
		$items_list = $d->rawQuery("SELECT * from #_lists where type=? and tmp_table=? order by numb asc, id desc",$param_list);
		$param_cat = array($type,$com,$item['id_list']);
		$param_item = array($type,$com,$item['id_cat']);
		$param_sub = array($type,$com,$item['id_item']);
		if($id){
			$items_cat = $d->rawQuery("SELECT * from #_cats where type=? and tmp_table=? and id_list=? order by numb asc, id desc",$param_cat);
			$items_item = $d->rawQuery("SELECT * from #_items where type=? and tmp_table=? and id_cat=? order by numb asc, id desc",$param_item);
			$items_sub = $d->rawQuery("SELECT * from #_subs where type=? and tmp_table=? and id_item=? order by numb asc, id desc",$param_sub);

			$param = array($id,$type);
			$items_photo = $d->rawQuery("SELECT * from #_post_photos where id_post=? and type=? order by numb asc, id desc",$param);
		}

		$com = htmlspecialchars($_GET['com']);
		$dv = 'dich-vu';
		$param_dv = array($dv,$com);
		$items_dv = $d->rawQuery("SELECT * from #_lists where type=? and tmp_table=? order by numb asc, id desc",$param_dv);

		if($setting[$com][$type]['tags']==true){
			$items_tags_type = $d->rawQuery("SELECT id,name_vi from #_tags where type=? and find_in_set ('hienthi',status) order by numb asc, id desc",array($type));
		}
	}
	function get_items(){
		global $d,$config,$items,$page,$paging,$func,$url_type,$items_list,$items_cat,$items_item,$items_sub,$items_dv;

		$type = htmlspecialchars($_GET['type']);
		$com = htmlspecialchars($_GET['com']);
		$param_list = array($type,$com);
		$items_list = $d->rawQuery("SELECT * from #_lists where type=? and tmp_table=? order by numb asc, id desc",$param_list);
		if($_GET['id_list']){
			$param_cat = array($type,$com,$_GET['id_list']);
			$items_cat = $d->rawQuery("SELECT * from #_cats where type=? and tmp_table=? and id_list=? order by numb asc, id desc",$param_cat);
			$where .= " and id_list=".$_GET['id_list'];
		}
		if($_GET['id_cat']){
			$param_item = array($type,$com,$_GET['id_cat']);
			$items_item = $d->rawQuery("SELECT * from #_items where type=? and tmp_table=? and id_cat=? order by numb asc, id desc",$param_item);
			$where .= " and id_cat=".$_GET['id_cat'];
		}
		if($_GET['id_item']){
			$param_sub = array($type,$com,$_GET['id_item']);
			$items_sub = $d->rawQuery("SELECT * from #_subs where type=? and tmp_table=? and id_item=? order by numb asc, id desc",$param_sub);
			$where .= " and id_item=".$_GET['id_item'];
		}
		if($_GET['id_sub']){
			$where .= " and id_sub=".$_GET['id_sub'];
		}

		if($_GET['id_service']){
			$where .= " and id_service=".$_GET['id_service'];
		}

		$keyword = (isset($_GET['keyword'])) ? htmlspecialchars($_GET['keyword']):'';
	   	if($keyword){
	   		$where .= " and (name_vi like '%".$keyword."%')";
	   	}

		$dv = 'dich-vu';
		$param_dv = array($dv,$com);
		$items_dv = $d->rawQuery("SELECT * from #_lists where type=? and tmp_table=? order by numb asc, id desc",$param_dv);


		$type = htmlspecialchars($_GET['type']);
		$param = array($type);
		
	    if($config['paging-table']==true){
		    $items = $d->rawQuery("SELECT * from #_posts where type=? $where order by numb asc, id desc",$param);
		}else{
			$per_page = 10;
	        $startpoint = ($page * $per_page) - $per_page;
	        $limit = ' limit '.$startpoint.','.$per_page;
	        $sql = "SELECT * from #_posts where type=? $where order by numb asc, id desc ".$limit;
	        $items = $d->rawQuery($sql,$param);
	        $sqlq = "SELECT COUNT(*) as `num` from #_posts where type=? $where order by numb asc, id desc";
	        $count = $d->rawQueryOne($sqlq,$param);
	       	$total = $count['num'];
	        $url = 'index.html?com=posts&act=man'.$url_type;
			$paging = $func->pagination($total,$per_page,$page,$url);
		}

	}
	function get_item(){
		global $d,$item;
		if($_GET['id']){
			$id = (int)$_GET['id'];
		}else{
			$id = (int)$_GET['id_post'];
		}

		$item  =  $d->rawQueryOne("select * from #_posts where id=?",array($id));
		if(empty($item)){
			$func->transfer('Không nhận được dữ liệu','index.html');
		}
	}
	function save_item(){
		global $d,$config,$func,$url_type,$path,$setting;
		$message = '';
		$id = (int)$_GET['id'];
		$table = 'posts';
		$type = (string)$_GET['type'];
		$set = $setting[$table][$type];
		
		$data = $_POST['data'];
    	if($_POST){
    		foreach ($data as $k => $v) {
				if($k!='tags'){
    				$data[$k] = htmlspecialchars($v);
    			}
			}
    	}
    	$file = $_FILES['photo'];
    	if(!empty($file)){
    		if($id){
	    		if($file['error']==0){
		    		$photo = $func->uploadImg($id,'photo','thumb',$file,$path,'posts',$set['thumb-w'],$set['thumb-h'],$set['thumb-r'],$set['thumb-b']);
		    		$data['photo'] = $photo['photo'];
		    		$data['thumb'] = $photo['thumb'];
		    	}
	    	}else{
	    		if($file['error']==0){
		    		$photo = $func->uploadImg(0,'photo','thumb',$file,$path,'posts',$set['thumb-w'],$set['thumb-h'],$set['thumb-r'],$set['thumb-b']);
		    		$data['photo'] = $photo['photo'];
		    		$data['thumb'] = $photo['thumb'];
		    	}
	    	}
    	}
    	
    	if($setting[$table][$type]['tags']==true){
	    	$data['tags'] = json_encode($data['tags']);
	    }
    	if($id){
    		$data['updatedAt'] = $d->now();
			$data['edit_count'] = $d->inc(1);
    		$d->where('id', $id);
			if ($d->update('posts', $data)) {

				if (!empty($_FILES['files']) && count($_FILES['files'])>0) {
		            if (isset($_FILES['files'])) {
		            	for($i=0;$i<count($_FILES['files']['name']);$i++){
		            		if($_FILES['files']['error'][$i]!=4){
		            			$files['name'] = $_FILES['files']['name'][$i];
								$files['type'] = $_FILES['files']['type'][$i];
								$files['tmp_name'] = $_FILES['files']['tmp_name'][$i];
								$files['error'] = $_FILES['files']['error'][$i];
								$files['size'] = $_FILES['files']['size'][$i];
								$photo_multi = $func->uploadImg(0,'photo','thumb',$files,$path,'posts',$set['thumb-w'],$set['thumb-h'],$set['thumb-r'],$set['thumb-b']);
					    		$data_x['photo'] = $photo_multi['photo'];
					    		$data_x['thumb'] = $photo_multi['thumb'];
					    		$data_x['id_post'] = $id;
					    		$data_x['status'] = 'hienthi';
					    		$data_x['type'] = $type;
					    		$data_x['createdAt'] = $d->now();
					    		$data_x['author_id'] = $_SESSION['login']['id'];
					    		$id_insert_multi = $d->insert('post_photos', $data_x);
		            		}
		            	}
		            }
		        }

			    $result['status'] = 200;
				$result['message'] = 'Đã cập nhật thông tin thành công id#'.$id;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=posts&act=edit'.$url_type.'&id='.$id.'&message='.$message);
			} else {
			  	$func->transfer('Không nhận được dữ liệu','index.html?com=posts&act=man'.$url_type);
			}
    	}else{
    		$data['status'] = 'hienthi';
    		$data['type'] = htmlspecialchars($_GET['type']);
    		$data['createdAt'] = $d->now();
    		$data['author_id'] = $_SESSION['login']['id'];
    		$id_insert = $d->insert('posts', $data);
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
								$photo_multi = $func->uploadImg(0,'photo','thumb',$files,$path,'posts',$set['thumb-w'],$set['thumb-h'],$set['thumb-r'],$set['thumb-b']);
					    		$data_x['photo'] = $photo_multi['photo'];
					    		$data_x['thumb'] = $photo_multi['thumb'];
					    		$data_x['id_post'] = $id_insert;
					    		$data_x['type'] = $type;
					    		$data_x['status'] = 'hienthi';
					    		$data_x['createdAt'] = $d->now();
					    		$data_x['author_id'] = $_SESSION['login']['id'];
					    		$id_insert_multi = $d->insert('post_photos', $data_x);
		            		}
		            	}
		            }
		        }

			    $result['status'] = 200;
				$result['message'] = 'Đã thêm dữ liệu thành công id#'.$id_insert;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=posts&act=man'.$url_type.'&message='.$message);
			}
    	}
	}
	function delete_item(){
		global $d,$func,$url_type,$path;
		$id = (int)$_GET['id'];
		if(isset($_GET['id'])){
			$item  =  $d->rawQueryOne("select id,photo,thumb from #_posts where id=?",array($id));
			if($item){
				$func->deleteFile($path.$item['photo']);
				$func->deleteFile($path.$item['thumb']);
				$d->where('id', $item['id']);
				$d->delete('posts');
	        	$result['status'] = 200;
				$result['message'] = 'Đã xóa dữ liệu thành công id#'.$id;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=posts&act=man'.$url_type.'&message='.$message);
			}else{
				$func->transfer('Không nhận được dữ liệu','index.html');
			}
		}elseif(isset($_GET['listid'])){
			$listid = explode(",",$_GET['listid']);
			if(count($listid)){
				$result['message'] = 'Đã xóa dữ liệu thành công id#';
				foreach ($listid as $k => $v) {
					$id = (int)$v;
					$item  =  $d->rawQueryOne("select id,photo,thumb from #_posts where id=?",array($id));
					if($item){
						$func->deleteFile($path.$item['photo']);
						$func->deleteFile($path.$item['thumb']);
						$d->where('id', $item['id']);
						$d->delete('posts');
						$result['message'] .= $id.',';
					}
				}
				$result['message'] = substr($result['message'], 0, -1);
				$result['status'] = 200;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=posts&act=man'.$url_type.'&message='.$message);
			}else{
				$func->transfer('Không nhận được dữ liệu','index.html?com=posts&act=man');
			}
		}
	}
?>