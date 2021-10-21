<div id="page-login">
	<div class="text-center margin-bottom-10">
		<h1 class="title-head"><?=$title?></h1>
	</div>
	<div class="text-forgot d-block text-center margin-top-0">
		<p>
			<?=_nhap_email_lay_mat_khau?>
		</p>
	</div>
	<div class="form-signup margin-top-20">
		<form action="account/quen-mat-khau" method="post" name="forgot-form" id="forgot-form" accept-charset="utf-8">
			<div class="form-group margin-bottom-20">
				<input autocomplete="off" placeholder="<?=_nhap_email?>" type="email" class="form-control form-control-lg" value="<?=$_POST['data']['email']?>" name="data[email]" id="member_email" >
			</div>
			<div class="pull-xs-left text-center margin-top-20">
				<button class="btn btn-style btn-blues" type="submit" value="<?=_lay_lai_mat_khau?>"><?=_lay_lai_mat_khau?></button>
			</div>
			<div class="text-forgot d-block text-center margin-top-20">
				<p>
					<?=_chua_co_tai_khoan_dang_ky_tai_day?>
				</p>
			</div>
		</form>
	</div>
</div>