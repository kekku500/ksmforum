<?php


class User_model extends CI_Model {
    
    private $table = 'users';
    private $user_to_session = 'sessionbinds';
    private $user_to_google = 'googleusers';
    private $ci_sessions = 'ci_sessions';
    private $user_to_usergroup = 'usergroups';

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
    
    /**
     * Seostab kasutaja id sessiooni id-ga.
     * @param type $id user id
     */
    function bindSessionToUser($id){
        $data = array(
            'uid' => $id,
            'session_id' => $this->session->userdata('session_id')
        );
        
        $this->db->insert($this->user_to_session, $data);
    }
    
    /**
     * Kustutab sessiooni ja kasutaja vahelise seose.
     * @param type $id user id
     */
    function unbindSessionFromUser($id){
        $this->db->where('session_id', $this->session->userdata('session_id'));
        $this->db->delete($this->user_to_session);
    }
    
    /**
     * 
     * @return type Sisseloginud kasutajate arv.
     */
    function onlineUserCount(){
        $this->db->select('count(*) as amount');
        $this->db->join($this->ci_sessions, $this->ci_sessions.'.session_id = '.$this->user_to_session.'.session_id');
        $this->db->where('last_activity >=', (now()-$this->config->item('sess_time_to_update')));
        $this->db->group_by('uid');
        
        $query = $this->db->get($this->user_to_session);
        return $query->num_rows();
    }
    
    /**
     * Kontrollib, kas kasutaja parool on $pass.
     * @param type $id
     * @param type $pass
     * @return boolean/null Kui andmebaasis on parool NULL, siis funktsioon tagastab null.
     */
    public function checkPassword($id, $pass){
        $this->db->select('pass');
        $query = $this->db->get_where($this->table, array('id' => $id));
        $correct_pass = $query->row_array()['pass'];
        
        if(empty($correct_pass))
            return null;
        
        $this->load->library('encrypt');
        $encrypted_pass = $this->encrypt->sha1($pass);
        if($correct_pass == $encrypted_pass)
            return true;
        return false;
    }
    
    /**
     * 
     * @param type $id 
     * @param type $newpass krüptimata parool
     */
    public function changePassword($id, $newpass){
        $this->load->library('encrypt');
        $this->db->where('id', $id);
        $this->db->update($this->table, array(
            'pass' => $this->encrypt->sha1($newpass)
        ));
    }
    
    public function getUserJoinUserGroup($uid){
        $this->db->join($this->user_to_usergroup, 
                $this->table.'.usergroup = '.$this->user_to_usergroup.'.id');
        $this->db->select(
                'usergroups.id as usergroup_id,'.
                'usergroups.name as usergroup_name,'.
                'addforum');
        
        $query = $this->db->get_where($this->table, array('users.id' => $uid));
                
        return $query->row_array();
    }
    
    /**
     * 
     * @param type $id
     * @return type array(), kõik kasutaja väljad
     */
    public function getUser($id){
        $query = $this->db->get_where($this->table, array('id' => $id));
        return $query->row_array();
    }
    
    /**
     * @param array $data users tabelisse lisamine, väli pass krüpteeritakse
     */
    public function addUser($data){
        $this->load->library('encrypt');
        $data['pass'] = $this->encrypt->sha1($data['pass']);
        $this->db->set('create_time', 'NOW()', FALSE);
        $this->db->insert($this->table, $data);
    }
    
    /**
     * @param type $userdata kasutaja andmed (eeldus, et pass = NULL)
     * @param type $google_id 
     */
    public function addUser_Google($userdata, $google_id){
        $this->db->set('create_time', 'NOW()', FALSE);
        $this->db->insert($this->table, $userdata);
        $this->db->insert('googleusers', array(
            'id' => $google_id, 
            'uid' => $this->db->insert_id()));
    }
    
    //TODO
    public function editUser($data){
        
    }
    
    //TODO
    public function delUser($uid){
        
    }
    
}