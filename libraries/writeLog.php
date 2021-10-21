<?php
    /**
     * Application Main Page That Will Serve All Requests
     * @package PRO CODE BMWEB FRAMEWORK
     * @author  AP CAO
     * @version 1.0.0
     * @license https://bmweb.vn
     * @PHP >=5.6
     */
    class writeLog {
        private $path;
        private $browserAgent;
        private $ipAgent;

        public function __construct($path) {
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $this->browserAgent = $_SERVER['HTTP_USER_AGENT'];
            $this->ipAgent = $this->browserAgent;
            $this->path = $path;
        }
        
        public function write($message) {
            $date = new DateTime();
            $log = $this->path . $date->format('Y-m-d').".txt";
            if(is_dir($this->path)) {
                if(!file_exists($log)) {
                    $fh  = fopen($log, 'a+') or die("Fatal Error !");
                    $logcontent = $date->format('c') . ' - ' . $message . ' - ' . $this->getClientIp() . ' - ' .$this->ipAgent ."\r\n\r\n";
                    fwrite($fh, $logcontent);
                    fclose($fh);
                } else {
                    $this->edit($log,$date, $message);
                }
            }else {
                if(mkdir($this->path,0777) === true){
                    $this->write($message);  
                }	
            }
        }
        
        private function edit($log,$date,$message) {
            $logcontent = $date->format('c'). " - " . $message . ' - ' . $this->browserAgent ."\r\n\r\n";
            $logcontent = $logcontent . file_get_contents($log);
            file_put_contents($log, $logcontent);
        }
        private function getClientIp() {
            $ipaddress = '';
            if (isset($_SERVER['HTTP_CLIENT_IP']))
                $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
            else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
                $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else if(isset($_SERVER['HTTP_X_FORWARDED']))
                $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
            else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
                $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
            else if(isset($_SERVER['HTTP_FORWARDED']))
                $ipaddress = $_SERVER['HTTP_FORWARDED'];
            else if(isset($_SERVER['REMOTE_ADDR']))
                $ipaddress = $_SERVER['REMOTE_ADDR'];
            else
                $ipaddress = 'UNKNOWN';
            return $ipaddress;
        }
    }
?>