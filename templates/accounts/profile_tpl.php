<div id="page-login" class="account-profile">
	
	<div class="account-page row d-flex justify-content-between flex-wrap">
		<div class="item col-2">
			<?php include 'templates/accounts/menu_account.php'; ?>
		</div>
		<div class="item col-10">
			<div class="form-signup">
				<div class="text-left margin-bottom-20">
					<h1 class="title-head line"><?=$title?></h1>
				</div>
				<form action="account/thong-tin-tai-khoan" name="profile-form" id="profile-form" method="post" accept-charset="utf-8">
					<div class="row d-flex justify-content-between flex-wrap">
						<div class="form-group item col--2 margin-bottom-20">
							<label>Email<span class="required">*</span></label>
							<input autocomplete="off" placeholder="Nhập Email" readonly disabled type="email" class="form-control form-control-lg" value="<?=$row_user['email']?>" name="data[email]" id="member_email" >
						</div>
						<div class="form-group item col--2 margin-bottom-20">
							<label><?=_ho_ten?><span class="required">*</span></label>
							<input autocomplete="off" placeholder="<?=_nhap_ho_ten?>" type="text" class="form-control form-control-lg" value="<?=$row_user['fullname']?>" name="data[fullname]" id="member_fullname" >
						</div>
					</div>
					<div class="row d-flex justify-content-between flex-wrap">
						<div class="form-group item col--2 margin-bottom-20">
							<label><?=_dia_chi?><span class="required">*</span></label>
							<input autocomplete="off" placeholder="<?=_nhap_dia_chi?>" type="text" class="form-control form-control-lg" value="<?=$row_user['address']?>" name="data[address]" id="member_address">
						</div>
						<div class="form-group item col--2 margin-bottom-20">
							<label><?=_dien_thoai?><span class="required">*</span></label>
							<input autocomplete="off" placeholder="<?=_nhap_dien_thoai?>" type="text" class="form-control form-control-lg" value="<?=$row_user['phone']?>" name="data[phone]" id="member_phone" >
						</div>
					</div>
					<?php
                        $result_city = $apiPlace->getPlace('place_citys',"id, name_$lang as name",'id asc');
                        if($row_user['id_city']!=0){
                        	$result_dist = $apiPlace->getFieldWhere('place_dists',$row_user['id_city'],"id, name_$lang as name,code",'id_city','numb asc, id desc');
                        }
                    ?>
                    <div class="row d-flex justify-content-between flex-wrap">
						<div class="form-group item col--2 margin-bottom-20">
							<label><?=_tinh_thanh?></label>
							<select name="data[id_city]" class="form-flex-col w-100" id="id_city" onchange="onChangeSelect('#id_dist',{id:this.value, fs:'id,name_<?=$lang?> as name, code',fw:'id_city',t:'place/dists',tt:'<?=_chon_quan_huyen?>'})">
								<option value=""><?=_chon_tinh_thanh?></option>
								<?php foreach($result_city as $k => $v){ ?>
                                <option value="<?=$v['id']?>" <?=($v['id']==$row_user['id_city']) ? 'selected':''?>><?=$v['name']?></option>
                                <?php } ?>
							</select>
						</div>
						<div class="form-group item col--2 margin-bottom-20">
							<label><?=_quan_huyen?></label>
							<select name="data[id_dist]" class="form-flex-col w-100" id="id_dist">
								<option value=""><?=_chon_quan_huyen?></option>
								<?php if(count($result_dist)>0) { foreach($result_dist as $k => $v){ ?>
                                <option value="<?=$v['id']?>" <?=($v['id']==$row_user['id_dist']) ? 'selected':''?>><?=$v['code']?> <?=$v['name']?></option>
                                <?php } } ?>
							</select>
						</div>
					</div>
					
					<?php if($row_user['birthday']!=''){ $birthday = explode('-', $row_user['birthday']); } ?>
					<div class="form-group">
						<label><?=_ngay_sinh?></label>
						<div class="from-flex row d-flex justify-content-start flex-wrap">
							<div class="form-group item col--3 margin-bottom-20">
								<select name="ngay" class="form-flex-col w-100" id="ngay">
									<?php for($i=1;$i<=31;$i++){ ?>
									<option value="<?=$i?>" <?=($birthday[0]==$i) ? 'selected':''?>><?=$i?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group item col--3 margin-bottom-20">
								<select name="thang" class="form-flex-col w-100" id="thang">
									<?php for($i=1;$i<=12;$i++){ ?>
									<option value="<?=$i?>" <?=($birthday[1]==$i) ? 'selected':''?>>Tháng <?=$i?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group item col--3 margin-bottom-20">
								<select name="nam" class="form-flex-col w-100" id="nam">
									<?php for($i=date('Y');$i>1900;$i--){ ?>
									<option value="<?=$i?>" <?=($birthday[2]==$i) ? 'selected':''?>><?=$i?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="pull-xs-left text-left">
						<button class="btn btn-style btn-blues auto-w" type="submit" value="<?=_cap_nhat_thay_doi?>"><?=_cap_nhat_thay_doi?></button>
					</div>
				</form>
			</div>
			<div class="form-signup">
				<div class="text-left margin-top-40 margin-bottom-20">
					<h1 class="title-head line"><?=_doi?> <?=_matkhau?></h1>
				</div>
				<form action="account/doi-mat-khau" name="reset-password-form" id="reset-password-form" method="post" accept-charset="utf-8">
					<?php if(!empty($error_pass)){ ?>
					<div class="form-group margin-bottom-20">
						<label style="display: block;" class="error"><?=$error_pass['message']?></label>
					</div>
					<?php } ?>
					<div class="row d-flex justify-content-between flex-wrap">
						<div class="form-group item col--3 margin-bottom-20">
							<label><?=_mat_khau?> <?=_cu_?><span class="required">*</span></label>
							<input autocomplete="new-password" placeholder="<?=_nhap?> <?=_matkhau?> <?=_cu_?>" type="password" class="form-control form-control-lg" value="" name="data[password-old]" id="member_password_old">
						</div>
						<div class="form-group item col--3 margin-bottom-20">
							<label><?=_mat_khau?> <?=_moi_?><span class="required">*</span></label>
							<input autocomplete="new-password" placeholder="<?=_nhap?> <?=_matkhau?> <?=_moi_?>" type="password" class="form-control form-control-lg" value="" name="data[password]" id="member_password">
						</div>
						<div class="form-group item col--3 margin-bottom-20">
							<label><?=_mat_khau?> <?=_xac_nhan_?><span class="required">*</span></label>
							<input autocomplete="new-password" placeholder="<?=_nhap?> <?=_matkhau?> <?=_xac_nhan_?>" type="password" class="form-control form-control-lg" value="" name="data[password-confirm]" id="member_password_confirm">
						</div>
					</div>
					
					<div class="pull-xs-left text-left">
						<button class="btn btn-style btn-blues auto-w" type="submit" value="<?=_thay_doi?> <?=_matkhau?>"><?=_thay_doi?> <?=_matkhau?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>