<?php 
	
	$per_page = $row_setting['page_acticles'];
    $startpoint = ($page * $per_page) - $per_page;
    $limit = ' limit '.$startpoint.','.$per_page;
   	$sql = "SELECT id,name_$lang as name, alias_$lang as alias,photo,thumb from #_multi_photos where type=? order by numb asc, id desc ".$limit;
    $items = $d->rawQuery($sql,array($type));
    $sqlq = "SELECT COUNT(*) as `num` from #_multi_photos where type=? order by numb asc, id desc";
    $count = $d->rawQueryOne($sqlq,array($type));
   	$total = $count['num'];
    $url = $func->getCurrentPageURL();
	$paging = $func->pagination($total,$per_page,$page,$url);


	$row_seo = $d->rawQueryOne("SELECT photo, thumb, title_$lang as title, keywords_$lang as keywords, description_$lang as description from #_meta_seos where type=? and find_in_set ('hienthi',status)",array($type));
	$title_seo = ($row_seo['title']=='') ? $row_setting['title']:$row_seo['title'];
	$keywords_seo = ($row_seo['keywords']=='') ? $row_setting['keywords']:$row_seo['keywords'];
	$description_seo = ($row_seo['description']=='') ? $row_setting['description']:$row_seo['description'];
	$str_share = $func->getShare($row_seo,_upload_photo_l,$type_ob,false,'thumb');

	$str_breadcrumbs = $breadcrumbs->getUrl(_trangchu, array(array('alias'=>$com,'name'=>$title)));
?>