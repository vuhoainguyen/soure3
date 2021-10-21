<?php 
	$row_logo_index = $d->rawQueryOne("select photo,thumb,name_$lang as name from #_photos where type=? and find_in_set ('hienthi',status)",array('logo'));
	$row_logo_index1 = $d->rawQueryOne("select photo,thumb,name_$lang as name from #_photos where type=? and find_in_set ('hienthi',status)",array('logo1'));
	$row_banner_index = $d->rawQueryOne("select photo,thumb,name_$lang as name from #_photos where type=? and find_in_set ('hienthi',status)",array('banner'));
    $menu_lists_product = $d->rawQuery("SELECT id,name_$lang as name, alias_$lang as alias from #_lists where type=? and find_in_set ('hienthi',status) order by numb asc, id desc",array("san-pham"));
?>
<header id="header" class="header">
	<div class="container">
		<div class="row d-flex justify-content-end">
			<div class="item">
				<ul class="top-header d-flex flex-wrap justify-content-end align-items-center">
					<li>
						<i class="fa fa-map-marker"></i> <?=$row_setting['address']?>
					</li>
					<li>
						<i class="fa fa-phone"></i> Hotline: <?=$row_setting['hotline']?>
					</li>
				</ul>
			</div>
		</div>
		<div class="header-box d-flex justify-content-between align-items-end">
			<div class="logo d-flex justify-content-center align-items-center">
				<a href="">
					<img class="img-block-auto" src="<?=_upload_photo_l.$row_logo_index['thumb']?>" alt="<?=$row_setting['company']?>">
				</a>
			</div>
			<div class="list-btn">
				<h5 class="menu-click-list">Danh mục sản phẩm<span></span></h5>
                <?php if(count($menu_lists_product)>0){ ?>
                <ul class="list-btn-position">
                    <?php foreach ($menu_lists_product as $k1 => $v1) { $menu_cats_product = $d->rawQuery("SELECT id,name_$lang as name, alias_$lang as alias from #_cats where type=? and id_list=? and find_in_set ('hienthi',status) order by id desc",array("san-pham",$v1['id']));?>
                    <li>
                        <a href="<?=$v1['alias']?>"><?=$v1['name']?></a>
                        <?php if(count($menu_cats_product)>0){ ?>
                        <span><i class="fa fa-angle-right"></i></span>
                        <ul>
                            <?php foreach ($menu_cats_product as $k2 => $v2) { ?>
                            <li>
                                <a href="<?=$v2['alias']?>"><?=$v2['name']?></a>
                            </li>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                    </li>
                    <?php } ?>
                </ul>
                <?php } ?>
			</div>
			<div class="menu-list d-flex flex-wrap justify-content-end">
				<?php require_once _layouts.'menu.php'; ?>
			</div>
		</div>
	</div>
</header><!-- /header -->

