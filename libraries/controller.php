<?php 
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @author  AP CAO
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */
	$com = (isset($_REQUEST['com'])) ? addslashes($_REQUEST['com']) : "";
	$page = (int)(!isset($_GET["p"]) ? 1 : $_GET["p"]);
	if($page <= 0) $page = 1;
	
	$row_setting = $d->rawQueryOne("select *, address_$lang as address, company_$lang as company, slogan_$lang as slogan, title_$lang as title, keywords_$lang as keywords, description_$lang as description from #_settings limit 0,1");
	$row_favicon = $d->rawQueryOne("select thumb,photo from #_photos where type=? and find_in_set ('hienthi',status)",array('favicon'));
	$row_share = $d->rawQueryOne("select thumb,photo from #_photos where type=? and find_in_set ('hienthi',status)",array('share'));
	$row_logo = $d->rawQueryOne("select thumb,name_$lang as name from #_photos where type=? and find_in_set ('hienthi',status)",array('logo'));
	$row_video = $d->rawQueryOne("select youtube from #_videos where type=? and find_in_set ('hienthi',status) order by numb asc, id desc limit 0,1",array('clips'));
	$row_popup = $d->rawQueryOne("select photo,link,name_$lang as name,status from #_photos where type=? and find_in_set ('hienthi', status) limit 0,1", array('popup'));
	$attr_page = array(
	    array("tbl"=>"lists","field"=>"idl","source"=>"products","com"=>"san-pham","type"=>"san-pham"),
	    array("tbl"=>"cats","field"=>"idc","source"=>"products","com"=>"san-pham","type"=>"san-pham"),
	    array("tbl"=>"products","field"=>"id","source"=>"products","com"=>"san-pham","type"=>"san-pham"),
	    array("tbl"=>"posts","field"=>"id","source"=>"posts","com"=>"tin-tuc","type"=>"tin-tuc"),
	    array("tbl"=>"posts","field"=>"id","source"=>"posts","com"=>"tuyen-dung","type"=>"tuyen-dung"),
	    array("tbl"=>"posts","field"=>"id","source"=>"posts","com"=>"dich-vu","type"=>"dich-vu"),
	    array("tbl"=>"posts","field"=>"id","source"=>"posts","com"=>"ho-tro","type"=>"ho-tro"),
	    array("tbl"=>"pages","field"=>"id","source"=>"pages","com"=>"gioi-thieu","type"=>"gioi-thieu"),
	    array("tbl"=>"contacts","field"=>"id","source"=>"contacts","com"=>"lien-he","type"=>"lien-he"),
	    array("tbl"=>"multi_photos","field"=>"id","source"=>"multi_photos","com"=>"hoat-dong","type"=>"album")
	);
	if($com){
	    foreach($attr_page as $k => $v){
	        if(isset($com) && $v['tbl']!='pages' && $v['tbl']!='contacts' && $v['tbl']!='videos'){
	            $row = $d->rawQueryOne("select id from #_".$v['tbl']." where alias_$lang='".$com."' and type='".$v['type']."' and find_in_set ('hienthi',status)");
	            if(!empty($row)){
	                $_GET[$v['field']] = $row['id'];
	                $com = $v['com'];
	                break;
	            }
	        }
	    }
	}
	switch ($com) {
		case 'tags-san-pham':
			$title = $title_seo = 'Tags '._sanpham;
			$source = "tags";
			$type_ob = isset($_GET['id']) ? "article" : "object";
			$template = "products/product";
			break;
		case 'tags-bai-viet':
			$title = $title_seo = 'Tags '._baiviet;
			$source = "tags";
			$type_ob = isset($_GET['id']) ? "article" : "object";
			$template = "posts/post";
			break;
		case 'san-pham':
			$title = $title_seo = _sanpham;
			$type = 'san-pham';
			$source = "products";
			$type_ob = isset($_GET['id']) ? "article" : "object";
			$template = isset($_GET['id']) ? "products/product_detail" : "products/product";
			break;
		case 'phu-tung-theo-xe':
			$title = $title_seo = 'Phụ tùng theo xe';
			$type = 'phu-tung-theo-xe';
			$source = "accessarys";
			$type_ob = isset($_GET['id']) ? "article" : "object";
			$template = "accessarys/product";
			break;
		case 'san-pham-noi-bat':
			$title = $title_seo = _sanpham . ' ' . _noi_bat;
			$type = 'san-pham';
			$option = 'noibat';
			$source = "products";
			$type_ob = "object";
			$template = "products/product";
			break;
		case 'san-pham-ban-chay':
			$title = $title_seo = _sanpham . ' ' . _ban_chay;
			$type = 'san-pham';
			$option = 'banchay';
			$source = "products";
			$type_ob = "object";
			$template = "products/product";
			break;
		case 'tin-tuc':
			$title = $title_seo = _tintuc;
			$type = 'tin-tuc';
			$source = "posts";
			$type_ob = isset($_GET['id']) ? "article" : "object";
			$template = isset($_GET['id']) ? "posts/post_detail" : "posts/post";
			break;
		case 'dich-vu':
			$title = $title_seo = 'Dịch vụ';
			$type = 'dich-vu';
			$source = "posts";
			$type_ob = isset($_GET['id']) ? "article" : "object";
			$template = isset($_GET['id']) ? "posts/post_detail" : "posts/post";
			break;
		case 'tuyen-dung':
			$title = $title_seo = 'Tuyển dụng';
			$type = 'tuyen-dung';
			$source = "posts";
			$type_ob = isset($_GET['id']) ? "article" : "object";
			$template = isset($_GET['id']) ? "posts/post_detail" : "posts/post";
			break;
		case 'chinh-sach':
			$title = $title_seo = 'Chính sách';
			$type = 'chinh-sach';
			$source = "posts";
			$type_ob = isset($_GET['id']) ? "article" : "object";
			$template = isset($_GET['id']) ? "posts/post_detail" : "posts/post";
			break;
		case 'lien-he':
			$title = $title_seo = _lien_he_chung_toi;
			$type = 'lien-he';
			$source = "contacts";
			$type_ob = "object";
			$template = "contacts/contact";
			break;
		case 'gioi-thieu':
			$title = $title_seo = _gioi_thieu_ve_chung_toi;
			$type = 'gioi-thieu';
			$source = "pages";
			$type_ob = "article";
			$template = "pages/page";
			break;
		case 'hoat-dong':
			$title = $title_seo = 'Hoạt động';
			$type = 'album';
			$source = "multi_photos";
			$type_ob = "object";
			$template = isset($_GET['id']) ? "multi_photos/item_detail" : "multi_photos/item";
			break;
		case 'video':
			$title = $title_seo = _video;
			$type = 'clips';
			$source = "videos";
			$type_ob = "article";
			$template = "videos/page";
			break;
		case 'account':
			$title = $title_seo = _taikhoan_kh;
			$type = 'member';
			$source = "users";
			$type_ob = "object";
			$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";
			switch ($act) {
				case 'dang-nhap':
					$title = $title_seo = _dangnhap. ' ' ._taikhoan;
					$template = 'accounts/login';
					break;
				case 'dang-ky':
					$title = $title_seo = _dangky. ' ' ._taikhoan;
					$template = 'accounts/register';
					break;
				case 'thong-tin-tai-khoan':
					$title = $title_seo = _thongtin. ' ' ._taikhoan;
					$template = 'accounts/profile';
					break;
				case 'doi-mat-khau':
					$title = $title_seo = _doi.' '._matkhau;
					$template = 'accounts/profile';
					break;
				case 'quen-mat-khau':
					$title = $title_seo = _quen.' '._matkhau;
					$template = 'accounts/forgot_password';
					break;
				case 'so-dia-chi':
					$title = $title_seo = _so_diachi;
					$template = 'accounts/address_list';
					break;
				case 'danh-sach-don-hang':
					$title = $title_seo = _danhsach.' '._donhang;
					$template = 'accounts/order_list';
					break;
				case 'don-hang-doi-tra':
					$title = $title_seo = _danhsach.' '._donhang.' '. _doitra;
					$template = 'accounts/order_return_list';
					break;
				case 'don-hang-huy':
					$title = $title_seo = _danhsach.' '._donhang.' '. _huy;
					$template = 'accounts/order_cancel_list';
					break;
				default:
					header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
					$template = "404";
					break;
			}
			$str_breadcrumbs = $breadcrumbs->getUrl(_trangchu, array(array('alias'=>'account/'.$act,'name'=>$title)));
			break;
		case 'carts':
			$title = 'Giỏ hàng';
			$type = 'san-pham';
			$source = "carts";
			$type_ob = "object";
			if(!$func->isAjax()){ 
				$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";
				switch ($act) {
					case 'gio-hang':
						$title = $title_seo = _gio_hang;
						$template = 'carts/items';
						break;
					case 'thanh-toan':
						$title = $title_seo = _thanh_toan;
						$template = 'carts/checkout';
						break;
					case 'xac-nhan':
						$title = $title_seo = _xac_nhan.' '._donhang;
						$template = 'carts/checkorder';
						break;
					default:
						header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
						$template = "404";
						break;
				}
				$str_breadcrumbs = $breadcrumbs->getUrl(_trangchu, array(array('alias'=>'carts/'.$act,'name'=>$title)));
			}else{
				include _sources.'carts.php';
				die;
			}
			break;

		
		/*case 'tim-kiem':
			$title = $title_seo = _timkiem.' bài viết';
			$source = "search_posts";
			$type_ob = isset($_GET['id']) ? "article" : "object";
			$template = "posts/post";  
			break;*/
		case 'tim-kiem':
			$title = $title_seo = _timkiem.' '._sanpham;
			$type = 'san-pham';
			$source = "searchs";
			$type_ob = isset($_GET['id']) ? "article" : "object";
			if(!$func->isAjax()){ 
				$template = "products/product";  
			}else{
				include _sources.'searchs.php';
				$template = "products/product"; 
				die;
			}
			break;

		case 'quickview':
			$title = _xem_nhanh;
			$type = 'san-pham';
			$source = "quickview";
			$type_ob = "object";
			break;
		case 'lang':
			if(isset($_GET['lang']))
			{
				switch($_GET['lang'])
					{
					case 'vi':
						$_SESSION['lang'] = 'vi';
						break;
					case 'en':
						$_SESSION['lang'] = 'en';
						break;
					default:
						$_SESSION['lang'] = 'vi';
						break;
					}
			}
			else{
				$_SESSION['lang'] = 'vi';
			}
			$func->redirect($_SERVER['HTTP_REFERER']);
			break;

		case '': 
			$source = 'index';
			$template = 'index'; 
			$type_ob = "website";
			break;

		default:
			header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
			$template = "404";
			break;
	}
	
	include_once _lib."style.php";
	if($source!="") include _sources.$source.".php";
?>