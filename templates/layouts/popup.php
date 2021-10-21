<?php
  $popup = $d->rawQueryOne("select photo,link,name_$lang as name,status from #_photos where type=? and find_in_set ('hienthi', status) limit 0,1", array('popup'));
?>
<?php if(isset($popup) && $source=='index' && $popup['status']=='hienthi') { ?>
<a href="#popup" class="open-popup"></a>
<div id="popup" class="white-popup mfp-hide">
  <div class="content-popup t-center">
    <a href="<?=$popup['link']?>" title="<?=$popup['name']?>">
      <img src="<?=_upload_photo_l.$popup['photo']?>" alt="<?=$popup['name']?>">
    </a>
  </div>
</div>
<?php } ?>