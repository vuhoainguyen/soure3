<?php $str_id = ($_GET['id']) ? '&id='.$_GET['id']:'' ; ?>
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
				<form action="account/so-dia-chi&action=save<?=$str_id?>" name="address-form" id="address-form" method="post" accept-charset="utf-8">
					<div class="row d-flex justify-content-between flex-wrap">
						<div class="form-group item col--2 margin-bottom-20">
							<label><?=_ho_ten?><span class="required">*</span></label>
							<input autocomplete="off" placeholder="<?=_nhap_ho_ten?>..." type="text" class="form-control form-control-lg" value="<?=$item['fullname']?>" name="data[fullname]" id="member_fullname" >
						</div>
						<div class="form-group item col--2 margin-bottom-20">
							<label><?=_dien_thoai?><span class="required">*</span></label>
							<input autocomplete="off" placeholder="<?=_nhap_dien_thoai?>" type="text" class="form-control form-control-lg" value="<?=$item['phone']?>" name="data[phone]" id="member_phone" >
						</div>
					</div>
					<div class="row d-flex justify-content-between flex-wrap">
						<div class="form-group item col--2 margin-bottom-20">
							<label><?=_dia_chi?><span class="required">*</span></label>
							<input autocomplete="off" placeholder="<?=_nhap_dia_chi?>" type="text" class="form-control form-control-lg" value="<?=$item['address']?>" name="data[address]" id="member_address">
						</div>
						<div class="form-group item col--2 margin-bottom-20">
							<label><?=_loai_dia_chi?><span class="required">*</span></label>
							<select class="form-control form-control-lg select" name="data[type]" id="type" placeholder="<?=_loai_dia_chi?>">
					            <option value="1" <?=($item['type']==1) ? 'selected':''?>><?=_nha_rieng?></option>
					            <option value="2" <?=($item['type']==2) ? 'selected':''?>><?=_cong_ty?></option>
					        </select>
						</div>
					</div>
					<?php
					    $result_city = $apiPlace->getPlace('place_citys',"id, name_$lang as name",'id asc');

					    if($_GET['action']=='edit'){
					    	$result_dist = $apiPlace->getFieldWhere('place_dists',$item['id_city'],"id, name_$lang as name, code",'id_city','numb asc, id desc');
					    	$result_ward = $apiPlace->getFieldWhere('place_wards',$item['id_dist'],"id, name_$lang as name, code",'id_dist','numb asc, id desc');
					    }
					?>
					<div class="row d-flex justify-content-between flex-wrap">
						<div class="form-group item col--3 margin-bottom-20">
							<label for="id_city"><?=_tinh_thanh?> <span class="required">*</span></label>
							<select class="form-control form-control-lg select" name="data[id_city]" id="id_city" placeholder="<?=_tinh_thanh?>" onchange="onChangeSelect('#id_dist',{id:this.value, fs:'id,name_<?=$lang?> as name, code',fw:'id_city',t:'place/dists',tt:'<?=_chon_quan_huyen?>'})">
					            <option value=""><?=_chon_tinh_thanh?></option>
					            <?php foreach($result_city as $k => $v){ ?>
					            <option value="<?=$v['id']?>" <?=($item['id_city']==$v['id']) ? 'selected':''?>><?=$v['name']?></option>
					            <?php } ?>
					        </select>
						</div>
						<div class="form-group item col--3 margin-bottom-20">
							<label for="id_dist"><?=_quan_huyen?><span class="required">*</span></label>
							<select class="form-control form-control-lg select" name="data[id_dist]" id="id_dist" placeholder="<?=_quan_huyen?>" onchange="onChangeSelect('#id_ward',{id:this.value, fs:'id,name_<?=$lang?> as name, code',fw:'id_dist',t:'place/wards',tt:'<?=_chon_phuong_xa?>'})">
					            <option value=""><?=_chon_quan_huyen?></option>
					            <?php if(count($result_dist) >0 ) { foreach($result_dist as $k => $v){ ?>
					            <option value="<?=$v['id']?>" <?=($item['id_dist']==$v['id']) ? 'selected':''?>><?=$v['code']?> <?=$v['name']?></option>
					            <?php } } ?>
					        </select>
						</div>
						<div class="form-group item col--3 margin-bottom-20">
							<label for="id_ward"><?=_phuong_xa?><span class="required">*</span></label>
							<select class="form-control form-control-lg select" name="data[id_ward]" id="id_ward" placeholder="<?=_phuong_xa?>">
					            <option value=""><?=_chon_phuong_xa?></option>
					            <?php if(count($result_ward) >0 ) { foreach($result_ward as $k => $v){ ?>
					            <option value="<?=$v['id']?>" <?=($item['id_ward']==$v['id']) ? 'selected':''?>><?=$v['code']?> <?=$v['name']?></option>
					            <?php } } ?>
					        </select>
						</div>
					</div>

					<div class="pull-xs-left text-left">
						<button class="btn btn-style btn-blues auto-w" type="submit" value="<?=($_GET['action']=='edit') ? _cap_nhat_thay_doi:_luu_them_moi?>"><?=($_GET['action']=='edit') ? _cap_nhat_thay_doi:_luu_them_moi?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


