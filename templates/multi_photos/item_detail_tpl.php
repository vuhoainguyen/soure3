<div class="wrap-bg-in margin-bottom-30">
    <div class="container">
        <div class="head-title">
            <h1><?=$title?></h1>
        </div>
        <div class="row margin-top-10 d-flex flex-wrap justify-content-start posts-body" id="posts-body">
            <?php foreach($items as $k=>$v){ ?>
           <div class="item col--3 album margin-bottom-30">
               <div class="post-inner row d-flex flex-wrap justify-content-start">
                    <div class="post-img item w-100">
                        <a data-fancybox="gallery" href="<?=_upload_photo_l.$v['photo']?>" title="<?=$v['alt']?>">
                            <img src="images/rolling.svg" data-lazyload="resize/600x420/1/<?=_upload_photo_l.$v['photo']?>" class="img-block-auto" alt="<?=$v['alt']?>">
                        </a>
                    </div>
                </div>
           </div>
           <?php } ?>
        </div>
        <div class="margin-top-10 d-flex flex-wrap justify-content-center">
            <nav aria-label="Page navigation example" id="posts-page">
                <?=$paging?>
            </nav>
        </div>
    </div>
</div>