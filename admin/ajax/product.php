<?php 
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @author  AP CAO
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */
	require_once 'config.php';
	$i = (int)htmlspecialchars($_POST['i']);
	$a = (string)htmlspecialchars($_POST['a']);
	if($a=='save'){
		$o_t = (int)htmlspecialchars($_POST['o_t']);
		$p_t = (int)htmlspecialchars($_POST['p_t']);
		$n = (string)htmlspecialchars($_POST['n']);
		$data['order_status'] = $o_t;
		$data['payment_status'] = $p_t;
		$data['notes'] = $n;
		$data['updatedAt'] = $d->now();
		$data['edit_count'] = $d->inc(1);
		$d->where('id', $i);
		if ($d->update('orders', $data)) {
			$result['status'] = 200;
			$result['message'] = 'Đã cập nhật thông tin thành công id#'.$i;
		}else{
			$result['status'] = 201;
			$result['message'] = 'Đã cập nhật thất bại id#'.$i;
		}
		echo json_encode($result);
	}

	if($a=='return'){
		$item = $d->rawQueryOne("SELECT * from #_orders where id=? order by id desc",array($i));
		if($item){
			$order_n = date('dmY').'TH';
			$order_new = $d->rawQueryOne("select id,code from #_order_returns where code like '?%'  order by id desc limit 0,1",array($order_n));

			if(empty($order_new['id'])){ $order_rand = 1001; }else{ $order_rand =  substr($order_new['code'],10)+1; }
			$order_code = date('dmY').'TH'.$order_rand;

			$item_th = $d->rawQueryOne("SELECT * from #_order_returns where id_order=? order by id desc",array($i));
			if(empty($item_th)){
				$data['id_order'] = $i;
				$data['code'] = $order_code;
				$data['total_price'] = $item['total_price'];
				$data['id_customer'] = $item['id_customer'];
				$data['sale_off'] = $item['sale_off'];
				$data['status'] = 'datra';
				$data['author_id'] = $_SESSION['login']['id'];
				$id_insert = $d->insert('order_returns', $data);
				if ($id_insert) {

					$data_od['updatedAt'] = $d->now();
					$data_od['edit_count'] = $d->inc(1);
					$data_od['order_status'] = 4;
					$d->where('id', $item['id']);
					$d->update('orders', $data_od);
					
					$result['status'] = 200;
					$result['message'] = 'Đã trả hàng thành công id#'.$i;
				}else{
					$result['status'] = 202;
					$result['message'] = 'Đã trả hàng thất bại id#'.$i;
				}
			}else{
				$data['updatedAt'] = $d->now();
				$data['edit_count'] = $d->inc(1);
				$d->where('id', $item_th['id']);
				if ($d->update('order_returns', $data)) {
					$result['status'] = 201;
					$result['message'] = 'Đơn hàng này đã được trả id#'.$i;
				}
			}
			
		}
		echo json_encode($result);
	}
?>