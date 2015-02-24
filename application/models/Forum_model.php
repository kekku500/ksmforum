<?php

class Forum_model extends CI_Model {
    
    private $path = array();
    
    private $table = 'forums';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function getRootForums(){
        $query = $this->db->get_where($this->table, array('p_fid' => null));
        return $query->result_array();
    }
    
    public function getForums(){
        $query = $this->db->get($this->table);
        return $query->result_array();
    }
    
    public function getForumsByParent($p_fid){
        $query = $this->db->get_where($this->table, array('p_fid' => $p_fid));
        return $query->result_array();
    }
    
    public function getForum($fid){
        $query = $this->db->get_where($this->table, array('id' => $fid));
        return $query->row_array();
    }
    
    public function getPathToRootForum($fid){
        $forum = $this->forum_model->getForum($fid);
        
        if($forum['p_fid'] != null){
            $this->getPathToRootForum($forum['p_fid']);
        }
        
        $this->path[] = $forum;
        
        return $this->path;
    }
    
    public function addForum($data){
        $this->db->insert($this->table, $data);
    }
    
    public function editForum($fid, $name){
        
    }
    
    public function delForum($fid){
        $this->db->where('id', $fid);
        $this->db->delete($this->table);
    }
    
}
