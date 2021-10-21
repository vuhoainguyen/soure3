<nav class="sidebar sidebar-bunker <?=($_GET['com']=='orders' && $_GET['act']=='add') ? 'active':''?>">
    <div class="sidebar-header">
        <!--<a href="index.html" class="logo"><span>bd</span>task</a>-->
        <a href="index.html" class="logo"><img src="assets/dist/img/logo_BMWEB_co.png" alt=""></a>
    </div><!--/.sidebar header-->
    <?php /*  <div class="profile-element d-flex align-items-center flex-shrink-0">
        <div class="avatar online">
            <img src="assets/dist/img/avatar-1.jpg" class="img-fluid rounded-circle" alt="">
        </div>
        <div class="profile-text">
            <h6 class="m-0">Naeem Khan</h6>
            <span><a href="cdn-cgi/l/email-protection.html" class="__cf_email__" data-cfemail="76130e171b061a1336111b171f1a5815191b">[email&#160;protected]</a></span>
        </div>
    </div><!--/.profile element-->
    <form class="search sidebar-form" action="#" method="get" >
        <div class="search__inner">
            <input type="text" class="search__text" placeholder="Search...">
            <i class="typcn typcn-zoom-outline search__helper" data-sa-action="search-close"></i>
        </div>
    </form><!--/.search-->*/ ?>
    <div class="sidebar-body">
        <nav class="sidebar-nav">
            <ul class="metismenu">
                <li class="nav-label">Main Menu</li>
                <?php if($config['cart']['coupon']==true){ ?>
                <li class="<?=($_GET['com']=='coupons') ? 'mm-active':''?>">
                    <a class="has-arrow material-ripple" href="#">
                        <i class="typcn typcn-map mr-2"></i>
                        Quản lý mã giảm giá
                    </a>
                    <ul class="nav-second-level">
                        <li><a class="<?=($_GET['com']=='coupons') ? 'active':''?>" href="index.html?com=coupons&act=man">Danh sách mã giảm giá</a></li>
                    </ul>
                </li>
                <?php } ?>
                <?php if($setting['products']){ ?>
                <?php foreach ($setting['products'] as $k => $v) { ?>
                    <?php if($v['dropdown']==true){ ?>
                    <li class="<?=($_GET['com']=='products' || $_GET['table']=='products' || $_GET['com']=='product_posts' || $_GET['com']=='product_properties' || $_GET['type']=='phu-tung-theo-xe') ? 'mm-active':''?>">
                        <a class="has-arrow material-ripple" href="#">
                            <i class="typcn typcn-folder mr-2"></i>
                            Quản lý <?=$v['name']?>
                        </a>
                        <ul class="nav-second-level">
                            <?php $m=1; foreach ($v['level'] as $k1 => $v1) { ?>
                            <li><a class="<?=($_GET['com']==$v1 && $_GET['type']==$k) ? 'active':''?>" href="index.html?com=<?=$v1?>&act=man&table=products&type=<?=$k?>">Danh mục cấp <?=$m?></a></li>
                            <?php $m += 1;} ?>
                            <li><a class="<?=($_GET['com']=='products' && $_GET['type']==$k) ? 'active':''?>" href="index.html?com=products&act=man&type=<?=$k?>">Danh sách <?=$v['name']?></a></li>

                           <!--  <li><a class="<?=($_GET['com']=='multi_photos' && $_GET['type']=='phu-tung-theo-xe') ? 'active':''?>" href="index.html?com=multi_photos&act=man&type=phu-tung-theo-xe">Phụ tùng theo xe</a></li> -->
                        </ul>
                    </li>
                    <?php } ?>
                    <?php } ?>
                <?php } ?>

                <?php if($showpageproducts>0) { ?>
                <li class="<?=(!empty($setting['products'][$_GET['type']]) && $_GET['com']=='products') ? 'mm-active':''?>">
                    <a class="has-arrow material-ripple" href="#">
                        <i class="typcn typcn-folder mr-2"></i>
                        Quản lý sản phẩm
                    </a>
                    <ul class="nav-second-level">
                        <?php foreach ($setting['products'] as $k => $v) { ?>
                        <?php if($v['dropdown']==false){ ?>
                        <li><a class="<?=($_GET['com']=='products' && $_GET['type']==$k) ? 'active':''?>" href="index.html?com=products&act=man&type=<?=$k?>">Danh sách <?=$v['name']?></a></li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>


                <?php if($setting['posts']){ ?>
                <?php foreach ($setting['posts'] as $k => $v) { ?>
                    <?php if($v['dropdown']==true){ ?>
                    <li class="<?=(($_GET['com']=='posts' || $_GET['table']=='posts') && $_GET['type']==$k && $setting['posts'][$_GET['type']]['dropdown']==true) ? 'mm-active':''?>">
                        <a class="has-arrow material-ripple" href="#">
                            <i class="typcn typcn-news mr-2"></i>
                            Quản lý <?=$v['name']?>
                        </a>
                        <ul class="nav-second-level">
                            <?php $m=1; foreach ($v['level'] as $k1 => $v1) { ?>
                            <li><a class="<?=($_GET['com']==$v1 && $_GET['type']==$k) ? 'active':''?>" href="index.html?com=<?=$v1?>&act=man&table=posts&type=<?=$k?>">Danh mục cấp <?=$m?></a></li>
                            <?php $m += 1;} ?>
                            <li><a class="<?=($_GET['com']=='posts' && $_GET['type']==$k) ? 'active':''?>" href="index.html?com=posts&act=man&type=<?=$k?>">Danh sách <?=$v['name']?></a></li>
                        </ul>
                    </li>
                    <?php } ?>
                    <?php } ?>
                <?php } ?>

                <?php if($showpageposts>0) { ?>
                <li class="<?=(!empty($setting['posts'][$_GET['type']]) && $_GET['com']=='posts' && $setting['posts'][$_GET['type']]['dropdown']==false) ? 'mm-active':''?>">
                    <a class="has-arrow material-ripple" href="#">
                        <i class="typcn typcn-document mr-2"></i>
                        Quản lý bài viết
                    </a>
                    <ul class="nav-second-level">
                        <?php foreach ($setting['posts'] as $k => $v) { ?>
                        <?php if($v['dropdown']==false){ ?>
                        <li><a class="<?=($_GET['com']=='posts' && $_GET['type']==$k) ? 'active':''?>" href="index.html?com=posts&act=man&type=<?=$k?>">Danh sách <?=$v['name']?></a></li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>

                <?php if($setting['pages']){ ?>
                <li class="<?=(!empty($setting['pages'][$_GET['type']])) ? 'mm-active':''?>">
                    <a class="has-arrow material-ripple" href="#">
                        <i class="typcn typcn-tabs-outline mr-2"></i>
                        Quản lý trang tĩnh
                    </a>
                    <ul class="nav-second-level">
                        <?php foreach ($setting['pages'] as $k => $v) { ?>
                        <?php if($v['dropdown']==false){ ?>
                        <li><a class="<?=($_GET['com']=='pages' && $_GET['type']==$k) ? 'active':''?>" href="index.html?com=pages&act=update&type=<?=$k?>">Cập nhật <?=$v['name']?></a></li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>

                <?php if($setting['photos']){ ?>
                <li class="<?=(!empty($setting['photos'][$_GET['type']])) ? 'mm-active':''?>">
                    <a class="has-arrow material-ripple" href="#">
                        <i class="typcn typcn-th-small mr-2"></i>
                        Quản lý photo
                    </a>
                    <ul class="nav-second-level">
                        <?php foreach ($setting['photos'] as $k => $v) { ?>
                        <?php if($v['dropdown']==false){ ?>
                        <li><a class="<?=($_GET['com']=='photos' && $_GET['type']==$k) ? 'active':''?>" href="index.html?com=photos&act=update&type=<?=$k?>">Cập nhật <?=$v['name']?></a></li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                
                <?php if($setting['multi_photos']){ ?>
                <li class="<?=(!empty($setting['multi_photos'][$_GET['type']])) ? 'mm-active':''?>">
                    <a class="has-arrow material-ripple" href="#">
                        <i class="typcn typcn-image mr-2"></i>
                        Quản lý gallery
                    </a>
                    <ul class="nav-second-level">
                        <?php foreach ($setting['multi_photos'] as $k => $v) { ?>
                        <?php if($v['dropdown']==false){ ?>
                            <li><a class="<?=($_GET['com']=='multi_photos' && $_GET['type']==$k) ? 'active':''?>" href="index.html?com=multi_photos&act=man&type=<?=$k?>">Cập nhật <?=$v['name']?></a></li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>

                <?php if($setting['videos']){ ?>
                <li class="<?=(!empty($setting['videos'][$_GET['type']])) ? 'mm-active':''?>">
                    <a class="has-arrow material-ripple" href="#">
                        <i class="typcn typcn-video-outline mr-2"></i>
                        Quản lý video
                    </a>
                    <ul class="nav-second-level">
                        <?php foreach ($setting['videos'] as $k => $v) { ?>
                        <?php if($v['dropdown']==false){ ?>
                        <li><a class="<?=($_GET['com']=='videos' && $_GET['type']==$k) ? 'active':''?>" href="index.html?com=videos&act=man&type=<?=$k?>">Danh sách <?=$v['name']?></a></li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
    
                <?php if($setting['customers'] && $config['login']['check']==true){ ?>
                <li class="<?=(!empty($setting['customers'][$_GET['type']])) ? 'mm-active':''?>">
                    <a class="has-arrow material-ripple" href="#">
                        <i class="typcn typcn-group-outline mr-2"></i>
                        Quản lý khách hàng
                    </a>
                    <ul class="nav-second-level">
                        <?php foreach ($setting['customers'] as $k => $v) { ?>
                        <?php if($v['dropdown']==false){ ?>
                        <li><a class="<?=($_GET['com']=='customers' && $_GET['type']==$k) ? 'active':''?>" href="index.html?com=customers&act=man&type=<?=$k?>">Danh sách <?=$v['name']?></a></li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                
                <?php if($config['cart']['check']==true){ ?>
                <?php if($setting['orders']){ ?>
                <li class="<?=(!empty($setting['orders'][$_GET['type']]) || $_GET['com']=='statitics') ? 'mm-active':''?>">
                    <a class="has-arrow material-ripple" href="#">
                        <i class="typcn typcn-shopping-cart mr-2"></i>
                        Quản lý đơn hàng
                    </a>
                    <ul class="nav-second-level">
                        <?php foreach ($setting['orders'] as $k => $v) { ?>
                        <?php if($v['dropdown']==false){ ?>
                        <li><a class="<?=($_GET['com']=='orders' && $_GET['type']==$k) ? 'active':''?>" href="index.html?com=orders&act=man&type=<?=$k?>">Danh sách <?=$v['name']?></a></li>
                        <?php } ?>
                        <?php } ?>
                        <li><a class="<?=($_GET['com']=='statitics') ? 'active':''?>" href="index.html?com=statitics&act=man&type=<?=$k?>">Thống kê - báo cáo</a></li>
                    </ul>
                </li>
                <?php } ?>
                <?php } ?>

                <?php if($setting['newsletters']){ ?>
                <li class="<?=(!empty($setting['newsletters'][$_GET['type']]) || !empty($setting['sends'][$_GET['type']])) ? 'mm-active':''?>">
                    <a class="has-arrow material-ripple" href="#">
                        <i class="typcn typcn-mail mr-2"></i>
                        Quản lý nhận tin
                    </a>
                    <ul class="nav-second-level">
                        <?php foreach ($setting['newsletters'] as $k => $v) { ?>
                        <?php if($v['dropdown']==false){ ?>
                        <li><a class="<?=($_GET['com']=='newsletters' && $_GET['type']==$k) ? 'active':''?>" href="index.html?com=newsletters&act=man&type=<?=$k?>">Danh sách <?=$v['name']?></a></li>
                        <?php } ?>
                        <?php } ?>

                        <?php foreach ($setting['sends'] as $k => $v) { ?>
                        <?php if($v['dropdown']==false){ ?>
                        <li><a class="<?=($_GET['com']=='sends' && $_GET['type']==$k) ? 'active':''?>" href="index.html?com=sends&act=man&type=<?=$k?>">Danh sách <?=$v['name']?></a></li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                <?php if($setting['tags']){ ?>
                <li class="<?=(!empty($setting['tags'][$_GET['type']]) && $_GET['com']=='tags') ? 'mm-active':''?>">
                    <a class="has-arrow material-ripple" href="#">
                        <i class="typcn typcn-tags mr-2"></i>
                        Quản lý tags
                    </a>
                    <ul class="nav-second-level">
                        <?php foreach ($setting['tags'] as $k => $v) { ?>
                        <?php if($v['dropdown']==false){ ?>
                        <li><a class="<?=($_GET['com']=='tags' && $_GET['type']==$k) ? 'active':''?>" href="index.html?com=tags&act=man&type=<?=$k?>">DS <?=$v['name']?></a></li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>

                <?php if($setting['infos']){ ?>
                <li class="<?=(!empty($setting['infos'][$_GET['type']])) ? 'mm-active':''?>">
                    <a class="has-arrow material-ripple" href="#">
                        <i class="typcn typcn-tabs-outline mr-2"></i>
                        Quản lý mô tả trang
                    </a>
                    <ul class="nav-second-level">
                        <?php foreach ($setting['infos'] as $k => $v) { ?>
                        <?php if($v['dropdown']==false){ ?>
                        <li><a class="<?=($_GET['com']=='infos' && $_GET['type']==$k) ? 'active':''?>" href="index.html?com=infos&act=update&type=<?=$k?>">Cập nhật <?=$v['name']?></a></li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                <?php if($config['other']['permission']==true){ ?>
                <?php if($_SESSION['login']['role']==3){ ?>
                <li class="<?=($_GET['com']=='permissions' || $_GET['com']=='users') ? 'mm-active':''?>">
                    <a class="has-arrow material-ripple" href="#">
                        <i class="typcn typcn-arrow-sync-outline mr-2"></i>
                        Quản lý phân quyền
                    </a>
                    <ul class="nav-second-level">
                         <li><a class="<?=($_GET['com']=='permissions') ? 'active':''?>" href="index.html?com=permissions&act=man">Danh sách quyền</a></li>
                         <li><a class="<?=($_GET['com']=='users') ? 'active':''?>" href="index.html?com=users&act=man">Danh sách quản trị viên</a></li>
                    </ul>
                </li>
                <?php } ?>
                <?php } ?>
                <?php if($config['place']==true){ ?>
                <li class="<?=($_GET['com']=='place_citys' || $_GET['com']=='place_dists' || $_GET['com']=='place_wards' || $_GET['com']=='place_streets') ? 'mm-active':''?>">
                    <a class="has-arrow material-ripple" href="#">
                        <i class="typcn typcn-map mr-2"></i>
                        Quản lý khu vực
                    </a>
                    <ul class="nav-second-level">
                        <li><a class="<?=($_GET['com']=='place_citys') ? 'active':''?>" href="index.html?com=place_citys&act=man">Danh sách tỉnh thành</a></li>
                        <li><a class="<?=($_GET['com']=='place_dists') ? 'active':''?>" href="index.html?com=place_dists&act=man">Danh sách quận huyện</a></li>
                        <li><a class="<?=($_GET['com']=='place_wards') ? 'active':''?>" href="index.html?com=place_wards&act=man">Danh sách phường xã</a></li>
                        <li><a class="<?=($_GET['com']=='place_streets') ? 'active':''?>" href="index.html?com=place_streets&act=man">Danh sách đường phố</a></li>
                    </ul>
                </li>
                <?php } ?>
                 <?php if($setting['contacts']){ ?>
                <li class="<?=(!empty($setting['contacts'][$_GET['type']])) ? 'mm-active':''?>">
                    <a class="has-arrow material-ripple" href="#">
                        <i class="typcn typcn-bell mr-2"></i>
                        Quản lý form liên hệ
                    </a>
                    <ul class="nav-second-level">
                        <?php foreach ($setting['contacts'] as $k => $v) { ?>
                        <?php if($v['dropdown']==false){ ?>
                        <li><a class="<?=($_GET['com']=='contacts' && $_GET['type']==$k) ? 'active':''?>" href="index.html?com=contacts&act=man&type=<?=$k?>">Danh sách <?=$v['name']?></a></li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                <?php if($setting['branchs']){ ?>
                <li class="<?=(!empty($setting['branchs'][$_GET['type']])) ? 'mm-active':''?>">
                    <a class="has-arrow material-ripple" href="#">
                        <i class="typcn typcn-tabs-outline mr-2"></i>
                        Quản lý chi nhánh
                    </a>
                    <ul class="nav-second-level">
                        <?php foreach ($setting['branchs'] as $k => $v) { ?>
                        <li><a class="<?=($_GET['com']=='branchs' && $_GET['type']==$k) ? 'active':''?>" href="index.html?com=branchs&act=man&type=<?=$k?>">Danh sách <?=$v['name']?></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                <li class="<?=($_GET['com']=='settings' || $_GET['com']=='meta_seos') ? 'mm-active':''?>">
                    <a class="has-arrow material-ripple" href="#">
                        <i class="typcn typcn-map mr-2"></i>
                        Cấu hình - Meta seo
                    </a>
                    <ul class="nav-second-level">
                        <li><a class="<?=($_GET['com']=='settings') ? 'active':''?>" href="index.html?com=settings&act=update">Cấu hình website</a></li>
                        <li><a class="<?=($_GET['com']=='meta_seos') ? 'active':''?>" href="index.html?com=meta_seos&act=man">Meta seo trang tĩnh</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div><!-- sidebar-body -->
</nav>