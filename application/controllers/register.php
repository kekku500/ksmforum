<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of register
 *
 * @author Kevin
 */
class Register extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library('template');
        
    }
    
    public function index(){
        $this->load->helper(array('form', 'url'));
	$this->load->library('form_validation');
        
        $this->form_validation->set_rules('user', 'Kasutajanimi', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('pass', 'Salasõna', 'required');
        $this->form_validation->set_rules('passconf', 'Salasõna kontroll', 'required');
        
        if($this->form_validation->run() == FALSE){
            $this->template->body('forms/register_form' /*, $data*/);
        }else{  
            $this->load->model('user_model');
            $this->load->library('auth');
            
            $user = $this->input->post('user');
            $email = $this->input->post('email');
            $pass = $this->input->post('pass');
            
            $userdata = array(
                'name' => $user,
                'email' => $email,
                'pass' => $pass
            );
            $this->user_model->adduser($userdata);
            
            $userid = $this->user_model->attemptLogin($user, $pass);

            if(!$userid){
              echo 'wtf';
            }else{
              $this->auth->login($userid);
              redirect(base_url());
            }
 
        }  

        $this->template->load('default', array('title' => "Näide"));
    }
    
    
}
    