<?php
    $themes = new themes();

    $themes_css = $themes->miniCssSet('css/all',$config['debug-style']);
    $themes_css .= $themes->miniCssSet('css/reset',$config['debug-style']);
    $themes_css .= $themes->miniCssSet('css/animate',$config['debug-style']);
    $themes_css .= $themes->miniCssSet('css/use.awesome',$config['debug-style']);
    $themes_css .= $themes->miniCssSet('css/vegas.min',$config['debug-style']);
    $themes_css .= $themes->miniCssSet('css/style',$config['debug-style']);
    $themes_css .= $themes->miniCssSet('css/plugin',$config['debug-style']);
    if($config['cart']['check']==true){
        $themes_css .= $themes->miniCssSet('css/cart',$config['debug-style']);
    }
    
    /*$themes_css = $themes->cssSet('setcss','all',$config['debug-style']);
    $themes_css .= $themes->cssSet('setcss','reset',$config['debug-style']);
    $themes_css .= $themes->cssSet('setcss','animate',$config['debug-style']);
    $themes_css .= $themes->cssSet('setcss','use.awesome',$config['debug-style']);
    if($_SESSION['signin'] && $config['login']['check']==true && $config['cart']['check']==true){
        $themes_css .= $themes->cssSet('setcss','jquery.dataTables.min',$config['debug-style']);
    }
    $themes_css .= $themes->cssSet('setcss','style',$config['debug-style']);
    $themes_css .= $themes->cssSet('setcss','plugin',$config['debug-style']);
    if($config['other']['quickview']==true){
        $links_css .= $themes->cssSet('setcss','quickview',$config['debug-style']);
    }
    if($config['cart']['check']==true){
        $links_css .= $themes->cssSet('setcss','cart',$config['debug-style']);
    }
     
    $links_css .= $themes->cssLayout('popup','type1',$config['debug-style']);
    if($config['login']['check']==true){
        $links_css .= $themes->cssSet('setcss','account',$config['debug-style']);
    }*/
?>