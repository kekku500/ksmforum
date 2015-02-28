<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Multiform {
    
    private $ci;
    
    private $form;
    
    public function __construct() {
        $this->ci =& get_instance(); 
    }
    
    function setForm($form){
        $this->form = $form;
    }
    
    function getForm(){
        return $this->form;
    }

    /*function validation_errors($form){
        if($this->ci->input->post('form') == $form)
            return validation_errors();
    }*/
    
    function validation_errors(){
        if($this->ci->input->post('form') == $this->form)
            return validation_errors();
    }
    
    function form_error($field){
        if($this->ci->input->post('form') == $this->form)
            return form_error($field);
    }

    /*function form_open($form, $url){
        return form_open($url).'<input type="hidden" name="form" value="'.$form.'" />';
    }*/
    
    function form_open($url){
        return form_open($url).'<input type="hidden" name="form" value="'.$this->form.'" />';
    }
    
    function is_form($form){
        return $this->ci->input->post('form') == $form;
    }
    
}
