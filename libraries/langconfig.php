<?php 
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @author  AP CAO
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */
	class langConfig
	{
		public function __construct($config,$db,$func,$attr)
		{
			$this->config = $config;
			$this->db = $db;
			$this->func = $func;
			$this->attr = $attr;
		}
		public function initLang(){
			foreach ($this->config['website']['lang'] as $key => $value) {
				$lang = $key;
				for ($i=0,$c=count($this->attr); $i < $c; $i++) { 
					$table = $this->attr[$i]['name'];
					for ($j=0,$cc=count($this->attr[$i]['value']); $j < $cc; $j++) { 
						$column  = $this->attr[$i]['value'][$j]['name'];
						$type = $this->attr[$i]['value'][$j]['type'];
						$row = $this->db->rawQueryOne("SHOW COLUMNS FROM table_".$table." LIKE '".$column."_".$lang."'");
						if($row==null){
							$this->db->rawQuery("ALTER TABLE table_".$table." ADD ".$column."_".$lang." $type CHARACTER SET utf8 COLLATE utf8_unicode_ci ");
						}
					}
				}
			}
		}
		public function deleteLang($lang = 'ci'){
			for ($i=0; $i < count($this->attr); $i++) { 
				$table = $this->attr[$i]['name'];
				for ($j=0; $j < count($this->attr[$i]['value']); $j++) { 
					$column  = $this->attr[$i]['value'][$j]['name'];
					$row = $this->db->rawQueryOne("SHOW COLUMNS FROM table_".$table." LIKE '".$column."_".$lang."'");
					if($row!=null){
						$this->db->rawQuery("ALTER TABLE table_$table DROP ".$column."_".$lang);
					}
				}
			}
		}
	}
?>