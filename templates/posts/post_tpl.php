<div class="wrap-bg-in margin-bottom-30">
    <div class="container">
         <div class="row d-flex justify-content-between flex-wrap">
            <div class="item left-page col-3">
                <?php require_once _layouts.'left.php'; ?>
            </div>
            <div class="item right-page col-9">
                <div class="head-title">
                    <h1><?=$title?></h1>
                </div>
                <div class="row margin-top-10 d-flex flex-wrap justify-content-start posts-body" id="posts-body">
                    <?php foreach($items as $k=>$v){ ?>
                   <div class="item col--1 margin-bottom-20">
                       <div class="post-inner row d-flex flex-wrap justify-content-start">
                            <div class="post-img item col-4">
                                <a href="<?=$v['alias']?>" title="<?=$v['name']?>">
                                    <img src="images/rolling.svg" data-lazyload="resize/380x270/1/<?=_upload_post_l.$v['photo']?>" class="img-block-auto" alt="<?=$v['name']?>">
                                </a>
                            </div>
                            <div class="post-content item col-8">
                                <h3>
                                    <a title="<?=$v['name']?>" href="<?=$v['alias']?>"><?=$v['name']?></a>
                                </h3>
                                <p class="meta-article">
                                    <span><i class="fa fa-calendar"></i> <?=$v['createdAt']?></span>
                                </p>
                                <p class="meta-content">
                                    <?=$func->subSpaceStr($v['descs'],30)?>
                                </p>
                                <p class="meta-view">
                                    <a class="view-more" href="<?=$v['alias']?>"><?=_doc_tiep?> <i class="fa fa-angle-right"></i></a>
                                </p>
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