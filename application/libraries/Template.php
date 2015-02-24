<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

//Ümbris controllerile
class Template extends CI_Loader{
    
    private $ci;
    
    private $js_files = array();
    private $css_files = array();
    
    private $scripts;
    private $body;
    
    private $prebody_calls = array();
    private $postbody;
    
    function __construct() {
        $this->ci =& get_instance();

        $this->addJS('assets/js/jquery-1.11.2.min.js');
    }
    
    function body($view, $vars = array()){
        $this->body .= $this->ci->load->view($view, $vars, true);
    }
    
    function prebody($view, $vars = array()){
        $this->prebody_calls[] = array($view, $vars);
    }
    
   function postbody($view, $vars = array()){
        $this->postbody .= $this->ci->load->view($view, $vars, true);
    }
    
    function load($template, $vars = array()){
        $this->load_JS_and_CSS();
        
        $vars['body'] = '';
        
        foreach($this->prebody_calls as $prebody)
            $vars['body'] .= $this->ci->load->view($prebody[0], $prebody[1], true);
        $vars['body'] .= $this->body;
        $vars['body'] .= $this->postbody;
        
        $vars['scripts'] = $this->scripts;
        
        return $this->ci->load->view('templates/'.$template, $vars);
    }
    
    
    function addJS($name){
        $this->js_files[] = $name;
    }
    
    function addCSS($name){
        $this->css_files[] = $name;
    }
    
    private function load_JS_and_CSS(){
        $this->ci->load->helper('html', 'url');
        
        foreach ($this->js_files as $js){
            $this->scripts .= '<script type="text/javascript" src="'.base_url($js).'"></script>';
        }
        foreach ($this->css_files as $css){
            $this->scripts .= link_tag($css);
        }
        
    }
    
}
