<?php
	$support_support = $d->rawQuery("select thumb, photo, name_$lang as name, desc_$lang as descs from #_multi_photos where type=? and find_in_set ('hienthi',status) order by numb asc",array('support'));
?>
<div class="hotline-box">
	<h5 class="name-hotline">Hỗ trợ trực tuyến</h5>
	<div class="desc-hotline">
		<?php foreach ($support_support as $k => $v) { ?>
		<p>
			<?=$v['name']?> - <?=$v['descs']?>
		</p>
		<?php } ?>
	</div>
</div>