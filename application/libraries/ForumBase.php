<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

//Ümbris controllerile
class ForumBase {
    
    private $ci;
    

    function __construct() {
       $this->ci =& get_instance();

       $this->ci->load->library('template');
    }
    

    
}
