<?php 
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @author  AP CAO
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */
	$id = (isset($_GET['id'])) ? addslashes($_GET['id']) : "";
	$idl = (isset($_GET['idl'])) ? addslashes($_GET['idl']) : "";
	$idc = (isset($_GET['idc'])) ? addslashes($_GET['idc']) : "";
	$idi = (isset($_GET['idi'])) ? addslashes($_GET['idi']) : "";
	$ids = (isset($_GET['ids'])) ? addslashes($_GET['ids']) : "";
	$sortby = (isset($_GET['sortby'])) ? addslashes($_GET['sortby']) : "";
	if($sortby){
		$ex_sort_by = str_replace('-', ' ', $sortby);
		$order_by = ' order by '.$ex_sort_by;
		
	}else{
		$order_by = ' order by numb asc, id desc';
	}
	$field_load = "name_$lang as name, alias_$lang as alias, id, photo, thumb, title_$lang as title, keywords_$lang as keywords, description_$lang as description,status";
	$field_breadcrumb = "alias_$lang as alias, id, name_$lang as name";

	
	if(!empty($id)){
		$row_list = $d->rawQueryOne("select $field_load from #_multi_photos where type=? and id=? and find_in_set ('hienthi',status)",array($type,$id));
		if($row_list){
			$where .= ' and find_in_set('.$row_list['id'].',id_accessary)';
			$data['breadcrumbs'][0] = array('alias'=>$type,'name'=>$title);
			$data['breadcrumbs'][1] = $func->getArray($row_list);
			$title = $row_list['name'];
			$title_seo = ($row_list['title']=='') ? $row_list['name']:$row_list['title'];
			$keywords_seo = ($row_list['keywords']=='') ? $row_setting['keywords']:$row_list['keywords'];
			$description_seo = ($row_list['description']=='') ? $row_setting['description']:$row_list['description'];

			$str_breadcrumbs = $breadcrumbs->getUrl(_trangchu, $data['breadcrumbs']);
			$json_code .= $json_schema->BreadcrumbList(_trangchu,$data['breadcrumbs']);
			$str_share = $func->getShare($row_list,_upload_product_l,$type_ob,false);

			$field_load .= ", price, price_old, material_$lang as material,photo1,thumb1";
			$per_page = $row_setting['page_product'];
	        $startpoint = ($page * $per_page) - $per_page;
	        $limit = ' limit '.$startpoint.','.$per_page;
	       	$sql = "SELECT $field_load from #_products where type=? $where and find_in_set('hienthi',status) $order_by ".$limit;
	        $items = $d->rawQuery($sql,array('san-pham'));
	        $sqlq = "SELECT COUNT(*) as `num` from #_products where type=? $where and find_in_set('hienthi',status) $order_by";
	        $count = $d->rawQueryOne($sqlq,array('san-pham'));
	       	$total = $count['num'];
	        $url = $func->getCurrentPageURL();
			$paging = $func->pagination($total,$per_page,$page,$url);
			
			
		}
	}
?>