<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


class Template{
    
    private $ci;
    
    private $js_files = array();
    private $css_files = array();
    private $css_ns_files = array();
    
    private $scripts;
    private $body;
    
    private $prebody;
    private $postbody;
    
    private $loadvars = array(
        'title' => 'Tiitel');
    
    function __construct() {
        $this->ci =& get_instance();
    }
    
    function setTitle($title){
        $this->loadvars['title'] = $title;
    }
    
    function body($view, $vars = array(), $processed = false){
        if($processed)
            $this->body .= $view;
        else
            $this->body .= $this->ci->load->view($view, $vars, true);
    }
    
    function prebody($view, $vars = array()){
        $this->prebody .= $this->ci->load->view($view, $vars, true);
    }
    
   function postbody($view, $vars = array()){
        $this->postbody .= $this->ci->load->view($view, $vars, true);
   }
    
    function load($template, $vars = array()){
        if(count($vars) == 0)
            $vars = $this->loadvars;
        
        $this->load_JS_and_CSS();
        
        $vars['body'] = '';
        
        $vars['body'] .= $this->prebody;
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
    
    function addCSS_Noscript($name){
        $this->css_ns_files[] = $name;
    }
    
    private function load_JS_and_CSS(){
        $this->ci->load->helper('html', 'url');
        

        
        foreach ($this->js_files as $js){
            $this->scripts .= '<script async type="text/javascript" src="'.base_url($js).'"></script>';
        }
        
        
        
        foreach ($this->css_files as $css){
            $this->scripts .= link_tag($css);
        }
        
        
        
       
        foreach ($this->css_ns_files as $css){
            $this->scripts .= '<noscript>'.link_tag($css).'</noscript>';
        }
        
        
        
    }
    
}
