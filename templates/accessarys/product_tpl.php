<div class="wrap-bg-in margin-bottom-20">
    <div class="container">
        <div class="row d-flex flex-wrap justify-content-between">
            <div class="head-title item">
                <h1><?=$title?></h1>
            </div>
        </div>
        <div class="product-view">
            <div class="row margin-top-10 d-flex flex-wrap justify-content-start">
               <?php echo $func->getTemplateProduct($items,'col--4 item','','margin-bottom-30','resize/260x220/1/',0, array('moi'), 1); ?>
            </div>
            <div class="margin-top-10 d-flex flex-wrap justify-content-center">
                <nav aria-label="Page navigation example" id="search-page">
                    <?=$paging?>
                </nav>
            </div>
        </div>
    </div>
</div>