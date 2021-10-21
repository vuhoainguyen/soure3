<?php 
	$menu_lists_product = $d->rawQuery("SELECT id,name_$lang as name, alias_$lang as alias from #_lists where type=? and find_in_set ('hienthi',status) order by numb asc, id desc",array("san-pham"));
	$posts_news = $d->rawQuery("SELECT id,name_$lang as name, alias_$lang as alias, photo, thumb,UNIX_TIMESTAMP(createdAt) as datecreated from #_posts where type=? and find_in_set ('hienthi',status)  order by id desc limit 0,5",array("tin-tuc"));
	$posts_services = $d->rawQuery("SELECT id,name_$lang as name, alias_$lang as alias, photo, thumb,UNIX_TIMESTAMP(createdAt) as datecreated from #_posts where type=? and find_in_set ('hienthi',status)  order by id desc limit 0,5",array("dich-vu"));
?>
<?php if($menu_lists_product){ ?>
<div class="left-sub">
	<h4 class="head-left"><span>Danh mục sản phẩm</span></h4>
	<?php if(count($menu_lists_product)>0){ ?>
    <ul class="menu-left level0 d-flex flex-wrap justify-content-between">
        <?php foreach ($menu_lists_product as $k => $v) {  $menu_cats_product = $d->rawQuery("SELECT id,name_$lang as name, alias_$lang as alias from #_cats where type=? and id_list=? and find_in_set ('hienthi',status) and NOT find_in_set ('menu',status) order by numb asc, id desc",array("san-pham",$v['id']));?>
        <li class="level1 parent item">
            <a href="<?=$v['alias']?>">
                <?=$v['name']?>
            </a>
            <?php if(count($menu_cats_product)>0){ ?>
		    <ul>
		        <?php foreach ($menu_cats_product as $k1 => $v1) {  ?>
		        <li>
		            <a href="<?=$v1['alias']?>">
		                <?=$v1['name']?>
		            </a>
		        </li>
		        <?php } ?>
		    </ul>
		    <?php } ?>

        </li>
        <?php } ?>
    </ul>
    <?php } ?>
</div>
<?php } ?>
<?php /*<div class="left-sub mb-24">
	<h4 class="head-left"><span>Dịch vụ mới nhất</span></h4>
	<div class="desc-left">
		<ul class="other-post none">
        	<?php foreach($posts_services as $k=>$v){ ?>
	        <li class="d-flex flex-wrap justify-content-start none">
	            <div class="img">
	                <a href="<?=$v['alias']?>" title="<?=$v['name']?>">
	                    <img class="img-block" src="resize/100x70/1/<?=_upload_post_l.$v['thumb']?>" alt="<?=$v['name']?>">
	                </a>
	            </div>
	            <h4>
	                <a href="<?=$v['alias']?>" title="<?=$v['name']?>"><?=$func->subSpaceStr($v['name'],9,'')?><br/><span><?=date('d/m/Y',$v['datecreated'])?></span></a>
	            </h4>
	        </li>
	        <?php } ?>
	    </ul>
	</div>
</div>*/ ?>
<div class="left-sub mb-24">
	<h4 class="head-left"><span>Tin tức mới nhất</span></h4>
	<div class="desc-left">
		<ul class="other-post none">
        	<?php foreach($posts_news as $k=>$v){ ?>
	        <li class="d-flex flex-wrap justify-content-start none">
	            <div class="img">
	                <a href="<?=$v['alias']?>" title="<?=$v['name']?>">
	                    <img class="img-block" src="resize/100x70/1/<?=_upload_post_l.$v['thumb']?>" alt="<?=$v['name']?>">
	                </a>
	            </div>
	            <h4>
	                <a href="<?=$v['alias']?>" title="<?=$v['name']?>"><?=$func->subSpaceStr($v['name'],9,'')?><br/><span><?=date('d/m/Y',$v['datecreated'])?></span></a>
	            </h4>
	        </li>
	        <?php } ?>
	    </ul>
	</div>
</div>