<?php
$result_slider = $d->rawQuery("select thumb,name_$lang as name,photo,link from #_multi_photos where type=? and find_in_set ('hienthi',status)",array('slider'));
?>

<link href="css/css_jssor_slider.css" type="text/css" rel="stylesheet" />

<style> 
		
    </style>
<section id="slider" class="slider-one">
<div id="slider1_container" style="position: relative;width: 1356px; height: 554px;;margin:0 auto;">
    <!-- Slides Container -->
    <div u="slides" style="cursor: move;width: 1356px; height: 554px;overflow: hidden;">
        <?php for($i=0;$i<count($result_slider);$i++){ ?>
        <div>
        	<a href="<?=$result_slider[$i]['link']?>" target="_blank">
            <img u="image" src="<?php if($result_slider[$i]['photo']!='')echo _upload_photo_l.$result_slider[$i]['photo'];else echo 'images/noimage.png' ?>" alt="<?=$result_slider[$i]['ten']?>" />
            </a>
        </div>
        <?php } ?>                
    </div>
    <!-- Trigger -->
             
    <!-- Arrow Left -->
    <span u="arrowleft" class="jssora05l" style="top:40%;"></span>
    <!-- Arrow Right -->
    <span u="arrowright" class="jssora05r" style="top:40%;"></span>
</div><!-- Jssor Slider End -->
</section>
       

    
 