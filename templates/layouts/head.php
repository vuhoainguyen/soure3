<meta charset="utf-8">
<base href="<?=$config_base?>">
<link rel="canonical" href="<?=$func->getCurrentPageURLCanonical()?>" />
<link rel="alternate" href="<?=$func->getCurrentPageURLCanonical()?>" hreflang="vn-vi" />
<?php /*<meta http-equiv="content-language" content="vi">*/ ?>
<?php foreach ($config['website']['lang'] as $key => $value) { if($key!='vi'){ ?>
<link rel="alternate" href="<?=$func->getCurrentPageURLCanonical()?>" hreflang="en" />
<?php } } ?>
<link href="//www.google-analytics.com" rel="dns-prefetch" />
<link href="//www.googletagmanager.com/" rel="dns-prefetch" />
<?php if($config['debug-reponsive']==true){ ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<?php }else{ ?>
<meta name="viewport" content="width=1349" />
<?php } ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link id="favicon" rel="shortcut icon" href="<?=$config_base._upload_photo_l.$row_favicon['thumb']?>" type="image/x-icon" />
<title><?php if($title_seo!='') echo $title_seo; else echo $row_setting['title']; ?></title>
<meta name="description" content="<?php if($description_seo!='') echo $description_seo; else echo $row_setting['description']; ?>">
<meta name="keywords" content="<?php if($keywords_seo!='') echo $keywords_seo; else echo $row_setting['keywords']; ?>">
<meta name="robots" content="noodp,index,follow" />
<?=htmlspecialchars_decode($row_setting['html_head'])?>
<meta http-equiv="audience" content="General" />
<meta name="resource-type" content="Document" />
<meta name="distribution" content="Global" />
<meta name='revisit-after' content='1 days' />
<meta name="ICBM" content="<?=$row_setting['map_marker']?>">
<meta name="geo.position" content="<?=$row_setting['map_marker']?>">
<meta name="geo.placename" content="<?=$row_setting['address']?>">
<meta name="author" content="<?=$row_setting['company']?>">
<meta name="theme-color" content="<?=$config['website']['theme-color']?>"/>
<meta property="fb:app_id" content="<?=($row_setting['facebook_id']!='') ? $row_setting['facebook_id']:$config['website']['facebookId']?>" /> 
<meta name="dc.language" CONTENT="vietnamese">
<meta name="dc.source" CONTENT="<?=$config_base?>">
<meta name="dc.title" CONTENT="<?php if($title_seo!='') echo $title_seo; else echo $row_setting['title']; ?>">
<meta name="dc.keywords" CONTENT="<?php if($keywords_seo!='') echo $keywords_seo; else echo $row_setting['keywords']; ?>">
<meta name="dc.description" CONTENT="<?php if($description_seo!='') echo $description_seo; else echo $row_setting['description']; ?>"><?=$str_share?>
<script>WebFontConfig = { google: { families: ['Roboto:300,400,700,900','Muli:400,500,600,700,800,900','Open Sans:400,500,600,700,800,900','Anton:400'] },custom: {families: ['SFUFuturaBook','SVNAvobold','UTMFlamenco','FontAwesome'],urls: ['css/fonts.css']},timeout: 300 }; (function(d) { var wf = d.createElement('script'), s = d.scripts[0]; wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js'; wf.async = true; s.parentNode.insertBefore(wf, s); })(document); </script><?=$json_schema->SearchAction().$json_schema->Organization().$json_schema->Person().$json_schema->Library().$json_code?>
<style type="text/css" media="screen"><?=($config['debug-style']==false) ? $themes_css.$links_css:''?></style><?=($config['debug-style']==true) ? $themes_css.$links_css:''?>