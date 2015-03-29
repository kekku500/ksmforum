<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


class SpamBlocker{
    
    private $CI;
    
    public function __construct() {
        $this->CI =& get_instance();
    }
    
    function check($id, $time, $interval){
        if($this->CI->session->userdata('spamblock_'.$id) != false &&
                $this->CI->session->userdata('spamblock_'.$id)+$interval >= $time){
            exit('spamblock');
        }
        
        $this->CI->session->set_userdata('spamblock_'.$id, $time);
    }
    
}
