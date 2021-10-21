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
	$path_product = _upload_product;
	switch ($act) {
        case 'man':
        	load_list();
			get_items();
			$templates = 'orders/items';
			break;
		case 'add':
			load_list();
			$templates = 'orders/item_add';
			break;
		case 'edit':
			load_list();
			get_item();
			$templates = 'orders/item_add';
			break;
		case 'save':
			save_item();
			$templates = 'orders/item_add';
			break;
		case 'delete':
			delete_item();
			break;
        
		default:
			$templates = 'index';
			break;
	}
	function load_list(){
		global $d,$items_status,$items_members,$items_products,$item_citys,$item_dists;
		$items_status = $d->rawQuery("SELECT * from #_order_status order by id asc");
		$items_members = $d->rawQuery("SELECT * from #_customers where type=? order by id desc",array("member"));
		if($_GET['act']=='add'){
			$items_products = $d->rawQuery("SELECT * from #_products where type=? order by id desc",array("san-pham"));
		}

		$item_citys  =  $d->rawQuery("select * from #_place_citys order by numb asc");
		if($id_city){
			$item_dists  =  $d->rawQuery("select * from #_place_dists where id_city=? order by numb asc", array($id_city));
		}
	}
	function get_items(){
	   	global $d,$config,$items,$page,$paging,$func,$url_type,$type;

	   	$keyword = (isset($_GET['keyword'])) ? htmlspecialchars($_GET['keyword']):'';
	   	$daterange = (isset($_GET['daterange'])) ? htmlspecialchars($_GET['daterange']):'';
	   	$order_status = (isset($_GET['order_status'])) ? htmlspecialchars($_GET['order_status']):0;
	   	$payment_status = (isset($_GET['payment_status'])) ? htmlspecialchars($_GET['payment_status']):200;
	   	if($keyword){
	   		$where .= " and (code like '%".$keyword."%' or fullname like '%".$keyword."%' or email like '%".$keyword."%' or phone like '%".$keyword."%' or address like '%".$keyword."%')";
	   	}
	   	if($order_status && $payment_status!=0){
	   		$where .= " and order_status=".$order_status;
	   	}
	   	if($payment_status && $payment_status!=200){
	   		$where .= " and payment_status=".$payment_status;
	   	}
	   	if($daterange){
	   		$exp_day = explode(' - ',$daterange);
	   		$start = explode('/',$exp_day[0]);
	   		$start_day = $start[2].'-'.$start[0].'-'.$start[1].' 00:00:00';
	   		$end = explode('/',$exp_day[1]);
	   		$end_day = $end[2].'-'.$end[0].'-'.$end[1].' 00:00:00';

	   		$where .= " and UNIX_TIMESTAMP(createdAt) >= UNIX_TIMESTAMP('".$start_day."') and UNIX_TIMESTAMP(createdAt) <= UNIX_TIMESTAMP('".$end_day."')";
	   	}
	   	
	    $per_page = 10;
        $startpoint = ($page * $per_page) - $per_page;
        $limit = ' limit '.$startpoint.','.$per_page;
        $sql = "SELECT * from #_orders where type=? $where order by id desc ".$limit;
        $items = $d->rawQuery($sql,array($type));
        $sqlq = "SELECT COUNT(*) as `num` from #_orders where type=? $where order by id desc";
        $count = $d->rawQueryOne($sqlq,array($type));
       	$total = $count['num'];
        $url = 'index.html?com=orders&act=man'.$url_type;
		$paging = $func->pagination($total,$per_page,$page,$url);
	}
	function get_item(){
		global $d,$item,$type;
		$id = (int)$_GET['id'];
		$item  =  $d->rawQueryOne("select * from #_orders where id=? and type=?",array($id,$type));
		if(empty($item)){
			$func->transfer('Không nhận được dữ liệu','index.html');
		}
	}
	function save_item(){
		global $d,$config,$func,$cart,$type,$url_type,$setting,$path;
		$message = '';
		$id = (int)$_GET['id'];
		$table = 'orders';
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
			if ($d->update('orders', $data)) {
			    $result['status'] = 200;
				$result['message'] = 'Đã cập nhật thông tin thành công id#'.$id;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=orders&act=edit'.$url_type.'&id='.$id.'&message='.$message);
			} else {
			  	$func->transfer('Không nhận được dữ liệu','index.html?com=orders&act=man'.$url_type);
			}
		}else{
			$order_n = date('dmY').'DH';
			$order_new = $d->rawQueryOne("select id,code from #_orders where code like '$order_n%'  order by id desc limit 0,1");
			

			if(empty($order_new['id'])){ $order_rand = 1001; }else{ $order_rand =  substr($order_new['code'],10)+1; }
			$order_code = date('dmY').'DH'.$order_rand;
			if(count($_SESSION['cart-admin'])==0){
				$func->transfer('Bạn sẽ không tạo được đơn hàng nếu không có sản phẩm nào?','index.html?com=orders&act=add'.$url_type);
			}
			$data['code'] = $order_code;
			$data['sale_off'] = str_replace('.','',$data['sale_off']);
		    $data['status'] = 'hienthi';
		    $data['payment'] = 1;
		    $data['payment_status'] = 0;
		    $data['order_status'] = 1;
			$data['type'] = $type;
			$data['author_id'] = $_SESSION['login']['id'];
			$data['createdAt'] = $d->now();
			$data['sale_off'] = ($_SESSION['sale-off']) ? $_SESSION['sale-off']:0;
			$data['total_price'] = $cart->getTotalPrice()-$data['sale_off'];
			$id_insert = $d->insert('orders', $data);
			if ($id_insert) {
				if(count($_SESSION['cart-admin'])>0){
					foreach ($_SESSION['cart-admin'] as $k => $v) {
						$color_name = $cart->getPropertiesName($v['color'],'name_vi');
                       	$size_name = $cart->getPropertiesName($v['size'],'name_vi');
						$product = $func->getFieldId($v['productid'],'products');
						$data_order['code'] = $product['code'];
						$data_order['name'] = $product['name_vi'];
						$data_order['id_product'] = $product['id'];
						$data_order['price'] = $product['price'];
						$data_order['qty'] = $v['qty'];
						$data_order['color'] = $v['color'];
                        $data_order['color_name'] = $color_name;
                        $data_order['size'] = $v['size'];
                        $data_order['size_name'] = $size_name;
						$data_order['createdAt'] = $d->now();
						$data_order['id_order'] = $id_insert;
						$id_order = $d->insert('order_details', $data_order);
					}
				}
			    $result['status'] = 200;
				$result['message'] = 'Đã thêm dữ liệu thành công id#'.$id_insert;
				$message = base64_encode(json_encode($result));
				unset($_SESSION['cart-admin']);
				unset($_SESSION['sale-off']);
				$func->redirect('index.html?com=orders&act=man'.$url_type.'&message='.$message);
			} else {
			    print_r($d->getLastError());
			}
		}
	}
	function delete_item(){
		global $d,$func,$url_type;
		$id = (int)$_GET['id'];

		if(isset($_GET['id'])){
			$item  =  $d->rawQueryOne("select id from #_orders where id=?",array($id));
			if($item){
				$items  =  $d->rawQuery("select id from #_order_details where id_order=?",array($id));
				if($items){
					$d->where('id_order', $id);
					$d->delete('order_details');
				}
				$items_r  =  $d->rawQuery("select id from #_order_returns where id_order=?",array($id));
				if($items_r){
					$d->where('id_order', $id);
					$d->delete('order_returns');
				}

				$d->where('id', $item['id']);
				$d->delete('orders');
	        	$result['status'] = 200;
				$result['message'] = 'Đã xóa dữ liệu thành công id#'.$id;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=orders&act=man'.$url_type.'&message='.$message);
			}else{
				$func->transfer('Không nhận được dữ liệu','index.html?com=orders&act=man'.$url_type);
			}
		}elseif(isset($_GET['listid'])){
			$listid = explode(",",$_GET['listid']);
			if(count($listid)){
				$result['message'] = 'Đã xóa dữ liệu thành công id#';
				foreach ($listid as $k => $v) {
					$id = (int)$v;
					$items  =  $d->rawQuery("select id from #_order_details where id_order=?",array($id));
					if($items){
						$d->where('id_order', $id);
						$d->delete('order_details');
					}
					$items_r  =  $d->rawQuery("select id from #_order_returns where id_order=?",array($id));
					if($items_r){
						$d->where('id_order', $id);
						$d->delete('order_returns');
					}

					$item  =  $d->rawQueryOne("select id from #_orders where id=?",array($id));
					if($item){
						$d->where('id', $item['id']);
						$d->delete('orders');
						$result['message'] .= $id.',';
					}
				}
				$result['message'] = substr($result['message'], 0, -1);
				$result['status'] = 200;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=orders&act=man'.$url_type.'&message='.$message);
			}else{
				$func->transfer('Không nhận được dữ liệu','index.html?com=orders&act=man'.$url_type);
			}
		}

	}
?>