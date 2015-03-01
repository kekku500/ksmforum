<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


class Auth{
    
    private $CI;
    
    public function __construct() {
        $this->CI =& get_instance();
    }

    function isLoggedIn(){
      if(!$this->CI->session->userdata('user_id'))
          return false;
      return true;
    }
    
    function login($userid){
        $this->CI->user_model->bindSessionToUser($userid);
        
        $this->CI->session->set_userdata('user_id', $userid);
    }
    
    function logout(){
        if($this->CI->googleoauth2->hasAccessToken())
            $this->CI->googleoauth2->destroyAccessToken();
        
        $this->CI->user_model->unbindSessionFromUser($this->getUserId());
        
        $this->CI->session->unset_userdata('user_id');
    }
    
    function getUserId(){
        return $this->CI->session->userdata('user_id');
    }
    
}
