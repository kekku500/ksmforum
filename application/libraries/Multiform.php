<?php

class Multiform{
    
    private $ci;
    
    public function __construct() {
        $this->ci =& get_instance(); 
    }

    function validation_errors($form){
        if($this->ci->input->post('form') == $form)
            return validation_errors();
    }

    function form_open($form, $url){
        return form_open($url).'<input type="hidden" name="form" value="'.$form.'" />';
    }
    
    function is_form($form){
        return $this->ci->input->post('form') == $form;
    }
    
}
