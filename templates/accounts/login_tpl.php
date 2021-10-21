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
		<form action="account/dang-nhap&return=<?=($_GET['return']) ? '&return='.$_GET['return']:''?>" name="login-form" id="login-form" method="post" accept-charset="utf-8">
			<?php if(!empty($error)){ ?>
			<div class="form-group margin-bottom-20">
				<label style="display: block;" class="error"><?=$error['message']?></label>
			</div>
			<?php } ?>
			<div class="form-group margin-bottom-20">
				<label>Email<span class="required">*</span></label>
				<input autocomplete="off" placeholder="<?=_nhap_email?>" type="email" class="form-control form-control-lg" value="<?=$_POST['data']['email']?>" name="data[email]" id="member_email"  >
			</div>
			<div class="form-group margin-bottom-20">
				<label><?=_mat_khau?><span class="required">*</span></label>
				<input autocomplete="new-password" placeholder="<?=_nhap_mat_khau?>" type="password" class="form-control form-control-lg" value="" name="data[password]" id="member_password">
			</div>
			<p class="text-left recover">
				<?=_quen_mat_khau_nhan_tai_day?>
			</p>
			<div class="pull-xs-left text-center margin-top-20">
				<button class="btn btn-style btn-blues" type="submit" value="<?=_dangnhap?>"><?=_dangnhap?></button>
			</div>
			<p class="login--notes"><?=_cam_ket_dang_ky_dang_nhap?></p>
			<div class="text-login text-center">
				<p>
					<?=_chua_co_tai_khoan_dang_ky_tai_day?>
				</p>
			</div>
		</form>
	</div>
</div>