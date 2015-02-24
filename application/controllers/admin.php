<?php

class Admin extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library('template');
        $this->load->helper('url'); 
    }
    
    public function index(){
        $path = array();
        
        $segments = array('main');
        $home_url = site_url($segments);
        $path[] = array('Kodu', $home_url);
        
        $data['path'] = $path;
        $this->template->body('navigator', $data);
        
        if($this->auth->isLoggedIn()){
            
            $this->load->model(array('user_model', 'usergroup_model'));
            $usergroup = $this->usergroup_model->getActiveUserGroup();

            if($usergroup['addforum']){
                $this->load->model('forum_model');

                $this->load->helper('form');   
                $this->load->library('form_validation');
                if($this->input->post('form') == 'addforum'){
                    $this->form_validation->set_rules('p_fid', 'Vanem', 'required');
                    $this->form_validation->set_rules('name', 'Nimi', 'required');

                    if($this->form_validation->run() == FALSE){
                    }else{
                        $p_fid = $this->input->post('p_fid');
                        $data = array(
                            'p_fid' => ($p_fid == 'null' ? null : $p_fid),
                            'name' => $this->input->post('name'),
                            'uid' => $this->auth->getUserId()
                        );
                        $this->forum_model->addForum($data);
                        echo 'Foorum '.$data['name'].' lisatud!<br>';
                    } 
                }else{

                }
                if($this->input->post('form') == 'delforum'){
                    $this->form_validation->set_rules('fid', 'Foorum', 'required');

                    if($this->form_validation->run() == FALSE){
                    }else{
                        $fid = $this->input->post('fid');
                        $forum = $this->forum_model->getForum($fid);
                        
                        $this->forum_model->delForum($fid);
                        echo 'Foorum '.$forum['name'].' kustutatud!<br>';
                    } 
                }else{

                }

                $data['forums'] = $this->forum_model->getForums();

                $this->template->body('forms/addforum_form', $data); 
                $this->template->body('forms/delforum_form', $data); 
            }else{
                echo 'Sul pole õigusi, et foorumeid lisada!';
            }
            
        }
        
        $this->template->load('default', array('title' => "Näide")); 
    }
    
    
}