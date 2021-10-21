<?php 
	/*$result_slider = $d->rawQuery("select thumb,name_$lang as name,desc_$lang as descs,photo,link from #_multi_photos where type=? and find_in_set ('hienthi',status)",array('slider'));
?>
<section id="slider" class="slider-one">
	<div class="home-slider owl-carousel owl-theme owl-carousel-loop in-home" data-animateOut="fadeOut" data-animateIn="fadeIn" data-dot="0" data-nav='1' data-loop='1' data-play='1' data-lg-items='1' data-md-items='1' data-sm-items='1' data-xs-items="1" data-margin='0'>
		<?php foreach ($result_slider as $k => $v){ ?>
		<div>
			<div class="box-slider">
				<a href="<?=$v['link']?>">
					<img class="img-block" src="resize/1920x700/1/<?=_upload_photo_l.$v['photo']?>" alt="<?=$v['name']?>">
				</a>
				<div class="box-slider-in">
					<div class="container">
						<?=htmlspecialchars_decode($v['descs'])?>
						<p><a href="<?=$v['link']?>" title="Xem thêm">Xem thêm</a></p>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</section>*/?>

<?php 
	$result_why = $d->rawQuery("select thumb, photo, name_$lang as name,link from #_multi_photos where type=? and find_in_set ('hienthi',status) order by numb asc",array('why'));
