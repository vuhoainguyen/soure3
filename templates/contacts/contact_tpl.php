<div class="wrap-bg-in contact-body margin-bottom-20" id="contact-body">
    <div class="container">
        <div class="head-title">
            <h1><?=$title?></h1>
        </div>
        <div class="box-frame-map margin-top-20">
            <?=htmlspecialchars_decode($row_setting['map_frame'])?>
        </div>
        <div class="row margin-top-20 d-flex flex-wrap justify-content-start">
            <div class="item col-4">
                <h4 class="title">
                    <?=_lienhe?>
                </h4>
                <div class="content-contact margin-top-20">
                    <?=htmlspecialchars_decode($func->checkSSLContent($row_detail['content']))?>
                </div>
            </div>
            <div class="item col-8">
                <h4 class="title">
                    <?=_gui_yeu_cau_cho_chung_toi?>
                </h4>
                <div class="form-contact margin-top-20">
                    <form action="lien-he" method="post" id="contact-form" name="contact-form" accept-charset="utf-8">
                        <div class="row d-flex flex-wrap justify-content-start">
                            <div class="item col-6">
                                <div class="r-input margin-bottom-10">
                                    <input type="text" name="data[fullname]" class="input-control" id="fullname" value="" placeholder="<?=_nhap_ho_ten?> (*)">
                                </div>
                                <div class="r-input margin-bottom-10">
                                    <input type="text" name="data[email]" class="input-control" id="email" value="" placeholder="<?=_nhap_email?> (*)">
                                </div>
                                <div class="r-input margin-bottom-10">
                                    <input type="text" name="data[phone]" class="input-control" id="phone" value="" placeholder="<?=_nhap_dien_thoai?> (*)">
                                </div>
                            </div>
                            <div class="item col-6">
                                <div class="r-input margin-bottom-10">
                                    <textarea name="data[content]" class="input-control" id="content" placeholder="<?=_nhap_noi_dung_can_lien_he?> (*)"></textarea>
                                    <input type="hidden" name="data[type]" class="input-control" id="type" value="contact">
                                </div>
                                <div class="r-input margin-top-10 margin-bottom-0 text-right">
                                    <input type="hidden" class="input" id="type" value="contact" name="data[type]">
                                    <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                                    <button type="submit" class="button-control"><?=_gui_lien_he_cua_ban?></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>