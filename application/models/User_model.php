<?php


class User_model extends CI_Model {
    
    private $table = 'users';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function attemptLogin($user, $pass){
       $this->load->library('encrypt');
       $query = $this->db->get_where($this->table, array(
           'name' => $user,
           'pass' => $this->encrypt->sha1($pass)
       ));
       if($query->num_rows() == 0)
           return false;
       return $query->row()->id;
    }
    
    public function getUser($id){
        $query = $this->db->get_where($this->table, array('id' => $id));
        return $query->row_array();
    }
    
    public function addUser($data){
        $this->load->library('encrypt');
        $data['pass'] = $this->encrypt->sha1($data['pass']);
        $this->db->insert($this->table, $data);
    }
    
    public function editUser($data){
        
    }
    
    public function delUser($uid){
        
    }
    
}