?>
<section id="why-box">
	<div class="container">
		<div class="box-why">
			<?php foreach ($result_why as $k => $v) { ?>
			<div class="box-i-why">
				<div class="cycle">
					<p>
						<a href="<?=$v['link']?>" title="<?=$v['name']?>">
							<img src="<?=_upload_photo_l.$v['photo']?>?v=<?=$config['version']?>" alt="<?=$v['name']?>">
						</a>
					</p>
				</div>
				<div class="desc-why">
					<h4>
						<a href="<?=$v['link']?>" title="<?=$v['name']?>"><?=$v['name']?></a>
					</h4>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</section>

<?php  $product_lists = $d->rawQuery("SELECT id,desc_$lang as descs,name_$lang as name, alias_$lang as alias,photo from #_lists where type=? and find_in_set ('hienthi',status) and find_in_set ('noibat',status) order by numb asc, id desc",array("san-pham"));
?>
<section id="product-page" class="product-page">
	<div class="container">
		<div class="owl-carousel in-product" data-dot="0" data-nav='0' data-loop='0' data-play='0' data-lg-items='3' data-md-items='3' data-sm-items='2' data-xs-items="2" data-margin='12'>
            <?php foreach ($product_lists as $k => $v) { ?>
			<div>
				<div class="img-list">
					<img class="img-block" src="resize/390x305/1/<?=_upload_product_l.$v['photo']?>" alt="<?=$v['name']?>">
					<div class="position-list">
						<div>
							<h4 class="list-title">
								<a href="<?=$v['alias']?>"><?=$v['name']?></a>
							</h4>
							<p>
								<?=$v['descs']?>
							</p>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
        </div>
	</div>
</section>

<?php 
    $product_lists = $d->rawQuery("SELECT id,name_$lang as name, status, alias_$lang as alias,icon,icon_thumb, photo, thumb from #_lists where type=? and find_in_set ('hienthi',status) order by numb asc, id desc",array("san-pham"));
?>
<section  id="tab-paging" class="saleoff padding-top-30">
    <div class="container">
        <div class="list-index d-flex flex-wrap justify-content-center margin-bottom-20">
            <?php foreach ($product_lists as $k => $v) { ?>
            <div class="img-li" data-id="<?=$v['id']?>" data-el="view-load-product">
                <span class="name"><?=$v['name']?></span>
            </div>
            <?php } ?>
        </div>
        <div class="row1 margin-top-10 d-flex flex-wrap justify-content-start product-view" id="view-load-product"></div>
    </div>
</section>

<?php 
	$row_adv = $d->rawQueryOne("select photo,link,name_$lang as name,status from #_photos where type=? and find_in_set ('hienthi', status) limit 0,1", array('adv'));
?>
<section id="adv">
	<div class="adv-product">
		<a href="<?=$row_adv['link']?>" title="<?=$row_adv['name']?>">
			<img class="img-block-auto" src="<?=_upload_photo_l.$row_adv['photo']?>" alt="<?=$row_adv['name']?>">
		</a>
	</div>
</section>


<?php
    $result_news = $d->rawQuery("SELECT id,name_$lang as name,desc_$lang as descs, alias_$lang as alias, photo, thumb,UNIX_TIMESTAMP(createdAt) as datecreated from #_posts where type=? and find_in_set ('hienthi',status) order by numb asc limit 0,15",array("tin-tuc"));
	
	$result_video = $d->rawQuery("select thumb,name_$lang as name,desc_$lang as descs,youtube,view,id,photo from #_videos where type=? and find_in_set ('hienthi',status) order by numb asc, id desc",array('clips')); ?>
<section class="news-one">
	<div class="container">
		<div class="box-news-video d-flex flex-wrap justify-content-between row">
			<div class="item col--2">
				<div class="title-service margin-bottom-20">
					<h5 onclick="window.location.href='tin-tuc'">Tin tức nổi bật</h5>
				</div>
				<div class="slick slick-page slick-why" data-dots="0" data-infinite="0" data-arrows="0" data-autoplay='0' data-slidesDefault="3:1" data-lg-items='3:1' data-md-items='3:1' data-sm-items='3:1' data-xs-items="3:1" data-vertical="1">
		            <?php foreach ($result_news as $k => $v) { ?>
					<div>
						<div class="post-inner">
			                <div class="post-img <?=(($k+1)%2==1) ? 'order1':'order2'?>">
			                    <a href="<?=$v['alias']?>" title="<?=$v['name']?>">
			                        <img class="img-block" src="resize/390x300/1/<?=_upload_post_l.$v['photo']?>" class="img-block-auto" alt="<?=$v['name']?>">
			                    </a>
			                </div>
			                <div class="post-content <?=(($k+1)%2==1) ? 'order2':'order1'?>">
			                	<h3>
			                        <a title="<?=$v['name']?>" href="<?=$v['alias']?>"><?=$v['name']?></a>
			                    </h3>
			                    <p class="meta-content">
			                        <?=$func->subSpaceStr($v['descs'],25)?>
			                    </p>
			                </div>
			            </div>
					</div>
					<?php } ?>
		        </div>
			</div>
			<div class="item col--2">
				<div class="title-service margin-bottom-20">
					<h5>Video</h5>
				</div>
				
				<div class="video-in">
					<a data-fancybox="thumbnail" href="https://www.youtube.com/watch?v=<?=$func->youtobe($result_video[0]['youtube'])?>" title="<?=$result_video[0]['name']?>">
						<div class="img-video">
							<img class="ytd-thumbnail img-block" src="https://i1.ytimg.com/vi/<?=$func->youtobe($result_video[0]['youtube'])?>/maxresdefault.jpg" alt="<?=$result_video[0]['name']?>">
							<span class="play"></span>
						</div>
					</a>
				</div>
				<div class="owl-carousel in-product" data-dot="0" data-nav='1' data-loop='0' data-play='0' data-lg-items='3' data-md-items='3' data-sm-items='2' data-xs-items="2" data-margin='20'>
		            <?php foreach ($result_video as $k => $v) { ?>
					<div>
						<a data-fancybox="thumbnail" href="https://www.youtube.com/watch?v=<?=$func->youtobe($v['youtube'])?>" title="<?=$v['name']?>">
							<div class="img-video1">
								<img class="ytd-thumbnail img-block" src="https://i1.ytimg.com/vi/<?=$func->youtobe($v['youtube'])?>/maxresdefault.jpg" alt="<?=$v['name']?>">
								<span class="play"></span>
							</div>
						</a>
					</div>
					<?php } ?>
		        </div>
			</div>
		</div>
	</div>
</section>
<?php 
	$row_album = $d->rawQuery("select thumb, photo, name_$lang as name, alias_$lang as alias from #_multi_photos where type=? and find_in_set ('hienthi',status) order by numb asc",array('album'));
?>
<section id="partner" class="partner-one">
	<div class="container">
		<div class="title-section-module margin-bottom-20">
			<h4>Album showroom</h4>
		</div>
		<div class="desc-partner">
			<div class="owl-carousel in-product" data-dot="0" data-nav='1' data-loop='1' data-play='1' data-lg-items='4' data-md-items='4' data-sm-items='3' data-xs-items="2" data-margin='30'>
	            <?php foreach ($row_album as $k => $v) { ?>
				<div class="img-partner">
					<a href="<?=$v['alias']?>" class="d-block"><img class="img-block-auto" src="resize/280x225/1/<?=_upload_photo_l.$v['photo']?>?v=<?=$config['version']?>" alt="<?=$v['name']?>"></a>
				</div>
				<?php } ?>
	        </div>
		</div>
	</div>
</section>

<?php /*
	$result_adv_about = $d->rawQuery("select thumb,name_$lang as name,photo,link from #_multi_photos where type=? and find_in_set ('hienthi',status)",array('adv-about'));

	$row_gioithieu = $d->rawQueryOne("select name_$lang as name, alias_$lang as alias, desc_$lang as descs, id,thumb,photo from #_pages where type=? order by numb asc",array('gioi-thieu')); ?>
<section id="about" class="about bg-about">
	<div class="container">
		<div class="row d-flex justify-content-between flex-wrap">
			<div class="item col--2">
				<h6>Về chúng tôi</h6>
				<h2><?=$row_gioithieu['name']?></h2>
				<div class="desc">
					<?=htmlspecialchars_decode($row_gioithieu['descs'])?>
				</div>
				<a href="gioi-thieu" class="readmore">Xem thêm <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a>
			</div>

			<div class="item col--2">
				<div class="desc-img">
					<a href="gioi-thieu" title="">
						<img class="img-block" src="<?=_upload_post_l.$row_gioithieu['thumb']?>" alt="<?=$row_gioithieu['name']?>">
					</a>
				</div>
			</div>
			
		</div>
	</div>
</section>
<?php /*$result_video = $d->rawQuery("select thumb,name_$lang as name,desc_$lang as descs,youtube,view,id,photo from #_videos where type=? and find_in_set ('hienthi',status) order by numb asc, id desc",array('clips')); ?>
<section id="product-page" class="product-page">
	<div class="container">
		<div class="title-section-module margin-bottom-20">
			<h4>Video <span>Nổi bật</span></h4>
		</div>
		<div class="owl-carousel in-product" data-dot="0" data-nav='1' data-loop='0' data-play='0' data-lg-items='3' data-md-items='3' data-sm-items='2' data-xs-items="2" data-margin='24'>
            <?php foreach ($result_video as $k => $v) { ?>
			<div>
				<a data-fancybox="thumbnail" href="https://www.youtube.com/watch?v=<?=$func->youtobe($v['youtube'])?>" title="<?=$v['name']?>">
					<div class="img-video">
						<img class="ytd-thumbnail img-block" src="https://i1.ytimg.com/vi/<?=$func->youtobe($v['youtube'])?>/maxresdefault.jpg" alt="<?=$v['name']?>">
						<span class="play"></span>
					</div>
					<h4 class="video-title"><?=$v['name']?></h4>
				</a>
			</div>
			<?php } ?>
        </div>
	</div>
</section>

<section id="mail">
	<div class="container">
		<div class="content-mail d-flex justify-content-between flex-wrap align-items-center">
			<div class="info-mail">
				<h5>Đăng ký <span>nhận tin</span></h5>
				<p>Để nhận tin khuyến mãi mới nhất của chúng tôi</p>
			</div>
			<div class="form-mail">
				<form action="" onsubmit="return false;" method="post" id="subscribe-form" name="subscribe-form" target="_blank">
					<input type="email" class="input" value="" placeholder="<?=_nhap_email_cua_ban?>" name="email" id="email">
					<button class="btn btn-primary subscribe" type="submit" name="subscribe" id="subscribe"><?=_dangky?></button>
				</form>
				<button class="btn btn-primary btn-sup lienhe" type="button" name="lienhe" id="lienhe" onclick="window.location.href='lien-he'">Liên hệ</button>
				<button class="btn btn-primary btn-sup hotro" type="button" name="hotro" id="hotro" onclick="window.location.href='ho-tro'">Hỗ trợ</button>
			</div>
		</div>
	</div>
</section>

<?php $album = $d->rawQuery("SELECT id,name_$lang as name, status, alias_$lang as alias, photo, thumb from #_multi_photos where type=? and find_in_set ('hienthi',status) and id_parent=0 order by numb asc, id desc limit 0,5",array("album")); ?>
<section id="gallery">
	<div class="container">
		<div class="title-section-module text-center margin-bottom-20">
            <h3><a href="hoat-dong" title="Hoạt động doanh nghiệp">Hoạt động doanh nghiệp</a></h3>
            <?=htmlspecialchars_decode($func->getInfoPgae('slogan-hoatdong',$lang))?>
        </div>
        <div class="row1 d-flex flex-wrap justify-content-start">
        	<div class="col--2 item1 margin-bottom-10">
        		<div class="img-album">
        			<a href="<?=$album[4]['alias']?>" title="<?=$album[4]['name']?>">
        				<img class="img-block" src="resize/595x350/1/<?=_upload_photo_l.$album[0]['photo']?>" alt="<?=$album[0]['name']?>">
        			</a>
        		</div>
        	</div>
        	<div class="col--2 item1 margin-bottom-10">
        		<div class="img-album">
        			<a href="<?=$album[4]['alias']?>" title="<?=$album[4]['name']?>">
        				<img class="img-block" src="resize/595x350/1/<?=_upload_photo_l.$album[1]['photo']?>" alt="<?=$album[1]['name']?>">
        			</a>
        		</div>
        	</div>
        	<div class="col--3 item1">
        		<div class="img-album">
        			<a href="<?=$album[4]['alias']?>" title="<?=$album[4]['name']?>">
        				<img class="img-block" src="resize/394x350/1/<?=_upload_photo_l.$album[2]['photo']?>" alt="<?=$album[2]['name']?>">
        			</a>
        		</div>
        	</div>
        	<div class="col--3 item1">
        		<div class="img-album">
        			<a href="<?=$album[4]['alias']?>" title="<?=$album[4]['name']?>">
        				<img class="img-block" src="resize/394x350/1/<?=_upload_photo_l.$album[3]['photo']?>" alt="<?=$album[3]['name']?>">
        			</a>
        		</div>
        	</div>
        	<div class="col--3 item1">
        		<div class="img-album">
        			<a href="<?=$album[4]['alias']?>" title="<?=$album[4]['name']?>">
        				<img class="img-block" src="resize/394x350/1/<?=_upload_photo_l.$album[4]['photo']?>" alt="<?=$album[4]['name']?>">
        			</a>
        		</div>
        	</div>
        </div>
	</div>
</section>

<?php 
	$result_why = $d->rawQuery("select thumb, photo, name_$lang as name, alias_$lang as alias, desc_$lang as descs,icon,icon_thumb from #_multi_photos where type=? and find_in_set ('hienthi',status) order by numb asc",array('why'));
?>
<section id="why-box">
	<div class="container">
		<div class="title-section-module margin-bottom-20">
			<h4>Vì sao chọn chúng tôi</h4>
			<?=htmlspecialchars_decode($func->getInfoPgae('slogan-visao',$lang))?>
		</div>
		<div class="box-why">
			<div class="d-flex flex-wrap justify-content-between align-items-stretch">
				<div class="left-why">
					<ul class="why-list">
						<?php foreach ($result_why as $k => $v) { ?>
						<li data-slide="<?=$k+1?>" class="<?=($k==0) ? 'active':''?>">
							<span><?=($k<10) ? '0'.($k+1):($k+1)?></span>
							<h4><?=$v['name']?></h4>
						</li>
						<?php } ?>
					</ul>
				</div>
				<div class="right-why">
					<div class="slick slick-page slick-why" data-dots="0" data-infinite="0" data-arrows="0" data-autoplay='0' data-slidesDefault="1:1" data-lg-items='1:1' data-md-items='1:1' data-sm-items='1:1' data-xs-items="1:1" data-vertical="0">
						<?php foreach ($result_why as $k => $v) { ?>
						<div>
							<div class="right-why-box">
								<div class="cycle">
									<p><img src="<?=_upload_photo_l.$v['icon_thumb']?>?v=<?=$config['version']?>" alt="<?=$v['name']?>"></p>
								</div>
								<div class="desc-why">
									<p>
										<?=$v['descs']?>
									</p>
									<p>
										<a href="<?=$v['alias']?>" title="Xem thêm">Xem thêm</a>
									</p>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php 
	$row_partner = $d->rawQuery("select thumb, photo, name_$lang as name, desc_$lang as descs from #_multi_photos where type=? and find_in_set ('hienthi',status) order by numb asc",array('partner'));
?>
<section id="partner" class="partner-one">
	<div class="container">
		<div class="desc-partner">
			<div class="owl-carousel in-product" data-dot="0" data-nav='0' data-loop='1' data-play='1' data-lg-items='7' data-md-items='5' data-sm-items='4' data-xs-items="3" data-margin='10'>
	            <?php foreach ($row_partner as $k => $v) { ?>
				<div class="img-partner">
					<a href="<?=$v['link']?>" class="d-block"><img class="img-block-auto" src="<?=_upload_photo_l.$v['thumb']?>?v=<?=$config['version']?>" alt="<?=$v['name']?>"></a>
				</div>
				<?php } ?>
	        </div>
		</div>
	</div>
</section>
*/?>