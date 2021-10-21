<?php 
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @author  AP CAO
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */
	require_once 'config.php';
	$id = (int)$_POST['id'];
	$color_get = $d->rawQueryOne("select photo,thumb,id,id_product,name_$lang as name from #_product_properties where id=".$id);
	$product_get = $d->rawQueryOne("select photo,thumb,id,name_$lang as name from #_products where id=".$color_get['id_product']);
	$photo_get = $d->rawQuery('select * from #_product_photo_properties where id_product='.$id);
	$photo = $d->rawQuery("select id,photo,thumb from #_product_photos where id_product=? order by id desc",array($product_get['id']));
	$photo_p = '';

	if($color_get['photo']!=''){
		$photo_p .= '<div class="img-top">
            <a href="'._upload_properties_l.$color_get['photo'].'" class="MagicZoom" id="Zoom-1" data-options="variableZoom: true;expand: off; hint: always; " >
                <img src="'._upload_properties_l.$color_get['photo'].'" alt="'.$color_get['name'].'"/>
            </a>
        </div>';
	}else{
		$photo_p .= '<div class="img-top">
            <a href="'._upload_properties_l.$product_get['thumb'].'" class="MagicZoom" id="Zoom-1" data-options="variableZoom: true;expand: off; hint: always; " >
                <img src="'._upload_properties_l.$product_get['thumb'].'" alt="'.$product_get['name'].'"/>
            </a>
        </div>';
	}
	
	if(count($photo_get)>0){
        $photo_p .= '<div class="img-bottom">
            <div class="product-detail-slider owl-carousel owl-theme not-aweowl">
                <div class="items"><div class="img"><a data-zoom-id="Zoom-1" href="'._upload_properties_l.$color_get['photo'].'" data-image="'._upload_properties_l.$color_get['photo'].'"><img src="'._upload_properties_l.$color_get['thumb'].'" alt="'.$color_get['name'].'"></a></div></div>';
                foreach($photo_get as $k=>$v){
                $photo_p .= '<div class="items"><div class="img"><a data-zoom-id="Zoom-1" href="'._upload_properties_l.$v['photo'].'" data-image="'._upload_properties_l.$v['photo'].'"><img src="'._upload_properties_l.$v['thumb'].'" alt="'.$color_get['name'].'"></a></div></div>';
                }
            $photo_p .= '</div>
        </div>';
	}else{
		if($color_get['photo']==''){
			 $photo_p .= '<div class="img-bottom">
	            <div class="product-detail-slider owl-carousel owl-theme not-aweowl">
	                <div class="items"><div class="img"><a data-zoom-id="Zoom-1" href="'._upload_properties_l.$product_get['photo'].'" data-image="'._upload_properties_l.$product_get['photo'].'"><img src="'._upload_properties_l.$product_get['thumb'].'" alt="'.$product_get['name'].'"></a></div></div>';
	                foreach($photo as $k=>$v){
	                $photo_p .= '<div class="items"><div class="img"><a data-zoom-id="Zoom-1" href="'._upload_properties_l.$v['photo'].'" data-image="'._upload_properties_l.$v['photo'].'"><img src="'._upload_properties_l.$v['thumb'].'" alt="'.$product_get['name'].'"></a></div></div>';
	                }
	            $photo_p .= '</div>
	        </div>';
	    }
	}

	$res['gal'] = $photo_p;
	echo  json_encode($res);
?>