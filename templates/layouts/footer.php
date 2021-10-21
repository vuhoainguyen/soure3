<?php 
	$result_online = $counter->countOnline();
	$result_counter = $counter->getCounter();

	$result_chinhsach = $d->rawQuery("select name_$lang as name, alias_$lang as alias, id from #_posts where type=? and find_in_set ('hienthi',status) order by numb asc",array('chinh-sach'));
	$result_branchs = $d->rawQuery("select name_$lang as name, alias_$lang as alias, id, address_$lang as address, phone, hotline, email from #_branchs where type=? and find_in_set ('hienthi',status) order by numb asc",array('branch'));

	$result_social = $d->rawQuery("select thumb,name_$lang as name,photo,link from #_multi_photos where type=? and find_in_set ('hienthi',status)",array('social'));
	$row_logo_footer = $d->rawQueryOne("select photo,thumb,name_$lang as name from #_photos where type=? and find_in_set ('hienthi',status)",array('logo-footer'));
	$menu_lists_footer = $d->rawQuery("SELECT id,name_$lang as name, alias_$lang as alias from #_lists where type=? and find_in_set ('hienthi',status) order by numb asc, id desc",array("san-pham"));
?>

<footer class="footer bg-footer">
	<div class="container">
		<div class="footer-top row d-flex justify-content-between align-items-center">
			<div class="item f-social d-flex justify-content-start align-items-center">
				<span class="margin-right-20">Mạng xã hội</span>
				<ul class="social d-flex flex-wrap justify-content-start align-items-center">
			       	<?php foreach ($result_social as $k => $v){ ?>
					<li class="margin-right-10">
						<a href="<?=$v['link']?>">
							<img src="<?=_upload_photo_l.$v['thumb']?>" alt="<?=$v['name']?>">
						</a>	
					</li>
					<?php } ?>
		       </ul>
			</div>
			<div class="item f-name d-flex justify-content-center align-items-center">
				<h4 class="name-company"><?=$row_setting['company']?></h4>
			</div>
			<div class="item f-mail d-flex justify-content-start align-items-center">
				<div class="form-mail">
					<form action="" onsubmit="return false;" method="post" id="subscribe-form" name="subscribe-form" target="_blank">
						<input type="email" class="input" value="" placeholder="<?=_nhap_email_cua_ban?>" name="email" id="email">
						<button class="btn btn-primary subscribe" type="submit" name="subscribe" id="subscribe"><?=_dangky?></button>
					</form>
				</div>
			</div>
		</div>
		<div class="row d-flex justify-content-between flex-wrap info-footer">
			<div class="item d-flex justify-content-start align-items-center col--4">
				<span class="margin-right-10">
					<img src="images/glv.png" alt="Giờ mở cửa">
				</span>
				<p>
					Giở mở cửa:<br/><?=$row_setting['time_work']?>
				</p>
			</div>
			<div class="item d-flex justify-content-start align-items-center col--4">
				<span class="margin-right-10">
					<img src="images/dt.png" alt="Đặt hàng">
				</span>
				<p>
					Hotline đặt hàng:<br/><?=$row_setting['hotline']?>
				</p>
			</div>
			<div class="item d-flex justify-content-start align-items-center col--4">
				<span class="margin-right-10">
					<img src="images/vt.png" alt="Địa chỉ">
				</span>
				<p>
					Địa chỉ:<br/><?=$row_setting['address']?>
				</p>
			</div>
			<div class="item d-flex justify-content-start align-items-center col--4">
				<span class="margin-right-10">
					<img src="images/ma.png" alt="Email">
				</span>
				<p>
					Email:<br/><?=$row_setting['email']?>
				</p>
			</div>
		</div>
	</div>
	<div class="copyright">
		<div class="container">
			<div class="d-flex justify-content-between align-items-center">
				<p>
					© Bản quyền thuộc về <b><a href="//bmweb.vn" title="<?=$row_setting['company']?>" target="_blank"><?=$row_setting['company']?></a></b> Cung cấp bởi <a href="//bmweb.vn" rel="nofollow" title="Bmweb" target="_blank">Bmweb co.ltd</a>
				</p>
				<p>
					Đang online: <?=$result_online['dangxem']?> | Tổng truy cập: <?=$result_counter['totalaccess']?>
				</p>
			</div>
		</div>
	</div>
</footer>

<section id="maps-load-frame"></section>

<?php /*<div class="item col--2">
				
				<?php foreach($result_branchs as $k=>$v){ ?>
				<h5><?=$v['name']?></h5>
				<p><i class="fa fa-home"></i> Địa chỉ: <?=$v['address']?></p>
				<p class="margin-bottom-10"><i class="fa fa-phone"></i> Điện thoại: <?=$v['phone']?> - <?=$v['hotline']?></p>
				<?php } ?>
			</div>
			<div class="item col--4">
				<h4 class="name-company">Sản phẩm</h4>
				<?php if($menu_lists_footer){ ?>
				<ul class="list-menu d-flex justify-content-center flex-wrap margin-top-20">
		        	<?php foreach ($menu_lists_footer as $k => $v) { ?>
		            <li class="li_menu"><a href="<?=$v['alias']?>"><?=$v['name']?></a></li>
		            <?php } ?>
		        </ul>
		        <?php } ?>
				<h4 class="name-company margin-top-20">Liên kết mạng xã hội</h4>
				
			</div>
			<div class="item col--4">
				<h4 class="name-company">Fanpage facebook</h4>
				<div class="fanpage-overflow">
					<div class="fb-page" data-href="<?=$row_setting['fanpage']?>" data-width="500" data-height="130" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="<?=$row_setting['fanpage']?>"><a href="<?=$row_setting['fanpage']?>"><?=$row_setting['ten_'.$lang]?></a></blockquote></div></div>
				</div>
				<h4 class="name-company margin-top-20">Đăng ký nhận tin</h4>
				<form action="" onsubmit="return false;" method="post" id="subscribe-form" name="subscribe-form" target="_blank">
					<input type="email" class="input" value="" placeholder="<?=_nhap_email_cua_ban?>" name="email" id="email">
					<button class="btn btn-primary subscribe" type="submit" name="subscribe" id="subscribe"><i class="fa fa-send"></i></button>
				</form>
			</div>*/ ?>