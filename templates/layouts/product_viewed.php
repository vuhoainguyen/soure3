<?php 
	if(count($_SESSION['viewed'])>0){
		$product_viewed = $func->getViewed($lang,'san-pham');
	}
?>
<?php if(count($_SESSION['viewed'])>0){ ?>
    <?php if(count($product_viewed)>=5){ ?>
    <section id="viewed" class="margin-top-30">
        <div class="container">
            <div class="wrap-bg-in">
                <div class="title-section-module text-center margin-bottom-20">
                    <h2><a href="san-pham-da-xem" title="<?=_sanpham?> <?=_da_xem?>"><?=_sanpham?> <?=_da_xem?></a></h2>
                </div>
                <?php if(count($product_viewed)>=5){ ?>
                <div class="owl-carousel in-product" data-dot="0" data-nav='0' data-loop='1' data-play='1' data-lg-items='5' data-md-items='5' data-sm-items='3' data-xs-items="2" data-margin='15'>
                    <?php echo $func->getTemplateProduct($product_viewed,''); ?>
                </div>
                <?php }else{ ?>
                <div class="product-view">
                    <div class="row margin-top-10 d-flex flex-wrap justify-content-start">
                        <?php echo $func->getTemplateProduct($product_viewed,'col--5 item'); ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <?php } ?>
<?php } ?>