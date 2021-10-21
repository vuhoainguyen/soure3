<?php 
    $product_noibat = $d->rawQuery("SELECT id,name_$lang as name, status, alias_$lang as alias,material_$lang as material, desc_$lang as descs, photo, thumb,price,price_old from #_products where type=? and find_in_set ('hienthi',status) and find_in_set ('moi',status) order by numb asc, id desc",array("san-pham"));

    $result_adv_slider = $d->rawQuery("select thumb,name_$lang as name,link from #_multi_photos where type=? and find_in_set ('hienthi',status) limit 0,2",array('adv-slider'));
?>
<section id="sale-off" class="saleoff margin-top-30">
    <div class="container">
        <div class="wrap-bg-in">
            <div class="title-section-module text-center margin-bottom-20">
                <h3><a href="san-pham-moi-nhat" title="<?=_sanpham?> <?=_moi_nhat?>"><?=_sanpham?> <?=_moi_nhat?></a></h3>
                <p><?=$func->getInfoPgae('san-pham',$lang)?></p>
            </div>
            <div class="owl-carousel in-product in-rows" data-dot="0" data-nav='1' data-loop='1' data-play='1' data-lg-items='4' data-md-items='4' data-sm-items='3' data-xs-items="2" data-margin='30'>
                <?php echo $func->getTemplateProduct($product_noibat,'','none-border','','resize/390x390/1/',0,null,1); ?>
            </div>
        </div>
    </div>
</section>


<section id="adv-content" class="margin-top-30 margin-bottom-20">
    <div class="container">
        <div class="adv-product row3 d-flex flex-wrap justify-content-between">
           <?php foreach ($result_adv_slider as $k => $v){ ?>
            <div class="adv-content item3 col--2">
                <a href="<?=$v['link']?>">
                    <img class="img-block" src="<?=_upload_photo_l.$v['thumb']?>" alt="<?=$v['name']?>">
                </a>    
            </div>
            <?php } ?>
        </div>
    </div>
</section>
