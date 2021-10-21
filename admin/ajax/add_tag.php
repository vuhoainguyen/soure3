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
	$data = $_POST['data'];
	if($_POST){
		foreach ($data as $k => $v) {
			$data[$k] = htmlspecialchars($v);
		}
	}
	$data['type'] =htmlspecialchars($_POST['type']);
	$data['status'] = 'hienthi';
	$data['createdAt'] = $d->now();
	$data['author_id'] = $_SESSION['login']['id'];
	$id_insert = $d->insert('tags', $data);
	if ($id_insert) {
	    $result['status'] = 200;
		$result['message'] = 'Đã thêm dữ liệu thành công id#'.$id_insert;
		$result['htmlalert'] = '<div class="row">
			         <div class="col-lg-12">
			            <div class="alert alert-success alert-dismissible fade show" role="alert">
			                <strong>'.$result['message'].'</strong>
			                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			                    <span aria-hidden="true">×</span>
			                </button>
			            </div>
			        </div>
			    </div>';
		echo json_encode($result);
	}else{
		$result['status'] = 201;
		$result['message'] = 'Thêm tags thất bại, xin thử lại';
		$result['htmlalert'] = '<div class="row">
			         <div class="col-lg-12">
			            <div class="alert alert-danger alert-dismissible fade show" role="alert">
			                <strong>'.$result['message'].'</strong>
			                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			                    <span aria-hidden="true">×</span>
			                </button>
			            </div>
			        </div>
			    </div>';
		echo json_encode($result);
	}
?>