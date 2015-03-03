<?php


class Session_model extends CI_Model {
    
    private $table = 'ci_sessions';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * @return type tabelis ci_sessions ridade arv, kus last_activity pole väga vana.
     */
    public function visitorCount(){
        $this->db->select('count(*) as amount');
        $this->db->where('last_activity >=', (now()-$this->config->item('sess_time_to_update')));
        $query = $this->db->get($this->table);
        return $query->row()->amount;
    }
    
}