<?php
    /**
     * Application Main Page That Will Serve All Requests
     * @package PRO CODE BMWEB FRAMEWORK
     * @author  AP CAO
     * @version 1.0.0
     * @license https://bmweb.vn
     * @PHP >=5.6
     */
    class autoload{
        public function __construct()
        {
            spl_autoload_register(array($this,'_autoload'));
        }
        private function _autoload($file){
            $file = _lib.str_replace("\\","/",trim($file,'\\')).'.php';

            if(file_exists($file)){
                require_once $file;
            }
        }
    }
?>