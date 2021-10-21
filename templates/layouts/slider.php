<?php 
	$result_slider = $d->rawQuery("select thumb,name_$lang as name,photo,link from #_multi_photos where type=? and find_in_set ('hienthi',status)",array('slider'));
?>
<section id="slider" class="slider-one">
	<div class="home-slider" id="home-slider"></div>
	<div id="vegasSliderInner"></div>
	<?php require_once _layouts.'header.php'; ?>
</section>