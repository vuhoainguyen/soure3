<?php 
	$result_social_top = $d->rawQuery("select thumb,name_$lang as name,photo,link from #_multi_photos where type=? and find_in_set ('hienthi',status)",array('social-top'));
?>
<section id="top">
	<div class="container">
		<div class="row d-flex justify-content-between">
			<div class="item col--2">
				<marquee behavior="" direction="">
					<p><?=$row_setting['slogan']?></p>
				</marquee>
			</div>
			<div class="item col--2">
				<ul class="d-flex flex-wrap justify-content-end align-items-center">
					<li>Mạng xã hội</li>
					<?php if($result_social_top) { foreach ($result_social_top as $k => $v){ ?>
					<li>
						<a href="<?=$v['link']?>">
							<img class="img-block" src="<?=_upload_photo_l.$v['thumb']?>" alt="<?=$v['name']?>">
						</a>	
					</li>
					<?php } } ?>
				</ul>
			</div>
		</div>
	</div>
</section>