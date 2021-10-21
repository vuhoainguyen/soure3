<?php 
    $product_noibat = $d->rawQuery("SELECT id,name_$lang as name, status, alias_$lang as alias,material_$lang as material, desc_$lang as descs, photo, thumb,price,price_old from #_products where type=? and find_in_set ('hienthi',status) and find_in_set ('noibat',status) order by numb asc, id desc limit 0,15",array("san-pham"));
    $product_lists = $d->rawQuery("SELECT id,name_$lang as name, status, alias_$lang as alias,icon,icon_thumb, photo, thumb from #_lists where type=? and find_in_set ('hienthi',status) order by numb asc, id desc",array("san-pham"));

    $row_camnhan = $d->rawQueryOne("select photo,name_$lang as name,desc_$lang as descs from #_pages where type=?", array('cam-nhan'));

    //print_r( $d->getLastError());
?>
<section  id="tab-paging" class="saleoff padding-top-30">
    <div class="container">
        <div class="title-section-module text-center margin-bottom-20">
            <h4><?=$row_setting['slogan']?></h4>
            <h3><a href="san-pham-noi-bat" title="<?=_sanpham?> <?=_noi_bat?>"><?=_sanpham?> <?=_noi_bat?></a></h3>
            <p>Cửa Hàng Thực Phẩm Hưng Tái Chuyên Cung Cấp Sỉ & Lẻ các loại đặc sản Hà Nội</p>
        </div>
        <div class="list-index d-flex flex-wrap justify-content-center margin-bottom-20">
            <?php foreach ($product_lists as $k => $v) { ?>
            <div class="img-li" data-id="<?=$v['id']?>">
                <span class="img">
                    <img class="img-block" src="<?=_upload_product_l.$v['icon']?>" alt="<?=$v['name']?>">
                </span>
                <span class="name"><?=$v['name']?></span>
            </div>
            <?php } ?>
        </div>
        <div class="row1 margin-top-10 d-flex flex-wrap justify-content-start product-view" id="view-load-product"></div>
        
    </div>
</section>

<?php if($row_camnhan){ ?>
<div class="adv-product margin-top-30 margin-bottom-20">
    <div class="adv-content text-center">
        <h5>
            <?=$row_camnhan['name']?>
        </h5>
        <?=htmlspecialchars_decode($row_camnhan['descs'])?>
        <p>
            <a href="" title="">
                Liên hệ ngay: <span><?=$row_setting['hotline']?></span>
            </a>
        </p>
    </div>
</div>
<style type="text/css" media="screen">
    .adv-product{
        background: url('<?=_upload_post_l.$row_camnhan['photo']?>') no-repeat top center;
        -webkit-background-size: cover;
        background-size: cover;
    }
</style>
<?php } ?>