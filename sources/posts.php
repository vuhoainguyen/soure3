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
	$field_load = "name_$lang as name, alias_$lang as alias, desc_$lang as descs, content_$lang as content, id, photo, thumb, title_$lang as title, keywords_$lang as keywords, description_$lang as description,createdAt";
	$field_breadcrumb = "alias_$lang as alias, id, name_$lang as name";
	if(!empty($idl)){

		$row_list = $d->rawQueryOne("select $field_load from #_lists where type=? and id=? and tmp_table='posts' and find_in_set ('hienthi',status)",array($type,$idl));
		if($row_list){
			$where .= ' and id_list='.$row_list['id'];

			$data['breadcrumbs'][0] = array('alias'=>$type,'name'=>$title);
			$data['breadcrumbs'][1] = $func->getArray($row_list);

			$title = $row_list['name'];
			$title_seo = ($row_list['title']=='') ? $row_list['name']:$row_list['title'];
			$keywords_seo = ($row_list['keywords']=='') ? $row_setting['keywords']:$row_list['keywords'];
			$description_seo = ($row_list['description']=='') ? $row_setting['description']:$row_list['description'];

			$str_breadcrumbs = $breadcrumbs->getUrl(_trangchu, $data['breadcrumbs']);
			$json_code .= $json_schema->BreadcrumbList(_trangchu,$data['breadcrumbs']);
			$str_share = $func->getShare($row_list,_upload_post_l,$type_ob,false);
		}

	}
	if(!empty($idc)){
		$field_load .= ', id_list';
		$row_cat = $d->rawQueryOne("select $field_load from #_cats where type=? and id=? and tmp_table='posts' and find_in_set ('hienthi',status)",array($type,$idc));
		if($row_cat){
			$where .= ' and id_cat='.$row_cat['id'];

			$data['breadcrumbs'][0] = array('alias'=>$type,'name'=>$title);
			$row_list = $func->getFieldWhereOne('lists',$row_cat['id_list'],$field_breadcrumb,'id','id desc','0,1');
			$data['breadcrumbs'][1] = $func->getArray($row_list);
			$data['breadcrumbs'][2] = $func->getArray($row_cat);

			$title = $row_cat['name'];
			$title_seo = ($row_cat['title']=='') ? $row_cat['name']:$row_cat['title'];
			$keywords_seo = ($row_cat['keywords']=='') ? $row_setting['keywords']:$row_cat['keywords'];
			$description_seo = ($row_cat['description']=='') ? $row_setting['description']:$row_cat['description'];

			$str_breadcrumbs = $breadcrumbs->getUrl(_trangchu, $data['breadcrumbs']);
			$json_code .= $json_schema->BreadcrumbList(_trangchu,$data['breadcrumbs']);
			$str_share = $func->getShare($row_cat,_upload_post_l,$type_ob,false);
		}
	}
	if(!empty($idi)){
		$field_load .= ', id_list, id_cat';
		$row_item = $d->rawQueryOne("select $field_load from #_items where type=? and id=? and tmp_table='posts' and find_in_set ('hienthi',status)",array($type,$idi));
		if($row_item){
			$where = ' and id_item='.$row_item['id'];

			$data['breadcrumbs'][0] = array('alias'=>$type,'name'=>$title);
			$row_list = $func->getFieldWhereOne('lists',$row_item['id_list'],$field_breadcrumb,'id','id desc','0,1');
			$data['breadcrumbs'][1] = $func->getArray($row_list);
			$row_cat = $func->getFieldWhereOne('cats',$row_item['id_cat'],$field_breadcrumb,'id','id desc','0,1');
			$data['breadcrumbs'][2] = $func->getArray($row_cat);
			$data['breadcrumbs'][3] = $func->getArray($row_item);

			$title = $row_item['name'];
			$title_seo = ($row_item['title']=='') ? $row_item['name']:$row_item['title'];
			$keywords_seo = ($row_item['keywords']=='') ? $row_setting['keywords']:$row_item['keywords'];
			$description_seo = ($row_item['description']=='') ? $row_setting['description']:$row_item['description'];

			$str_breadcrumbs = $breadcrumbs->getUrl(_trangchu, $data['breadcrumbs']);
			$json_code .= $json_schema->BreadcrumbList(_trangchu,$data['breadcrumbs']);
			$str_share = $func->getShare($row_item,_upload_post_l,$type_ob,false);

		}
	}
	if(!empty($ids)){
		$field_load .= ', id_list, id_cat, id_item';
		$row_sub = $d->rawQueryOne("select $field_load from #_subs where type=? and id=? and tmp_table='posts' and find_in_set ('hienthi',status)",array($type,$ids));
		if($row_sub){
			$where = ' and id_item='.$row_sub['id'];
			$data['breadcrumbs'][0] = array('alias'=>$type,'name'=>$title);
			$row_list = $func->getFieldWhereOne('lists',$row_sub['id_list'],$field_breadcrumb,'id','id desc','0,1');
			$data['breadcrumbs'][1] = $func->getArray($row_list);
			$row_cat = $func->getFieldWhereOne('cats',$row_sub['id_cat'],$field_breadcrumb,'id','id desc','0,1');
			$data['breadcrumbs'][2] = $func->getArray($row_cat);
			$row_item = $func->getFieldWhereOne('items',$row_sub['id_item'],$field_breadcrumb,'id','id desc','0,1');
			$data['breadcrumbs'][3] = $func->getArray($row_item);
			$data['breadcrumbs'][4] = $func->getArray($row_sub);

			$title = $row_sub['name'];
			$title_seo = ($row_sub['title']=='') ? $row_sub['name']:$row_sub['title'];
			$keywords_seo = ($row_sub['keywords']=='') ? $row_setting['keywords']:$row_sub['keywords'];
			$description_seo = ($row_sub['description']=='') ? $row_setting['description']:$row_sub['description'];
			
			$str_breadcrumbs = $breadcrumbs->getUrl(_trangchu, $data['breadcrumbs']);
			$json_code .= $json_schema->BreadcrumbList(_trangchu,$data['breadcrumbs']);
			$str_share = $func->getShare($row_sub,_upload_post_l,$type_ob,false);
		}
	}

	if((!empty($idl) || !empty($idc) || !empty($idi) || !empty($ids)) && empty($id)){
		
		$per_page = $row_setting['page_acticles'];
        $startpoint = ($page * $per_page) - $per_page;
        $limit = ' limit '.$startpoint.','.$per_page;
       	$sql = "SELECT $field_load from #_posts where type=? $where $order_by ".$limit;
        $items = $d->rawQuery($sql,array($type));
        $sqlq = "SELECT COUNT(*) as `num` from #_posts where type=? $where $order_by";
        $count = $d->rawQueryOne($sqlq,array($type));
       	$total = $count['num'];
        $url = $func->getCurrentPageURL();
		$paging = $func->pagination($total,$per_page,$page,$url);

		/*plugin*/
		$json_code .= $json_schema->ItemList($items);
		$str_breadcrumbs = $breadcrumbs->getUrl(_trangchu, array(array('alias'=>$com,'name'=>$title)));
	}

	if(empty($id) && empty($idl) && empty($idc) && empty($idi) && empty($ids) ){


		$per_page = $row_setting['page_acticles'];
        $startpoint = ($page * $per_page) - $per_page;
        $limit = ' limit '.$startpoint.','.$per_page;
       	$sql = "SELECT $field_load from #_posts where type=? $order_by ".$limit;
        $items = $d->rawQuery($sql,array($type));
        $sqlq = "SELECT COUNT(*) as `num` from #_posts where type=? $order_by";
        $count = $d->rawQueryOne($sqlq,array($type));
       	$total = $count['num'];
        $url = $func->getCurrentPageURL();
		$paging = $func->pagination($total,$per_page,$page,$url);

		/*plugin*/
		$json_code .= $json_schema->ItemList($items);
		$str_breadcrumbs = $breadcrumbs->getUrl(_trangchu, array(array('alias'=>$com,'name'=>$title)));

		$row_detail = $d->rawQueryOne("SELECT photo, thumb, title_$lang as title, keywords_$lang as keywords, description_$lang as description from #_meta_seos where type=? and find_in_set ('hienthi',status)",array($type));
		$title_seo = ($row_detail['title']=='') ? $row_setting['title']:$row_detail['title'];
		$keywords_seo = ($row_detail['keywords']=='') ? $row_setting['keywords']:$row_detail['keywords'];
		$description_seo = ($row_detail['description']=='') ? $row_setting['description']:$row_detail['description'];

		
		$str_share = $func->getShare($row_detail,_upload_photo_l,$type_ob,false,'thumb');

	}elseif(!empty($id)){

		$field_load .= ", id_list, id_cat, id_item, id_sub, content_$lang as content, desc_$lang as descs,tags, createdAt, updatedAt";
		$d->rawQuery("update #_posts set view=view+1 where type=? and id=?",array($type,$id));
		$row_detail = $d->rawQueryOne("select $field_load from #_posts where type=? and id=? and find_in_set ('hienthi',status)",array($type,$id));

		$func->viewed($row_detail['id']);
		$func->viewUpdate('posts',$row_detail['id']);

		$list_detail = $func->getFieldWhereOne('lists',$row_detail['id_list'],$field_breadcrumb,'id','id desc','0,1');
		$cat_detail = $func->getFieldWhereOne('cats',$row_detail['id_cat'],$field_breadcrumb,'id','id desc','0,1');
		$item_detail = $func->getFieldWhereOne('items',$row_detail['id_item'],$field_breadcrumb,'id','id desc','0,1');
		$sub_detail = $func->getFieldWhereOne('subs',$row_detail['id_sub'],$field_breadcrumb,'id','id desc','0,1');

		$data['breadcrumbs'][0] = array('alias'=>$type,'name'=>$title);
		if(!empty($list_detail)){
			$data['breadcrumbs'][1] = $func->getArray($list_detail);
			$where .= ' and id_list='.$list_detail['id'];
			if(!empty($cat_detail)){
				$data['breadcrumbs'][2] = $func->getArray($cat_detail);
				$where .= ' and id_cat='.$cat_detail['id'];
				if(!empty($item_detail)){
					$data['breadcrumbs'][3] = $func->getArray($item_detail);
					$where .= ' and id_item='.$item_detail['id'];
					if(!empty($sub_detail)){
						$data['breadcrumbs'][4] = $func->getArray($sub_detail);
						$data['breadcrumbs'][5] = $func->getArray($row_detail);
						$where .= ' and id_subs='.$subs_detail['id'];
					}else{
						$data['breadcrumbs'][4] = $func->getArray($row_detail);
					}
				}else{
					$data['breadcrumbs'][3] = $func->getArray($row_detail);
				}
			}else{
				$data['breadcrumbs'][2] = $func->getArray($row_detail);
			}
		}else{
			$data['breadcrumbs'][1] = $func->getArray($row_detail);
		}

		$where .= ' and id<>'.$row_detail['id'];
		
		$str_breadcrumbs = $breadcrumbs->getUrl(_trangchu, $data['breadcrumbs']);
		$json_code .= $json_schema->BreadcrumbList(_trangchu,$data['breadcrumbs']);
		$json_code .= $json_schema->NewsArticle($row_detail);
		$json_code .= $json_schema->Review($row_detail,count($row_star),$num_star);

		$str_share = $func->getShare($row_detail,_upload_post_l,$type_ob,false);

		$posts_other = $d->rawQuery("SELECT id,name_$lang as name, alias_$lang as alias, photo, thumb from #_posts where type=? and find_in_set ('hienthi',status) $where order by numb asc limit 0,10",array($type));

		$w_not = " type not in ('chinh-sach','hinh-thuc-thanh-toan','khach-hang','tinh-chat')";
		$posts_views = $d->rawQuery("SELECT id,name_$lang as name, alias_$lang as alias, photo, thumb from #_posts where $w_not and find_in_set ('hienthi',status) order by view desc limit 0,5");
		$posts_news = $d->rawQuery("SELECT id,name_$lang as name, alias_$lang as alias, photo, thumb from #_posts where $w_not and find_in_set ('hienthi',status) order by id desc limit 0,10");

		if($row_detail['tags']!='' && !empty($row_detail['tags'])){
			$tags_product = json_decode($row_detail['tags'],true);
			$im_tag = implode(',',$tags_product);
			$post_tags = $d->rawQuery("SELECT id,name_$lang as name, alias_$lang as alias from #_tags where find_in_set ('hienthi',status) and id in ($im_tag) order by numb asc",array($type));
		}

		$title = $row_detail['name'];
		$title_seo = ($row_detail['title']=='') ? $row_detail['name']:$row_detail['title'];
		$keywords_seo = ($row_detail['keywords']=='') ? $row_setting['keywords']:$row_detail['keywords'];
		$description_seo = ($row_detail['description']=='') ? $row_setting['description']:$row_detail['description'];

		$hascode_sliders = $d->rawQuery("SELECT id,name_$lang as name,has_code from #_multi_photos where type='hascode' and id_parent=0 and find_in_set ('hienthi',status) order by id desc");

		$array_code = array();
		$array_slider = array();
		foreach ($hascode_sliders as $k => $v) {
			$hascode_sliders_photo = $d->rawQuery("SELECT id,name_$lang as name,photo from #_multi_photos where type='hascode' and id_parent<>0 and id_parent='".$v['id']."' and find_in_set ('hienthi',status) order by id desc");
			if(!empty($hascode_sliders_photo)){
				$str_slider = "<div class='owl-carousel in-product' data-dot='0' data-nav='0' data-loop='1' data-play='1' data-lg-items='2' data-md-items='2' data-sm-items='2' data-xs-items='2' data-margin='15'>";
				foreach ($hascode_sliders_photo as $k1 => $v1) {
					$str_slider .= "<div>";
					$str_slider .= "<a data-fancybox='gallery".$v['id']."' href='"._upload_photo_l.$v1['photo']."'>";
						$str_slider .= "<img src='"._upload_photo_l.$v1['photo']."'/>";
					$str_slider .= "</a>";
					$str_slider .= "</div>";
				}
				$str_slider .= "</div>";
				$array_slider['{{'.$v['has_code'].'}}'] = $str_slider;
			}
		}
		
	}
?>