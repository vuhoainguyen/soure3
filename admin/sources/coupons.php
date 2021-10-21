<?php 
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @author  AP CAO
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */
	
	switch ($act) {
        case 'man':
			get_items();
			$templates = 'coupons/items';
			break;
		case 'add':
			$templates = 'coupons/item_add';
			break;
		case 'edit':
			get_item();
			$templates = 'coupons/item_add';
			break;
		case 'save':
			save_item();
			$templates = 'coupons/item_add';
			break;
		case 'delete':
			delete_item();
			break;
       
		default:
			$templates = 'coupons/items';
			break;
	}

	function get_items(){
		global $d,$config,$items,$page,$paging,$func;
		if($config['paging-table']==true){
		    $items = $d->rawQuery("SELECT * from #_coupons order by numb asc, id desc");
		}else{
			$per_page = 10;
	        $startpoint = ($page * $per_page) - $per_page;
	        $limit = ' limit '.$startpoint.','.$per_page;
	        $sql = "SELECT * from #_coupons order by numb asc, id desc ".$limit;
	        $items = $d->rawQuery($sql);
	        $sqlq = "SELECT COUNT(*) as `num` from #_coupons order by numb asc, id desc";
	        $count = $d->rawQueryOne($sqlq);
	       	$total = $count['num'];
	        $url = 'index.html?com=coupons&act=man';
			$paging = $func->pagination($total,$per_page,$page,$url);
		}
	}
	function get_item(){
		global $d,$item;
		$id = (int)$_GET['id'];
		$item  =  $d->rawQueryOne("select * from #_coupons where id=?",array($id));
		if(empty($item)){
			$func->transfer('Không nhận được dữ liệu','index.html');
		}
	}
	function save_item(){
		global $d,$config,$func,$path,$setting;
		$message = '';
		$id = (int)$_GET['id'];
		$data = $_POST['data'];
    	if($_POST){
    		foreach ($data as $k => $v) {
				$data[$k] = htmlspecialchars($v);
			}
    	}
	    $data['start_date'] = strtotime(str_replace('/','-',$data['start_date']));
	    $data['end_date'] = strtotime(str_replace('/','-',$data['end_date']));
	    $data['price_start'] = str_replace(',','',$data['price_start']);
    	$data['price_end'] = str_replace(',','',$data['price_end']);
    	if($id){
    		$data['updatedAt'] = $d->now();
			$data['edit_count'] = $d->inc(1);
    		$d->where('id', $id);
			if ($d->update('coupons', $data)) {
			    $result['status'] = 200;
				$result['message'] = 'Đã cập nhật thông tin thành công id#'.$id;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=coupons&act=edit&id='.$id.'&message='.$message);
			} else {
			  	$func->transfer('Không nhận được dữ liệu','index.html?com=coupons&act=man');
			}
    	}else{
    		$data['status'] = 'hienthi';
    		$data['createdAt'] = $d->now();
    		$data['author_id'] = $_SESSION['login']['id'];
    		$id_insert = $d->insert('coupons', $data);
			if ($id_insert) {
			    $result['status'] = 200;
				$result['message'] = 'Đã thêm dữ liệu thành công id#'.$id_insert;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=coupons&act=man&message='.$message);
			}else{
				print_r($d->getLastError());
				die;
			}
    	}
	}
	function delete_item(){
		global $d,$func,$path;
		$id = (int)$_GET['id'];

		if(isset($_GET['id'])){
			$item  =  $d->rawQueryOne("select id from #_coupons where id=?",array($id));
			if($item){
				$d->where('id', $item['id']);
				$d->delete('coupons');
	        	$result['status'] = 200;
				$result['message'] = 'Đã xóa dữ liệu thành công id#'.$id;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=coupons&act=man&message='.$message);
			}else{
				$func->transfer('Không nhận được dữ liệu','index.html');
			}
		}elseif(isset($_GET['listid'])){
			$listid = explode(",",$_GET['listid']);
			if(count($listid)){
				$result['message'] = 'Đã xóa dữ liệu thành công id#';
				foreach ($listid as $k => $v) {
					$id = (int)$v;
					$item  =  $d->rawQueryOne("select id from #_coupons where id=?",array($id));
					if($item){
						$d->where('id', $item['id']);
						$d->delete('coupons');
						$result['message'] .= $id.',';
					}
				}
				$result['message'] = substr($result['message'], 0, -1);
				$result['status'] = 200;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=coupons&act=man&message='.$message);
			}else{
				$func->transfer('Không nhận được dữ liệu','index.html?com=coupons&act=man');
			}
		}

	}
?>