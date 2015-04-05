<?php

class Ajax extends CI_Controller {
    

    public function __construct() {
        parent::__construct();

        $this->load->model('post_model');
        $this->load->helper('url'); 
        $this->lang->load('forum');
    }
    
    /**
     * Annab xml dokumendi
     * @param type $tid
     * @param type $page
     * @param type $root_post_id
     * @param type $offset
     * @param type $extradepth
     * @param type $prev_url
     */
    public function posts_content($tid, $page, $root_post_id, $offset, $extradepth, $prev_url){
        header('Content-Type: application/xml; charset=utf-8'); //output xml
        
        $data['response_disabled'] = false;      
        $data['posts'] = $this->post_model->getPostsPaginated($root_post_id, $page, $offset);
        $data['topic']['id'] = $tid;
        $data['extradepth'] = $extradepth;
        $data['cur_url_encoded'] = $prev_url;
        $reply_count = $this->post_model->getPostReplyCount($root_post_id);
        $data['next_page_valid'] = ($offset+$this->config->item('max_post_count')*$page < $reply_count);
        $data['cur_page'] = $page;
        $data['topic_root_post_id'] = $this->post_model->getRootPost($tid)['post_id'];
        $data['page_offset'] = $offset;
        $this->load->view('topic/posts_xml', $data);   
    }
    
    
}
