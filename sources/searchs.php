<?php 
	$alias = (isset($_REQUEST['alias'])) ? addslashes($_REQUEST['alias']) : "";
	$sortby = (isset($_REQUEST['sortby'])) ? addslashes($_REQUEST['sortby']) : "";
	$keywords = (isset($_REQUEST['keywords'])) ? addslashes($_REQUEST['keywords']) : "";
	
	if($_GET['href']){
		$get_link = base64_decode($_GET['href']);
		$get_ex = explode('/', $get_link);
		$com_tag = $get_ex[count($get_ex)-2];
		$alias_tag =  $get_ex[count($get_ex)-1];
	}else{
		$alias_tag = $alias;
	}
	

	/*Kiểm tra danh mục*/
	if(!empty($alias_tag) && $alias_tag!=$type){
		$row_list = $d->rawQueryOne("select id from #_lists where type=? and alias_$lang=? and find_in_set ('hienthi',status)",array($type,$alias_tag));
		if($row_list){
			$where = ' and id_list='.$row_list['id'];
		}else{
			$row_cat = $d->rawQueryOne("select id from #_cats where type=? and alias_$lang=? and find_in_set ('hienthi',status)",array($type,$alias_tag));
			if($row_cat){
				$where = ' and id_cat='.$row_cat['id'];
			}else{
				$row_item = $d->rawQueryOne("select id from #_items where type=? and alias_$lang=? and find_in_set ('hienthi',status)",array($type,$alias_tag));
				if($row_item){
					$where = ' and id_item='.$row_item['id'];
				}
			}
		}
	}

	
	/*Kiểm tra tag*/
	if($com_tag=='tags-san-pham'){
		$product_tags = $d->rawQueryOne("SELECT id,name_$lang as name, alias_$lang as alias from #_tags where type=? and find_in_set ('hienthi',status) and alias_$lang=? order by numb asc",array($type,$alias_tag));
		if(!empty($product_tags)){
			$where .= " and tags like '%".$product_tags['id']."%'";
		}
	}

	/*Kiểm tra status*/
	if($alias_tag=='san-pham-moi-nhat'){
		$where .= " and find_in_set('moi',status)";
	}
	if($alias_tag=='san-pham-ban-chay'){
		$where .= " and find_in_set('banchay',status)";
	}
	if($alias_tag=='san-pham-noi-bat'){
		$where .= " and find_in_set('noibat',status)";
	}

	if(!empty($keywords)){
		$where .= " and (name_$lang like '%".$keywords."%' or code like '%".$keywords."%')";
		$url_page .= '&keywords='.$keywords;
	}

	if(!empty($sortby)){
		$ex_sort_by = str_replace('-', ' ', $sortby);
		$order_by = ' order by '.$ex_sort_by;
		$url_page .= '&sortby='.$sortby;
	}else{
		$order_by = ' order by numb asc, id desc';
	}

	$field_load = "name_$lang as name, alias_$lang as alias, id, photo, thumb, title_$lang as title, keywords_$lang as keywords, description_$lang as description, price, price_old, material_$lang as material,status";

	$per_page = $row_setting['page_product'];
    $startpoint = ($page * $per_page) - $per_page;
    $limit = ' limit '.$startpoint.','.$per_page;
   	$sql = "SELECT $field_load from #_products where type=? $where and find_in_set('hienthi',status) $order_by ".$limit;
    $items = $d->rawQuery($sql,array($type));
    $sqlq = "SELECT COUNT(*) as `num` from #_products where type=? $where and find_in_set('hienthi',status) $order_by";
    $count = $d->rawQueryOne($sqlq,array($type));
   	$total = $count['num'];
    
	if($func->isAjax()){
       	$url = base64_decode($_GET['href']).$url_page;
		$paging = $func->pagination($total,$per_page,$page,$url);
		$html['resx'] = $_GET;
		$html['res'] = $func->getTemplateProduct($items,'col--4 item','','margin-bottom-30','resize/280x225/1/',0, null, 0);
		$html['page'] = $paging;
		echo json_encode($html);
	}else{
        $url = $func->getCurrentPageURL();
		$paging = $func->pagination($total,$per_page,$page,$url);
		$title = _voi_tu_khoa.' <span style="font-weight: bold; color: #FF0000;">\''.$keywords.'\'</span> '._co.' <span style="font-weight: bold; color: #FF0000;">'.$total.'</span> '._sanpham;
	}
?>