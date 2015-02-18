<?php

class Forum_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_forums_by_category($cid){
        $query = $this->db->get_where('forum', array('cid' => $cid));
        return $query->result_array();
    }
    
    public function get_forums_by_parent($p_fid){
        $query = $this->db->get_where('forum', array('p_fid' => $p_fid));
        return $query->result_array();
    }
    
}
