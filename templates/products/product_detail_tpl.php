<div id="detail-product" class="wrap-bg-in">
    <div class="container">
        <form method="post" data-role="add-to-cart" enctype="multipart/form-data" onsubmit="return false" name="product-detail-<?=$row_detail['id']?>" id="product-detail-<?=$row_detail['id']?>">
            <input type="hidden" name="act" value="addcart">
            <input type="hidden" name="id" value="<?=$row_detail['id']?>">
            <div id="content" class="row23 d-flex flex-wrap justify-content-start">
                <div class="item23 left" id="photo-view-detail">
                    <div class="img-top">
                        <a href="<?=_upload_product_l.$row_detail['photo']?>" class="MagicZoom" id="Zoom-1" data-options="variableZoom: true;expand: off; hint: always; " >
                            <img src="<?=_upload_product_l.$row_detail['photo']?>" alt="<?=$row_detail['name']?>"/>
                        </a>
                    </div>
                    <?php if(count($photo)>0){ ?>
                    <div class="img-bottom">
                        <div class="product-detail-slider owl-carousel owl-theme not-aweowl">
                            <div class="items"><div class="img"><a data-zoom-id="Zoom-1" href="<?=_upload_product_l.$row_detail['photo']?>" data-image="<?=_upload_product_l.$row_detail['photo']?>"><img src="<?=_upload_product_l.$row_detail['thumb']?>" alt="<?=$row_detail['name']?>"></a></div></div>
                            <?php foreach($photo as $k=>$v){  ?>
                            <div class="items"><div class="img"><a data-zoom-id="Zoom-1" href="<?=_upload_product_l.$v['photo']?>" data-image="<?=_upload_product_l.$v['photo']?>"><img src="<?=_upload_product_l.$v['thumb']?>" alt="<?=$v['alt']?>"></a></div></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php 
                    $ex_status = explode(',',$row_detail['status']);
                ?>
                <div class="item23 right">
                    <div class="header"><h1><?=$row_detail['name']?></h1></div>
                    <div class="quickview-info">
                        <div class="status-page">
                            <div class="status">SKU: <span class="status-class"><?=$row_detail['code']?></span></div>
                            <?php if($row_detail['id_list']!=0){ ?>
                            <div class="status"><?=_danh_muc?>: <span class="status-class"><?=$list_detail['name']?>...</span></div>
                            <?php } ?>
                            <?php /*<div class="status"><?=_tinh_trang?>: <span class="status-class"><?=($row_detail['material']=='') ? _het_hang:_con_hang?></span></div>*/ ?>
                        </div>
                        <?php if($config['other']['rating']){ ?>
                        <div class="reviews"><?=$func->getRating(5)?></div>
                        <?php } ?>
                        
                        
                    </div>
                    <div class="product-description">
                        <div class="rte"><?=nl2br($row_detail['descs'])?></div>
                    </div>
                    <div class="quickview-info">
                        <div class="prices">
                            Giá bán: 
                            <?php if($row_detail['price_old']!=0){ ?>
                            <span class="old-price"><?=$func->moneyFormat($row_detail['price_old'],'<u>đ</u>')?></span>
                            <?php } ?>
                            <span class="price" ><span id="load-Price" class="money-format"><?=($row_detail['price']!=0) ? $func->moneyFormat($row_detail['price'],'<u>đ</u>').'</span></span>':'Liên hệ'?></span></span>
                            <?php if(in_array('hethang', $ex_status)){ ?>
                            <label class="status checkbox red"> Hết hàng
                              <input type="checkbox" checked="checked">
                              <span class="checkmark"></span>
                            </label>
                            <?php }else{ ?>
                            <label class="status checkbox"> Còn hàng
                              <input type="checkbox" checked="checked">
                              <span class="checkmark"></span>
                            </label>
                            <?php } ?>
                        </div>
                    </div>
                    <?php /*if($row_detail['price_old']!=0){ ?>
                    <div class="prices">
                        <span class="save-price"><?=_tiet_kiem_duoc?>:
                            <span class="product-price-save"><span id="load-Price-Sale" class="money-format"><?=$func->moneyFormat($row_detail['price_old']-$row_detail['price'],'')?></span>₫</span>
                        </span>
                    </div>
                    <?php } */?>
                    <?php if($config['cart']['advance']==true){ ?>
                    <?php if(count($product_color)>0){ ?>
                    <div class="element"><div class="head"><?=_mau_sac?>: </div>
                        <div class="cont">
                            <?php foreach ($product_color as $k => $v){ ?>
                            <div class="el color-img" data-id="<?=$v['id']?>" data-priceold="<?=$row_detail['price_old']?>" data-price="<?=($v['price']!=0) ? $v['price']:$row_detail['price']?>">
                                <input id="swatch-0-<?=$v['id']?>" type="radio" name="option1" <?=($k==0) ? 'checked':''?> value="<?=$v['id']?>">
                                <label for="swatch-0-<?=$v['id']?>"><?=$v['name']?></label>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(count($product_size)>0){ ?>
                    <div class="element">
                        <div class="head"><?=_kich_thuoc?>: </div>
                        <div class="cont">
                            <?php foreach ($product_size as $k => $v){ ?>
                            <div class="el">
                                <input id="swatch-0-<?=$v['id']?>" type="radio" name="option2" <?=($k==0) ? 'checked':''?> value="<?=$v['id']?>">
                                <label for="swatch-0-<?=$v['id']?>"><?=$v['name']?></label>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php } ?>
                    <?php if($config['cart']['check']==true){ ?>
                    <div class="qty-ant btn-number">
                        <div class="custom custom-btn-numbers form-control">
                            <button onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN(qty) &amp; qty > 1 ){ result.value--; }else { return false; }" class="btn-minus btn-cts numb-detail" type="button">–</button>
                            <input type="text" class="qty input-text" id="qty" name="quantity" size="4" value="1" maxlength="3">
                            <button onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN(qty)){ result.value++; }else { return false; }" class="btn-plus btn-cts numb-detail" type="button">+</button>
                        </div>
                        <div class="btn-mua">
                            <button type="submit" data-role="addtocart" data-el="#product-detail-<?=$row_detail['id']?>" class="buy add-to-cart"><span class="txt-main"><?=_them_vao_gio_hang?><b class="product-price money-format d-none" id="product-price"><?=$func->moneyFormat($row_detail['price'],'')?></b><b class="d-none">₫</b></span><span class="text-add d-none"><?=_dat_hang_giao_tan_noi?></span></button>

                            <button type="button" data-role="addtocartPayment" data-el="#product-detail-<?=$row_detail['id']?>" class="buypayment add-to-cart-payment"><span class="txt-main"><?=_mua_ngay?></span><span class="text-add d-none"><?=_dat_hang_giao_tan_noi?></span></button>
                        </div>
                    </div>
                    
                    <?php } ?>
                    <div class="hotline-product margin-top-15">
                        <i class="fa fa-phone"></i> <?=_goi?>: <a href="tel:<?=$row_setting['hotline']?>" title="<?=$row_setting['hotline']?>"><?=$row_setting['hotline']?></a> <span><?=_de_duoc_tu_van?>.</span>
                    </div>
                    <?php /*<div class="social-link margin-top-10">
                        <a href="<?=$row_setting['messenger']?>">
                            <img class="img-block" src="images/link-mess.jpg" alt="Message">
                        </a>
                         <a href="https://zalo.me/<?=preg_replace('/[^0-9]/','',$row_setting['zalo'])?>">
                            <img class="img-block" src="images/link-zalo.jpg" alt="Zalo">
                        </a>
                    </div>
                    <div class="form-phone margin-top-20">
                        <div class="row d-flex flex-wrap justify-content-start">
                            <div class="col--2 item">
                                <h5>Để lại số điện thoại</h5>
                                <div class="form-box" id="form-phone">
                                    <input type="text" name="phone_res" id="phone-res">
                                    <button type="button" id="btn-phone">Gửi</button>
                                </div>
                            </div>
                            <div class="col--2 item">
                                <?=htmlspecialchars_decode($func->getInfoPgae('desc-product',$lang))?>
                            </div>
                        </div>
                    </div>*/ ?>
                    
                    <div class="social-product">
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
            <div class="section margin-top-20">
                <div class="product-tab e-tabs">
                    <ul class="tabs tabs-title"> 
                        <li class="tab-link current" data-tab="chitiet"><?=_chi_tiet?></li>
                        <?php if(count($posts)>0){ foreach ($posts as $k => $v) { ?>
                        <li class="tab-link" data-tab="tab<?=$v['id']?>"><?=$v['name']?></li>
                        <?php } } ?>
                        <li class="tab-link" data-tab="comnent"><?=_binh_luan?></li>
                    </ul>
                    <div id="chitiet" class="tab-content active current">
                        <div class="detail-set">
                            <?php 
                                if(!empty($array_slider)){
                                    $noidung = str_replace(array_keys($array_slider), array_values($array_slider), $func->checkSSLContent($row_detail['content']));
                                    echo htmlspecialchars_decode($func->checkSSLContent($noidung));
                                }else{
                                    echo htmlspecialchars_decode($func->checkSSLContent($row_detail['content']));
                                }
                            ?>
                        </div>
                    </div>
                    <?php if(count($posts)>0){ foreach ($posts as $k => $v) { ?>
                    <div id="tab<?=$v['id']?>" class="tab-content">
                        <div class="detail-set"><?=htmlspecialchars_decode($func->checkSSLContent($v['content']))?></div>
                    </div>
                    <?php } } ?>
                    <div id="comnent" class="tab-content">
                        <div class="fb-comments" data-href="<?=$func->getCurrentPageURL()?>" data-width="100%" data-numposts="5"></div>
                    </div>
                </div>
                
                <?php /*<?php 
                    $result_product = $d->rawQuery("select thumb,name_$lang as name,photo,link from #_multi_photos where type=? and find_in_set ('hienthi',status)",array('img-product'));
                ?>
                <div class="row margin-bottom-20 d-flex justify-content-start flex-wrap policy-product">
                    <?php foreach($result_product as $k=>$v){ ?>
                    <div class="col--3 item">
                        <a href="<?=$v['link']?>" title="<?=$v['name']?>">
                            <img class="img-block" src="<?=_upload_photo_l.$v['thumb']?>" alt="<?=$v['name']?>">
                        </a>
                    </div>
                    <?php } ?>
                </div>
                <div class="name-title-page"><h3>Thông tin chi tiết về <?=$title?></h3></div>
                <div class="detail-set">
                    <?php 
                        if(!empty($array_slider)){
                            $noidung = str_replace(array_keys($array_slider), array_values($array_slider), $func->checkSSLContent($row_detail['content']));
                            echo htmlspecialchars_decode($func->checkSSLContent($noidung));
                        }else{
                            echo htmlspecialchars_decode($func->checkSSLContent($row_detail['content']));
                        }
                    ?>
                </div>
                
                <?php if(count($posts)>0){ foreach ($posts as $k => $v) { ?>
                <div class="detail-set"><?=htmlspecialchars_decode($func->checkSSLContent($v['content']))?></div>
                <?php } } ?>
                <div class="name-title-page">Bình luận</div>
                <div class="fb-comments" data-href="<?=$func->getCurrentPageURL()?>" data-width="100%" data-numposts="5"></div>*/ ?>
            </div>
            <?php if(count($product_tags)>0){ ?>
            <div class="section margin-top-20">
                <ul class="tags">
                    <?php foreach ($product_tags as $k => $v) { ?>
                    <li><a href="tags-san-pham/<?=$v['alias']?>" class="tag"><?=$v['name']?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <?php } ?>
        </form>
        <div class="section margin-top-20">
            <div class="head-title">
                <h2 class="d-inline-block"><?=_sanpham?> <?=_lien_quan?></h2>
            </div>
            <div class="product-view">
                <div class="row margin-top-10 d-flex flex-wrap justify-content-start" id="search-body" data-href="<?=$_GET['com']?>">
                    <?php if(!$func->isAjax()){ ?>
                    <?php echo $func->getTemplateProduct($product_other,'col--4 item','none-border','margin-bottom-10','resize/260x220/1/',0, null, 0); ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
