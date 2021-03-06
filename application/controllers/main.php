<?php
// Foorumis ringi liikumiseks
class Main extends CI_Controller {
    
    //meetod kutstutakse kõige alguses
    public function __construct() {
        parent::__construct();

        $this->load->library(array('multiform', 'form_validation', 'googleoauth2'));
        $this->load->model(array('topic_model', 'post_model', 'forum_model', 'user_model', 'session_model'));
        $this->load->helper(array('url','date', 'form', 'cookie')); 
		
        
        $segments = array('main', 'oauth2callback');
        $this->googleoauth2->setCallbackUrlSegments($segments);
   
        $this->load->library('template', 'multiform');
        
        $this->lang->load('forum');
        
        //javascript
        $this->template->addJS('assets/js/jquery-1.11.2.min.js');
        $this->template->addJS('assets/js/bootstrap.min.js');
        $this->template->addJS('assets/js/main.js');
        //css
        $this->template->addCSS('assets/css/bootstrap-min.css');
        $this->template->addCSS('assets/css/bootstrap-theme-min.css');
        $this->template->addCSS('assets/css/main.css');
        $this->template->addCSS_Noscript('assets/css/main_noscript.css');
		
        $this->check_login();
        
        $this->user_controls();
    }
    
    //kutsutakse kõige lõpus
    private function end(){
        $this->template->postbody('footer', array(
            'users_online' => $this->user_model->onlineUserCount(),
            'visitors' => $this->session_model->visitorCount()
        ));
        
        $this->template->load('bootstrap'); 
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
    
    //kontrollib, kas kasutaja logitud. Kui mitte, siis lihtsalte
    //sisselogimise katse kontroll
    private function check_login(){  
        if($this->auth->isLoggedIn())
            return;

        if($this->multiform->is_form('login')){
            if($this->form_validation->run('login') == false){
		$this->template->postbody('javascript_calls/re_loginpopup.php');
	    }
            //loogika on funcktioonis loginAttempt()
        }
        
        if($this->auth->isLoggedIn())
            return;
        
        //GOOGLE OAUTH2
        $redirectedFromGoogle = $this->input->get('oauth2');
        if($this->multiform->is_form('logingoogle') || $redirectedFromGoogle){
            $userinfo = $this->googleoauth2->getUserInfo();
            $google_uid = $userinfo->id;
            $this->session->set_userdata('google_email', $userinfo->email);

            $userid = $this->user_model->getUserId_GoogleId($google_uid);

            if($userid){ //account found
                $this->auth->login($userid);
                //redirect(current_url());
            }else{//account not found
                $this->template->postbody('javascript_calls/re_registergooglepopup.php');
            }
        }
        
        //ka google logimine ebaõnnestus, näita vajalikke forme
        if(!$this->auth->isLoggedIn()){
            $formdata['valid_accesstoken'] = $this->googleoauth2->hasValidAccessToken();
            $this->template->prebody('forms/login_form', $formdata); 
            
            if($formdata['valid_accesstoken'])
                $this->registergoogle(); 
            $this->register();

        }
        
    }
    
    //nupud sisselogimiseks ja registreerimieks
    private function user_controls(){
        if($this->auth->isLoggedIn())
            $userinfo['user'] = $this->user_model->getUser($this->auth->getUserId());
        $this->template->prebody('auth_header', (isset($userinfo) ? $userinfo : array()));
    }
    
    public function loginAttempt(){
        if(!$this->multiform->is_form('login'))
            redirect(base_url());
        if($this->form_validation->error_count() > 0)
            return true; // kasutaja/parool valesti sisestatud, ära näita login failed errorit
        $user = $this->input->post('user');
        $pass = $this->input->post('pass');

        $userid = $this->user_model->getUserId_UserPass($user, $pass);
        
        if($userid){
            $this->auth->login($userid);
            return true;
        }
        return false;
    }
    
    public function oauth2callback($return_url_encoded = ''){
        $this->googleoauth2->callback($return_url_encoded);
    }
    
    public function reset(){
        $this->googleoauth2->destroyAccessToken();
    }
    
    public function logout($url){
        $this->auth->logout();
        
        redirect(base64_decode($url));
    }
    
    public function userpanel(){   
        $this->navigator();
        
        if(!$this->auth->isLoggedIn()){
            redirect(base_url());
            return;
        }
        $passState = $this->user_model->checkPassword($this->auth->getUserId(), "huvitav, kas pass on null?"); 
        if($this->multiform->is_form('change_password')){
              
            $form_val_rule = 'changepassword';
            if(!isset($passState)){
                $form_val_rule = 'changepassword_no_old';
            }
            
            if($this->form_validation->run($form_val_rule)){ 
                $pass = $this->input->post('pass');
                
                $this->user_model->changePassword($this->auth->getUserId(), $pass);
                
                $passState = 'pass changed';

                $this->multiform->setSuccessMessage($this->lang->line('changepassword_success_msg'));
            } 
        }
        
        if($this->multiform->is_form('del_user')){
            
            if($this->form_validation->run('del_user')){ 
                if($this->input->post('delete') == '1'){
                    $userPosts = $this->post_model->getPostsByUser($this->auth->getUserId());
                    
                    foreach($userPosts as $userPost){
                        $this->post_model->delPostRecursive($userPost);
                    }

                    $this->user_model->delUser($this->auth->getUserId());
                    $this->logout(base64_encode(base_url()));
                }
            } 
        }
 
        $formdata['pass_null'] = !isset($passState);
        $this->multiform->setForm('change_password');
        $this->template->body('forms/change_password_form', $formdata);
        
        $this->multiform->setForm('del_user');
        $this->template->body('forms/delete_user.php');
    }
    
    public function changePasswordCheck(){
        if(!$this->multiform->is_form('change_password'))
            redirect(base_url());
        $oldpass = $this->input->post('oldpass');
        $passState = $this->user_model->checkPassword($this->auth->getUserId(), $oldpass);
        if($passState == false)
            return false;
        return true;
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
        $this->template->prebody('navigator', $data);
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
            
            if($this->form_validation->run('register')){ 
                echo 'registreerimine käivitus';
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

                $userid = $this->user_model->getUserId_UserPass($user, $pass);

                if(!$userid){
                  echo 'wtf';
                }else{
                  $this->session->set_userdata('register_limit', now());

                  $this->auth->login($userid);
                  redirect(base_url());
                }

            }else{
				$this->template->postbody('javascript_calls/re_registerpopup.php');
			}
        }
        $this->multiform->setForm('register');
        $this->template->prebody('forms/register_form');
    }
    
