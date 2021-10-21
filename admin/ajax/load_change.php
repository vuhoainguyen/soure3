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

	$id = (int)$_POST['val'];
	$table = htmlspecialchars($_POST['table']);
	$type = htmlspecialchars($_POST['type']);
	$field_change = htmlspecialchars($_POST['field_change']);
	if($type!='null'){
		$param_change = array($type,$id);
		if($id){
			if($table == 'cats'){
				$title = 'Chọn danh mục cấp 2';
			}
			if($table == 'items'){
				$title = 'Chọn danh mục cấp 3';
			}
			if($table == 'subs'){
				$title = 'Chọn danh mục cấp 4';
			}
			$resp = $d->rawQuery("SELECT name_vi,id from #_$table where type=? and $field_change=? order by id desc",$param_change);
		}
	}else{
		if($table == 'place_dists'){
			$title = 'Chọn quận / huyện';
		}
		$param_change = array($id);
		$resp = $d->rawQuery("SELECT name_vi,id from #_$table where $field_change=? order by id desc",$param_change);
	}
	
?>
<option value="0"><?=$title?></option>
<?php for($i=0;$i<count($resp);$i++){ ?>
<option value="<?=$resp[$i]['id']?>"><?=$resp[$i]['name_vi']?></option>
<?php } ?>