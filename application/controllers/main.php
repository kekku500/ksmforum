<?php
// Foorumis ringi liikumiseks
class Main extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library(array('template', 'multiform', 'form_validation', 'forumbase'));
        $this->load->model(array('topic_model', 'post_model', 'forum_model', 'user_model', 'usergroup_model'));
        $this->load->helper(array('url','date', 'form')); 
        
        $this->check_login(); 
        
        $this->user_controls();
        
        $this->lang->load('forum');
        
    }
    
    //pealeht
    public function index(){   
        $this->template->setTitle($this->lang->line('index_website_title'));
        
        $this->navigator();
        
        $this->rootforums();
    }
    
    //peale ükskõik, mis meetodit, kutstu veel end()
    public function _remap($method, $params = array()){
        if (method_exists($this, $method)){
            $ret = call_user_func_array(array($this, $method), $params);
            $this->end();
            return $ret;
        }
        show_404();
    }
    
    //kutsutakse kõige lõpus
    private function end(){
        $this->template->load('default'); 
    }
    
    //nupud sisselogimiseks ja registreerimieks
    private function user_controls(){
        if($this->auth->isLoggedIn())
            $userinfo['user'] = $this->user_model->getUser($this->auth->getUserId());
        $this->template->prebody('auth_header', (isset($userinfo) ? $userinfo : array()));
        if(!$this->auth->isLoggedIn()){
            $this->template->prebody('forms/login_form');  
            $this->register();
        }
    }
    
    //kontrollib, kas kasutaja logitud. Kui mitte, siis lihtsalte
    //sisselogimise katse kontroll
    private function check_login(){  
        if($this->auth->isLoggedIn()){
            return;
        }

        if($this->multiform->is_form('login')){
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
    

    //logib välja
    public function logout($url){
        $this->auth->logout();
        
        redirect(base64_decode($url));
    }
    
    //foorumis navigeerimiseks
    //fid - foorum, kus hetkel ollakse
    //extra - saab navigaatorit pikendada (näiteks lisa postitus)
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
    
    //foorumid, millel pole vanemaid
    private function rootforums(){
        $rootforums = $this->forum_model->getRootForums();
        foreach($rootforums as $row){
            $data['row'] = $row;

            $forums = $this->forum_model->getForumsByParent($row['id']);
            
            if(count($forums) > 0){
                $data['header']['name'] = $row['name'];
                $data['header']['topic_count'] = 'Teemasid';
                $this->template->body('forum/header', $data);
                
                foreach ($forums as $subrow){ 
                    $data['row'] = $subrow;

                    $segments = array('main', 'forum', $subrow['id']);
                    $data['row']['site_url'] = site_url($segments);

                    $this->template->body('forum/row', $data);
                }  
                $data['row'] = $row;
                $this->template->body('forum/footer', $data);
            }
        }
    }
    
    //foorumi vaade
    public function forum($fid){
        $forum = $this->forum_model->getForum($fid);
        $data['fid'] = $fid;
        
        $this->template->setTitle(sprintf($this->lang->line('forum_website_title'), $forum['name']));
        
        $this->navigator($fid);
        
        //alamfoorumid
        $data['header']['name'] = $forum['name'];
        $this->template->body('subforum/header', $data);
        
        $subforums = $this->forum_model->getForumsByParent($fid);

        foreach ($subforums as $row){ 
            $data['row'] = $row;
            
            $segments = array('main', 'forum', $row['id']);
            $data['row']['site_url'] = site_url($segments);
            
            $this->template->body('forum/row', $data);
        }  

        $data['row'] = $forum;
        $this->template->body('forum/footer', $data);
        
        //if($this->auth->isLoggedIn())
            //$this->template->body('addtopic_anchor', $data);
        
        if($forum['p_fid'] != null){
            //teemad
            $data['row']['name'] = $forum['name'];
            $this->template->body('topic/table/header', $data);
            
            
            $teemad = $this->topic_model->getTopics($fid);

            foreach ($teemad as $row){ 
                $segments = array('main', 'topic', $row['id']);
                $row['site_url'] = site_url($segments);
                $row['name'] = $this->security->xss_clean($row['name']);

                $data['row'] = $row;

                $this->template->body('topic/table/row', $data);
            }  

            $data['row'] = $forum;
            $this->template->body('topic/table/footer', $data);
        }

    }
    
    //kontrollib, kas teemat on vaadatud, kui ei, siis suurendab andmebaasis view count-i
    private function viewed_topic($tid){
        //print_r($this->session->userdata['t']);
        //$this->session->unset_userdata('t');
        if(!$this->session->userdata('t'))
            $this->session->set_userdata('t', array());

        if(!in_array($tid, $this->session->userdata('t'))){
            $this->topic_model->editTopicSet($tid, array(
                'views' => 'views+1'
                ));

            $t = $this->session->userdata('t');
            $t[] = $tid;
            $this->session->set_userdata('t', $t);
        }
    }
    
    //teema vaade, comments n shit
    public function topic($tid){
        $this->viewed_topic($tid);
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
    
    //teema lisamise vaade
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
    
    //postituse lisamise vaade
    public function addpost($tid, $pid){
        $topic = $this->topic_model->getTopic($tid);
        
        //nav
        $segments = array('main', 'topic', $topic['id']);
        $this->navigator($topic['fid'], 
            array(
                array($topic['name'], site_url($segments)),
                array('Lisa kommentaar', current_url())
            ));

        //form
        if($this->auth->isLoggedIn()){ 
            if($this->multiform->is_form('addpost')){
                $this->form_validation->set_rules('content', 'Sisu', 'required');
                
                if($this->form_validation->run()){
                    $this->post_model->addPost($tid, $pid, $this->input->post('content'));
                    $segments = array('main', 'topic', $tid);

                    redirect(site_url($segments));
                } 
            }
            //show to post you are replying to
            $data['row_item'] =  $this->post_model->getPostJoinUser($pid);
            $data['row_item']['depth'] = 0;
            $this->template->body('topic/topic_content', $data);
            
            //language
            $data['title'] = $this->lang->line('addpost_title');
            $data['submit'] = $this->lang->line('addpost_button');
            $data['content'] = $this->lang->line('addpost_content');
            
            $data['callback'] = 'addpost';
            $this->template->body('forms/post_form', $data);  
        }else{
            $this->template->body('errors/no_permission');
        }

    }
    
    
    //postituse muutmise vaade
    public function editpost($tid, $pid){
        $topic = $this->topic_model->getTopic($tid);
        
        //nav
        $segments = array('main', 'topic', $topic['id']);
        $this->navigator($topic['fid'], 
            array(
                array($topic['name'], site_url($segments)),
                array('Muuda kommentaari', current_url())
            ));
        
        //edit post form
        if($this->auth->isLoggedIn()){     
            $post =  $this->post_model->getPostJoinUser($pid);
            $uid = $post['user_id'];
            
            //kas autor muudab postitust?
            if($this->auth->getUserId() == $uid){
                if($this->input->post('form') == 'editpost'){
                    $this->form_validation->set_rules('content', 'Sisu', 'required');
                    
                    //postitame ja lähme teemasse tagasi
                    if($this->form_validation->run()){
                        $this->post_model->editPost($pid, $this->input->post('content'));

                        $segments = array('main', 'topic', $tid);

                        redirect(site_url($segments));
                    } 
                }
                
                //näita muudetavad postitust
                $data['row_item'] = $post;
                $data['row_item']['depth'] = 0;
                $this->template->body('topic/topic_content', $data);
                
                //lang
                $data['title'] = $this->lang->line('editpost_title');
                $data['submit'] = $this->lang->line('editpost_button');
                
                $data['content'] = $post['content'];
                $data['callback'] = 'editpost';
                $this->template->body('forms/post_form', $data); 
            }else{
                $this->template->body('errors/no_permission');
            }
 
        }else{
            $this->template->body('errors/no_permission');
        }

    }
    
    //registreerimise aken
    private function register(){
        if($this->multiform->is_form('register')){
            
            //register spam limit
            if($this->session->userdata('register_limit')){
                $register_second = $this->session->userdata('register_limit');
                $time_since_register = now() - $register_second;
                $wait_time = 0;
                if($time_since_register < $wait_time){
                    echo 'Oota '.($wait_time - $time_since_register).' sekundit enne uuesti registreerimist.';
                    return;
                }else{
                    $this->session->unset_userdata('register_limit');
                }
            }
            
            $this->form_validation->set_rules('user', 'Kasutajanimi', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('pass', 'Salasõna', 'required');
            $this->form_validation->set_rules('passconf', 'Salasõna kontroll', 'required');

            if($this->form_validation->run() == FALSE){ 
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
                  $this->session->set_userdata('register_limit', now());

                  $this->auth->login($userid);
                  redirect(base_url());
                }

            }  
        }
        $this->template->prebody('forms/register_form');
    }
    
}
