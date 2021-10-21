
<section id="menu" class="menu-fixed-scroll">
    <nav id="menu-box">
        <ul class="item-big">
            <li class="nav-item <?=($source=='index') ? 'active':''?>">
                <a class="a-img" href="">Trang chủ</a>
            </li>
            <li class="nav-item <?=($_GET['com']=='gioi-thieu') ? 'active':''?>">
                <a class="a-img" href="gioi-thieu">Giới thiệu</a>
            </li>
            <li class="nav-item <?=($_GET['com']=='dich-vu') ? 'active':''?>">
                <a class="a-img" href="dich-vu">Dịch vụ</a>
                 <?php if(count($menu_lists_product)>0){ ?>
                <ul class="sub-menu level0 mega-content">
                    <?php foreach ($menu_lists_product as $k => $v) { $menu_cats_product = $d->rawQuery("SELECT id,name_$lang as name, alias_$lang as alias from #_cats where type=? and find_in_set ('hienthi',status) and id_list=? order by numb asc, id desc",array("san-pham",$v['id'])); ?>
                    <li>
                        <a href="<?=$v['alias']?>"><?=$v['name']?> <?php if(count($menu_cats_product)>0) { ?><span class="btn-dropdown-menu"><i class="fa fa-angle-right"></i></span><?php } ?></a>
                        <?php if(count($menu_cats_product)>0) { ?>
                        <ul class="sub-menu level1">
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
            <li class="nav-item <?=($_GET['com']=='tuyen-dung') ? 'active':''?>">
                <a class="a-img" href="tuyen-dung">Tuyển dụng</a>
            </li>
            <li class="nav-item <?=($_GET['com']=='tin-tuc') ? 'active':''?>">
                <a class="a-img" href="tin-tuc">Tin tức</a>
            </li>
            <li class="nav-item <?=($_GET['com']=='lien-he') ? 'active':''?>">
                <a class="a-img" href="lien-he"><?=_lienhe?></a>
            </li>
            <li class="nav-item">
                <span class="search-icon">
                    <i class="fa fa-search"></i>
                </span>
            </li>
        </ul>
        <div class="menu-mobile">
            <span></span>
        </div>
        <form class="search-bar" action="tim-kiem" id="search-form" name="search-form" method="get" onsubmit="return false" role="search">
            <input type="text" name="keywords" value="<?=$_GET['keywords']?>" id="keywords" role="search-input" placeholder="<?=_timkiem?>... " class="search-text">
            <button class="search-btn">
                <i class="fa fa-search"></i>
            </button>
        </form>
    </nav>
</section>

