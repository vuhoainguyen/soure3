<div class="wrap-bg-in" id="page-body">
    <div class="container">
        <div class="page-scrol-social d-flex flex-wrap justify-content-start">
            <div class="social">
                <ul>
                    <li>
                        <button class="sharer btn btn-primary btn-lg" data-sharer="twitter" data-title="<?=$title?>" data-url="<?=$func->getCurrentPageURL()?>"><i class="fa fa-twitter"></i></button>
                    </li>
                    <li>
                        <button class="sharer btn btn-primary btn-lg" data-sharer="facebook" data-url="<?=$func->getCurrentPageURL()?>"><i class="fa fa-facebook"></i></button>
                    </li>
                    <li>
                        <button class="sharer btn btn-primary btn-lg" data-sharer="linkedin" data-url="<?=$func->getCurrentPageURL()?>"><i class="fa fa-linkedin"></i></button>
                    </li>
                    <li>
                       <button class="sharer btn btn-primary btn-lg" data-sharer="email" data-title="<?=$title?>" data-url="<?=$func->getCurrentPageURL()?>" data-subject="<?=$title?>" data-to="<?=$row_setting['email']?>"><i class="fa fa-envelope"></i></button>
                    </li>
                    <li>
                        <button class="sharer btn btn-primary btn-lg" data-sharer="whatsapp" data-title="<?=$title?>" data-url="<?=$func->getCurrentPageURL()?>"><i class="fa fa-whatsapp"></i></button>
                    </li>
                    <li>
                        <button class="sharer btn btn-primary btn-lg" data-sharer="pinterest" data-url="<?=$func->getCurrentPageURL()?>"><i class="fa fa-pinterest"></i></button>
                    </li>
                </ul>
            </div>
            <div class="detail-box">
                <h1 class="title-page"><?=$title?></h1>
                <div class="author-desc">
                    
                </div>
                <?php if($row_detail['descs']!=''){ ?>
                <div class="meta-desc">
                    <?=htmlspecialchars_decode($row_detail['descs'])?>
                </div>
                <?php } ?>
                <?php if($row_detail['content']!=''){ ?>
                <div class="meta-toc">
                    <div class="box-readmore">
                        <ul class="toc-list" data-toc="article" data-toc-headings="h1, h2, h3"></ul>
                    </div>
                </div>
                <?php } ?>
                <div class="content-detail-desc margin-top-20" id="blog-detail">
                    <?php 
                        if(!empty($array_slider)){
                            $noidung = str_replace(array_keys($array_slider), array_values($array_slider), $func->checkSSLContent($row_detail['content']));
                            echo htmlspecialchars_decode($noidung);
                        }else{
                            echo htmlspecialchars_decode($func->checkSSLContent($row_detail['content']));
                        }
                    ?>
                </div>
                <div class="content-other margin-top-20 margin-bottom-20">
                    <h5>Bài viết liên quan</h5>
                    <?php foreach($posts_other as $k=>$v){ ?>
                    <h3>
                        <a href="<?=$v['alias']?>" title="<?=$v['name']?>"><i class="fa fa-angle-right"></i> <?=$v['name']?></a>
                    </h3>
                    <?php } ?>
                </div>
                <?php if(count($post_tags)>0){ ?>
                <div class="section margin-top-20">
                    <ul class="tags">
                        <?php foreach ($post_tags as $k => $v) { ?>
                        <li><a href="'tags-bai-viet/<?=$v['alias']?>" class="tag"><?=$v['name']?></a></li>
                        <?php } ?>
                    </ul>
                </div>
                <?php } ?>
            </div>

            <div class="right-post-other">
                <?php /*<div class="title-right">
                    <h5><?=_tin_lien_quan?></h5>
                </div>
                <div class="desc-right margin-bottom-20">
                    <ul class="other-post">
                        <?php foreach($posts_other as $k=>$v){ ?>
                        <li>
                            <a href="<?=$v['alias']?>" title="<?=$v['name']?>"><?=$v['name']?></a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>*/ ?>
                <div class="title-right">
                    <h5>Tin mới nhất</h5>
                </div>
                <div class="desc-right margin-bottom-20">
                    <ul class="other-post">
                        <?php foreach($posts_news as $k=>$v){ ?>
                        <li class="d-flex flex-wrap justify-content-start">
                            <div class="img">
                                <a href="<?=$v['alias']?>" title="<?=$v['name']?>">
                                    <img class="img-block" src="resize/100x66/1/<?=_upload_post_l.$v['thumb']?>" alt="<?=$v['name']?>">
                                </a>
                            </div>
                            <h4>
                                <a href="<?=$v['alias']?>" title="<?=$v['name']?>"><?=$v['name']?></a>
                            </h4>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="title-right">
                    <h5>Tin được xem nhiều nhất</h5>
                </div>
                <div class="desc-right margin-bottom-20">
                    <ul class="other-post">
                        <?php foreach($posts_views as $k=>$v){ ?>
                        <li class="d-flex flex-wrap justify-content-start">
                            <div class="img">
                                <a href="<?=$v['alias']?>" title="<?=$v['name']?>">
                                    <img class="img-block" src="resize/100x66/1/<?=_upload_post_l.$v['thumb']?>" alt="<?=$v['name']?>">
                                </a>
                            </div>
                            <h4>
                                <a href="<?=$v['alias']?>" title="<?=$v['name']?>"><?=$v['name']?></a>
                            </h4>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>