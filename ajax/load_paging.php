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

	require_once _lib.'paginations.php';
	
	$field_load = "name_$lang as name, alias_$lang as alias, id, photo, thumb, price, price_old, status";
	
	$perPage = new paginations();
	$perPage->perpage = $row_setting['page_index'];
	$rowcount = (int)htmlspecialchars($_GET['rowcount']);
	$cateid = (int)htmlspecialchars($_GET['cateid']);
	$listid = (int)htmlspecialchars($_GET['listid']);
	$eShow = htmlspecialchars($_GET['eShow']);

	if(!empty($_GET['cateid'])){
		$where .= " and id_cat=".$cateid;
	}
	if(!empty($_GET['listid'])){
		$where .= " and id_list=".$listid;
	}
	$sql = "SELECT $field_load from #_products where id<>0 $where and find_in_set('hienthi',status) and find_in_set('noibat',status) and type='san-pham' ";
	if(!empty($_GET['cateid']) && !empty($_GET['listid'])){
		$paginationlink = "ajax/load_paging.php?listid=".$listid."&cateid=".$cateid."&p=";
	}else{
		$paginationlink = "ajax/load_paging.php?listid=".$listid."&p=";
	}
	$page = 1;
	if(!empty($_GET["p"])) { $page = (int)$_GET["p"]; }

	$start = ($page-1) * $perPage->perpage;
	if($start < 0) $start = 0;

	$query =  $sql . " limit " . $start . "," . $perPage->perpage; 
	$items = $d->rawQuery($query);

	$result = $d->rawQuery($sql);

	if($rowcount==0) {
		$rowcount = count($result);
	}
	
	$perpageresult = $perPage->getAllPageLinks($rowcount, $paginationlink,$eShow);	

	$output = '';
	if(count($result)==0){
		$output .= '<div class="w-100 margin-bottom-30"><p class="text-center">Dữ liệu không được tìm thấy</p></div>';
	}else{
		// $output .= $func->getTemplateProduct($items,'col--4 item','','margin-bottom-30','resize/280x225/1/',0, array('moi'), 1);
		$output .= $func->getTemplateProduct($items,'col--4 item','','margin-bottom-30','resize/280x225/1/',0, null, 0);

		/*foreach ($items as $k => $v) {
			$output .= '<div class="item col-4">
				<div class="img-service1">
					<div class="content-service1">
						<a href="'.$v['alias'].'"><img class="img-block-auto" src="resize/380x270/2/'._upload_post_l.$v['photo'].'?v='.$config['version'].'" alt="'.$v['name'].'"></a>
						<h3>
							<a href="'.$v['alias'].'" title="'.$v['name'].'">'.$v['name'].'</a>
						</h3>
					</div>
				</div>
			</div>';
		}*/
	}
	

	if(!empty($perpageresult)) {
		$output .= '<div id="pagination">' . $perpageresult . '</div>';
	}
	echo $output;
?>