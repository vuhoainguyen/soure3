<?php 
	$keywords = (isset($_REQUEST['keywords'])) ? addslashes($_REQUEST['keywords']) : "";

	$field_load = "name_$lang as name, alias_$lang as alias, desc_$lang as descs, content_$lang as content, id, photo, thumb, title_$lang as title, keywords_$lang as keywords, description_$lang as description,createdAt";
	if(!empty($keywords)){
		$where .= " and (name_$lang like '%".$keywords."%' or alias_$lang like '%".$keywords."%')";
		$url_page .= '&keywords='.$keywords;
	}
	$per_page = $row_setting['page_acticles'];
    $startpoint = ($page * $per_page) - $per_page;
    $limit = ' limit '.$startpoint.','.$per_page;
  	$sql = "SELECT $field_load from #_posts where type not in ('doi-ngu-bac-si','khach-hang') $where $order_by ".$limit;
    $items = $d->rawQuery($sql,array($type));
    $sqlq = "SELECT COUNT(*) as `num` from #_posts where type not in ('doi-ngu-bac-si','khach-hang') $where $order_by";
    $count = $d->rawQueryOne($sqlq,array($type));
   	$total = $count['num'];
    $url = $func->getCurrentPageURL();
	$paging = $func->pagination($total,$per_page,$page,$url);

	$title = _voi_tu_khoa.' <span style="font-weight: bold; color: #FF0000;">\''.$keywords.'\'</span> '._co.' <span style="font-weight: bold; color: #FF0000;">'.$total.'</span> bài viết';

	/*plugin*/
	$str_breadcrumbs = $breadcrumbs->getUrl(_trangchu, array(array('alias'=>'','name'=>$title)));
?>