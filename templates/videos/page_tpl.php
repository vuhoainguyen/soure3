<div class="wrap-bg-in">
    <div class="row d-flex flex-wrap justify-content-between">
        <div class="head-title item">
            <h1><?=$title?></h1>
        </div>
    </div>
    <div class="row margin-top-10 d-flex flex-wrap justify-content-start video-body" id="video-body">
        <?php foreach($items as $k=>$v){ ?>
       <div class="item col--4 margin-bottom-20">
           <div class="post-inner">
                <div class="post-img">
                    <a data-fancybox="" href="https://www.youtube.com/watch?v=<?=$func->youtobe($v['youtube'])?>" title="<?=$v['name']?>">
                        <img src="images/rolling.svg" data-lazyload="https://img.youtube.com/vi/<?=$func->youtobe($v['youtube'])?>/hq720.jpg" class="img-block-auto" alt="<?=$v['name']?>">
                    </a>
                </div>
            </div>
       </div>
       <?php } ?>
    </div>
    <div class="row margin-top-10 d-flex flex-wrap justify-content-start">
        <div class="item">
            <nav aria-label="Page navigation example" id="video-page">
                <?=$paging?>
            </nav>
        </div>
    </div>
</div>