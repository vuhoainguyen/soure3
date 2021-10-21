<?php 
	$id = (isset($_GET['id'])) ? addslashes($_GET['id']) : "";
	$idl = (isset($_GET['idl'])) ? addslashes($_GET['idl']) : "";

	

	if($id){
		$row_detail = $d->rawQueryOne("SELECT id,name_$lang as name, alias_$lang as alias, desc_$lang as descs, type, content_$lang as content, photo, thumb, title_$lang as title, keywords_$lang as keywords, description_$lang as description from #_multi_photos where type=? and id=? and id_parent=0",array($type,$id));

		if($row_detail){
			$items = $d->rawQuery("SELECT id,name_$lang as name, alt_$lang as alt, type, photo, thumb from #_multi_photos where type=? and id_parent=? and id_parent!=0 order by numb asc, id desc",array($type,$row_detail['id']));
		}

		if($row_detail['type']=='why'){
			$im_com = 'tai-sao';
		}else{
			$im_com = 'hoat-dong';
		}

		$str_breadcrumbs = $breadcrumbs->getUrl(_trangchu, array(array('alias'=>$im_com,'name'=>$title),array('alias'=>$row_detail['alias'],'name'=>$row_detail['name'])));
		$title = $row_detail['name'];
		$title_seo = ($row_detail['title']=='') ? $row_detail['name']:$row_detail['title'];
		$keywords_seo = ($row_detail['keywords']=='') ? $row_setting['keywords']:$row_detail['keywords'];
		$description_seo = ($row_detail['description']=='') ? $row_setting['description']:$row_detail['description'];
		$str_share = $func->getShare($row_detail,_upload_post_l,$type_ob,false);


		$posts_other = $d->rawQuery("SELECT id,name_$lang as name, alias_$lang as alias, photo, thumb from #_multi_photos where type=? and find_in_set ('hienthi',status) and id!=? order by numb asc limit 0,10",array($type,$row_detail['id']));

		$posts_views = $d->rawQuery("SELECT id,name_$lang as name, alias_$lang as alias, photo, thumb from #_posts where type!='chinh-sach' and type!='hinh-thuc-thanh-toan' and type!='khach-hang' and find_in_set ('hienthi',status) order by view desc limit 0,5");
		$posts_news = $d->rawQuery("SELECT id,name_$lang as name, alias_$lang as alias, photo, thumb from #_posts where type!='chinh-sach' and type!='hinh-thuc-thanh-toan' and type!='khach-hang' and find_in_set ('hienthi',status) order by id desc limit 0,10");

	}else{
		$per_page = $row_setting['page_acticles'];
        $startpoint = ($page * $per_page) - $per_page;
        $limit = ' limit '.$startpoint.','.$per_page;
       	$sql = "SELECT id,name_$lang as name, alias_$lang as alias, desc_$lang as descs, type, content_$lang as content, photo, thumb from #_multi_photos where type=? and find_in_set('hienthi',status) and id_parent=0 $order_by ".$limit;
        $items = $d->rawQuery($sql,array($type));
        $sqlq = "SELECT COUNT(*) as `num` from #_multi_photos where type=? and find_in_set('hienthi',status) and id_parent=0 $order_by";
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
	}

?>