    private function registergoogle(/*$enable = false*/){
       // if($this->googleoauth2->hasValidAccessToken()){
            if($this->multiform->is_form('registergoogle')/*|| $enable*/){

                if($this->form_validation->run('registergoogle')){ 
                    $google_userinfo = $this->googleoauth2->getUserInfo();
                    $google_uid = $google_userinfo->id;

                    $user = $this->input->post('user');

                    $userdata = array(
                        'name' => $user,
                        'email' => $google_userinfo->email
                    );

                    $this->user_model->addUser_Google($userdata, $google_uid);

                    $userid = $this->user_model->getUserId_GoogleId($google_uid);

                    if($userid){ 
                        $this->auth->login($userid);
                        redirect(current_url());
                    } 
                }else{
                    $this->template->postbody('re_registergooglepopup.php');
                }
            }
            $formdata['google_email'] = $this->session->userdata('google_email');
            $this->multiform->setForm('registergoogle');
            $this->template->prebody('forms/registergoogle_form', $formdata);
        //}

    }
    
    //pealeht
    public function index(){   
        $this->template->setTitle($this->lang->line('index_website_title'));
        
        $this->navigator();
        
        $data['forums'] = $this->forum_model->getIndexForums();
        $this->template->body('forum/table', $data);
    }
    
