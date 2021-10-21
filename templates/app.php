<!DOCTYPE html>
<html lang="<?=$lang?>">
<head>
<?php include _layouts.'head.php'; ?>
</head>
<body <?php if($source!='index'){ ?>class="in-page"<?php } ?>>
	
	<?php if($source=='index'){ ?>
	<h1 class="hidden-h1"><?=$row_setting['title']?></h1>
	<?php } ?>
	<?php if($com=='carts' && ($act=='thanh-toan' || $act=='xac-nhan')){ ?>
		<?php require_once _templates.$template.'_tpl.php'; ?>
	<?php }else{ ?>
		<?php require_once _layouts.'top.php'; ?>
		<?php require_once _layouts.'header.php'; ?>
		<?php require_once _layouts.'slider_jssor.php'; ?>
		<section id="full-page">
			<?php if($source!='index'){ ?>
			<section id="title-breadcrumbs">
				<div class="container">
					<?=$str_breadcrumbs?>
				</div>
			</section>
			<?php } ?>
			<section id="content-page">
				<?php require_once _templates.$template.'_tpl.php'; ?>
			</section>
		</section>
	<?php require_once _layouts.'footer.php'; ?>
	<a href="#" id="back-to-top" class="backtop show" title="Lên đầu trang"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
	<?php } ?>
	
	
  	
	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/lang_<?=$lang?>.js"></script>
	<script src="js/vegas.min.js"></script>
	<script type="text/javascript">
		var _BMWEB = _BMWEB || {};
		var _BASE = '<?=$config_base?>';
		var _LANG = '<?=$lang?>';
		var _INDEX = <?=($source=='index') ? 1:0?>;
		var _LINK_YOUTUBE = '<?=$func->youtobe($row_video['youtube'])?>';
		var _CART_ADVANCE = <?=($config['cart']['advance']==true) ? 1:0?>;
		var placeholderText = [ "Nhập từ khóa..." ];
	</script>
	<?php if($com=='carts' && $act=='thanh-toan'){ ?>
	<script src="js/jquery.form-validator.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$.validate({});
		});
	</script>
	<?php } ?>

	<script type="text/javascript" src="js/jssor.js"></script>
  	<script type="text/javascript" src="js/jssor.slider.js"></script>
  	<script type="text/javascript" src="js/js_jssor_slider_caption.js"></script> 
	
	<script src="js/sharer.min.js"></script>
	<script src="js/functions.js"></script>
	<script src="js/custom.js"></script>
	<script type="text/javascript">
		$("#home-slider").vegas({
			delay: 7000,
		    timer: false,
		    shuffle: true,
		    firstTransition: 'fade',
		    firstTransitionDuration: 1000,
		    transition: 'slideDown2',
		    transitionDuration: 2000,
		    slides: [
		    	<?php foreach ($result_slider as $k => $v){ ?>
		        { src: "<?=_upload_photo_l.$v['photo']?>", link: '<a href="<?=$v['link']?>"><div class="full-href"></div></a>' },
		        <?php } ?>
		    ],
		    animation: [ 'kenburnsUp', 'kenburnsDown', 'kenburnsLeft', 'kenburnsRight' ],
		    walk: function (index, slideSettings) {
	           $('#vegasSliderInner').html(slideSettings.link);
	       	}
		});
	</script>

	<?php if($config['quickview']==true){ ?>
	<script src="js/quickview.js"></script>
	<div id="quickview-modal" class="white-popup mfp-with-anim mfp-hide"></div>
	<?php } ?>
	<?php if($config['cart']['check']==true){ ?>
	<script src="js/cart.js"></script>
	<div id="cart-modal" class="white-popup mfp-with-anim mfp-hide"></div>
	<?php } ?>

	<div id="fb-root"></div>
	<script>
	var fired = false;
	window.addEventListener("scroll", function(){
	if ((document.documentElement.scrollTop != 0 && fired === false) || (document.body.scrollTop != 0 && fired === false)) {
		(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v6.0&appId=<?=$row_setting['facebook_id']?>&autoLogAppEvents=1";
		fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		fired = true;
	}
	}, true);
	</script>
	
	<?php if($source=='contacts' || $source=='index'){ ?>
	<script src="https://www.google.com/recaptcha/api.js?render=<?=$config['website']['sitekey']?>"></script>
	<script>
	    grecaptcha.ready(function () {
	        grecaptcha.execute('<?=$config['website']['sitekey']?>', { action: 'contact' }).then(function (token) {
	            var recaptchaResponse = document.getElementById('recaptchaResponse');
	            if(recaptchaResponse) recaptchaResponse.value = token;

	            var recaptchaResponse1 = document.getElementById('recaptchaResponse1');
	            if(recaptchaResponse1) recaptchaResponse1.value = token;
	        });
	    });
	</script>
	<?php } ?>
	<?=htmlspecialchars_decode($row_setting['html_body'])?>
	<?php $ex_map_marker = explode(',',$row_setting['map_marker']); ?>
	<ul class="h-card hidden-micro"><li class="h-fn fn"><?=$row_setting['title']?></li><li class="h-org org"><?=$row_setting['company']?></li><li class="h-tel tel"><?=$row_setting['phone']?></li><li><a class="u-url ul" href="<?=$config_base?>"><?=$config_base?></a></li></ul><span class="h-geo geo hidden-micro"><span class="p-latitude latitude"><?=trim($ex_map_marker[0])?></span>,<span class="p-longitude longitude"><?=trim($ex_map_marker[1])?></span></span>

	<?php require_once _layouts.'popup.php'; ?>
	<?php if($com!='carts' && ($act!='thanh-toan' || $act!='xac-nhan')){ ?>
	<?php require_once _layouts.'zalo_phone.php'; ?>
	<?php } ?>
	<?php require_once _layouts.'menu_mobile.php'; ?>
	<div class="opacity-menu-list"></div>
</body>
</html>