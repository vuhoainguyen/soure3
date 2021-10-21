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
	
	switch ($act) {
        case 'man':
			get_items();
			$templates = 'product_posts/items';
			break;
		case 'add':
			$templates = 'product_posts/item_add';
			break;
		case 'edit':
			get_item();
			$templates = 'product_posts/item_add';
			break;
		case 'save':
			save_item();
			$templates = 'product_posts/item_add';
			break;
		case 'delete':
			delete_item();
			break;
       
		default:
			$templates = 'product_posts/items';
			break;
	}

	function get_items(){
		global $d,$config,$items,$page,$paging,$func,$url_type;
		$id_product = htmlspecialchars($_GET['id_product']);
		$type = htmlspecialchars($_GET['type']);
		$param = array($type,$id_product);

		if($config['paging-table']==true){
		    $items = $d->rawQuery("SELECT * from #_product_posts where type=? and id_product=? order by id desc",$param);
		}else{
			$per_page = 10;
	        $startpoint = ($page * $per_page) - $per_page;
	        $limit = ' limit '.$startpoint.','.$per_page;
	        $sql = "SELECT * from #_product_posts where type=? and id_product=? order by id desc ".$limit;
	        $items = $d->rawQuery($sql,$param);
	        $sqlq = "SELECT COUNT(*) as `num` from #_product_posts where type=? and id_product=? order by id desc";
	        $count = $d->rawQueryOne($sqlq,$param);
	       	$total = $count['num'];
	        $url = 'index.html?com=product_posts&act=man'.$url_type;
			$paging = $func->pagination($total,$per_page,$page,$url);
		}
	}
	function get_item(){
		global $d,$item;
		$id = (int)$_GET['id'];
		$item  =  $d->rawQueryOne("select * from #_product_posts where id=?",array($id));
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
    	$data['id_product'] = (int)$_GET['id_product'];
    	if($id){
    		$data['updatedAt'] = $d->now();
			$data['edit_count'] = $d->inc(1);
    		$d->where('id', $id);
			if ($d->update('product_posts', $data)) {
			    $result['status'] = 200;
				$result['message'] = 'Đã cập nhật thông tin thành công id#'.$id;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=product_posts&act=edit'.$url_type.'&id='.$id.'&message='.$message);
			} else {
			  	$func->transfer('Không nhận được dữ liệu','index.html?com=product_posts&act=man'.$url_type);
			}
    	}else{
    		$data['status'] = 'hienthi';
    		$data['type'] = htmlspecialchars($_GET['type']);
    		$data['createdAt'] = $d->now();
    		$data['author_id'] = $_SESSION['login']['id'];
    		$id_insert = $d->insert('product_posts', $data);
			if ($id_insert) {
			    $result['status'] = 200;
				$result['message'] = 'Đã thêm dữ liệu thành công id#'.$id_insert;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=product_posts&act=man'.$url_type.'&message='.$message);
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
			$item  =  $d->rawQueryOne("select id from #_product_posts where id=?",array($id));
			if($item){
				$d->where('id', $item['id']);
				$d->delete('product_posts');
	        	$result['status'] = 200;
				$result['message'] = 'Đã xóa dữ liệu thành công id#'.$id;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=product_posts&act=man'.$url_type.'&message='.$message);
			}else{
				$func->transfer('Không nhận được dữ liệu','index.html');
			}
		}elseif(isset($_GET['listid'])){
			$listid = explode(",",$_GET['listid']);
			if(count($listid)){
				$result['message'] = 'Đã xóa dữ liệu thành công id#';
				foreach ($listid as $k => $v) {
					$id = (int)$v;
					$item  =  $d->rawQueryOne("select id from #_product_posts where id=?",array($id));
					if($item){
						$d->where('id', $item['id']);
						$d->delete('product_posts');
						$result['message'] .= $id.',';
					}
				}
				$result['message'] = substr($result['message'], 0, -1);
				$result['status'] = 200;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=product_posts&act=man'.$url_type.'&message='.$message);
			}else{
				$func->transfer('Không nhận được dữ liệu','index.html?com=product_posts&act=man');
			}
		}

	}
?>