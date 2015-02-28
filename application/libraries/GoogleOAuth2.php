<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


class GoogleOAuth2{
    
    //https://code.google.com/p/google-api-php-client/source/browse/trunk/examples/userinfo/index.php
    //$plus_service = new Google_Service_Plus($client);
    //return $plus_service->people->get('me')->getEmails()[0]->getValue();
    
    private $CI;
    
    private $google_uri = APPPATH.'third_party/google-api-php-client';
    private $autoload_dir = '/src/Google/autoload.php';
    private $client_secret_dir = '/files/client_secrets.json';
    
    private $callback_url_segments;
    
    public function __construct() {
        $this->CI =& get_instance();
        
        $this->CI->load->file($this->google_uri.$this->autoload_dir);
    }
    
    public function setCallbackUrlSegments($url){
        $this->callback_url_segments = $url;
    }

    private function getAccessToken(){
        $access_token = $this->CI->session->userdata('access_token');
        if(!$access_token){
            $this->callback_url_segments[] = base64_encode(current_url());
            redirect(site_url($this->callback_url_segments));
        }
        return $access_token;
    }
    
    public function hasValidAccessToken(){
        if(!$this->CI->session->userdata('access_token'))
            return false;
        else{
            $client = $this->createGoogleClient();
            $token = $this->getAccessToken();
            $client->setAccessToken($token);
            if($client->isAccessTokenExpired())
                return false;
        }
        return true;
    }
    
    public function hasAccessToken(){
        if(!$this->CI->session->userdata('access_token'))
            return false;
        return true;
    }
    
    private function createGoogleClient(){
        $client = new Google_Client();
        $client->setAuthConfigFile($this->google_uri.$this->client_secret_dir);
        $client->addScope(Google_Service_Plus::USERINFO_PROFILE);
        $client->addScope(Google_Service_Plus::USERINFO_EMAIL);
        return $client;
    }

    private function getGoogleClient(){
        $token = $this->getAccessToken();
        $client = $this->createGoogleClient();
        $client->setAccessToken($token);
        if($client->isAccessTokenExpired()){
            $this->destroyAccessToken();
            $this->getAccessToken();
        }
        return $client;
    }
    
        
    public function getUserInfo(){
        $client = $this->getGoogleClient();
        
        $oauth2 = new Google_Service_Oauth2($client);
            
        $google_userinfo = $oauth2->userinfo->get();
        
        return $google_userinfo;
    }
    
    public function getUserId(){
        return $this->getUserInfo()->id;
    }
    
    public function getUserEmail(){
        return $this->getUserInfo()->email;
    }

    
    public function callback($return_url_encoded){
        $client = $this->createGoogleClient();
        
        $code = $this->CI->input->get('code');
        if(!$code){
            $client->setRedirectUri(site_url($this->callback_url_segments));
            $client->setState($return_url_encoded);
            $auth_url = $client->createAuthUrl();
            redirect($auth_url);
        }else{
            $client->authenticate($code);
            $this->CI->session->set_userdata('access_token', $client->getAccessToken());
            $state = $this->CI->input->get('state');
            $redirect_url = base64_decode($state);
            //$redirect_url = base_url(array('main', 'return_place'));
            redirect($redirect_url.'?oauth2=1');
        }
    }
    
    public function destroyAccessToken(){
        $this->CI->session->unset_userdata('access_token');
    }
    
}
