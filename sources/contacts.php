<?php 
	$row_detail = $d->rawQueryOne("SELECT id,name_$lang as name, alias_$lang as alias, desc_$lang as descs, type, content_$lang as content, photo, thumb, title_$lang as title, keywords_$lang as keywords, description_$lang as description from #_pages where type=? ",array($type));

	if($com=='bao-gia'){
		$row_seo = $d->rawQueryOne("SELECT photo, thumb, title_$lang as title, keywords_$lang as keywords, description_$lang as description from #_meta_seos where type=? and find_in_set ('hienthi',status)",array('bao-gia'));
		$title_seo = ($row_seo['title']=='') ? $row_setting['title']:$row_seo['title'];
		$keywords_seo = ($row_seo['keywords']=='') ? $row_setting['keywords']:$row_seo['keywords'];
		$description_seo = ($row_seo['description']=='') ? $row_setting['description']:$row_seo['description'];
		$str_share = $func->getShare($row_seo,_upload_photo_l,$type_ob,false,'thumb');
	}else{
		$str_breadcrumbs = $breadcrumbs->getUrl(_trangchu, array(array('alias'=>$type,'name'=>$title)));

		$title_seo = ($row_detail['title']=='') ? $row_detail['name']:$row_detail['title'];
		$keywords_seo = ($row_detail['keywords']=='') ? $row_setting['keywords']:$row_detail['keywords'];
		$description_seo = ($row_detail['description']=='') ? $row_setting['description']:$row_detail['description'];
		$str_share = $func->getShare($row_detail,_upload_post_l,$type_ob,false);
	}
	
	
	if(!empty($_POST)){
		$data = $_POST['data'];
    	if($_POST){
    		foreach ($data as $k => $v) {
				$data[$k] = htmlspecialchars($v);
			}
    	}
    	$data['subject'] = 'Liên hệ đến từ website';
    	$data['status'] = 'hienthi';
		$data['createdAt'] = $d->now();
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {
		    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
		    $recaptcha_secret = $config['website']['secretkey'];
		    $recaptcha_response = $_POST['recaptcha_response'];
		    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
		    $recaptcha = json_decode($recaptcha);
		    if ($recaptcha->score >= 0.5) {
				if($func->sendMailIndex($row_setting['email'],_lien_he_den_tu.' website',$data['content'],array($row_setting['email']),null,null)){
					$id_insert = $d->insert('contacts', $data);
					if ($id_insert) {
					    $result['status'] = 200;
						$result['message'] = _thong_bao_them_du_lieu_thanh_cong.' id#'.$id_insert;
					}
					$func->transfer(_thong_bao_gui_mail_thanh_cong.'!', $config_base);
				}else{
					$func->transfer(_thong_bao_gui_mail_that_bai.'!', $config_base.'lien-he');
				}
			}else{
				$result['status'] = 201;
				$func->transfer(_thong_bao_spam_he_thong.'!', $config_base.'lien-he');
			}
		}
	}

?>