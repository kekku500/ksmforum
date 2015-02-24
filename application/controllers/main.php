<?php
// Foorumis ringi liikumiseks
class Main extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library('template');
        $this->load->model(array('topic_model', 'post_model', 'forum_model', 'user_model', 'usergroup_model'));
        $this->load->helper('url'); 
        
        $this->check_login(); 
        
        $this->user_controls();
    }
    
    private function user_controls(){
        if($this->auth->isLoggedIn())
            $userinfo['user'] = $this->user_model->getUser($this->auth->getUserId());
        $this->template->prebody('auth_header', (isset($userinfo) ? $userinfo : array()));
        if(!$this->auth->isLoggedIn())
            $this->template->prebody('forms/login_form');  
    }
    
    private function end(){
        $this->template->load('default', array('title' => "Näide")); 
    }
    
    //kutsu veel end() lõpus
    public function _remap($method, $params = array()){
        if (method_exists($this, $method)){
            $ret = call_user_func_array(array($this, $method), $params);
            $this->end();
            return $ret;
        }
        show_404();
    }
    
    private function check_login(){  
        if($this->auth->isLoggedIn()){
            return;
        }
        
        $this->load->helper('form');   
        $this->load->library('form_validation');
        
        if($this->input->post('form') == 'login'){
            $this->form_validation->set_rules('user', 'Kasutajanimi', 'required');
            $this->form_validation->set_rules('pass', 'Salasõna', 'required');
        
            if($this->form_validation->run() == FALSE){
            }else{
                $this->load->model('user_model');
                $user = $this->input->post('user');
                $pass = $this->input->post('pass');

                $userid = $this->user_model->attemptLogin($user, $pass);

                if($userid){
                  $this->auth->login($userid);
                }
            }  
        }
    }
    

    
    public function logout($url){
        $this->auth->logout();
        
        redirect(base64_decode($url));
    }
    
    private function navigator($fid = null, $extra = null){
        $path = array();
        
        $segments = array('main');
        $home_url = site_url($segments);
        $path[] = array('Kodu', $home_url);
        
        if($fid != null){
            $forums = $this->forum_model->getPathToRootForum($fid);
            foreach($forums as $forum){
                $segments = array('main', 'forum', $forum['id']);
                $path[] = array($forum['name'], site_url($segments));
            }  
        }
        
        if($extra != null){
            foreach($extra as $e)
                $path[] = $e;
        }
        
        $data['path'] = $path;
        $this->template->body('navigator', $data);
    }
    
    public function index(){     
        $this->navigator();
        
        $this->rootforums();
        
        
    }
    

    
    private function rootforums(){
        $rootforums = $this->forum_model->getRootForums();
        foreach($rootforums as $row){
            $data['row'] = $row;

            $forums = $this->forum_model->getForumsByParent($row['id']);
            
            if(count($forums) > 0){
                $this->template->body('table/header', $data);
                
                foreach ($forums as $subrow){ 
                    $data['row'] = $subrow;

                    $segments = array('main', 'forum', $subrow['id']);
                    $data['row']['site_url'] = site_url($segments);

                    $this->template->body('table/row', $data);
                }  
                $data['row'] = $row;
                $this->template->body('table/footer', $data);
            }
        }
    }
    
    public function forum($fid){
        $forum = $this->forum_model->getForum($fid);
        $data['fid'] = $fid;
        

        
        $this->navigator($fid);
        
        //alamfoorumid
        $data['row']['name'] = $forum['name']." alamfoorumid";
        $this->template->body('table/header', $data);
        
        $subforums = $this->forum_model->getForumsByParent($fid);

        foreach ($subforums as $row){ 
            $data['row'] = $row;
            
            $segments = array('main', 'forum', $row['id']);
            $data['row']['site_url'] = site_url($segments);
            
            $this->template->body('table/row', $data);
        }  

        $data['row'] = $forum;
        $this->template->body('table/footer', $data);
        
        if($this->auth->isLoggedIn())
            $this->template->body('addtopic_anchor', $data);
        
        if($forum['p_fid'] != null){
            //teemad
            $data['row']['name'] = $forum['name']." teemad";
            $this->template->body('table/header', $data);
            
            
            $teemad = $this->topic_model->getTopics($fid);

            foreach ($teemad as $row){ 
                $segments = array('main', 'topic', $row['id']);
                $row['site_url'] = site_url($segments);
                $row['name'] = $this->security->xss_clean($row['name']);

                $data['row'] = $row;

                $this->template->body('table/row', $data);
            }  

            $data['row'] = $forum;
            $this->template->body('table/footer', $data);
        }

    }
    
    public function topic($tid){
        $this->load->model('user_model');        
        
        $topic = $this->topic_model->getTopic($tid);
        
        $this->navigator($topic['fid'], 
                array(
                    array($topic['name'], current_url())
                ));
        
                
        $data['topic'] = $this->topic_model->get_topic_name($tid);
        $data['topic'] = $this->security->xss_clean($data['topic']);

        $data['rows'] = $this->post_model->getPostsJoinUser($tid);

        $this->template->body('topic/topic_header', $data);
        foreach ($data['rows'] as $row_item){ 
           
            $row_item['content'] = $this->security->xss_clean($row_item['content']);
            $data['row_item'] = $row_item;
            $this->template->body('topic/topic_content', $data);
        }

    }
    
 
    public function addtopic($fid){
        $this->navigator($fid, 
                    array(
                        array('Lisa teema', current_url())
                    ));
        
        if($this->auth->isLoggedIn()){
            $this->load->helper('form');
            $this->load->library('form_validation');
            
            if($this->input->post('form') == 'addtopic'){
                $this->form_validation->set_rules('content', 'Sisu', 'required');
                $this->form_validation->set_rules('title', 'Pealkiri', 'required');

                if($this->form_validation->run() == FALSE){
                    $data['row_item'] =  $this->forum_model->getForum($fid);
                    $this->template->body('forms/addtopic_form', $data);
                }else{
                    $topicdata = array(
                        'fid' => $fid,
                        'name' => $this->input->post('title'),
                        'uid' => $this->auth->getUserId()
                    );
                    
                    $this->topic_model->addTopic($topicdata);

                    $tid = $this->db->insert_id();

                    $this->post_model->addPost($tid, 'null', $this->input->post('content'));

                    $segments = array('main', 'topic', $tid);

                    redirect(site_url($segments));
                } 
            }else{
                $data['row_item'] =  $this->forum_model->getForum($fid);
                $this->template->body('forms/addtopic_form', $data);  
            }
        }else{
            echo 'logi sesssse neegah';
        }

    }
    
    public function addpost($tid, $pid){
        $this->load->helper('form');
	$this->load->library('form_validation');
        
        $topic = $this->topic_model->getTopic($tid);
        $segments = array('main', 'topic', $topic['id']);
        $this->navigator($topic['fid'], 
            array(
                array($topic['name'], site_url($segments)),
                array('Lisa kommentaar', current_url())
            ));

        if($this->auth->isLoggedIn()){ 
            
            if($this->input->post('form') == 'addpost'){

                $this->form_validation->set_rules('content', 'Sisu', 'required');
                
                if($this->form_validation->run()){
                    $this->post_model->addPost($tid, $pid, $this->input->post('content'));
                    $segments = array('main', 'topic', $tid);

                    redirect(site_url($segments));
                } 
            }
            $data['row_item'] =  $this->post_model->getPostJoinUser($pid);
            $data['row_item']['depth'] = 0;
            $this->template->body('topic/topic_content', $data);
            $data['title'] = 'Lisa uus kommentaar';
            $data['callback'] = 'addpost';
            $data['submit'] = 'Lisa';
            $data['content'] = 'Kirjuta kommentaar siia';
            $this->template->body('forms/addpost_form', $data);  
        }else{
            echo 'logi sisse neeger';
        }

    }
    
    public function editpost($tid, $pid){
        $this->load->helper('form');
	$this->load->library('form_validation');
        
        $topic = $this->topic_model->getTopic($tid);
        $segments = array('main', 'topic', $topic['id']);
        $this->navigator($topic['fid'], 
            array(
                array($topic['name'], site_url($segments)),
                array('Muuda kommentaari', current_url())
            ));

        if($this->auth->isLoggedIn()){     

            $post =  $this->post_model->getPostJoinUser($pid);
            $uid = $post['users_id'];
            if($this->auth->getUserId() == $uid){
                if($this->input->post('form') == 'editpost'){
                    $this->form_validation->set_rules('content', 'Sisu', 'required');
                    echo 'yeah';
                    if($this->form_validation->run()){

                        $this->post_model->editPost($pid, $this->input->post('content'));

                        $segments = array('main', 'topic', $tid);

                        redirect(site_url($segments));
                    } 
                }

                $data['row_item'] = $post;
                $data['row_item']['depth'] = 0;
                $this->template->body('topic/topic_content', $data);
                $data['title'] = 'Muuda kommentaari';
                $data['callback'] = 'editpost';
                $data['submit'] = 'Muuda';
                $data['content'] = $post['content'];
                $this->template->body('forms/addpost_form', $data); 
            }else{
                echo 'vot ei muuda';
            }
 
        }else{
            echo 'logi sisse neeger';
        }

    }
    
    

    
}
