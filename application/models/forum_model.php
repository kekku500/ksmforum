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
     * Päring:
     * SELECT category.id as category_id, 
     * category.name as category_name, 
     * forum.id as forum_id, 
     * forum.name as forum_name, 
     * forum.topic_count as topic_count, 
     * forum.post_count as post_count  
     * FROM forums as category join forums as forum 
     * on forum.p_fid = category.id where category.p_fid is null 
     * order by category.id
     * 
     * Annab esilehe jaoks kõik vajalikud foorumid ning nende kategooriad.
     * @return type array() tabelid read
     * 
     */
    public function getIndexForums(){
        $this->db->select(
            'category.id as category_id,'.
            'category.name as category_name,'.
            'forum.id as forum_id,'.
            'forum.name as forum_name,'.
            'forum.topic_count as topic_count,'.
            'forum.post_count as post_count');
        $this->db->join($this->table.' as forum', 'forum.p_fid = category.id');
        
        $this->db->where('category.p_fid', null);
        
        $this->db->order_by("category.id", "asc");
        
        $query = $this->db->get($this->table.' as category');  
        
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
     * Päring:
     * SELECT id as forum_id, name as forum_name, topic_count, post_count  
     * FROM forums where p_fid = $p_fid
     * @param type $p_fid vanema foorumi id
     * @return type array() foorumi read
     */
    public function getForumsByParent($p_fid){
        $this->db->select(
            'id,'.
            'name,'.
            'topic_count,'.
            'post_count,');
        $this->db->where('p_fid', $p_fid);
        $query = $this->db->get($this->table);
        return $query->result_array();
    }
    
    /**
     * Päring:
     * 
     * @param type $fid foorumi id
     * @return type ühe realine array
     */
    public function getForum($fid){
        $this->db->select(
            'id,'.
            'p_fid as parent_id,'.
            'name,'.
            'topic_count,'.
            'post_count,');
        $this->db->where('id', $fid);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }
    
    /**
     * 
     * @param type $fid foorumi id
     * @return type array(), mis tagastab foorumid kuni vanem on null
     */
    public function getPathToRootForum($fid){
        $forum = $this->forum_model->getForum($fid);
        
        if($forum['parent_id'] != null){
            $this->getPathToRootForum($forum['parent_id']);
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
