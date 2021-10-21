<?php
    $product_moi = $d->rawQuery("SELECT id,name_$lang as name, alias_$lang as alias, photo, thumb,price,price_old from #_products where type=? and find_in_set ('hienthi',status) and find_in_set ('moi',status) order by numb asc limit 0,15",array("san-pham"));
?>
<section id="productNew" class="section_sanphamnoibat margin-top-30 margin-bottom-30">
    <div class="container">
        <div class="wrap-bg-in product-view">
            <div class="title-section-module text-center margin-bottom-20">
                <h2><a href="san-pham" title="<?=_sanpham?>"><?=_sanpham?></a></h2>
                <p>Tổng hợp những đồ chơi xe máy cao cấp, uy tín và chất lượng nhất thị trường. Phân phối đồ chơi và phụ kiện xe máy đa dạng phong phú chủng loại.</p>
            </div>
            <div class="row d-flex flex-wrap justify-content-between">
                <?php echo $func->getTemplateProduct($product_moi,'col--4 item','none-border','margin-bottom-20','resize/480x480/1/'); ?>
            </div>
            <div class="text-center">
                <a class="button_more" href="san-pham" title="Xem tất cả Sản Phẩm">Xem tất cả Sản Phẩm</a>
            </div>
        </div>
    </div>
</section>