<?php

class Topic_model extends CI_Model {
    
    private $table = 'topics';
    private $users = 'users';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * @param type $fid foorumi id
     * @return type kõik teemad, mis on foorumis id-ga fid. Join teemade loojatega.
     */
    public function getTopics($fid){
        $this->db->select(
            'topics.id as topic_id,'.
            'topics.name as topic_name,'.
            'topics.edit_time as topic_edit_time,'.
            'topics.views as topic_views,'.
            'topics.post_count as topic_post_count,'.
            'users.name as user_name');
        $this->db->join($this->users.' as users', $this->users.'.id = '.$this->table.'.uid');
        $this->db->where('fid', $fid);
        $query = $this->db->get($this->table.' as topics');
        return $query->result_array();
    }
    
    /**
     * Igas foorumis peab teema pealkiri olema unikaalne; selle kontroll.
     * @param type $fid foorumi id
     * @param type $title teema pealkiri
     * @return boolean kas on unikaalne või mitte?
     */
    public function isUniqueTopicTitle($fid, $title){
        $query = $this->db->get_where($this->table, array(
                    'fid' => $fid,
                    'name' => $title));
        if($query->num_rows() == 0) //duplicate title
            return true;
        return false;
    }
    
    /**
     * @param type $tid teema id
     * @return type ühe realine array() või null, kui teemat ei leitud
     */
    public function getTopic($tid){
        $query = $this->db->get_where($this->table, array('id' => $tid));
        if($query->num_rows() == 0)
            return null;
        return $query->row_array();
    }
    
    /**
     * Teema lisamine
     * @param type $data tabeli topics veergude andmed
     */
    public function addTopic($data){
        $this->db->set('create_time', 'NOW()', FALSE);
        $this->db->insert($this->table, $data);
    }
    

    /**
     * Teema muutmine
     * @param type $tid teema id
     * @param type $data teema muutunud veerud ja sisu
     */
    public function editTopic($tid, $data){
        $this->db->where('id', $tid);
        $this->db->update($this->table, $data);
    }
    
    /**
     * Teema välja muutmine. Kasulik näiteks vaatamise arvu suurendamiseks (views = views + 1)
     * @param type $tid teema id
     * @param type $set set käsk (nt viws = views + 1)
     */
    public function editTopicSet($tid, $set){
        $set_count = count($set);
        for($i=0;$i<$set_count;$i++){
            $d = each($set);
            $this->db->set($d['key'], $d['value'], false);
        }
       
        $this->db->where('id', $tid);
        $this->db->update($this->table);
    }
      
    //TODO
    public function delTopic($tid){
        $this->db->delete($this->table, array('id' => $tid));
    }
    
}
