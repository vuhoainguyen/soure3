<?php $link_search = ($_GET['com']!='tags-san-pham') ? $_GET['com']:$_GET['com'].'/'.$_GET['idl']; ?>
<div class="wrap-bg-in margin-bottom-20">
    <div class="container">
        <div class="row d-flex flex-wrap justify-content-between">
            <div class="head-title item">
                <h1><?=$title?></h1>
            </div>
            <?php if($config['other']['sortby']==true){ ?>
            <div id="sort-by" class="item d-flex flex-wrap justify-content-end">
                <label class="left"><?=_sap_xep?>: </label>
                <ul class="ul_col">
                    <li>
                        <span class="show-sort-by"><?=_macdinh?> <i class="fa fa-angle-down"></i></span>
                        <ul class="content_ul">                    
                            <li><a style="cursor: pointer" class="change-sortby" data-href="<?=$link_search?>" data-sort="id-desc"><?=_macdinh?></a></li>
                            <li><a style="cursor: pointer" class="change-sortby" data-href="<?=$link_search?>" data-sort="name_<?=$lang?>-asc">A → Z</a></li>
                            <li><a style="cursor: pointer" class="change-sortby" data-href="<?=$link_search?>" data-sort="name_<?=$lang?>-desc">Z → A</a></li>
                            <li><a style="cursor: pointer" class="change-sortby" data-href="<?=$link_search?>" data-sort="price-asc"><?=_gia_tang_dan?></a></li>
                            <li><a style="cursor: pointer" class="change-sortby" data-href="<?=$link_search?>" data-sort="price-desc"><?=_gia_giam_dan?></a></li>
                            <li><a style="cursor: pointer" class="change-sortby" data-href="<?=$link_search?>" data-sort="createdAt-desc"><?=_hang_moi_nhat?></a></li>
                            <li><a style="cursor: pointer" class="change-sortby" data-href="<?=$link_search?>" data-sort="createdAt-asc"><?=_hang_cu_nhat?></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <?php } ?>
        </div>
        <div class="product-view">
            <div class="row margin-top-10 d-flex flex-wrap justify-content-start" id="search-body" data-href="<?=$_GET['com']?>">
                <?php if(!$func->isAjax()){ ?>
                    <?php echo $func->getTemplateProduct($items,'col--4 item','','margin-bottom-30','resize/280x225/1/',0, null, 0); ?>
                <?php } ?>
            </div>
            <div class="row margin-top-10 d-flex flex-wrap justify-content-center">
                <div class="item">
                    <nav aria-label="Page navigation example" id="search-page">
                    <?php if(!$func->isAjax()){ ?>
                       <?=$paging?>
                    <?php } ?>
                    </nav>
                </div>
            </div>
        </div>
        <?php if($_GET['com']!='tags-san-pham'){ ?>
        <input type="hidden" name="href" value="<?=base64_encode($config_base.$link_search)?>">
        <?php }else{ ?>
        <input type="hidden" name="href" value="<?=base64_encode($config_base.$link_search)?>">
        <?php } ?>
    </div>
</div>