<div class="wrap-bg-in margin-bottom-30">
    <div class="container">
        <div class="head-title">
            <h1><?=$title?></h1>
        </div>
        <div class="row margin-top-10 d-flex flex-wrap justify-content-start photo-body" id="photo-body">
            <?php foreach($items as $k=>$v){ ?>
           <div class="item col--3 album margin-bottom-20">
               <div class="post-inner d-flex flex-wrap justify-content-start">
                    <div class="post-img w-100">
                        <a href="<?=$v['alias']?>" title="<?=$v['name']?>">
                            <img src="images/rolling.svg" data-lazyload="resize/480x320/1/<?=_upload_photo_l.$v['photo']?>" class="img-block-auto" alt="<?=$v['name']?>">
                        </a>
                    </div>
                    <div class="post-content margin-top-10 w-100">
                        <h3 class="text-center">
                            <a title="<?=$v['name']?>" href="<?=$v['alias']?>"><?=$v['name']?></a>
                        </h3>
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