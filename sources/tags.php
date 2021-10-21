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
	$sortby = (isset($_GET['sortby'])) ? addslashes($_GET['sortby']) : "";
	
	if($sortby){
		$ex_sort_by = str_replace('-', ' ', $sortby);
		$order_by = ' order by '.$ex_sort_by;
	}else{
		$order_by = ' order by id desc';
	}

	$field_load = "name_$lang as name, alias_$lang as alias, id, photo, thumb, title_$lang as title, keywords_$lang as keywords, description_$lang as description";
	if($com=='tags-san-pham'){
		$product_tags = $d->rawQueryOne("SELECT id,name_$lang as name, alias_$lang as alias from #_tags where alias_$lang=? and find_in_set ('hienthi',status) order by numb asc",array($idl));
		if(!empty($product_tags)){
			$where .= " and tags like '%".$product_tags['id']."%'";

			$per_page = $row_setting['page_product'];
		    $startpoint = ($page * $per_page) - $per_page;
		    $limit = ' limit '.$startpoint.','.$per_page;
		   	$sql = "SELECT $field_load,price,price_old from #_products where id<>0 $where $order_by ".$limit;
		    $items = $d->rawQuery($sql);
		    $sqlq = "SELECT COUNT(*) as `num` from #_products where id<>0 $where $order_by";
		    $count = $d->rawQueryOne($sqlq);
		   	$total = $count['num'];
		    $url = $func->getCurrentPageURL();
			$paging = $func->pagination($total,$per_page,$page,$url);

			$str_breadcrumbs = $breadcrumbs->getUrl(_trangchu, array(array('alias'=>$com.'/'.$idl,'name'=>$product_tags['name'])));
		}
	}elseif($com=='tags-bai-viet'){
		$post_tags = $d->rawQueryOne("SELECT id,name_$lang as name, alias_$lang as alias from #_tags where find_in_set ('hienthi',status) and alias_$lang=? order by numb asc",array($idl));
		if(!empty($post_tags)){
			$where .= " and tags like '%".$post_tags['id']."%'";

			$per_page = $row_setting['page_acticles'];
		    $startpoint = ($page * $per_page) - $per_page;
		    $limit = ' limit '.$startpoint.','.$per_page;
		   	$sql = "SELECT $field_load,createdAt,desc_$lang as descs from #_posts where  id<>0$where $order_by ".$limit;
		    $items = $d->rawQuery($sql);
		    $sqlq = "SELECT COUNT(*) as `num` from #_posts where id<>0 $where $order_by";
		    $count = $d->rawQueryOne($sqlq);
		   	$total = $count['num'];
		    $url = $func->getCurrentPageURL();
			$paging = $func->pagination($total,$per_page,$page,$url);

			$str_breadcrumbs = $breadcrumbs->getUrl(_trangchu, array(array('alias'=>$com.'/'.$idl,'name'=>$post_tags['name'])));
		}
	}
	
	
?>