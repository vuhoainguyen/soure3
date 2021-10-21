<div class="container">
	<div class="wrap-bg-in">
	   	<div class="head-title">
	        <h1><?=$title?></h1>
	    </div>

	    <div class="margin-top-10 margin-bottom-20 d-flex flex-wrap justify-content-start" id="cart-body">
	        <?=$apiCart->getTemplateCartG($lang,$config_base)?>
	    </div>
	</div>
</div>