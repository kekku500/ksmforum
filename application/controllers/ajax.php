<?php

class Ajax extends CI_Controller {
    

    public function __construct() {
        parent::__construct();

        $this->load->model('post_model');
        $this->load->helper('url'); 
    }
    
    public function posts_content($tid, $page, $root_post_id, $offset = 0){
        $data['response_disabled'] = false;      
        $data['posts'] = $this->post_model->getPostsPaginated($root_post_id, $page, $offset);
        $data['topic']['id'] = $tid;
        $this->load->view('topic/posts_subset_view', $data);
        
        $reply_count = $this->post_model->getPostReplyCount($root_post_id);
 
        $data['next_page_valid'] = ($offset+$this->config->item('max_post_count')*$page < $reply_count);
        $data['root_post'] = array('post_id' => $root_post_id);
        $data['cur_page'] = $page;
        
        $data['topic']['id'] = $tid;
        $data['topic_root_post_id'] = $this->post_model->getRootPost($tid)['post_id'];
        $data['page_offset'] = $offset;
        $this->load->view('topic/posts_bot_nav', $data);
    }
    
    
}
