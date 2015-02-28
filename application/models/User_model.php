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
    
    public function attemptLoginGoogle($guid){
        $result = $this->user_model->getUserByGoogle($guid);
        if(count($result) > 0) //account found
            return $result['user_id'];
        return false;
    }
    
    //peab sisse logitud olema
    public function checkPassword($pass){
        $this->db->select('pass');
        $query = $this->db->get_where($this->table, array('id' => $this->auth->getUserId()));
        $correct_pass = $query->row_array()['pass'];
        
        if(empty($correct_pass))
            return null;
        
        $this->load->library('encrypt');
        $encrypted_pass = $this->encrypt->sha1($pass);
        if($correct_pass == $encrypted_pass)
            return true;
        return false;
    }
    
    
    //peab sisse logitud olema
    public function changePassword($newpass){
        $this->load->library('encrypt');
        $this->db->where('id', $this->auth->getUserId());
        $this->db->update($this->table, array(
            'pass' => $this->encrypt->sha1($newpass)
        ));
    }
    
    public function getUserByEmail($email){
        $query = $this->db->get_where($this->table, array('email' => $email));
        return $query->row_array();
    }
    
    public function getUser($id){
        $query = $this->db->get_where($this->table, array('id' => $id));
        return $query->row_array();
    }
    
    
    public function getUserByGoogle($guid){
        $this->db->join('googleusers', 'googleusers.uid = '.$this->table.'.id');
        $this->db->select(
                'users.id as user_id,
                googleusers.id as googleuser_id,
                name,
                pass,
                email');
        $query = $this->db->get_where($this->table, array('googleusers.id' => $guid));
        return $query->row_array();
    }
    
    public function addUser($data){
        $this->load->library('encrypt');
        $data['pass'] = $this->encrypt->sha1($data['pass']);
        $this->db->insert($this->table, $data);
    }
    
    public function addUserGoogle($userdata, $guid){
        $this->db->insert($this->table, $userdata);
        $this->db->insert('googleusers', array(
            'id' => $guid, 
            'uid' => $this->db->insert_id()));
    }
    
    public function addGooglePlusUser($userdata){
        $this->db->insert($this->table, $data);
    }
    
    public function editUser($data){
        
    }
    
    public function delUser($uid){
        
    }
    
}