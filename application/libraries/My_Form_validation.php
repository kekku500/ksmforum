<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {
    
    function __construct($config = array()){
      parent::__construct($config);
    }
    
    function error_count(){
        return count($this->_error_array);
    }
    
	/**
	 * Match one field to another
	 *
	 * @access	public
	 * @param	string
	 * @param	field
	 * @return	bool
	 */
	public function mismatches($str, $field){
		return !parent::matches($str, $field);
	}
    

    
}
