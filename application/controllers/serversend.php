<?php

class ServerSend extends CI_Controller {
    

    public function __construct() {
        parent::__construct();
        
        $this->load->model('post_model');
    }
    
    public function newpost($tid){
        $time_array = $this->post_model->getTopicMaxCreateTime($tid);
        if($time_array == null)
            return;
        
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header("Connection: keep-alive");
        
        $old_time = $time_array['create_time'];
        while (true) { //kuni uus postitus leidub
            $new_time = $this->post_model->getTopicMaxCreateTime($tid)['create_time'];
            if($old_time != $new_time){
                $data = "messageNewPost";
                $this->sendMessage($data);
                break;
            }
            sleep(2);
        }
    }
    
    private function sendMessage($data){
        echo "data: $data\n\n";
        ob_flush();
        flush();
    }
    
    
    
}
