<?php 
    /**
     * Application Main Page That Will Serve All Requests
     * @package PRO CODE BMWEB FRAMEWORK
     * @author  AP CAO
     * @version 1.0.0
     * @license https://bmweb.vn
     * @PHP >=5.6
     */
    class statistic{
        private $db;
        public function __construct($db)
        {
            $this->db = $db;
            $this->counterOn();
        }
        
        public function counterOn(){         
            $locktime        =  15; 
            $initialvalue    =    1; 
            $records        =    10000000; 
            $locktime        =    $locktime * 60;
            $now             =    time(); 
            $ip                 =    ($this->get_ip()=='::1') ? '127.0.0.1':$this->get_ip(); 
            $t = $this->db->rawQueryOne("SELECT MAX(id) AS total FROM #_counters");
            $all_visitors     =    $t['total']; 
            if ($all_visitors !== NULL) { 
                $all_visitors += $initialvalue; 
            } else { 
                $all_visitors = $initialvalue; 
            } 
            $temp = $all_visitors - $records; 
            if ($temp>0){
                $this->db->rawQuery("DELETE FROM #_counters WHERE id<?",array($temp));
            }
            $nation = $this->get_nation();
            $trinhduyet = $this->get_browser_name();
            $dentu =  $this->get_fromto();
            $web =  $this->get_web();
            $thietbi = $this->get_device();
            $hdh = $this->get_hdh();
            $hdh2 = $this->get_hdh2();
            
            $pr1 = array($ip,$locktime,$now);
            $vip  =  $this->db->rawQueryOne("SELECT COUNT(*) AS visitip FROM #_counters WHERE ip=? AND (tm+?)>?", $pr1);
            $items  =    $vip['visitip']; 
            if (empty($items)) { 
                $data = array("tm" => $now, "ip" => $ip, "browser" => $trinhduyet, "fromto" => $dentu, "nation" => $nation, "device" => $thietbi, "osdetail" => $hdh, "website" => $web, 'dateupdate' => $this->db->now(), "os" => $hdh2, "type" => 'online');
                $this->db->insert('counters', $data);
            } else {
                $this->db->rawQuery("UPDATE #_counters SET pageview = pageview+1 WHERE ip=? AND (tm+?)>?", array($ip,$locktime,$now)); 
            } 
        }
        public function countOnline(){
            $time = 600; 
            $ssid = session_id();
            $sql = "delete from #_onlines where time<".(time()-$time);
            $this->db->rawQuery($sql);
            $sql = "select id,session_id from #_onlines order by id desc";
            $rows = $this->db->rawQuery($sql);
            $result['dangxem'] = count($rows);
            $i = 0;
            while(($rows[$i]['session_id'] != $ssid) && $i++<$result['dangxem']);
            
            if($i<$result['dangxem']){
                $sql = "update #_onlines set time='".time()."' where session_id='".$ssid."'";
                $this->db->rawQuery($sql);
                $result['daxem'] = $rows[0]['id'];
            }
            else{
                $data['session_id'] = $ssid;
                $data['time'] = time();
                $id_insert = $this->db->insert('onlines', $data);
                $result['daxem'] = $id_insert;
                $result['dangxem']++;
            }
            
            return $result;
        }
        public function getCounter(){
            $day             =    date('d'); 
            $month             =    date('n'); 
            $year             =    date('Y'); 
            $daystart         =    mktime(0,0,0,$month,$day,$year); 
            $yesterdaystart     =    $daystart - 86400; 
            $monthstart         =  mktime(0,0,0,$month,1,$year);
            $weekday         =    date('w'); 
            $weekday--; 
            if ($weekday < 0)    $weekday = 7; 
            $weekday         =    $weekday * 24*60*60; 
            $weekstart         =    $daystart - $weekday; 
           
            $todayrc  =  $this->db->rawQueryOne("SELECT COUNT(*) AS todayrecord FROM #_counters WHERE tm>?",array($daystart));
            $result['today']     =    $todayrc['todayrecord'];
            $yesrec  =  $this->db->rawQueryOne("SELECT COUNT(*) AS yesterdayrec FROM #_counters WHERE tm>? and tm<?", array($yesterdaystart,$daystart));
            $result['yesterday']     =    $yesrec['yesterdayrec']; 
            $weekrec  =  $this->db->rawQueryOne("SELECT COUNT(*) AS weekrec FROM #_counters WHERE tm>=?",array($weekstart));
            $result['week']     =    $weekrec['weekrec']; 
            $monthrec  =  $this->db->rawQueryOne("SELECT COUNT(*) AS monthrec FROM #_counters WHERE tm>=?",array($monthstart)); 
            $result['month']     =    $monthrec['monthrec'];  
            $t  =  $this->db->rawQueryOne("SELECT MAX(id) AS total FROM #_counters ");
            $all_visitors     =    $t['total']; 
            $result['totalaccess'] =  $all_visitors;
            return $result;
        }
    
        public function get_ip(){
            if (isset($_SERVER['HTTP_CLIENT_IP'])){
                $real_ip_adress = $_SERVER['HTTP_CLIENT_IP'];
            }
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $real_ip_adress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }else{
                $real_ip_adress = $_SERVER['REMOTE_ADDR'];
            }
            return $real_ip_adress;
        }
    
        public function get_nation(){
            $ip = $this->get_ip();
            $iptolocation = 'https://ipinfo.io/'.$ip.'/country';
            if($_SERVER['SERVER_NAME']!='localhost'){
                return $creatorlocation = file_get_contents($iptolocation);
            }else{
                return 'Viet Nam';
            }
        }
    
        public function get_browser_name()
        {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
            elseif (strpos($user_agent, 'Edge')) return 'Edge';
            elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
            elseif (strpos($user_agent, 'Safari')) return 'Safari';
            elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
            elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';
            return 'Other';
        }
    
        public function get_fromto(){
            $form = $_SERVER['HTTP_REFERER'];
            if($form!=''){
                $form = explode('//',$form);
                $form = explode('/',$form[1]);
                $domain = $_SERVER["SERVER_NAME"];
                if($form[0]!=$domain){
                    return $form[0];
                } else {
                    return 'localhost';
                }
            }else{
                return 'localhost';
            }
        }
        public function get_web(){
            $web = $this->get_fromto();
            if($web){
                $catchuoi = explode('.',$web);
                if($catchuoi[0]=='m' || $catchuoi[0]=='www'){
                    return $catchuoi[1];
                } else {
                    return $catchuoi[0];
                }
            }else{
                return 'Viet Nam';
            }
        }
    
        public function get_device(){
            $detect = new MobileDetect;
            if($detect->isMobile()){
                if ($detect->isTablet()){
                    return "Tablet";
                }else{
                    return "Phone";    
                }  
            }else{
                return "Computer";
            }
        }
    
        public function get_hdh(){
            $result = 'Other';
            $os = array(
                '/windows nt 10.0/i' => 'Windows 10',
                '/windows nt 6.3/i' => 'Windows 8.1',
                '/windows nt 6.2/i' => 'Windows 8',
                '/windows nt 6.1/i' => 'Windows 7',
                '/windows nt 6.0/i' => 'Windows Vista',
                '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
                '/windows nt 5.1/i' => 'Windows XP',
                '/windows xp/i' => 'Windows XP',
                '/windows nt 5.0/i' => 'Windows 2000',
                '/windows me/i' => 'Windows ME',
                '/win98/i' => 'Windows 98',
                '/win95/i' => 'Windows 95',
                '/win16/i' => 'Windows 3.11',
                '/macintosh|mac os x/i' => 'Mac OS X',
                '/mac_powerpc/i' => 'Mac OS 9',
                '/linux/i' => 'Linux',
                '/ubuntu/i' => 'Ubuntu',
                '/iphone/i' => 'iPhone',
                '/ipod/i' => 'iPod',
                '/ipad/i' => 'iPad',
                '/android/i' => 'Android',
                '/blackberry/i' => 'BlackBerry',
                '/webos/i' => 'Mobile'
            );
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            foreach($os as $regex => $value) {
                if(preg_match($regex, $user_agent)) {
                    $result = $value;
                    break;
                }
            }
            return $result;
        }
    
        public function get_hdh2(){
            $result = 'Other';
            $os = array(
                '/windows nt 10.0/i' => 'Windows',
                '/windows nt 6.3/i' => 'Windows',
                '/windows nt 6.2/i' => 'Windows',
                '/windows nt 6.1/i' => 'Windows',
                '/windows nt 6.0/i' => 'Windows',
                '/windows nt 5.2/i' => 'Windows',
                '/windows nt 5.1/i' => 'Windows',
                '/windows xp/i' => 'Windows',
                '/windows nt 5.0/i' => 'Windows',
                '/windows me/i' => 'Windows',
                '/win98/i' => 'Windows',
                '/win95/i' => 'Windows',
                '/win16/i' => 'Windows',
                '/macintosh|mac os x/i' => 'Mac OS',
                '/mac_powerpc/i' => 'Mac OS',
                '/linux/i' => 'Linux',
                '/ubuntu/i' => 'Linux',
                '/iphone/i' => 'IOS',
                '/ipod/i' => 'IOS',
                '/ipad/i' => 'IOS',
                '/android/i' => 'Android',
                '/blackberry/i' => 'BlackBerry',
                '/webos/i' => 'Mobile'
            );
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            foreach($os as $regex => $value) {
                if(preg_match($regex, $user_agent)) {
                    $result = $value;
                    break;
                }
            }
            return $result;
        }
    }
?>