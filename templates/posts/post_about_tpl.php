<div class="wrap-bg-in" id="page-body">
    <div class="page-scrol-social d-flex flex-wrap justify-content-start">
        <div class="detail-box page">
            <ul class="tabs-page tabs-about">
                <?php foreach($items as $k=>$v){ ?>
                <li data-ref="#tabs<?=$v['id']?>"><?=$v['name']?></li>
                <?php } ?>
            </ul>
            <?php foreach($items as $k=>$v){ ?>
            <div class="content-tab margin-top-20 content-page" id="tabs<?=$v['id']?>">
                <?=htmlspecialchars_decode($func->checkSSLContent($v['content']))?>
            </div>
            <?php } ?>
        </div>
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
    </div>
</div>