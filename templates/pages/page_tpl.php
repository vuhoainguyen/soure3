<div class="wrap-bg-in" id="page-body">
    <div class="container">
         <div class="row d-flex justify-content-between flex-wrap">
            <div class="item left-page col-3">
                <?php require_once _layouts.'left.php'; ?>
            </div>
            <div class="item right-page col-9">
                <div class="page-scrol-social d-flex flex-wrap justify-content-start">
                    <div class="detail-box page">
                        <h1 class="title-page"><?=$title?></h1>
                        <?=htmlspecialchars_decode($func->checkSSLContent($row_detail['content']))?>
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
        </div>
    </div>
</div>