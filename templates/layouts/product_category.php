<?php 
    $product_lists = $d->rawQuery("SELECT id,name_$lang as name,desc_$lang as descs, alias_$lang as alias, photo, thumb, adv, adv_thumb,adv_link from #_lists where type=? and find_in_set ('hienthi',status) and find_in_set ('noibat',status) order by numb asc, id desc",array("san-pham"));

    $row_adv_noibat = $d->rawQueryOne("select photo,name_$lang as name,link from #_photos where type=? and find_in_set ('hienthi',status)",array('adv-noibat'));
?>
<?php foreach ($product_lists as $k => $v) {  $product_its = $d->rawQuery("SELECT id,name_$lang as name,status, alias_$lang as alias,material_$lang as material, photo, thumb,price,price_old from #_products where type=? and find_in_set ('noibat',status) and find_in_set ('hienthi',status) and id_list=? order by numb asc, id desc",array("san-pham",$v['id']));?>
<section id="product-cate<?=$v['id']?>" class="margin-bottom-30">
    <div class="container">
        <div class="title-section-module margin-top-30 text-center margin-bottom-20">
            <h3><a href="<?=$v['alias']?>" title="<?=$v['name']?>"><?=$v['name']?></a></h3>
            <input type="hidden" name="id_list_page" value="<?=$v['id']?>" class="id_list_page">
        </div>
        <div class="row margin-top-10 d-flex flex-wrap product-view justify-content-start" id="view-load-product<?=$v['id']?>" data-id="<?=$v['id']?>">
            
        </div>
        
        <?php /*
            <?php if(!$func->isAjax()){ ?>
            <?php echo $func->getTemplateProduct($product_its,'col--4 item','none-border','margin-bottom-20','resize/274x330/1/',0,array('moi'),1); ?>
            <?php } ?>
            <div class="readmore-product">
                <a href="<?=$v['alias']?>">
                    Xem tất cả
                </a>
            </div>
            <div class="readmore-product">
                <a href="<?=$v['alias']?>">
                    Xem tất cả sản phẩm <img src="images/arrow-view.png" alt="Xem tất cả sản phẩm">
                </a>
            </div>
            if($v['adv_thumb']!=''){ ?>
            <div class="adv-product margin-top-30 margin-bottom-20">
                <a href="<?=$v['adv_link']?>">
                    <img class="img-block" src="<?=_upload_product_l.$v['adv_thumb']?>" alt="ADV - <?=$v['name']?>">
                </a>
            </div>
            <?php }
        */ ?>
    </div>
</section>
<?php } ?>


<section id="adv" class="margin-top-20">
    <a href="<?=$row_adv_noibat['link']?>" title="<?=$row_adv_noibat['name']?>">
        <img class="img-block-auto" src="<?=_upload_photo_l.$row_adv_noibat['photo']?>" alt="<?=$row_adv_noibat['name']?>">
    </a>
</section>