    //foorumi vaade
    public function forum($fid){
        $forum = $this->forum_model->getForum($fid);
        
        if($forum == null){
            $this->navigator();
            $msg = $this->lang->line('error_no_such_forum');
            $this->template->body('notifications/general', array('message' => $msg));
            return;
        }
        
        $data['fid'] = $fid;
        
        $this->template->setTitle(sprintf($this->lang->line('forum_website_title'), $forum['name']));
        
        $this->navigator($fid);
        
        //alamfoorumid
        $data['parent_forum'] = $this->forum_model->getForum($fid);
        $data['forums'] = $this->forum_model->getForumsByParent($fid);
        $this->template->body('subforum/table', $data);
        
        //teemad
        $data['forum'] = $this->forum_model->getForum($fid);
        $data['topics'] = $this->topic_model->getTopics($fid);
        $this->template->body('topic/table', $data);
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
    
    public function topic($tid, $page = 1, $root_post_id = null){
        $topic = $this->topic_model->getTopic($tid);
        
        if($topic == null){
            $this->navigator();
            $msg = $this->lang->line('error_no_such_topic');
            $this->template->body('notifications/general', array('message' => $msg));
            return;
        }
        
        
        
        if($root_post_id == null){
            $root_post_id = $this->post_model->getRootPost($tid)['post_id'];  
            $data['topic_root_post_id'] = $root_post_id;
        }else{
            if($this->post_model->getPost($root_post_id) == null)
                redirect(base_url(array('main', 'topic', $tid)));
            $data['topic_root_post_id'] = $this->post_model->getRootPost($tid)['post_id'];
        }
        
        $data['topic'] = $topic;
        $this->template->postbody("javascript_calls/re_createeventsource", $data); //kuula uute postituste loomist
        
        $this->viewed_topic($tid);       
        
        $this->navigator($topic['fid'], 
                array(
                    array($topic['name'], base_url()."main/topic/".$topic['id']."/1/".$root_post_id)
                ));
        
        $data['posts'] = $this->post_model->getPostsPaginated($root_post_id, $page);
        
        
        $data['post'] = $data['posts'][0];
        $this->template->body('topic/root_post', $data);
        
        $data['response_disabled'] = false;      
        $data['posts'] = $this->post_model->getPostsPaginated($root_post_id, $page);
        $data['topic']['id'] = $tid;
        $data['cur_url_encoded'] = base64_encode(current_url());
        $reply_count = $this->post_model->getPostReplyCount($root_post_id);
        $data['next_page_valid'] = ($this->config->item('max_post_count')*$page < $reply_count);
        $data['cur_page'] = $page;
        $data['topic_root_post_id'] = $this->post_model->getRootPost($tid)['post_id'];
        $data['page_offset'] = 0;
        
        $xmlString = $this->load->view('topic/posts_xml', $data, true);
        $document = $this->parseXML($xmlString, 'assets/xslt/posts.xsl');
        $document = str_replace('<?xml version="1.0"?>', '', $document);
        
        $this->template->body($document, array(), true);

        $this->template->body('topic/messageNewPosts');
    }
    
    private function parseXML($xmlString, $xsltFilePath){
        $xml = new DOMDocument;
        $xml->loadXML($xmlString);
        
        $xsl = new DOMDocument;
        $xsl->load($xsltFilePath);
        
        $proc = new XSLTProcessor;
        $proc->importStyleSheet($xsl); // attach the xsl rules

        $document = $proc->transformToXml($xml);

        return $document;
    }
    
    //teema lisamise vaade
    public function addtopic($fid){
        $forum = $this->forum_model->getForum($fid);
        if($forum == null){
            $this->navigator();
            $msg = $this->lang->line('error_no_such_forum');
            $this->template->body('notifications/general', array('message' => $msg));
            return;
        }
        
        $this->navigator($fid, 
                    array(
                        array('Lisa teema', current_url())
                    ));
        
        if($this->auth->isLoggedIn()){
            if($this->multiform->is_form('addtopic')){
                if($this->form_validation->run('addtopic')){
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
            }
            $data['row_item'] =  $forum;
            $this->multiform->setForm('addtopic');
            $this->template->body('forms/addtopic_form', $data);  
        }else{
           $this->template->body('errors/no_permission');
        }
    }
    
    public function addTopicCheck(){
        if(!$this->multiform->is_form('addtopic'))
            redirect(base_url());
        if($this->form_validation->error_count() > 0)
            return true; // 
        
        $fid = $this->uri->segment(3);
        $title = $this->input->post('title');
        
        if($this->topic_model->isUniqueTopicTitle($fid, $title))
                return true;
        return false;
        
    }
    
    //postituse lisamise vaade
    public function addpost($pid, $url = null){
        $post =  $this->post_model->getPost($pid);
        
        if($post == null || $post['deleted']){
            $this->navigator();
            $msg = $this->lang->line('error_no_such_post');
            $this->template->body('notifications/general', array('message' => $msg));
            return;
        }
        
        //nav
        $segments = array('main', 'topic', $post['topic_id']);
        $this->navigator($post['forum_id'], 
            array(
                array($post['topic_name'], site_url($segments)),
                array('Lisa kommentaar', current_url())
            ));

        //form
        if($this->auth->isLoggedIn()){ 
            
            //if($this->auth->getUserId() != $data['row_item']['user_id']){
                if($this->multiform->is_form('addpost')){
                    
                    if($this->form_validation->run('addeditpost')){
                        $this->post_model->addPost($post['topic_id'], $pid, $this->input->post('content'));
                        redirect(base64_decode($url));
                    }
                }
                
  
                $data['topic_root_post_id'] = $this->post_model->getRootPost($post['topic_id'])['post_id'];
                $data['response_disabled'] = true;
                $data['post'] = $post;
                $data['topic'] = array('id' => $post['topic_id'], 'name' => $post['topic_name']);
                $this->template->body('topic/root_post', $data);

                //language
                $data['title'] = $this->lang->line('addpost_title');
                $data['submit'] = $this->lang->line('addpost_button');
                $data['content'] = $this->lang->line('addpost_content');

                $this->multiform->setForm('addpost');
                $this->template->body('forms/post_form', $data);  
                
                 $this->template->body('topic/messageNewPosts');
            //}else{
            //    $this->template->body('errors/no_permission');
            //}
        }else{
            $this->template->body('errors/no_permission');
        }
        
       
    }
    
    //postituse muutmise vaade
    public function editpost($pid, $url){
        $post =  $this->post_model->getPost($pid);
        
        if($post == null || $post['deleted']){
            $this->navigator();
            $msg = $this->lang->line('error_no_such_post');
            $this->template->body('notifications/general', array('message' => $msg));
            return;
        }
        
        //nav
        $segments = array('main', 'topic', $post['topic_id']);
        $this->navigator($post['forum_id'], 
            array(
                array($post['topic_name'], site_url($segments)),
                array('Muuda kommentaari', current_url())
            ));
        
        //edit post form
        if($this->auth->isLoggedIn()){     
            $uid = $post['user_id'];
            
            //kas autor muudab postitust?
            if($this->auth->getUserId() == $uid){
                if($this->input->post('form') == 'editpost'){
                    
                    //postitame ja lähme teemasse tagasi
                    if($this->form_validation->run('addeditpost')){
                        $this->post_model->editPost($pid, array('content' => $this->input->post('content')));

                        redirect(base64_decode($url));
                    } 
                }
                
                //näita muudetavat postitust
                $data['topic_root_post_id'] = $this->post_model->getRootPost($post['topic_id'])['post_id'];
                $data['response_disabled'] = true;
                $data['post'] = $post;
                $data['topic'] = array('id' => $post['topic_id'], 'name' => $post['topic_name']);
                $this->template->body('topic/root_post', $data);
                
                //lang
                $data['title'] = $this->lang->line('editpost_title');
                $data['submit'] = $this->lang->line('editpost_button');
                
                $data['content'] = $post['content'];

                $this->multiform->setForm('editpost');
                $this->template->body('forms/post_form', $data); 
            }else{
                $this->template->body('errors/no_permission');
            }
 
        }else{
            $this->template->body('errors/no_permission');
        }

    }
    
    public function delpost($pid, $url){
        $post =  $this->post_model->getPost($pid);
        
        if($post == null || $post['deleted'])
            redirect(base_url());
        
        if($this->auth->isLoggedIn() && $this->auth->getUserId() == $post['user_id']){     
            $topic_deleted = $this->post_model->delPostRecursive($post);
            if($topic_deleted)
               redirect(site_url(array('main', 'forum', $post['forum_id'])));
            else
               redirect(base64_decode($url));  
        }else{
            $this->template->body('errors/no_permission');
        }
    }
    
    
    
    public function admin(){
        $this->navigator();
        
        if($this->auth->isLoggedIn()){
            
            $usergroup = $this->user_model->getUserJoinUserGroup($this->auth->getUserId());
            if($usergroup['addforum']){
                if($this->input->post('form') == 'addforum'){
                    if($this->form_validation->run('addforum')){
                        $p_fid = $this->input->post('p_fid');
                        $data = array(
                            'p_fid' => ($p_fid == 0 ? null : $p_fid),
                            'name' => $this->input->post('name'),
                            'uid' => $this->auth->getUserId()
                        );
                        $this->forum_model->addForum($data);
                        $this->multiform->setSuccessMessage(sprintf(
                                $this->lang->line('addforum_success_msg'), $data['name']));
                    } 
                }
                if($this->input->post('form') == 'delforum'){
                    if($this->form_validation->run('delforum')){
                        $fid = $this->input->post('fid');
                        $forum = $this->forum_model->getForum($fid);
                        
                        $this->forum_model->delForum($fid);
                        $this->multiform->setSuccessMessage(sprintf(
                                $this->lang->line('delforum_success_msg'), $forum['name']));
                    } 
                }

                $data['forums'] = $this->forum_model->getForums();
                
                $this->multiform->setForm('addforum');
                $this->template->body('forms/addforum_form', $data); 
                $this->multiform->setForm('delforum');
                $this->template->body('forms/delforum_form', $data); 
            }else{
                $this->template->body('errors/no_permission'); 
            }
            
        }else{
            redirect(base_url());
        }
    }
    
}
