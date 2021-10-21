<?php
class paginations {
	public $perpage;
	
	function __construct() {
		$this->perpage = 1;
	}
	
	function getAllPageLinks($count,$href,$elShow) {
		$output = '';
		if(!isset($_GET["p"])) $_GET["p"] = 1;
		if($this->perpage != 0)
			$pages  = ceil($count/$this->perpage);
		if($pages>1) {
			if($_GET["p"] == 1) 
				$output = $output . '<span class="link first disabled">Đầu</span><span class="link disabled">Trước</span>';
			else	
				$output = $output . '<a class="link first" onclick="getResult(\'' . $href . (1) . '\',\''.$elShow.'\')" >Đầu</a><a class="link" onclick="getResult(\'' . $href . ($_GET["p"]-1) . '\',\''.$elShow.'\')" >Trước</a>';
			
			
			if(($_GET["p"]-3)>0) {
				if($_GET["p"] == 1)
					$output = $output . '<span id=1 class="link current">1</span>';
				else				
					$output = $output . '<a class="link" onclick="getResult(\'' . $href . '1\',\''.$elShow.'\')" >1</a>';
			}
			if(($_GET["p"]-3)>1) {
					$output = $output . '<span class="dot">...</span>';
			}
			
			for($i=($_GET["p"]-2); $i<=($_GET["p"]+2); $i++)	{
				if($i<1) continue;
				if($i>$pages) break;
				if($_GET["p"] == $i)
					$output = $output . '<span id='.$i.' class="link current">'.$i.'</span>';
				else				
					$output = $output . '<a class="link" onclick="getResult(\'' . $href . $i . '\',\''.$elShow.'\')" >'.$i.'</a>';
			}
			
			if(($pages-($_GET["p"]+2))>1) {
				$output = $output . '<span class="dot">...</span>';
			}
			if(($pages-($_GET["p"]+2))>0) {
				if($_GET["p"] == $pages)
					$output = $output . '<span id=' . ($pages) .' class="link current">' . ($pages) .'</span>';
				else				
					$output = $output . '<a class="link" onclick="getResult(\'' . $href .  ($pages) .'\',\''.$elShow.'\')" >' . ($pages) .'</a>';
			}
			
			if($_GET["p"] < $pages)
				$output = $output . '<a  class="link" onclick="getResult(\'' . $href . ($_GET["p"]+1) . '\',\''.$elShow.'\')" >Sau</a><a  class="link" onclick="getResult(\'' . $href . ($pages) . '\',\''.$elShow.'\')" >Cuối</a>';
			else				
				$output = $output . '<span class="link disabled">Sau</span><span class="link disabled">Cuối</span>';
			
			
		}
		return $output;
	}
	function getPrevNext($count,$href,$elShow) {
		$output = '';
		if(!isset($_GET["p"])) $_GET["p"] = 1;
		if($this->perpage != 0)
			$pages  = ceil($count/$this->perpage);
		if($pages>1) {
			if($_GET["p"] == 1) 
				$output = $output . '<span class="link disabled first">Prev</span>';
			else	
				$output = $output . '<a class="link first" onclick="getResult(\'' . $href . ($_GET["p"]-1) . '\',\''.$elShow.'\')" >Prev</a>';			
			
			if($_GET["p"] < $pages)
				$output = $output . '<a  class="link" onclick="getResult(\'' . $href . ($_GET["p"]+1) . '\',\''.$elShow.'\')" >Next</a>';
			else				
				$output = $output . '<span class="link disabled">Next</span>';
			
			
		}
		return $output;
	}
}
?>