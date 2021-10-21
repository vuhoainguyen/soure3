<div id="page-login">
	<div class="text-center margin-bottom-20">
		<h1 class="title-head"><?=$title?></h1>
	</div>
	<?php if($config['login']['social']==true){ ?>
	<div class="social-login text-center">
		<a href="#" class="fb btn-social">
          <i class="fa fa-facebook"></i> Facebook
         </a>
        <a href="#" class="google btn-social"><i class="fa fa-google-plus">
          </i> Google
        </a>
	</div>
	<div class="line-or">
		<span><?=_hoac?></span>
	</div>
	<?php } ?>
	<div class="form-signup">
		<form action="account/dang-ky" name="regiter-form" id="regiter-form" method="post" accept-charset="utf-8">
			<div class="form-group margin-bottom-20">
				<label>Email<span class="required">*</span></label>
				<input autocomplete="off" placeholder="<?=_nhap_email?>" type="email" class="form-control form-control-lg" value="" name="data[email]" id="member_email" >
			</div>
			<div class="form-group margin-bottom-20">
				<label><?=_mat_khau?><span class="required">*</span></label>
				<input autocomplete="new-password" placeholder="<?=_nhap?> <?=_matkhau?>" type="password" class="form-control form-control-lg" value="" name="data[password]" id="member_password">
			</div>
			<div class="form-group margin-bottom-20">
				<label><?=_mat_khau?> <?=_xac_nhan_?><span class="required">*</span></label>
				<input autocomplete="new-password" placeholder="<?=_nhap?> <?=_matkhau?> <?=_xac_nhan_?>" type="password" class="form-control form-control-lg" value="" name="data[password-confirm]" id="member_password_confirm">
			</div>
			<div class="form-group margin-bottom-20">
				<label><?=_dien_thoai?><span class="required">*</span></label>
				<input autocomplete="off" placeholder="<?=_nhap_dien_thoai?>" type="text" class="form-control form-control-lg" value="" name="data[phone]" id="member_phone" >
			</div>
			<div class="pull-xs-left text-center margin-top-20">
				<button class="btn btn-style btn-blues" type="submit" value="<?=_tao_tai_khoan?>"><?=_tao_tai_khoan?></button>
			</div>
			<p class="login--notes"><?=_cam_ket_dang_ky_dang_nhap?></p>
			<div class="text-login text-center">
				<p>
					<?=_da_co_tai_khoan_dang_nhap_tai_day?>
				</p>
			</div>
		</form>
	</div>
</div>