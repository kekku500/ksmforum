<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {
    
    function __construct($config = array()){
      parent::__construct($config);
    }
    
    function error_count(){
        return count($this->_error_array);
    }
    

    
}
