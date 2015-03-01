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
    
    public function isUniqueTopicTitle($fid, $title){
        $query = $this->db->get_where($this->table, array(
                    'fid' => $fid,
                    'name' => $title));
        if($query->num_rows() == 0) //duplicate title
            return true;
        return false;
    }
    
    public function getTopic($tid){
        $query = $this->db->get_where($this->table, array('id' => $tid));
        return $query->row_array();
    }
    
    public function addTopic($data){
        $this->db->set('create_time', 'NOW()', FALSE);
        $this->db->insert($this->table, $data);
    }
    
    public function delTopic($tid){
        
    }
    
    public function editTopic($tid, $data){
        $this->db->where('id', $tid);
        $this->db->update($this->table, $data);
    }
    
    public function editTopicSet($tid, $set){
        $set_count = count($set);
        for($i=0;$i<$set_count;$i++){
            $d = each($set);
            $this->db->set($d['key'], $d['value'], false);
        }
       
        $this->db->where('id', $tid);
        $this->db->update($this->table);
    }
            
    
}
