<div class="wrap-bg-in margin-bottom-30">
    <div class="container">
         <div class="row d-flex justify-content-between flex-wrap">
            <div class="item col-3">
                <?php require_once _layouts.'left.php'; ?>
            </div>
            <div class="item col-9">
                <div class="head-title">
                    <h1><?=$title?></h1>
                </div>
                <div class="row margin-top-10 d-flex flex-wrap justify-content-start">
                    <?php foreach($items as $k=>$v){ ?>
                   <div class="item margin-bottom-20 col--2">
                        <div class="img-service1">
                            <div class="content-service1">
                                <a href="<?=$v['link']?>"><img class="img-block-auto" src="resize/430x250/2/<?=_upload_photo_l.$v['photo']?>?v=<?=$config['version']?>" alt="<?=$v['name']?>"></a>
                                <h3>
                                    <a href="<?=$v['link']?>" title="<?=$v['name']?>"><?=$v['name']?></a>
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
        
    </div>
</div>