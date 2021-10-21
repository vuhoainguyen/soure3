<?php 
	$order_by = ' order by numb asc, id desc';
	$field_load = "name_$lang as name, alias_$lang as alias, desc_$lang as descs, content_$lang as content, id, photo, thumb, title_$lang as title, keywords_$lang as keywords, description_$lang as description,createdAt,youtube";

	$per_page = 12;
    $startpoint = ($page * $per_page) - $per_page;
    $limit = ' limit '.$startpoint.','.$per_page;
   	$sql = "SELECT $field_load from #_videos where type=? $where $order_by ".$limit;
    $items = $d->rawQuery($sql,array($type));
    $sqlq = "SELECT COUNT(*) as `num` from #_videos where type=? $where $order_by";
    $count = $d->rawQueryOne($sqlq,array($type));
   	$total = $count['num'];
    $url = $func->getCurrentPageURL();
	$paging = $func->pagination($total,$per_page,$page,$url);


	$str_breadcrumbs = $breadcrumbs->getUrl(_trangchu, array(array('alias'=>$com,'name'=>$title)));

	$row_detail = $d->rawQueryOne("SELECT photo, thumb, title_$lang as title, keywords_$lang as keywords, description_$lang as description from #_meta_seos where type=? and find_in_set ('hienthi',status)",array($type));


	$title_seo = ($row_detail['title']=='') ? $row_detail['name']:$row_detail['title'];
	$keywords_seo = ($row_detail['keywords']=='') ? $row_setting['keywords']:$row_detail['keywords'];
	$description_seo = ($row_detail['description']=='') ? $row_setting['description']:$row_detail['description'];

	$str_share = $func->getShare($row_detail,_upload_post_l,$type_ob,false);
?>