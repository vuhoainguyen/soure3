<?php 
	$row_detail = $d->rawQueryOne("SELECT id,name_$lang as name, alias_$lang as alias, desc_$lang as descs, type, content_$lang as content, photo, thumb, title_$lang as title, keywords_$lang as keywords, description_$lang as description from #_pages where type=? ",array($type));

	$str_breadcrumbs = $breadcrumbs->getUrl(_trangchu, array(array('alias'=>$row_detail['type'],'name'=>$row_detail['name'])));

	$title = ($row_detail['name']=='') ? $title:$row_detail['name'];
	$title_seo = ($row_detail['title']=='') ? $row_detail['name']:$row_detail['title'];
	$keywords_seo = ($row_detail['keywords']=='') ? $row_setting['keywords']:$row_detail['keywords'];
	$description_seo = ($row_detail['description']=='') ? $row_setting['description']:$row_detail['description'];

	$str_share = $func->getShare($row_detail,_upload_post_l,$type_ob,false);
?>