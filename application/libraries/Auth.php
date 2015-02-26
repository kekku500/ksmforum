<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


class Auth{
    
    private $ci;
    
    private $loggedout = false;
    
    public function __construct() {
        $this->ci =& get_instance();
    }

    function isLoggedIn(){
      if(!$this->ci->session->userdata('user_id'))
          return false;
      return true;
    }
    
    function justLoggedOut(){
        return $this->loggedout;
    }
    
    function login($userid){
        $this->ci->session->set_userdata('user_id', $userid);
    }
    
    function logout(){
        $this->ci->session->unset_userdata('user_id');
        $this->loggedout = true;
    }
    
    function getUserId(){
        return $this->ci->session->userdata('user_id');
    }
    
}
