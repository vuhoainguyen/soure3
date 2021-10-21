<?php 
/**
 * Application Main Page That Will Serve All Requests
 * @package PRO CODE BMWEB FRAMEWORK
 * @author  AP CAO
 * @version 1.0.0
 * @license https://bmweb.vn
 * @PHP >=5.6
 */
class themes{
    public function miniCssSet($link_css,$link=false){
        if($link==true){
            $link_css = $link_css.".css";
            return '<link href="'.$link_css.'" rel="stylesheet">';
        }else{
            $link_css = _root."/".$link_css.".css";
            $myfile = fopen($link_css, "r") or die("Unable to open file!");
            if(filesize($link_css)!=0){
                return self::compress(fread($myfile,filesize($link_css)));
            }
        }
    }
    public function cssSet($folder,$type,$link=false){
        if($link==true){
            $link_css = "themes/".$folder."/".$type.".css";
            return '<link href="'.$link_css.'" rel="stylesheet">';
        }else{
            $link_css = _root."/themes/".$folder."/".$type.".css";
            $myfile = fopen($link_css, "r") or die("Unable to open file!");
            if(filesize($link_css)!=0){
                return self::compress(fread($myfile,filesize($link_css)));
            }
        }
    }
    public function cssLayout($folder,$type,$link=false){
        if($link==true){
            $link_css = "themes/".$folder."/".$type."/style.css?v=".time();
            return '<link href="'.$link_css.'" rel="stylesheet">';
        }else{
            $link_css = _root."/themes/".$folder."/".$type."/style.css";
            $myfile = fopen($link_css, "r") or die("Unable to open file!");
            if(filesize($link_css)!=0){
                return self::compress(fread($myfile,filesize($link_css)));
            }
        }
    }

    public function html($folder,$layout){
        global $d,$func,$lang,$row_setting,$config,$config_base,$title,$apiCart,$counter,$type,$source;
    	include _root."/themes/".$folder."/".$layout."/index.php";
    }
    static public function compress($buffer){
    	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
		$buffer = str_replace(': ', ':', $buffer);
		$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
		return $buffer;
    }
    static public function addcss($url){
        $link_css = $url;
        $myfile = fopen($link_css, "r") or die("Unable to open file!");
        return self::compress(fread($myfile,filesize($link_css)));
    }
}
?>