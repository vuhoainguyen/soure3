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
				<div class="table">
					<table class="display list-table">
						<thead>
							<tr>
								<th align="left"><?=_ho_ten?></th>
								<th align="left"><?=_dia_chi?></th>
								<th align="left"><?=_khu_vuc?></th>
								<th align="left"><?=_dien_thoai?></th>
								<th align="left"><?=_trang_thai?></th>
								<th align="left"><?=_thao_tac?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($lists as $k=>$v){
								$city = $apiPlace->getPlaceId('id','place_citys',$v['id_city'],"name_$lang as name");
								$dist = $apiPlace->getPlaceId('id','place_dists',$v['id_dist'],"name_$lang as name, code");
								$ward = $apiPlace->getPlaceId('id','place_wards',$v['id_ward'],"name_$lang as name, code");
							?>
							<tr>
								<td><?=$v['fullname']?></td>
								<td><?=$v['address']?></td>
								<td><?=$city['name']?> - <?=$dist['code'].' '.$dist['name']?> - <?=$ward['code'].' '.$ward['name']?></td>
								<td><?=$v['phone']?></td>
								<td>
									<span data-id="<?=$v['id']?>" data-user="<?=$v['id_user']?>" class="check-default <?=($v['check_default']==1) ? 'set_default':''?>" data-val="<?=$v['check_default']?>">
										<i class="fa fa-check-circle"></i> <?=_mac_dinh?>
									</span>
								</td>
								<td>
									<a href="account/so-dia-chi&action=edit&id=<?=$v['id'])?>" title="" class="btn-ap r">
										<i class="fa fa-edit"></i> <?=_sua?>
									</a>
									<a href="account/so-dia-chi&action=delete&id=<?=$v['id'])?>" onclick="if(!confirm('<?=_ban_co_chac_chan_muon_xoa?>')) return false" class="btn-ap b">
										<i class="fa fa-remove"></i> <?=_xoa?>
									</a>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="form-signup">
				<div class="pull-xs-left text-left margin-top-20">
					<button class="btn btn-style btn-blues auto-w" type="button" onclick="window.location.href='account/so-dia-chi&action=add'" value="<?=_them_dia_chi_moi?>"><?=_them_dia_chi_moi?></button>
				</div>
			</div>
		</div>
	</div>
</div>