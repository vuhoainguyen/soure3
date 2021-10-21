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
	$url_type .= (isset($_GET['keyword'])) ? '&keyword='.htmlspecialchars($_GET['keyword']):'';
	$path = _upload_product;
	
	switch ($act) {
        case 'man':
			get_items();
			$templates = 'products/items';
			break;
		case 'add':
			getListPage();
			$templates = 'products/item_add';
			break;
		case 'edit':
			get_item();
			getListPage();
			$templates = 'products/item_add';
			break;
		case 'copy':
			get_item();
			getListPage();
			$templates = 'products/item_add';
			break;
		case 'save':
			save_item();
			$templates = 'products/item_add';
			break;
		case 'save_copy':
			save_item();
			$templates = 'products/item_add';
			break;
		case 'delete':
			delete_item();
			break;
		case 'import':
			import_item();
			break;
		case 'export':
			export_item();
			break;
		case 'extract_zip':
			extract_zip_item();
			break;	
		default:
			$templates = 'products/items';
			break;
	}
	function getListPage(){
		global $d,$items_list,$items_cat,$items_item,$items_sub,$item,$items_photo,$items_tags_type,$setting,$items_phutung;
		$id = ($_GET['id']) ? (int)$_GET['id']:(int)$_GET['id_product'];
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
			$items_photo = $d->rawQuery("SELECT * from #_product_photos where id_product=? and type=? order by numb asc, id desc",$param);
		}

		$param_phutung = array('phu-tung-theo-xe');
		$items_phutung = $d->rawQuery("SELECT * from #_multi_photos where type=? order by numb asc, id desc",$param_phutung);

		if($setting[$com][$type]['tags']==true){
			$items_tags_type = $d->rawQuery("SELECT id,name_vi from #_tags where type=? and find_in_set ('hienthi',status) order by numb asc, id desc",array($type));
		}
	}
	function get_items(){
		global $d,$config,$items,$page,$paging,$func,$url_type,$items_list,$items_cat,$items_item,$items_sub;
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

		$keyword = (isset($_GET['keyword'])) ? htmlspecialchars($_GET['keyword']):'';
	   	if($keyword){
	   		$where .= " and (code like '%".$keyword."%' or name_vi like '%".$keyword."%')";
	   	}

		$param = array($type);
	    if($config['paging-table']==true){
		    $items = $d->rawQuery("SELECT * from #_products where type=? $where order by numb asc, id desc",$param);
		}else{
			$per_page = 10;
	        $startpoint = ($page * $per_page) - $per_page;
	        $limit = ' limit '.$startpoint.','.$per_page;
	        $sql = "SELECT * from #_products where type=? $where order by numb asc, id desc ".$limit;
	        $items = $d->rawQuery($sql,$param);
	        $sqlq = "SELECT COUNT(*) as `num` from #_products where type=? $where order by numb asc, id desc";
	        $count = $d->rawQueryOne($sqlq,$param);
	       	$total = $count['num'];
	        $url = 'index.html?com=products&act=man'.$url_type;
			$paging = $func->pagination($total,$per_page,$page,$url);
		}
		
		
	}
	function get_item(){
		global $d,$item;
		
		if($_GET['id']){
			$id = (int)$_GET['id'];
		}else{
			$id = (int)$_GET['id_product'];
		}
		$item  =  $d->rawQueryOne("select * from #_products where id=?",array($id));
		if(empty($item)){
			$func->transfer('Không nhận được dữ liệu','index.html');
		}
	}
	function save_item(){
		global $d,$config,$func,$url_type,$path,$setting;
		$message = '';
		$id = (int)$_GET['id'];
		$table = 'products';
		$type = (string)$_GET['type'];
		$set = $setting[$table][$type];
		
		$data = $_POST['data'];
    	if($_POST){
    		foreach ($data as $k => $v) {
    			if($k!='tags' && $k!='id_accessary'){
    				$data[$k] = htmlspecialchars($v);
    			}
			}
			
    	}

    	$file = $_FILES['photo'];
    	if($file){
    		if($id){
	    		if($file['error']==0){
	    			$photo = $func->uploadImg($id,'photo','thumb',$file,$path,'products',$set['thumb-w'],$set['thumb-h'],$set['thumb-r'],$set['thumb-b']);
		    		$data['photo'] = $photo['photo'];
		    		$data['thumb'] = $photo['thumb'];
	    		}
	    	}else{
	    		if($file['error']==0){
	    			$photo = $func->uploadImg(0,'photo','thumb',$file,$path,'products',$set['thumb-w'],$set['thumb-h'],$set['thumb-r'],$set['thumb-b']);
		    		$data['photo'] = $photo['photo'];
		    		$data['thumb'] = $photo['thumb'];
	    		}
	    	}
    	}

    	$file = $_FILES['photo1'];
    	if($file){
    		if($id){
	    		if($file['error']==0){
	    			$photo1 = $func->uploadImg($id,'photo1','thumb1',$file,$path,'products',$set['thumb1-w'],$set['thumb1-h'],$set['thumb1-r'],$set['thumb1-b']);
		    		$data['photo1'] = $photo1['photo1'];
		    		$data['thumb1'] = $photo1['thumb1'];
	    		}
	    	}else{
	    		if($file['error']==0){
	    			$photo1 = $func->uploadImg(0,'photo1','thumb1',$file,$path,'products',$set['thumb1-w'],$set['thumb1-h'],$set['thumb1-r'],$set['thumb1-b']);
		    		$data['photo1'] = $photo1['photo1'];
		    		$data['thumb1'] = $photo1['thumb1'];
	    		}
	    	}
    	}
    	
        if($data['price']){
			$data['price'] = str_replace(',', '', $data['price']);
		}
		if($data['price_old']){
    		$data['price_old'] = str_replace(',', '', $data['price_old']);
    	}
    	if($setting[$table][$type]['tags']==true){
	    	$data['tags'] = json_encode($data['tags']);
	    }
	    if($data['id_accessary']){
	    	$data['id_accessary'] = implode(',',$data['id_accessary']);
	    }
    	if($id){
    		$data['updatedAt'] = $d->now();
			$data['edit_count'] = $d->inc(1);
    		$d->where('id', $id);
			if ($d->update('products', $data)) {
				if (!empty($_FILES['files']) && count($_FILES['files'])>0) {
		            if (isset($_FILES['files'])) {
		            	for($i=0;$i<count($_FILES['files']['name']);$i++){
		            		if($_FILES['files']['error'][$i]!=4){
		            			$files['name'] = $_FILES['files']['name'][$i];
								$files['type'] = $_FILES['files']['type'][$i];
								$files['tmp_name'] = $_FILES['files']['tmp_name'][$i];
								$files['error'] = $_FILES['files']['error'][$i];
								$files['size'] = $_FILES['files']['size'][$i];
								$photo_multi = $func->uploadImg(0,'photo','thumb',$files,$path,'products',$set['thumb-w'],$set['thumb-h'],$set['thumb-r'],$set['thumb-b']);
					    		$data_x['photo'] = $photo_multi['photo'];
					    		$data_x['thumb'] = $photo_multi['thumb'];
					    		$data_x['id_product'] = $id;
					    		$data_x['status'] = 'hienthi';
					    		$data_x['type'] = $type;
					    		if($_POST['numb'][$i] < 1){
					    			$data_x['numb'] = 1;
					    		}else{
									$data_x['numb'] = $_POST['numb'][$i];
					    		}
					    		$data_x['alt_vi'] = $_POST['alt_vi'][$i];
					    		$data_x['createdAt'] = $d->now();
					    		$data_x['author_id'] = $_SESSION['login']['id'];
					    		$id_insert_multi = $d->insert('product_photos', $data_x);
		            		}
		            	}
		            }
		        }

			    $result['status'] = 200;
				$result['message'] = 'Đã cập nhật thông tin thành công id#'.$id;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=products&act=edit'.$url_type.'&id='.$id.'&message='.$message);
			} else {
			  	$func->transfer('Không nhận được dữ liệu','index.html?com=products&act=man'.$url_type);
			}
    	}else{
    		$data['status'] = 'hienthi';
    		$data['type'] = htmlspecialchars($_GET['type']);
    		$data['createdAt'] = $d->now();
    		$data['author_id'] = $_SESSION['login']['id'];
    		$id_insert = $d->insert('products', $data);
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
								$photo_multi = $func->uploadImg(0,'photo','thumb',$files,$path,'products',$set['thumb-w'],$set['thumb-h'],$set['thumb-r'],$set['thumb-b']);
					    		$data_x['photo'] = $photo_multi['photo'];
					    		$data_x['thumb'] = $photo_multi['thumb'];
					    		$data_x['id_product'] = $id_insert;
					    		$data_x['type'] = $type;
					    		if($_POST['numb'][$i] < 1){
					    			$data_x['numb'] = 1;
					    		}else{
									$data_x['numb'] = $_POST['numb'][$i];
					    		}
					    		$data_x['alt_vi'] = $_POST['alt_vi'][$i];
					    		$data_x['status'] = 'hienthi';
					    		$data_x['createdAt'] = $d->now();
					    		$data_x['author_id'] = $_SESSION['login']['id'];
					    		$id_insert_multi = $d->insert('product_photos', $data_x);
		            		}
		            	}
		            }
		        }

			    $result['status'] = 200;
				$result['message'] = 'Đã thêm dữ liệu thành công id#'.$id_insert;
				$message = base64_encode(json_encode($result));
				if($_POST['save-add']==1){
					$func->redirect('index.html?com=products&act=add'.$url_type.'&message='.$message);
				}else{
					$func->redirect('index.html?com=products&act=man'.$url_type.'&message='.$message);
				}
				
			}else{
				// print_r($d->getLastQuery());
				print_r($d->getLastError());
				die;
			}
    	}
	}
	function save_copy(){
		
	}
	function delete_item(){
		global $d,$func,$url_type,$path;
		$id = (int)$_GET['id'];
		if(isset($_GET['id'])){
			$item  =  $d->rawQueryOne("select id,photo,thumb from #_products where id=?",array($id));
			if($item){

				$item_photo  =  $d->rawQuery("select id,photo,thumb from #_product_photos where id_product=?",array($id));
				if($item_photo){
					foreach ($item_photo as $k1 => $v1) {
						$func->deleteFile($path.$v1['photo']);
						$func->deleteFile($path.$v1['thumb']);
						$d->where('id', $v1['id']);
						$d->delete('product_photos');
					}
				}

				$func->deleteFile($path.$item['photo']);
				$func->deleteFile($path.$item['thumb']);
				$d->where('id', $item['id']);
				$d->delete('products');
	        	$result['status'] = 200;
				$result['message'] = 'Đã xóa dữ liệu thành công id#'.$id;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=products&act=man'.$url_type.'&message='.$message);
			}else{
				$func->transfer('Không nhận được dữ liệu','index.html?com=products&act=man'.$url_type);
			}
		}elseif(isset($_GET['listid'])){
			$listid = explode(",",$_GET['listid']);
			if(count($listid)){
				$result['message'] = 'Đã xóa dữ liệu thành công id#';
				foreach ($listid as $k => $v) {
					$id = (int)$v;
					$item  =  $d->rawQueryOne("select id,photo,thumb from #_products where id=?",array($id));
					if($item){
						$item_photo  =  $d->rawQuery("select id,photo,thumb from #_product_photos where id_product=?",array($id));
						if($item_photo){
							foreach ($item_photo as $k1 => $v1) {
								$func->deleteFile($path.$v1['photo']);
								$func->deleteFile($path.$v1['thumb']);
								$d->where('id', $v1['id']);
								$d->delete('product_photos');
							}
						}
						$func->deleteFile($path.$item['photo']);
						$func->deleteFile($path.$item['thumb']);
						$d->where('id', $item['id']);
						$d->delete('products');
						$result['message'] .= $id.',';
					}
				}
				$result['message'] = substr($result['message'], 0, -1);
				$result['status'] = 200;
				$message = base64_encode(json_encode($result));
				$func->redirect('index.html?com=products&act=man'.$url_type.'&message='.$message);
			}else{
				$func->transfer('Không nhận được dữ liệu','index.html?com=products&act=man'.$url_type);
			}
		}
	}
	function import_item(){
		global $d,$func;
		require_once  _lib.'PHPExcel/PHPExcel/IOFactory.php';
		$file = $_FILES['photo'];
		$path = _upload_excel;
		if($file['type']=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $file['type']=="application/vnd.ms-excel" || $file['type']=="application/x-ms-excel"){
			$result = $func->uploadFileSend('file',$file,$path);
			$objFile = PHPExcel_IOFactory::identify($path.$result['file']);
			$objData = PHPExcel_IOFactory::createReader($objFile);
			$objData->setReadDataOnly(true);
			$objPHPExcel = $objData->load($path.$result['file']);
			$sheet = $objPHPExcel->setActiveSheetIndex(0);
			$Totalrow = $sheet->getHighestRow();
			$LastColumn = $sheet->getHighestColumn();
			$TotalCol = PHPExcel_Cell::columnIndexFromString($LastColumn);
			for ($i = 2; $i <= $Totalrow; $i++) {
			    $numb = $sheet->getCellByColumnAndRow(0, $i)->getValue();
			    $id = ($sheet->getCellByColumnAndRow(1, $i)->getValue()!='') ? $sheet->getCellByColumnAndRow(1, $i)->getValue():0;
			    $code = $sheet->getCellByColumnAndRow(2, $i)->getValue();
			    $name_vi = $sheet->getCellByColumnAndRow(3, $i)->getValue();
			    $photo = $sheet->getCellByColumnAndRow(4, $i)->getValue();
			   	$thumb = $sheet->getCellByColumnAndRow(5, $i)->getValue();
			   	$price = $sheet->getCellByColumnAndRow(6, $i)->getValue();
			   	$price_old = $sheet->getCellByColumnAndRow(7, $i)->getValue();
			   	$quantity = $sheet->getCellByColumnAndRow(8, $i)->getValue();
			   	$data['numb'] = $numb;
		   		$data['code'] = $code;
		   		$data['name_vi'] = $name_vi;
		   		$data['title_vi'] = $name_vi;
		   		$data['alias_vi'] = $func->changeTitle($name_vi);
		   		$data['code'] = $code;
		   		if($photo!=''){
		   			$data['photo'] = $photo;
		   		}
		   		if($thumb!=''){
		   			$data['thumb'] = $thumb;
		   		}
		   		if($price_old!=''){
		   			$data['price_old'] = $price_old;
		   		}
		   		if($price!=''){
		   			$data['price'] = $price;
		   		}
		   		if($quantity!=''){
		   			$data['qty'] = $quantity;
		   		}
		   		$data['type'] = htmlspecialchars($_POST['type']);
			   	$item  =  $d->rawQueryOne("select id from #_products where id=?",array($id));
			   	if($item){
		    		$data['updatedAt'] = $d->now();
					$data['edit_count'] = $d->inc(1);
		    		$d->where('id', $item['id']);
					$d->update('products', $data);
			   	}else{
			   		$data['status'] = 'hienthi';
		    		$data['createdAt'] = $d->now();
		    		$data['author_id'] = $_SESSION['login']['id'];
		    		$id_insert = $d->insert('products', $data);
			   	}
			}
			$func->transfer('Đã import thành công.', 'index.html?com=products&act=man&type='.$_POST['type']);
		}else{
			$func->transfer('Định dạng file truyền vào không đúng.', 'index.html?com=products&act=man&type='.$_POST['type']);
		}
	}
	function export_item(){
		global $d,$func,$url_type;

		$items_product = $d->rawQuery("SELECT * from #_products where type=? order by id desc",array($_GET['type']));
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator('Maarten Balliauw')->setLastModifiedBy('Maarten Balliauw')->setTitle('PHPExcel Test Document')->setSubject('PHPExcel Test Document')->setDescription('Test document for PHPExcel, generated using PHP classes.')->setKeywords('office PHPExcel php')->setCategory('Test result file');

		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'A' )->setWidth( 5 );
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'B' )->setWidth( 10 );
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'C' )->setWidth( 15 );
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'D' )->setWidth( 50 );
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'E' )->setWidth( 25 );
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'F' )->setWidth( 20 );
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'G' )->setWidth( 20 );
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'H' )->setWidth( 15 );
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'I' )->setWidth( 15 );
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'J' )->setWidth( 15 );
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'K' )->setWidth( 20 );

		$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(20);

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A1','#' );
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'B1','ID' );
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'C1','CODE' );
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'D1','NAME_VI' );
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'E1','PHOTO' );
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'F1','THUMB' );
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'G1','PRICE' );
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'H1','PRICE OLD' );
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'I1','QUANTITY' );

		$styleA = array(
	        'fill' => array(
	            'type' => PHPExcel_Style_Fill::FILL_SOLID,
	            'color' => array('rgb' => '3ec2cf')
	        )
	    );
		$objPHPExcel->getActiveSheet()->getStyle('A1:I1' )->applyFromArray( array( 'font' => array( 'color' => array( 'rgb' => '000000' ), 'name' => 'Calibri', 'bold' => true, 'italic' => false, 'size' => 11 ), 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => false )));
		$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($styleA);

		$dataArrayList = array();
		$position = 2;

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				),
			),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getRowDimension( 1 )->setRowHeight( 20 );
		foreach ($items_product as $k => $v) {
			$status_order = $func->getFieldId($v['order_status'],'order_status');

			$dataArrayList[$k] = array($k+1,$v['id'],$v['code'],$v['name_vi'],$v['photo'],$v['thumb'],$v['price'],$v['price_old'],$v['qty']);

			$objPHPExcel->getActiveSheet()->getStyle( 'A'.$position.':I'.$position )->applyFromArray( array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => false ) ) );
			$objPHPExcel->getActiveSheet()->getStyle( 'A'.$position.':C'.$position )->applyFromArray( array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true ) ) );

			$objPHPExcel->getActiveSheet()->getStyle('A'.$position.':I'.$position)->applyFromArray($styleArray);
			/*$objPHPExcel->getActiveSheet()->getStyle('H'.$position.':J'.$position)->getNumberFormat()->setFormatCode('#,##0');*/
			$objPHPExcel->getActiveSheet()->getStyle( 'H'.$position.':J'.$position )->applyFromArray( array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true ) ) );
		    if($position%2==1){
		    	$styleR = array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'c5ecf0')
			        )
			    );
		    	$objPHPExcel->getActiveSheet()->getStyle('A'.$position.':I'.$position)->applyFromArray($styleR);
		    }else{
		    	$styleR = array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => 'ffffff')
			        )
			    );
		    	$objPHPExcel->getActiveSheet()->getStyle('A'.$position.':I'.$position)->applyFromArray($styleR);
		    }

			$position += 1;
		}
		$objPHPExcel->getActiveSheet()->fromArray($dataArrayList, NULL, 'A2');
		$objPHPExcel->setActiveSheetIndex(0);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="danh-sach-'.date('dmY').'.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		$func->transfer('Đã xuất file thành công.', 'index.html?com=products&act=man'.$url_type);
		exit;

	}

	function extract_zip_item(){
		global $func,$d,$path,$url_type;
		if(!empty($_FILES)){
			$res = $func->extractToZip($_FILES['file_zip'],$path);
			$func->transfer($res['message'], 'index.html?com=products&act=man'.$url_type);
		}
	}
?>