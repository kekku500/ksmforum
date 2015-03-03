<?php

class Forum_model extends CI_Model {
    
    private $path = array();
    
    private $table = 'forums';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * 
     * @return type array() tabeli forums kõik read, millel pole vanemat
     */
    public function getRootForums(){
        $query = $this->db->get_where($this->table, array('p_fid' => null));
        return $query->result_array();
    }
    
    /**
     * 
     * @return type kõik tabeli forums read
     */
    public function getForums(){
        $query = $this->db->get($this->table);
        return $query->result_array();
    }
    
    /**
     * 
     * @param type $p_fid vanema id
     * @return type array() foorumi read
     */
    public function getForumsByParent($p_fid){
        $query = $this->db->get_where($this->table, array('p_fid' => $p_fid));
        return $query->result_array();
    }
    
    /**
     * 
     * @param type $fid foorumi id
     * @return type ühe realine array
     */
    public function getForum($fid){
        $query = $this->db->get_where($this->table, array('id' => $fid));
        return $query->row_array();
    }
    
    /**
     * 
     * @param type $fid foorumi id
     * @return type array(), mis tagastab foorumid kuni vanem on null
     */
    public function getPathToRootForum($fid){
        $forum = $this->forum_model->getForum($fid);
        
        if($forum['p_fid'] != null){
            $this->getPathToRootForum($forum['p_fid']);
        }
        
        $this->path[] = $forum;
        
        return $this->path;
    }
    
    /**
     * 
     * @param type $data foorumi väljad arrays
     */
    public function addForum($data){
        $this->db->insert($this->table, $data);
    }
    
    /**
     * Kustuta foorum
     * @param type $fid foorumi id
     */
    public function delForum($fid){
        $this->db->where('id', $fid);
        $this->db->delete($this->table);
    }
    
    //TODO
    public function editForum($fid, $name){
        
    }
    

    
}
