<?php

class Topic_model extends CI_Model {
    
    private $table = 'topics';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_topics_by_forum($fid){
        $query = $this->db->get_where($this->table, array('fid' => $fid));
        return $query->result_array();
    }
    
    public function get_topic_name($tid){
        $this->db->select('name');
        $query = $this->db->get_where($this->table, array('id' => $tid));
        return $query->row_array();
    }
    
    public function getTopics($fid){
        $query = $this->db->get_where($this->table, array('fid' => $fid));
        return $query->result_array();
    }
    
    public function getTopic($tid){
        $query = $this->db->get_where($this->table, array('id' => $tid));
        return $query->row_array();
    }
    
    public function addTopic($data){
        $this->db->insert($this->table, $data);
    }
    
    public function delTopic($tid){
        
    }
    
    public function editTopic($tid, $name){
        
    }
            
    
}
