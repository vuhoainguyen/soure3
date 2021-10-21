<?php 
    
    $row_advpayment = $d->rawQueryOne("select thumb,name_$lang as name, link from #_photos where type=? and find_in_set ('hienthi',status)",array('advpayment'));
    $result_payment = $d->rawQuery("select desc_$lang as descs,name_$lang as name,id from #_posts where type=? and find_in_set ('hienthi',status) order by numb asc, id desc",array('hinh-thuc-thanh-toan'));
?>
<div id="full-cart-order">
    <form action="carts/thanh-toan" method="post" id="login-form" autocomplete="off" enctype="multipart/form-data" name="login-form">
        <div class="row d-flex flex-wrap justify-content-between">
            <div class="col-8 item coll-page">
                <?php if(!empty($row_advpayment)){ ?>
                <div class="img-cart margin-top-15">
                    <a href="<?=$row_advpayment['link']?>" title="<?=$row_advpayment['name']?>">
                        <img class="img-block" src="<?=_upload_photo_l.$row_advpayment['thumb']?>" alt="<?=$row_advpayment['name']?>">
                    </a>
                </div>
                <?php } ?>
                <div class="title-cart">
                    <h4><?=$title?></h4>
                </div>
                <div class="desc-cart">
                    <div class="row  d-flex flex-wrap justify-content-between">
                        <div class="col--2 item">
                            <div class="layout-flex mb-15">
                                <h2 class="title-card">
                                    <i class="fa fa-credit-card" aria-hidden="true"></i>
                                    <label class="control-label"><?=_thong_tin_mua_hang?></label>
                                </h2>
                                <?php if(!$func->isLogin() && $config['login']['login']==true){ ?>
                                <a class="user" href="account/dang-nhap&return=<?=base64_encode('carts/thanh-toan')?>">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <?=_dangnhap?> 
                                </a>
                                <?php } ?>
                            </div>
                            <div class="content">
                                <div class="row-input">
                                    <div class="wrap-input">
                                        <input class="input" type="text" name="email" placeholder="Email" id="email" data-validation="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$" data-validation-error-msg= "<?=_email_sai_dinh_dang?>" value="<?=$_SESSION['signin']['email']?>">
                                        <label for="email" class="label">Email</label>
                                    </div>
                                </div>
                                <div class="row-input">
                                    <div class="wrap-input">
                                        <input class="input" type="text" name="fullname" placeholder="<?=_ho_ten?>" id="fullname" data-validation-error-msg= "<?=_khong_duoc_de_trong?>" data-validation="required" value="<?=$_SESSION['signin']['fullname']?>">
                                        <label for="fullname" class="label"><?=_ho_ten?></label>
                                    </div>
                                </div>
                                <div class="row-input">
                                    <div class="wrap-input">
                                        <input class="input" type="text" name="phone" placeholder="<?=_dien_thoai?>" id="phone" data-validation-error-msg="<?=_dien_thoai_sai_dinh_dang?>" data-validation-regexp="(0[3|5|7|8|9])+([0-9]{8})\b" data-validation="custom" value="<?=$_SESSION['signin']['phone']?>">
                                        <label for="phone" class="label"><?=_dien_thoai?></label>
                                    </div>
                                </div>
                                <div class="row-input">
                                    <div class="wrap-input">
                                        <input class="input" type="text" name="address" placeholder="<?=_dia_chi?>" id="address" data-validation-error-msg= "<?=_khong_duoc_de_trong?>" data-validation="required" value="<?=$_SESSION['signin']['address']?>">
                                        <label for="address" class="label"><?=_dia_chi?></label>
                                    </div>
                                </div>
                                <?php
                                    $result_city = $apiPlace->getPlace('place_citys',"id, name_$lang",'id asc');
                                    if($_SESSION['signin']['id_city']!=0){
                                        $result_dist = $apiPlace->getFieldWhere('place_dists',$_SESSION['signin']['id_city'],"id, name_$lang as name,code",'id_city','numb asc, id desc');
                                    }
                                ?>
                                <div class="row-input">
                                    <div class="wrap-input">
                                        <select class="input-select select" name="id_city" data-validation-error-msg= "<?=_khong_duoc_de_trong?>" data-validation="required" id="id_city" placeholder="<?=_tinh_thanh?>"  onchange="onChangeSelect('#id_dist',{id:this.value, fs:'id,name_<?=$lang?> as name, code',fw:'id_city',t:'place/dists',tt:'<?=_chon_quan_huyen?>'})">
                                            <option value=""><?=_chon_tinh_thanh?></option>
                                            <?php foreach($result_city as $k => $v){ ?>
                                            <option value="<?=$v['id']?>" <?=($v['id']==$_SESSION['signin']['id_city']) ? 'selected':''?>><?=$v['name_'.$lang]?></option>
                                            <?php } ?>
                                        </select>
                                        <label for="id_city" class="label label-select"><?=_tinh_thanh?></label>
                                    </div>
                                </div>
                                <div class="row-input">
                                    <div class="wrap-input">
                                        <select class="input-select select" data-validation-error-msg= "<?=_khong_duoc_de_trong?>" data-validation="required" name="id_dist" id="id_dist" placeholder="<?=_quan_huyen?>">
                                            <option value=""><?=_chon_quan_huyen?></option>
                                            <?php if(count($result_dist)>0) { foreach($result_dist as $k => $v){ ?>
                                            <option value="<?=$v['id']?>" <?=($v['id']==$_SESSION['signin']['id_dist']) ? 'selected':''?>><?=$v['code']?> <?=$v['name']?></option>
                                            <?php } } ?>
                                        </select>
                                        <label for="id_dist" class="label label-select"><?=_quan_huyen?></label>
                                    </div>
                                </div>
                                <div class="row-input">
                                    <div class="wrap-input">
                                       <label class="checkbox" for="other_address">
                                            <input type="checkbox" name="other_address" id="other_address" value="1">
                                            <span><?=_giao_hang_den_dia_chi_khac?></span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div id="order_address_form" class="d-none">
                                    <div class="row-input">
                                        <div class="wrap-input">
                                            <input class="input" type="text" name="email_other" placeholder="Email" id="email_other" data-validation="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$" data-validation-error-msg= "<?=_email_sai_dinh_dang?>" value="">
                                            <label for="email" class="label">Email</label>
                                        </div>
                                    </div>
                                    <div class="row-input">
                                        <div class="wrap-input">
                                            <input class="input" type="text" name="fullname_other" placeholder="<?=_ho_ten?>" id="fullname_other" data-validation-error-msg= "<?=_khong_duoc_de_trong?>" data-validation="required" value="">
                                            <label for="fullname_other" class="label"><?=_ho_ten?></label>
                                        </div>
                                    </div>
                                    <div class="row-input">
                                        <div class="wrap-input">
                                            <input class="input" type="text" name="phone_other" placeholder="<?=_dien_thoai?>" id="phone_other" data-validation-error-msg="<?=_dien_thoai_sai_dinh_dang?>" data-validation-regexp="(0[3|5|7|8|9])+([0-9]{8})\b" data-validation="custom" value="">
                                            <label for="phone_other" class="label"><?=_dien_thoai?></label>
                                        </div>
                                    </div>
                                    <div class="row-input">
                                        <div class="wrap-input">
                                            <input class="input" type="text" name="address_other" placeholder="<?=_dia_chi?>" id="address_other" data-validation-error-msg= "<?=_khong_duoc_de_trong?>" data-validation="required" value="">
                                            <label for="address_other" class="label"><?=_dia_chi?></label>
                                        </div>
                                    </div>
                                    <?php
                                        $result_city = $apiPlace->getPlace('place_citys',"id, name_$lang",'id asc');
                                    ?>
                                    <div class="row-input">
                                        <div class="wrap-input">
                                            <select class="input-select select" name="id_city_other" data-validation-error-msg= "<?=_khong_duoc_de_trong?>" data-validation="required" id="id_city_other" placeholder="<?=_tinh_thanh?>"  onchange="onChangeSelect('#id_dist_other',{id:this.value, fs:'id,name_<?=$lang?> as name, code',fw:'id_city',t:'place/dists',tt:'<?=_chon_quan_huyen?>'})">
                                                <option value=""><?=_chon_tinh_thanh?></option>
                                                <?php foreach($result_city as $k => $v){ ?>
                                                <option value="<?=$v['id']?>"><?=$v['name_'.$lang]?></option>
                                                <?php } ?>
                                            </select>
                                            <label for="id_city_other" class="label label-select"><?=_tinh_thanh?></label>
                                        </div>
                                    </div>
                                    <div class="row-input">
                                        <div class="wrap-input">
                                            <select class="input-select select" data-validation-error-msg= "<?=_khong_duoc_de_trong?>" data-validation="required" name="id_dist_other" id="id_dist_other" placeholder="<?=_quan_huyen?>">
                                                <option value=""><?=_chon_quan_huyen?></option>
                                            </select>
                                            <label for="id_dist_other" class="label label-select"><?=_quan_huyen?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row-input">
                                    <div class="wrap-input">
                                        <textarea class="input h" name="notes" id="notes" rows="10" placeholder="<?=_ghi_chu?>"></textarea>
                                        <label for="notes" class="label"><?=_ghi_chu?></label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col--2 item">
                            <?php /*
                            <div class="layout-flex">
                                <h2 class="title-card">
                                    <i class="fa fa-dollar" aria-hidden="true"></i>
                                    <label class="control-label"><?=_van_chuyen?></label>
                                </h2>
                            </div>
                            <div class="content margin-top-15 margin-bottom-20">
                                <div class="transport">
                                    <ul>
                                        <li>
                                            <label class="radio">
                                                <input type="radio" name="transport" value="1" checked>
                                                <span>Giao hàng tận nơi</span>
                                            </label>
                                            <span class="price-transport" id="transport1">40.000đ</span>
                                        </li>
                                        <li>
                                            <label class="radio">
                                                <input type="radio" name="transport" value="2">
                                                <span>Giao hàng tiết kiệm</span>
                                            </label>
                                            <span class="price-transport" id="transport2">30.000đ</span>
                                        </li>
                                        <li>
                                            <label class="radio">
                                                <input type="radio" name="transport" value="3">
                                                <span>Giao hàng nhanh</span>
                                            </label>
                                            <span class="price-transport" id="transport3">35.000đ</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            */ ?>

                            <div class="layout-flex">
                                <h2 class="title-card">
                                    <i class="fa fa-dollar" aria-hidden="true"></i>
                                    <label class="control-label" style="text-transform: capitalize"><?=_thanh_toan?></label>
                                </h2>
                            </div>
                            <div class="content margin-top-15">
                                <div class="payment">
                                    <ul>
                                        <?php for($i=0;$i<count($result_payment);$i++){ ?>
                                        <li>
                                            <label class="radio">
                                                <input type="radio" name="payment" value="<?=$result_payment[$i]['id']?>" <?=($i==0) ? 'checked':''?>>
                                                <span><?=$result_payment[$i]['name']?></span>
                                            </label>
                                            <?php if($result_payment[$i]['descs']!=''){ ?>
                                            <div class="payment-desc" id="payment<?=$result_payment[$i]['id']?>">
                                                <?=htmlspecialchars_decode($result_payment[$i]['descs'])?>
                                            </div>
                                            <?php } ?>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="sidebar-action-mobile">
                                <a class="previous-link" href="carts/gio-hang">
                                    <i class="fa fa-angle-left fa-lg" aria-hidden="true"></i>
                                    <span><?=_quay_ve_gio_hang?></span>
                                </a>
                                <button type="submit"><?=_dat_hang?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4 item coll-page">
                <?php if(!empty($row_advpayment)){ ?>
                <div class="img-cart-mobile margin-top-15">
                    <a href="<?=$row_advpayment['link']?>" title="<?=$row_advpayment['name']?>">
                        <img class="img-block" src="<?=_upload_photo_l.$row_advpayment['thumb']?>" alt="<?=$row_advpayment['name']?>">
                    </a>
                </div>
                <?php } ?>
                <div class="box-order">
                    <div class="sidebar-header">
                        <h2>
                            <label class="control-label"><?=_don_hang?> (<?=$apiCart->getTotalQuality()?>) <?=_sanpham?></label>
                            <span class="collapsed-order"><?=_xem_chi_tiet?> <i class="fa fa-angle-right fa-lg" aria-hidden="true"></i></span>
                        </h2>
                        <div class="line-full"></div>
                    </div>
                    <div class="sidebar-content collapse-in">
                        <?=$apiCart->getTemplateCheckout($lang,$config_base)?>
                    </div>
                    <?php if($config['cart']['coupon']==true){ ?>
                    <div class="sidebar-coupon">
                        <input type="text" name="coupon" id="coupon" class="<?=(!empty($_SESSION['coupon'])) ? 'success':''?>" <?=(!empty($_SESSION['coupon'])) ? 'readonly="readonly"':''?> value="<?=$_SESSION['coupon']['code']?>" placeholder="<?=_nhap_ma_giam_gia?>">
                        <button type="button" <?=(!empty($_SESSION['coupon'])) ? 'data-rel="1"':'data-rel="0"'?> id="coupon-btn"><?=(!empty($_SESSION['coupon'])) ? _bo_ap_dung:_ap_dung?></button>
                    </div>
                    <div class="error-coupon"></div>
                    <?php } ?>
                    <div class="sidebar-total">
                        <div class="subtotal"><div><?=_tam_tinh?></div><div><span><?=$func->moneyFormat($apiCart->getTotalOrder(),'')?></span><span>₫</span></div></div>
                        <?php if($config['cart']['coupon']==true){ ?><div class="subtotal"><div><?=_giam_gia?></div><div><span id="price-coupon"><?=(!$_SESSION['coupon']) ? 0:$func->moneyFormat($_SESSION['coupon']['percents-price'],'')?></span><span>₫</span></div></div><?php } ?>
                        
                        <?php /*<div class="subtotal"><div>Phí vận chuyển</div><div><span id="shipping">0</span><span>₫</span></div></div>*/ ?>

                        <div class="total"><div><?=_tong_tien?></div><div><span id="total-order"><?=$func->moneyFormat($apiCart->getTotalOrder()-$_SESSION['coupon']['percents-price'],'')?></span><span>₫</span></div></div>
                    </div>
                    <div class="sidebar-action">
                        <a class="previous-link" href="carts/gio-hang">
                            <i class="fa fa-angle-left fa-lg" aria-hidden="true"></i>
                            <span><?=_quay_ve_gio_hang?></span>
                        </a>
                        <input type="hidden" name="id_customer" value="<?=($_SESSION['signin']['id']) ? $_SESSION['signin']['id']:0?>">
                        <button type="submit"><?=_dat_hang?></button>
                    </div>
                    <div class="desc-policy">
                        <?=htmlspecialchars_decode($func->getInfoPgae('desc-order',$lang))?>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>