<?php


class User_model extends CI_Model {
    
    private $table = 'users';
    private $user_to_session = 'sessionbinds';
    private $user_to_google = 'googleusers';
    private $ci_sessions = 'ci_sessions';

    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Sisselogimise kontrolliks mõeldud
     * @param type $user kasutajanimi
     * @param type $pass krüpteerimata parool
     * @return boolean/int kasutaja id või false, kui kasutajat pole
     */
    function getUserId_UserPass($user, $pass){
       $this->load->library('encrypt');
       $query = $this->db->get_where($this->table, array(
           'name' => $user,
           'pass' => $this->encrypt->sha1($pass)
       ));
       if($query->num_rows() == 0)
           return false;
       return $query->row()->id; 
    }
    
     /**
     * Sisselogimine läbi google id
     * @param type $google_id kasutajanimi
     * @return boolean/int kasutaja id või false, kui kasutajat pole
     */
    function getUserId_GoogleId($google_id){
       $query = $this->db->get_where($this->user_to_google, array(
           'id' => $google_id
       ));
       if($query->num_rows() == 0)
           return false;
       return $query->row()->uid;
    }
    
    function bindSessionToUser($id){
        $data = array(
            'uid' => $id,
            'session_id' => $this->session->userdata('session_id')
        );
        
        $this->db->insert($this->user_to_session, $data);
    }
    
    function unbindSessionFromUser($id){
        $this->db->where('session_id', $this->session->userdata('session_id'));
        $this->db->delete($this->user_to_session);
    }
    
    function onlineUserCount(){
        $this->db->select('count(*) as amount');
        $this->db->join($this->ci_sessions, $this->ci_sessions.'.session_id = '.$this->user_to_session.'.session_id');
        $this->db->where('last_activity >=', (now()-$this->config->item('sess_time_to_update')));
        $this->db->group_by('uid');
        
        $query = $this->db->get($this->user_to_session);
        return $query->num_rows();
    }
    
    //peab sisse logitud olema
    //Kontrollib, kas praeguse kasutaja parool on $pass.
    //Kui andmebaasis on parool NULL, siis funktsioon tagastab null.
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
    
    public function getUser($id){
        $query = $this->db->get_where($this->table, array('id' => $id));
        return $query->row_array();
    }
    
    public function addUser($data){
        $this->load->library('encrypt');
        $data['pass'] = $this->encrypt->sha1($data['pass']);
        $this->db->set('create_time', 'NOW()', FALSE);
        $this->db->insert($this->table, $data);
    }
    
    public function addUser_Google($userdata, $google_id){
        $this->db->set('create_time', 'NOW()', FALSE);
        $this->db->insert($this->table, $userdata);
        $this->db->insert('googleusers', array(
            'id' => $google_id, 
            'uid' => $this->db->insert_id()));
    }
    
    
    public function editUser($data){
        
    }
    
    public function delUser($uid){
        
    }
    
}