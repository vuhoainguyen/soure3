<div class="opacity-menu"></div>
<div class="header-left-fixwidth">
	<div class="section wrap-header">
		<div class="logos-menu">
			<a href="<?=$config_base?>">
				<img src="<?=_upload_photo_l.$row_logo_index['thumb']?>" alt="<?=$row_logo_index['name']?>">
			</a>
		</div>
		<?php /*<div class="searchs-menu">
			<form class="search-bar" action="tim-kiem" method="get" onsubmit="return false" id="search-form-mobile" name="search-form-mobile" role="search">
				<input type="text" name="keywords" value="<?=$_GET['keywords']?>" id="keywords" placeholder="Tìm kiếm... "  role="search-input" class="search-text">
				<button class="search-btn">
					<i class="fa fa-search"></i>
				</button>
			</form>
		</div>
		if ($config['cart']['check']==true || $config['login']['check']==true){ ?>
		<div class="account-cart-menu">
			<?php if ($config['cart']['check']==true){ ?>
			<a class="btn-text" href="cart/gio-hang"><?=_gio_hang?></a> <?php if($config['login']['check']==true){ ?><span>|</span><?php } ?>
			<?php } ?>
			<?php if($config['login']['check']==true){ ?>
				<?php if(isset($_SESSION['signin'])){ ?>
				<a class="btn-text" href="account/thong-tin-tai-khoan"><?=_taikhoan?></a> <span>|</span>
				<a class="btn-text" href="account/dang-xuat"><?=_dangxuat?></a>
				<?php }else{ ?>
				<a class="btn-text" href="account/dang-nhap&return=<?=base64_encode($func->getCurrentPage())?>"><?=_dangnhap?></a> <span>|</span>
				<a class="btn-text" href="account/dang-ky&return=<?=base64_encode($func->getCurrentPage())?>"><?=_dangky?></a>
				<?php } ?>
			<?php } ?>
		</div>
		<?php }*/ ?>
		<div class="nav-menu margin-top-10 padding-bottom-40">
			<ul>
			    <li class="nav-item <?=($source=='index') ? 'active':''?>">
                    <a class="a-img" href="<?=$config_base?>"><?=_trangchu?></a>
                </li>
                <li class="nav-item">
                    <a href="san-pham"><?=_sanpham?></a>
                    <?php if(count($menu_lists_product)>0) { ?><span class="btn-dropdown-menu"><i class="fa fa-angle-right"></i></span><?php } ?>
                    <?php if(count($menu_lists_product)>0){ ?>
                    <ul class="sub-menu none level0">
                        <?php foreach ($menu_lists_product as $k => $v) { $menu_cats_product = $d->rawQuery("SELECT id,name_$lang as name, alias_$lang as alias from #_cats where type=? and find_in_set ('hienthi',status) and id_list=? order by numb asc, id desc",array("san-pham",$v['id'])); ?>
                        <li>
                            <a href="<?=$v['alias']?>"><?=$v['name']?></a>
                            <?php if(count($menu_cats_product)>0) { ?><span class="btn-dropdown-menu"><i class="fa fa-angle-right"></i></span><?php } ?>
                            <?php if(count($menu_cats_product)>0) { ?>
                            <ul class="sub-menu none level1">
                                <?php foreach ($menu_cats_product as $k1 => $v1) { ?>
                                <li class="level2"> <a href="<?=$v1['alias']?>"><span><?=$v1['name']?></span></a></li>
                                <?php } ?>
                            </ul>
                            <?php } ?>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                </li>
                <?php if(count($menu_lists_product_show)>0){ ?>
                <?php foreach ($menu_lists_product_show as $k1 => $v1) { $menu_cats_product = $d->rawQuery("SELECT id,name_$lang as name, alias_$lang as alias from #_cats where type=? and id_list=? and find_in_set ('hienthi',status) order by id desc",array("san-pham",$v1['id']));?>
                <li class="nav-item <?=($idl==$v1['alias']) ? 'active':''?>">
                    <a class="a-img" href="<?=$v1['alias']?>"><?=$v1['name']?></a>
                    <?php if(count($menu_cats_product)>0) { ?><span class="btn-dropdown-menu"><i class="fa fa-angle-right"></i></span><?php } ?>
                    <?php if(count($menu_cats_product)>0){ ?>
                    <ul class="sub-menu none level0">
                        <?php foreach ($menu_cats_product as $k2 => $v2) { ?>
                        <li>
                            <a href="<?=$v2['alias']?>"><?=$v2['name']?></a>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                </li>
                <?php } ?>
                <?php } ?>
                <li class="nav-item <?=($_GET['com']=='tin-tuc') ? 'active':''?>">
                    <a class="a-img" href="tin-tuc">Tin tức</a>
                </li>
                <li class="nav-item <?=($_GET['com']=='lien-he') ? 'active':''?>">
                    <a class="a-img" href="lien-he"><?=_lienhe?></a>
                </li>
			</ul>
		</div>
	</div>
</div>