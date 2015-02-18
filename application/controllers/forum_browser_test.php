<?php


class Forum_Browser_Test extends CI_Controller {
    
    public function index(){
        $this->load->helper('url');
        
        $this->load->model('category_model');
        $this->load->model('forum_model');
        
        $categories = $this->category_model->get_categories();
        
        foreach($categories as $category_item){
            $data['name'] = $category_item['name'];
            $this->load->view('category_header', $data);
            $data['forums'] = $this->forum_model->get_forums_by_category($category_item['id']);
            $this->load->view('forums_view', $data);
        }    
    }
    
    public function forums($fid){
        $this->load->helper('url');
        
        $this->load->model('forum_model');
        
        $data['forums'] = $this->forum_model->get_forums_by_parent($fid);
        $this->load->view('forums_view', $data);
    }
    
}
