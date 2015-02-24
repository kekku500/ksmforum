<?php

class Auth{
    
    private $ci;
    
    public function __construct() {
        $this->ci =& get_instance();
    }

    function isLoggedIn(){
      if(!$this->ci->session->userdata('user_id'))
          return false;
      return true;
    }
    
    function login($userid){
        $this->ci->session->set_userdata('user_id', $userid);
    }
    
    function logout(){
        $this->ci->session->unset_userdata('user_id');
    }
    
    function getUserId(){
        return $this->ci->session->userdata('user_id');
    }
    
}
