<?php 
	if($func->isAjax()){
		$id = (int) $_POST['id'];
		$sql_update = "update #_products SET view = view + 1 where id=".$id;
		$d->rawQuery($sql_update);
		$row_detail = $d->rawQueryOne("select id,view,code,alias_$lang as alias,price,price_old,photo,thumb,name_$lang as name,desc_$lang as descs,content_$lang as content,id_list,status,trademark,specification from #_products where id=? and find_in_set('hienthi',status)",array($id));
		$photo = $d->rawQuery("select id,photo,thumb from #_product_photos where type=? and id_product=? order by id desc",array($type,$id));
		
		$color = $d->rawQuery("select id,name_$lang as name,price from #_product_properties where type=? and id_product=? order by  id desc",array('color',$id));
        $size = $d->rawQuery("select id,name_$lang as name from #_product_properties where type=? and id_product=? order by  id desc",array('size',$id));

		$func->viewed($row_detail['id']);
		$func->viewUpdate('products',$row_detail['id']);

		$row_detail['thumb'] = $config_base._upload_product_l.$row_detail['thumb'];
		$row_detail['photo'] = $config_base._upload_product_l.$row_detail['photo'];
		$row_detail['rating'] = $func->getRating(5);
		$list_detail = $func->getFieldWhereOne('lists',$row_detail['id_list'],"alias_$lang as alias, id, name_$lang as name",'id','id desc','0,1');
		$ex_status = explode(',',$row_detail['status']);
		$row_detail['list_name'] = $list_detail['name'];
		$row_detail['status_product'] = (in_array('hethang', $ex_status)) ? _het_hang:_con_hang;
		$row_detail['trademark'] = ($row_detail['trademark']!=null) ? $row_detail['trademark']:'';
		$row_detail['specification'] = ($row_detail['specification']!=null) ? $row_detail['specification']:'';
		$row_detail['price'] = $row_detail['price'];
		$row_detail['price_old'] = $row_detail['price_old'];
		$row_detail['price_text'] = $func->moneyFormat($row_detail['price'],'');
		$row_detail['price_old_text'] = $func->moneyFormat($row_detail['price_old'],'');
		$row_detail['alias'] = $config_base.$row_detail['alias'];
		$row_detail['descs'] = ($row_detail['descs']!='') ? htmlspecialchars_decode($row_detail['descs']):'';

		$row_detail['color'] = array();
        for($i=0;$i<count($color);$i++){
            $row_detail['color'][$i]['id'] = $color[$i]['id'];
            $row_detail['color'][$i]['name'] = $color[$i]['name'];
            $row_detail['color'][$i]['price'] = $color[$i]['price'];
        }
        $row_detail['size'] = array();
        for($i=0;$i<count($size);$i++){
            $row_detail['size'][$i]['id'] = $size[$i]['id'];
            $row_detail['size'][$i]['name'] = $size[$i]['name'];
        }
        
              
		$row_detail['listPhoto'] = array();
		for($i=0;$i<count($photo);$i++){
			$row_detail['listPhoto'][$i]['id'] = $photo[$i]['id'];
			$row_detail['listPhoto'][$i]['thumb'] = $config_base._upload_product_l.$photo[$i]['thumb'];
			$row_detail['listPhoto'][$i]['photo'] = $config_base._upload_product_l.$photo[$i]['photo'];
		}
		echo json_encode($row_detail);
		die;
	}
?>