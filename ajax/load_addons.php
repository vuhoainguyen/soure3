<?php 
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @author  AP CAO
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */
	require_once 'config.php';
	$row_setting = $d->rawQueryOne("select map_frame from #_settings limit 0,1");
	$url = htmlspecialchars($_GET['url']);
	$width = htmlspecialchars($_GET["width"]);
	$height = htmlspecialchars($_GET["height"]);
	$type = htmlspecialchars($_GET["type"]);
	switch ($type) {
		case 'youtube':
			$html = '<div class="video-container">
			    <iframe id="iframe-video" src="https://www.youtube.com/embed/'.$url.'?rel=0&amp;autoplay=0&amp;wmode=transparent" allowfullscreen frameborder="0" width="'.$width.'" height="'.$height.'"></iframe>
			</div>';
			echo $html;
			break;
		case 'maps':
			$html = htmlspecialchars_decode($row_setting['map_frame']);
			echo $html;
			break;
		default:
			break;
	}
?>