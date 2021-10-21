<?php
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @author  AP CAO
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */
	class functions
	{
		public function __construct($d)
		{
			$this->d = $d;
		}
		public function getLinkLang($alias){
			global $lang;
			return $alias;
			/*if($lang=='vi'){ return $alias; }else{ return $lang.'/'.$alias; }*/
		}
		public function getArray($arr = array()){
			return array('alias'=>$arr['alias'],'name'=>$arr['name']);
		}
		public function getFieldWhereOne($table,$id,$field_show,$fieldwhere,$order='id desc',$limit='0,1'){
	        $result = $this->d->rawQueryOne("select $field_show from #_$table where find_in_set ('hienthi',status) and $fieldwhere=$id order by $order limit $limit");
	        return $result;
	    }
	    public function getInfoPgae($type,$lang){
	        $result = $this->d->rawQueryOne("select desc_$lang as descs from #_infos where type=?",array($type));
	        return $result['descs'];
	    }
		public function getRating($numb=5){
			$str = '';
			for($i=1;$i<=$numb;$i++){
				$str .= '<span class="fa fa-star"></span>';
			}
			for($i=1;$i<=(5-$numb);$i++){
				$str .= '<span class="fa fa-star-o"></span>';
			}
			return $str;
		}
		public function linkDirect($url){
			return "window.location.href='$url'";
		}
		public function isLogin(){
			if(isset($_SESSION['signin']['id'])){
				return true;
			}else{
				return false;
			}
		}
		public function getCountProduct($type,$field_group,$id){
			$result = $this->d->rawQueryOne("select count(id) as total from #_products where type=? and find_in_set ('hienthi',status) and $field_group=$id group by $field_group",array($type));
			if(!empty($result)){
				return $result['total'];
			}else{
				return 0;
			}
		}
		public function getTemplateProduct($items=array(),$el='',$border='none-border',$margin='margin-bottom-20',$resize='resize/480x380/1/',$group=0,$status=null,$sale=0){
			global $lang, $config,$row_setting;
			$html = '';
			$j = 1;
			foreach ($items as $k => $v) {
				$product_color = $this->d->rawQuery("SELECT id,name_$lang as name, price, qty, photo, thumb from #_product_properties where type=? and id_product=? and find_in_set ('hienthi',status) order by numb asc",array('color',$v['id']));
				$product_size = $this->d->rawQuery("SELECT id,name_$lang as name, price, qty, photo, thumb from #_product_properties where type=? and id_product=? and find_in_set ('hienthi',status) order by numb asc",array('size',$v['id']));
				$color = (count($product_color)>0) ? $product_color[0]['id']:0;
				$size = (count($product_size)>0) ? $product_size[0]['id']:0;
				$rand = $this->randString(4);
				$rand_product = $this->randString(6);
				$id_item = $rand_product.$k.$rand.'-'.$v['id'];
				$form = $this->getCartForm($v['id'],$color,$size,$id_item);

				$ex_status = explode(',',$v['status']);

				$html .= ($el!='') ? '<div class="'.$el.'">':'';
				if($group!=0){
					if($j==1 || $j%$group==1){ $html .= '<div class="group">'; }
				}
				
				$html .= '<div class="item-product-main '.$margin.' '.$border.'">';
				if($config['cart']['check']==true){ $html .= $form['start']; }
				    $html .= '<div class="product-box product-item-main product-item-compare">
				        <div class="product-thumbnail">
				            <a class="image_thumb" href="'.$v['alias'].'" title="'.$v['name'].'">';
				            	if($resize!=''){
				                	$html .= '<img src="images/rolling.svg?v='.$config['version'].'" data-lazyload="'.$resize._upload_product_l.$v['photo'].'?v='.$config['version'].'" alt="'.$v['name'].'">';
				            	}else{
				                	$html .= '<img src="images/rolling.svg?v='.$config['version'].'" data-lazyload="'._upload_product_l.$v['thumb'].'?v='.$config['version'].'" alt="'.$v['name'].'">';
				            	}
				            $html .='</a>';
				            

							if($status!=null){
								if(count($status)>0){
									foreach($status as $k1=>$v1){
										if(in_array($v1,$ex_status)){
											$html .= '<span class="product-'.$v1.'"></span>';
										}
									}
								}
							}
							
							if($sale==1){
								$price_giam = $this->percentPrice($v['price_old'],$v['price']);
								$html .= '<span class="product-sale">-'.$price_giam.'</span>';
							}

				        $html .= '</div>
				        <div class="product-info product-bottom mh">
				            <h3 class="product-name"><a href="'.$v['alias'].'" title="'.$v['name'].'">'.$v['name'].'</a></h3>
				            <div class="price-box">';
				                if($v['price']!=0){
				                	$html .= '<p class="special-price"><span class="product-price">'.$this->moneyFormat($v['price'],' <u>đ</u>').'</span></p>';
								}else{
									$html .= '<p class="special-price product-price">'._lienhe.': '.$row_setting['phone'].'</p>';
								}
								if($v['price_old']!=0){
					                $html .= '<p class="old-price compare-price">';
					                    $html .= $this->moneyFormat($v['price_old'],' <u>đ</u>');
					                $html .= '</p>';
				                }
							$html .= '</div>';
							if($config['other']['quickview']==true || $config['cart']['check']==true){
								$html .=	'<div class="action">';
				           			if($config['other']['quickview']==true){ $html .= '<a title="'._xem_nhanh.'" onclick="return quickView('.$v['id'].')" class="quick-view btn-views"> <i class="fa fa-search"></i></a>'; }
									if($config['cart']['check']==true){ $html .=	'<button class="btn-buy btn-views  iconcart" data-el="#'.$id_item.'" title="'._them_vao_gio_hang.'">Mua ngay</button>'; }
								$html .=	'</div>';
							}
						/*
						if($v['material']!=''){
							$html .= '<p class="status">Tình trạng: <span>'.$v['material'].'</span></p>';
						}else{
							$html .= '<p class="status">Tình trạng: <span>Còn hàng</span></p>';
						}*/
						/*if($config['cart']['check']==true){
							$html .= '<a class="a_url btn-buy" data-el="#'.$id_item.'" title="Mua ngay">Mua ngay</a>';
						}elseif($config['other']['detail']==true){
							$html .= '<a href="'.$v['alias'].'" class="a_url" title="'._chi_tiet.'">'._chi_tiet.'</a>';
						}*/
				        $html .= '</div>
				    </div>';
				    if($config['cart']['check']==true){ $html .= $form['end']; }
				 $html .= '</div>';

				$html .= ($el!='') ? '</div>':'';
				if($group!=0){
					if($j%$group==0 || $j==count($items)){ $html .= '</div>'; }
				}
				$j++;
			}
			return $html;
		}
		public function dd($data=null){
			echo '<pre>';
			print_r($data);
		}
		public function stro_replace($search, $replace, $subject){
		    return strtr( $subject, array_combine($search, $replace) );
		}
		public function getCartForm($id,$color=0,$size=0,$el){

			$result['start'] = '<form method="post" data-role="add-to-cart" enctype="multipart/form-data" onsubmit="return false" name="'.$el.'" id="'.$el.'">';
			$result['start'] .= '<input type="hidden" name="id" value="'.$id.'"><input type="hidden" name="option1" value="'.$color.'"><input type="hidden" name="option2" value="'.$size.'"><input type="hidden" name="quantity" value="1"><input type="hidden" name="act" value="addcart">';
		    $result['end'] = '</form>';
		    return $result;
		}
		public function getShare($row_detail=null,$path,$type_ob,$set_index=false,$field='photo'){
			global $config_base,$row_setting,$row_share;
			if($set_index==false){
				$photo = $config_base.$path.$row_detail[$field];
				$description = ($row_detail['description']=='') ? strip_tags($row_detail['descs']):strip_tags($row_detail['description']);
				$title = ($row_detail['title']=='') ? strip_tags($row_detail['name']):strip_tags($row_detail['title']);
			}else{
				$row_detail = $row_setting;
				$photo = $config_base.$path.$row_share['thumb'];
				$description = strip_tags($row_detail['description']);
				$title = ($row_detail['title']=='') ? strip_tags($row_detail['company']):strip_tags($row_detail['title']);strip_tags($row_detail['title']);
			}
			
			$result = '<meta property="og:url" content="'.$this->getCurrentPageURL().'" />
						<meta property="og:site_name" content="'.$row_setting['website'].'" />
						<meta property="og:type" content="'.$type_ob.'" />
						<meta property="og:title" content="'.$title.'" />
						<meta property="og:description" content="'.$description.'" />
						<meta property="og:locale" content="vi" />
						<meta property="og:image:alt" content="'.$title.'" />
						<meta property="og:image" content="'.$photo.'" />
						<meta itemprop="name" content="'.$title.'">
						<meta itemprop="description" content="'.$description.'">
						<meta itemprop="image" content="'.$photo.'">
						<meta name="twitter:card" content="product">
						<meta name="twitter:site" content="'.$title.'">
						<meta name="twitter:title" content="'.$title.'">
						<meta name="twitter:description" content="'.$description.'">
						<meta name="twitter:creator" content="'.$title.'">
						<meta name="twitter:image" content="'.$photo.'">';
			return self::compress($result);
		}
		public function isAjax() {
		    return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'));
		}
		public function isReturnOrder($id_order){
			$item = $this->d->rawQueryOne("SELECT * from #_order_returns where id_order=? order by id desc",array($id_order));
			if($item){
				return true;
			}else{
				return false;
			}
		}
		public function permissionPage($com,$act,$type='null',$id_permisstion){
			$permission = $this->d->rawQueryOne("select * from #_permissions where id=?",array($id_permisstion));
			$role_list = json_decode($permission['role_list'],true);
			$str_permistion = $com.'|'.$type.'|'.$act;
			if($role_list){
				if(in_array($str_permistion,$role_list)){
					return 1;
				}else{
					return 0;
				}
			}else{
				return 0;
			}
		}
		public function moneyFormat($g,$s='đ'){
			if($g>0){
				return number_format($g,0, ',', '.').$s;
			}else{
				return '0'.$s;
			}
		}
		public function moneyFormatType($g,$s=' đ'){
			if($g>0){
				return number_format($g,0, '.', ',').$s;
			}
		}
		public function checkSSLContent($content){
			global $config;
			if(count($config['arrayDomainSSL'])>0){
				$pageURL = 'http';
				if ($_SERVER["HTTPS"] == "on") {
					$pageURLs .= $pageURL."s";
					$pageURLs .= "://";
					$pageURL .= "://";
					$pageURL .= $config['arrayDomainSSL'][0];
					$pageURLs .= $config['arrayDomainSSL'][0];
					return str_replace($pageURL,$pageURLs,$content);
				}else{
					return $content;
				}
			}else{
				return $content;
			}
			
		}
		public function getMoneyText( $number ){
			$hyphen = ' ';
			$conjunction = '  ';
			$separator = ' ';
			$negative = 'âm ';
			$decimal = ' phẩy ';
			$dictionary = array(
				0 => 'Không',
				1 => 'Một',
				2 => 'Hai',
				3 => 'Ba',
				4 => 'Bốn',
				5 => 'Năm',
				6 => 'Sáu',
				7 => 'Bảy',
				8 => 'Tám',
				9 => 'Chín',
				10 => 'Mười',
				11 => 'Mười một',
				12 => 'Mười hai',
				13 => 'Mười ba',
				14 => 'Mười bốn',
				15 => 'Mười năm',
				16 => 'Mười sáu',
				17 => 'Mười bảy',
				18 => 'Mười tám',
				19 => 'Mười chín',
				20 => 'Hai mươi',
				30 => 'Ba mươi',
				40 => 'Bốn mươi',
				50 => 'Năm mươi',
				60 => 'Sáu mươi',
				70 => 'Bảy mươi',
				80 => 'Tám mươi',
				90 => 'Chín mươi',
				100 => 'trăm',
				1000 => 'ngàn',
				1000000 => 'triệu',
				1000000000 => 'tỷ',
				1000000000000 => 'nghìn tỷ',
				1000000000000000 => 'ngàn triệu triệu',
				1000000000000000000 => 'tỷ tỷ'
			);
			if( !is_numeric( $number ) )
			{
				return false;
			}
			if( ($number >= 0 && (int)$number < 0) || (int)$number < 0 - PHP_INT_MAX )
			{
				// overflow
				trigger_error( 'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING );
				return false;
			}
			if( $number < 0 )
			{
				return $negative . $this->getMoneyText( abs( $number ) );
			}
			$string = $fraction = null;
			if( strpos( $number, '.' ) !== false )
			{
				list( $number, $fraction ) = explode( '.', $number );
			}
			switch (true)
			{
				case $number < 21:
					$string = $dictionary[$number];
					break;
				case $number < 100:
					$tens = ((int)($number / 10)) * 10;
					$units = $number % 10;
					$string = $dictionary[$tens];
					if( $units )
					{
						$string .= $hyphen . $dictionary[$units];
					}
					break;
				case $number < 1000:
					$hundreds = $number / 100;
					$remainder = $number % 100;
					$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
					if( $remainder )
					{
						$string .= $conjunction . $this->getMoneyText( $remainder );
					}
					break;
				default:
					$baseUnit = pow( 1000, floor( log( $number, 1000 ) ) );
					$numBaseUnits = (int)($number / $baseUnit);
					$remainder = $number % $baseUnit;
					$string = $this->getMoneyText( $numBaseUnits ) . ' ' . $dictionary[$baseUnit];
					if( $remainder )
					{
						$string .= $remainder < 100 ? $conjunction : $separator;
						$string .= $this->getMoneyText( $remainder );
					}
					break;
			}
			if( null !== $fraction && is_numeric( $fraction ) )
			{
				$string .= $decimal;
				$words = array( );
				foreach( str_split((string) $fraction) as $number )
				{
					$words[] = $dictionary[$number];
				}
				$string .= implode( ' ', $words );
			}
			return $string;
		}
		public function getViewed($lang,$type){
			$implode_id = implode(',',$_SESSION['viewed']);
			$result = $this->d->rawQuery("select id,name_$lang as name, alias_$lang as alias, photo, thumb,price,price_old from #_products where type=? and find_in_set ('hienthi',status) and id in ($implode_id) order by numb asc",array($type));
			return $result;
		}
		public function viewed($pid){
			if($pid<1) return;
			if(is_array($_SESSION['viewed'])){
				if($this->viewed_exists($pid)) return;
				$max=count($_SESSION['viewed']);
				$_SESSION['viewed'][$max]=$pid;
			}
			else{
				$_SESSION['viewed']=array();
				$_SESSION['viewed'][0]=$pid;
			}
		}
		public function viewed_exists($pid){
			$pid=intval($pid);
			$max=count($_SESSION['viewed']);
			$flag=0;
			for($i=0;$i<$max;$i++){
				if($pid==$_SESSION['viewed'][$i]){
					$flag=1;
					break;
				}
			}
			return $flag;
		}
		public function viewUpdate($tbl,$id){
			$this->d->rawQuery("UPDATE #_$tbl SET view = view+1  WHERE  id = ".$id." ");
		}
		public function countOrderProduct($id){
			$row = $this->d->rawQueryOne("select COUNT(*) as total from #_order_details where id_product='".$id."' ");
			return $row['total'];
		}
		public function getFieldId($id,$table){
			$this->d->where("id", $id);
			$item = $this->d->getOne($table);
			return $item;
		}
		public function getOrderDetails($id){
			$items  =  $this->d->rawQuery("select * from #_order_details where id_order=? order by id desc",array($id));
			return $items;
		}
		public function getOrderReturns($id){
			$items  =  $this->d->rawQuery("select * from #_order_returns where id_order=? order by id desc",array($id));
			return $items;
		}
		public function getTotalPriceOrder(){
			$item  =  $this->d->rawQueryOne("select sum(total_price) as total from #_orders");
			return $item['total'];
		}
		public function uploadVideo($id=0,$photo='video',$file,$path,$table){
			if($file){
	    		$handle = new Upload($file);
		    	if($file['error']!=4){
		    		if ($handle->uploaded) {
		    			$handle->file_new_name_body = $this->imagesName($handle->file_src_name_body);
		    			$data[$photo] = $handle->file_new_name_body.'.'.$handle->file_src_name_ext;
		    			$handle->process($path);
	                    if ($handle->processed) {
	                    	if($id!=0){
	                    		$this->d->where("id", $id);
								$item = $this->d->getOne($table);
			                	$this->deleteFile($path.$item[$photo]);
	                    	}
	                        $msg_upload = true;
	                    }
		    		}
		    	}
		    	return $data;
	    	}
		}
		public function uploadFileSend($photo='file',$file,$path){
			if($file){
	    		$handle = new Upload($file);
		    	if($file['error']!=4){
		    		if ($handle->uploaded) {
		    			$handle->file_new_name_body = $this->imagesName($handle->file_src_name_body);
		    			$data[$photo] = $handle->file_new_name_body.'.'.$handle->file_src_name_ext;
		    			$handle->process($path);
	                    if ($handle->processed) {
	                        $msg_upload = true;
	                    }
		    		}
		    	}
		    	return $data;
	    	}
		}
		public function uploadImg($id=0,$photo='photo',$thumb='thumb',$file,$path,$table,$w,$h,$r=1,$b=false){
			if($file){
	    		$handle = new Upload($file);
		    	if($file['error']!=4){
		    		if ($handle->uploaded) {
		    			$handle->file_new_name_body = $this->imagesName($handle->file_src_name_body);
		    			$data[$photo] = $handle->file_new_name_body.'.'.$handle->file_src_name_ext;
		    			$handle->process($path);
	                    if ($handle->processed) {
	                    	if($id!=0){
	                    		$this->d->where("id", $id);
								$item = $this->d->getOne($table);
			                	$this->deleteFile($path.$item[$photo]);
	                    	}
	                        $msg_upload = true;
	                    }
		    		}
		    		if ($handle->uploaded) {
		    			$handle->image_resize = true;
		    			$handle->image_x = $w;
		    			$handle->image_y = $h;
		    			$handle->file_new_name_body = $this->imagesName($handle->file_src_name_body).'_'.$handle->image_x.'x'.$handle->image_y;
		    			$data[$thumb] = $handle->file_new_name_body.'.'.$handle->file_src_name_ext;
		    			if($r==2){
	                        $handle->image_ratio_fill  = true;
	                        if($b==true){
	                            $handle->image_background_color = '#FFF';
	                        }
	                    }else{
	                        $handle->image_ratio_crop = true;
	                    }
	                    if($handle->file_src_name_ext=='jqg' || $handle->file_src_name_ext=='jpeg' || $handle->file_src_name_ext=='JPG' || $handle->file_src_name_ext=='JPEG'){
	                    	$handle->image_convert         = 'jpg';
	                    	$handle->jpeg_quality = 80;
	                    }elseif($handle->file_src_name_ext=='png' || $handle->file_src_name_ext=='PNG'){
	                    	$handle->image_convert         = 'png';
	                    	$handle->png_compression = 3;
	                    }
		    			$handle->process($path);
	                    if ($handle->processed) {
	                    	if($id!=0){
	                    		$this->d->where("id", $id);
								$item = $this->d->getOne($table);
			                	$this->deleteFile($path.$item[$thumb]);
	                    	}
	                        $msg_upload = true;
	                    }
		    		}
		    	}
		    	return $data;
	    	}
		}
		public function uploadImgType($type='null',$photo='photo',$thumb='thumb',$file,$path,$table,$w,$h,$r=1,$b=false){
			if($file){
	    		$handle = new Upload($file);
		    	if($file['error']!=4){
		    		if ($handle->uploaded) {
		    			$handle->file_new_name_body = $this->imagesName($handle->file_src_name_body);
		    			$data[$photo] = $handle->file_new_name_body.'.'.$handle->file_src_name_ext;
		    			$handle->process($path);
	                    if ($handle->processed) {
	                    	if($type!='null'){
	                    		$this->d->where("type", $type);
								$item = $this->d->getOne($table);
			                	$this->deleteFile($path.$item[$photo]);
	                    	}
	                        $msg_upload = true;
	                    }
		    		}
		    		if ($handle->uploaded) {
		    			$handle->image_resize = true;
		    			$handle->image_x = $w;
		    			$handle->image_y = $h;
		    			$handle->file_new_name_body = $this->imagesName($handle->file_src_name_body).'_'.$handle->image_x.'x'.$handle->image_y;
		    			$data[$thumb] = $handle->file_new_name_body.'.'.$handle->file_src_name_ext;
		    			if($r==2){
	                        $handle->image_ratio_fill  = true;
	                        if($b==true){
	                            $handle->image_background_color = '#FFF';
	                        }
	                    }else{
	                        $handle->image_ratio_crop = true;
	                    }
	                    if($handle->file_src_name_ext=='jqg' || $handle->file_src_name_ext=='jpeg' || $handle->file_src_name_ext=='JPG' || $handle->file_src_name_ext=='JPEG'){
	                    	$handle->image_convert         = 'jpg';
	                    	$handle->jpeg_quality = 80;
	                    }elseif($handle->file_src_name_ext=='png' || $handle->file_src_name_ext=='PNG'){
	                    	$handle->image_convert         = 'png';
	                    	$handle->png_compression = 3;
	                    }
		    			$handle->process($path);
	                    if ($handle->processed) {
	                    	if($type!='null'){
	                    		$this->d->where("type", $type);
								$item = $this->d->getOne($table);
			                	$this->deleteFile($path.$item[$thumb]);
	                    	}
	                        $msg_upload = true;
	                    }
		    		}
		    	}
		    	return $data;
	    	}
		}
		public function setParam($post){
			$data = array();
			foreach ($post as $k => $v) {
				$data[$k] = htmlspecialchars($v);
			}
			return $data;
		}
		public function getOneFieldQuery($id,$table,$field){
			$param = array($id);
			$result = $this->d->rawQueryOne("SELECT $field from #_$table where id=? order by id desc",$param);
			return $result[$field];
		}
		public function messageSeoPage($title,$desc,$lang){
			$str = '';
			$s = '';
			$t = false;
			if($title=='' && $desc==''){
				$t = true;
			    $s .= ' title seo, description seo';
			}elseif($title=='' && $desc!=''){
				$t = true;
			    $s .= ' title seo';
			}elseif($title!='' && $desc==''){
				$t = true;
			    $s .= ' description seo';
			}
			if($t==true){
				$str .= '<div class="row">
			         <div class="col-lg-12">
			            <div class="alert alert-danger alert-dismissible fade show" role="alert">
			                <strong>Cảnh báo SEO ['.$lang.']!</strong> Vui lòng nhập đầy đủ <strong>'.$s.'</strong> để việc SEO tốt hơn
			                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			                    <span aria-hidden="true">×</span>
			                </button>
			            </div>
			        </div>
			    </div>';
			}
		    return $str;
		}
		public function messagePage($message=''){
			$str = '';
			if($message!=''){
				$result = json_decode(base64_decode($message),true);
			    if(count($result)){
			    	$class = ($result['status']==200) ? 'success':'danger';
			    	$status = ($result['status']==200) ? 'Success!':'Fails!';
			    $str .= '<div class="row">
			         <div class="col-lg-12">
			            <div class="alert alert-'.$class.' alert-dismissible fade show" role="alert">
			                <strong>'.$status.'</strong> '.$result['message'].'
			                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			                    <span aria-hidden="true">×</span>
			                </button>
			            </div>
			        </div>
			    </div>';
			    }
			}
		    return $str;
		}
		public function compress($buffer){
	    	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
			$buffer = str_replace(': ', ':', $buffer);
			$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
			return $buffer;
	    }
	    public function randCoupon($numb){
			$str="ABCDEFGHIJKLMNOPQRSTUVWXYZW0123456789";
			$val = '';
			for ($i=0; $i < $numb; $i++){
				$local = mt_rand( 0 ,strlen($str) );
				$val = $val . substr($str,$local,1 );
			}
			return $val;
		}
		public function randString($numb){
			$str="ABCDEFGHIJKLMNOPQRSTUVWXYZWabcdefghijklmnopqrstuvwxyzw0123456789";
			$val = '';
			for ($i=0; $i < $numb; $i++){
				$local = mt_rand( 0 ,strlen($str) );
				$val = $val . substr($str,$local,1 );
			}
			return $val;
		}
		public function curl_get_contents($url){
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			$data = curl_exec($ch);
			curl_close($ch);
			return $data;
		}
		public function changeNameImage($str){
			$str = $this->stripUnicode($str);
			$str = mb_convert_case($str,MB_CASE_LOWER,'utf-8');
			$str = trim($str);
			$str = str_replace("  "," ",$str);
			$str = str_replace(" ","-",$str);
			return $str;
		}
		public function percentPrice($gia,$giam){
			$val = ($gia - $giam)/$gia;
			$result = round($val*100).'%';
			return $result;	
		}
		public function percentPage($val,$total){
			$percent = ($val/$total)*100;
			return round($percent,2);
		}
		public function encryptPassword($secret,$str,$salt){
			return md5($secret.$str.$salt);
		}
		public function makeDate($time,$dot='.',$lang='vi',$f=false){
			global $lang;
			$str = ($lang == 'vi') ? date("d{$dot}m{$dot}Y",$time) : date("m{$dot}d{$dot}Y",$time);
			if($f){
				$thu['vi'] = array('Chủ nhật','Thứ hai','Thứ ba','Thứ tư','Thứ năm','Thứ sáu','Thứ bảy');
				$thu['en'] = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
				$str = $thu[$lang][date('w',$time)].', '.$str;
			}
			return $str;
		}
		public function makeDateFull($time,$dot='.',$lang='vi',$f=false){
			global $lang;
			$str = ($lang == 'vi') ? date("d{$dot}m{$dot}Y, H:s",$time) : date("m{$dot}d{$dot}Y, H:s",$time);
			if($f){
				$thu['vi'] = array('Chủ nhật','Thứ hai','Thứ ba','Thứ tư','Thứ năm','Thứ sáu','Thứ bảy');
				$thu['en'] = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
				$str = $thu[$lang][date('w',$time)].', '.$str;
			}
			return $str;
		}
		public function deleteFile($file){
			if (file_exists($file)) {
				return @unlink($file);
			}
		}
		public function transfer($msg,$page="index.php",$number=true){
			$showtext = $msg;
			$page_transfer = $page;
			include(_templates."transfer_tpl.php");
			exit();
		}
		public function redirectLink($url=''){
			return 'onclick="window.location.href=\''.$url.'\'"';
		}
		public function redirect($url=''){
			echo '<script language="javascript">window.location = "'.$url.'"</script>';
			exit();
		}
		public function alert($str=''){
			echo '<script language="javascript">alert("'.$str.'")</script>';
			exit();
		}
		public function back($n=1){
			echo '<script language="javascript">history.go = "'.-intval($n).'" </script>';
			exit();
		}
		public function subStr($chuoi,$gioihan){
			if(strlen($chuoi)<=$gioihan)
			{
				return $chuoi;
			}else{
				if(strpos($chuoi," ",$gioihan) > $gioihan){
					$new_gioihan=strpos($chuoi," ",$gioihan);
					$new_chuoi = substr($chuoi,0,$new_gioihan)."...";
					return $new_chuoi;
				}else{
					$new_chuoi = substr($chuoi,0,$gioihan)."...";
					return $new_chuoi;
				}
			}
		}
		public function subSpaceStr($chuoi,$gioihan,$fix=' ...'){
			$ex = explode(' ', trim($chuoi));
			$str = '';
			for ($i=0; $i < $gioihan; $i++) { 
				$str .= $ex[$i].' ';
			}

			if(count($ex) > $gioihan){
				return trim($str).$fix;
			}else{
				return trim($str);
			}
		}
		
		public function utf8convert($str) {
			if(!$str) return false;
			$utf8 = array(
				'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
				'd'=>'đ|Đ',
				'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
				'i'=>'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
				'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
				'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
				'y'=>'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
				''=>'`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\“|\”|\:|\;|_',
			);
			foreach($utf8 as $ascii=>$uni)
				$str = preg_replace("/($uni)/i",$ascii,$str);
			return $str;
		}
		public function changeTitle($text){
			$text = strtolower($this->utf8convert($text));
			$text = preg_replace("/[^a-z0-9-\s]/", "",$text);
			$text = preg_replace('/([\s]+)/', '-', $text);
			$text = str_replace(array('%20', ' '), '-', $text);
			$text = preg_replace("/\-\-\-\-\-/","-",$text);
			$text = preg_replace("/\-\-\-\-/","-",$text);
			$text = preg_replace("/\-\-\-/","-",$text);
			$text = preg_replace("/\-\-/","-",$text);
			$text = '@'.$text.'@';
			$text = preg_replace('/\@\-|\-\@|\@/', '', $text);
			return $text;
		}
		public function changeTitleAlias($text){
			$text = str_replace(' ','',$this->changeTitle($text));
			return $text;
		}
		public function imagesName($name){
			$rand=rand(10,9999);
			$name_anh=explode(".",$name);
			$result = $this->changeTitle($name_anh[0])."-".$rand;
			return $result; 
		}
		public function getCurrentPageURLCanonical() {
			$pageURL = 'http';
			if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			$pageURL .= "://";
			if ($_SERVER["SERVER_NAME"]== "locahost") {
				$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
			} else {
				$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			}
			$pageURL = str_replace("amp/", "", $pageURL);
			$pageURL = explode("&p=", $pageURL);
			$pageURL = explode("?", $pageURL[0]);
			$pageURL = explode("#", $pageURL[0]);
			$pageURL = explode("index", $pageURL[0]);
			return $pageURL[0];
		}
		public function getCurrentPageURL() {
			$pageURL = 'http';
			if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			$pageURL .= "://";
			if ($_SERVER["SERVER_NAME"]== "locahost") {
				$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
			} else {
				$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			}
			$pageURL = explode("&p=", $pageURL);
			return $pageURL[0];
		}
		public function getCurrentPage() {
			$pageURL = 'http';
			if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			$pageURL .= "://";
			if ($_SERVER["SERVER_NAME"]=="locahost") {
				$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
			} else {
				$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			}
			return $pageURL;
		}
		public function formatSize ($rawSize){
			if ($rawSize / 1048576 > 1){
				return round($rawSize / 1048576, 1) . ' MB';
			}else{
				if ($rawSize / 1024 > 1){ 
					return round($rawSize / 1024, 1) . ' KB'; 
				}else{ 
					return round($rawSize, 1) . ' Bytes';
				}
			}
		}
		public function convertNumberToWords($number) {
			$hyphen      = ' ';
			$conjunction = '  ';
			$separator   = ' ';
			$negative    = 'âm ';
			$decimal     = ' phẩy ';
			$dictionary  = array(
				0                   => 'Không',
				1                   => 'Một',
				2                   => 'Hai',
				3                   => 'Ba',
				4                   => 'Bốn',
				5                   => 'Năm',
				6                   => 'Sáu',
				7                   => 'Bảy',
				8                   => 'Tám',
				9                   => 'Chín',
				10                  => 'Mười',
				11                  => 'Mười Một',
				12                  => 'Mười Hai',
				13                  => 'Mười Ba',
				14                  => 'Mười Bốn',
				15                  => 'Mười Lăm',
				16                  => 'Mười Sáu',
				17                  => 'Mười Bảy',
				18                  => 'Mười Tám',
				19                  => 'Mười Chín',
				20                  => 'Hai Mươi',
				30                  => 'Ba Mươi',
				40                  => 'Bốn Mươi',
				50                  => 'Năm Mươi',
				60                  => 'Sáu Mươi',
				70                  => 'Bảy Mươi',
				80                  => 'Tám Mươi',
				90                  => 'Chín Mươi',
				100                 => 'Trăm',
				1000                => 'Ngàn',
				1000000             => 'Triệu',
				1000000000          => 'Tỷ',
				1000000000000       => 'Nghìn Tỷ',
				1000000000000000    => 'Ngàn Triệu Triệu',
				1000000000000000000 => 'Tỷ Tỷ'
			);
			if (!is_numeric($number)) {
				return false;
			}
			if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
				trigger_error('convertNumberToWords only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING);
				return false;
			}
			if ($number < 0) {
				return $negative . convertNumberToWords(abs($number));
			}
			$string = $fraction = null;
			if (strpos($number, '.') !== false) {
				list($number, $fraction) = explode('.', $number);
			}
			switch (true) {
				case $number < 21:
					$string = $dictionary[$number];
					break;
				case $number < 100:
					$tens   = ((int) ($number / 10)) * 10;
					$units  = $number % 10;
					$string = $dictionary[$tens];
					if ($units) {
						$string .= $hyphen . $dictionary[$units];
					}
					break;
				case $number < 1000:
					$hundreds  = $number / 100;
					$remainder = $number % 100;
					$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
					if ($remainder) {
						$string .= $conjunction . convertNumberToWords($remainder);
					}
					break;
				default:
					$baseUnit = pow(1000, floor(log($number, 1000)));
					$numBaseUnits = (int) ($number / $baseUnit);
					$remainder = $number % $baseUnit;
					$string = convertNumberToWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
					if ($remainder) {
						$string .= $remainder < 100 ? $conjunction : $separator;
						$string .= convertNumberToWords($remainder);
					}
					break;
			}
			if (null !== $fraction && is_numeric($fraction)) {
				$string .= $decimal;
				$words = array();
				foreach (str_split((string) $fraction) as $number) {
					$words[] = $dictionary[$number];
				}
				$string .= implode(' ', $words);
			}
			return $string;
		}
		public function getRealIPAddress(){  
			if(!empty($_SERVER['HTTP_CLIENT_IP'])){
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			}else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}else{
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			return $ip;
		}
		public function getToken($numb){
			$str="ABCDEFGHIJKLMNOPQRSTUVWXYZWabcdefghijklmnopqrstuvwxyzw0123456789!@#$%^&*()_+";
			$val="";
			for ($i=0; $i < $numb; $i++){
				$local = mt_rand( 0 ,strlen($str) );
				$val= $val . substr($str,$local,1 );
			}
			return $val;
		}
		public function timeAgo($time_ago){
			$cur_time   = time();
			$time_elapsed   = $cur_time - $time_ago;
			$seconds    = $time_elapsed ;
			$minutes    = round($time_elapsed / 60 );
			$hours      = round($time_elapsed / 3600);
			$days       = round($time_elapsed / 86400 );
			$weeks      = round($time_elapsed / 604800);
			$months     = round($time_elapsed / 2600640 );
			$years      = round($time_elapsed / 31207680 );
			if($seconds <= 60){
				return $seconds.' giây trước';
			}else if($minutes <=60){
				if($minutes==1){
					return "1 phút trước";
				}
				else{
					return "$minutes phút trước";
				}
			}else if($hours <=24){
				if($hours==1){
					return "1 giờ trước";
				}else{
					return "$hours giờ trước";
				}
			}else if($days <= 7){
				if($days==1){
					return "hôm qua";
				}else{
					return "$days ngày trước";
				}
			}else if($weeks <= 4.3){
				if($weeks==1){
					return "1 tuần trước";
				}else{
					return "$weeks tuần trước";
				}
			}else if($months <=12){
				if($months==1){
					return "1 tháng trước";
				}else{
					return "$months tháng trước";
				}
			}else{
				if($years==1){
					return "1 năm trước";
				}else{
					return "$years 1 năm trước";
				}
			}
		}
		public function get_thu($date)
		{
			$get_date = date('l',$date);
			switch ($get_date) {
				case 'Monday':
					$result_date = 'Thứ 2';
					break;
				case 'Tuesday':
					$result_date = 'Thứ 3';
					break;
				case 'Wednesday':
					$result_date = 'Thứ 4';
					break;
				case 'Thursday':
					$result_date = 'Thứ 5';
					break;
				case 'Friday':
					$result_date = 'Thứ 6';
					break;
				case 'Saturday':
					$result_date = 'Thứ 7';
					break;
				case 'Sunday':
					$result_date = 'Chủ nhật';
					break;
				default:
					$result_date = '';
					break;
			}
			return $result_date;
		}
		function cleanInput($input)
		{
			$search = array
			(
				'@<script[^>]*?>.*?</script>@si',   // Loại bỏ javascript
				'@<[\/\!]*?[^<>]*?>@si',            // Loại bỏ HTML tags
				'@<style[^>]*?>.*?</style>@siU',    // Loại bỏ style tags
				'@<![\s\S]*?--[ \t\n\r]*>@'         // Loại bỏ multi-line comments
			);
			$output = preg_replace($search, '', $input);
			return $output;
		}
		function sanitize($input)
		{
			if (is_array($input))
			{
				foreach($input as $var=>$val){
					$output[$var] = sanitize($val);
				}
			}else{
				if (get_magic_quotes_gpc()){
					$input = stripslashes($input);
				}
				$input  = cleanInput($input);
				$output = mysql_real_escape_string($input);
			}
			return $output;
		}
		function base64url_encode($plainText) {
			$base64 = base64_encode($plainText);
			$base64url = strtr($base64, '+/=', '-_,');
			return $base64url;
		}
		function base64url_decode($plainText) {
			$base64url = strtr($plainText, '-_,', '+/=');
			$base64 = base64_decode($base64url);
			return $base64;
		}
		function sendMailIndex($author,$title,$body,$emailAddress=null,$emailCC=null,$emailBCC=null){
			global $config;
			include_once "libraries/Mailer/class.phpmailer.php";
			$mail = new PHPMailer();
			$mail->IsSMTP();
			if($config['mail']['gmail']==true){
				$mail->SMTPSecure = $config['mail']['secure'];
				$mail->Port   = $config['mail']['port'];
			}
			$mail->SMTPAuth   = true;
			// $mail->SMTPDebug   = true;
			$mail->Host       = $config['mail']['ip'];
			$mail->Username   = $config['mail']['email'];
			$mail->Password   = $config['mail']['password'];
			$mail->SetFrom($config['mail']['email'],$author);
			if(!empty($emailAddress)){
				foreach ($emailAddress as $k => $v) {
					$mail->AddAddress($v,$author);
				}
			}
			if(!empty($emailCC)){
				foreach ($emailCC as $k => $v) {
					$mail->AddCC($v,$author);
				}
			}
			if(!empty($emailBCC)){
				foreach ($emailBCC as $k => $v) {
					$mail->AddBCC($v,$author);
				}
			}
			$mail->Subject    = $title;
			$mail->IsHTML(true);
			$mail->CharSet = "utf-8";
			$mail->Body = $body;
			if($mail->Send()){
				return true;
			}else{
				return false;
			}
		}
		function stripUnicode($str){
			if(!$str) return false;
			$unicode = array(
				'a'=>'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
				'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
				'd'=>'đ',
				'D'=>'Đ',
				'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
				'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
				'i'=>'í|ì|ỉ|ĩ|ị',	  
				'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
				'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
				'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
				'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
				'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
				'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
				'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
			);
			foreach($unicode as $khongdau=>$codau) {
				$arr=explode("|",$codau);
				$str = str_replace($arr,$khongdau,$str);
			}
			return $str;
		}
		public function pagination($totalq,$per_page=10,$page=1,$url='?'){
			$total = $totalq;
			$adjacents = "2";
			$prevlabel = "&lsaquo; Prev";
			$nextlabel = "Next &rsaquo;";
			$lastlabel = "Last &rsaquo;&rsaquo;";
			$page = ($page == 0 ? 1 : $page);
			$start = ($page - 1) * $per_page;
			$prev = $page - 1;
			$next = $page + 1;
			$lastpage = ceil($total/$per_page);
			$lpm1 = $lastpage - 1; // //last page minus 1
			$pagination = "";
			if($lastpage > 1){
				$pagination .= "<ul class='pagination justify-content-center'>";
				$pagination .= "<li class='page-item'><a class='page-link'>Page {$page} / {$lastpage}</a></li>";
					if ($page > 1) $pagination.= "<li class='page-item'><a class='page-link' href='{$url}&p={$prev}'>{$prevlabel}</a></li>";
				if ($lastpage < 7 + ($adjacents * 2)){
					for ($counter = 1; $counter <= $lastpage; $counter++){
						if ($counter == $page)
							$pagination.= "<li class='page-item active'><a class='page-link'>{$counter}</a></li>";
						else
							$pagination.= "<li class='page-item'><a class='page-link' href='{$url}&p={$counter}'>{$counter}</a></li>";
					}
				} elseif($lastpage > 5 + ($adjacents * 2)){
					if($page < 1 + ($adjacents * 2)) {
						for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
							if ($counter == $page)
								$pagination.= "<li class='page-item active'><a class='page-link'>{$counter}</a></li>";
							else
								$pagination.= "<li class='page-item'><a class='page-link' href='{$url}&p={$counter}'>{$counter}</a></li>";
						}
						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}&p=1'>...</a></li>";
						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}&p={$lpm1}'>{$lpm1}</a></li>";
						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}&p={$lastpage}'>{$lastpage}</a></li>";
					} elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}&p=1'>1</a></li>";
						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}&p=2'>2</a></li>";
						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}&p=1'>...</a></li>";
						for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
							if ($counter == $page)
								$pagination.= "<li class='page-item active'><a class='page-link'>{$counter}</a></li>";
							else
								$pagination.= "<li class='page-item'><a class='page-link' href='{$url}&p={$counter}'>{$counter}</a></li>";
						}
						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}&p=1'>...</a></li>";
						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}&p={$lpm1}'>{$lpm1}</a></li>";
						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}&p={$lastpage}'>{$lastpage}</a></li>";
					} else {
						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}&p=1'>1</a></li>";
						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}&p=2'>2</a></li>";
						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}&p=1'>...</a></li>";
						for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
							if ($counter == $page)
								$pagination.= "<li class='page-item active'><a class='page-link'>{$counter}</a></li>";
							else
								$pagination.= "<li class='page-item'><a class='page-link' href='{$url}&p={$counter}'>{$counter}</a></li>";
						}
					}
				}
					if ($page < $counter - 1) {
						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}&p={$next}'>{$nextlabel}</a></li>";
						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}&p=$lastpage'>{$lastlabel}</a></li>";
					}
				$pagination.= "</ul>";
			}
			return $pagination;
		}
		public function recursive_dir($dir){
		    foreach (scandir($dir) as $file) {
		        if ('.' === $file || '..' === $file){
		            continue;
		        }
		        if (is_dir("$dir/$file")){
		            $this->recursive_dir("$dir/$file");
		        }else{
		            unlink("$dir/$file");
		        }
		    }
		    rmdir($dir);
		}
		public function extractToZip($file,$path_new){
			if ($file["name"]) {
			    $filename       = $file["name"];
			    $source         = $file["tmp_name"];
			    $type           = $file["type"];
			    $name           = explode(".", $filename);
			    $accepted_types = array(
			        'application/zip',
			        'application/x-zip-compressed',
			        'multipart/x-zip',
			        'application/x-compressed'
			    );
			    foreach ($accepted_types as $mime_type) {
			        if ($mime_type == $type) {
			            $okay = true;
			            break;
			        }
			    }
			    $continue = strtolower($name[1]) == 'zip' ? true : false;
			    if (!$continue) {
			        $result['message'] = "Vui lòng tải lên tệp .zip hợp lệ.";
			    }
			    /* PHP current path */
			    $path      = dirname(__FILE__) . '/';
			    $filenoext = basename($filename, '.zip');
			    $filenoext = basename($filenoext, '.ZIP');
			    $myDir     = $path . $filenoext; // target directory
			    $myFile    = $path . $filename; // target zip file

			    if (is_dir($myDir)){
			        $this->recursive_dir($myDir);
			    }
			    mkdir($myDir, 0777);
			    if (move_uploaded_file($source, $myFile)) {
			        $zip = new ZipArchive();
			        $x   = $zip->open($myFile); // open the zip file to extract
			        if ($x === true) {
			            $zip->extractTo($path_new); // place in the directory with same name
			            $zip->close();
			            unlink($myFile);
			        }
			        $result['message'] = "Tập tin .zip của bạn được tải lên và giải nén.";
			    } else {
			        $result['message'] = "Có vấn đề với việc tải lên.";
			    }
			}else{
				$result['message'] = "Dữ liệu không thỏa điều kiện";
			}
			return $result;
		}

		public function youtobe($id){
			$ext = explode('=',$id);
			$vaich = explode('&', $ext[1]);
			return $vaich[0];
		}
		
	}
?>