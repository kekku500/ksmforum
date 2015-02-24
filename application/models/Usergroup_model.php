<?php


class Usergroup_model extends CI_Model {
    
    private $table = 'usergroups';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    private function getUserGroup($id){
        $query = $this->db->get_where($this->table, array('id' => $id));
        return $query->row_array();
    }
    
    public function getActiveUserGroup(){
        $userinfo = $this->user_model->getUser($this->auth->getUserId());
        return $this->getUserGroup($userinfo['usergroup']);
    }
    
    

    
}