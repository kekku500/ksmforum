<?php

class PostNode {
    
    private static $order_counter;
    
    public $children = array();
    public $order;
    
    public $data;
    
    
    public function preorder(){
        $preordered_data = array();
        $update_array = array();
        $stack = array($this);
        while(count($stack) > 0){
            $node = array_pop($stack);
            $node->order = ++self::$order_counter; //oluline osa
            $preordered_data[] = $node->data;
            $update_array[] = array('id' => $node->data['id'], 'pos' => $node->order);
            foreach($node->children as $child){
                $stack[] = $child;
            }
        }
        return array($preordered_data, $update_array);
    }
 
}

class Post_model extends CI_Model {
    
    private $table = 'posts';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    private function updatePostsPosition($tid){
        $this->db->order_by("depth", "asc");
        $this->db->order_by("p_pid", "asc");
        $this->db->order_by("create_time", "desc");
        $query = $this->db->get_where($this->table, array('tid' => $tid));
        
        $result = $query->result_array();

        $nodes = array();

        $root = new PostNode();
        $root->data = $result[0];
        $nodes[$root->data['id']] = $root;

        $data_count = count($result);
        for($i = 1;$i<$data_count;$i++){
            $row = $result[$i];
            $n = new PostNode();
            $n->data = $row;
            $nodes[$n->data['p_pid']]->children[] = $n;
            $nodes[$n->data['id']] = $n;
        }

        $res = $root->preorder();
        
        $this->db->update_batch($this->table, $res[1], 'id');
        
        return $res[0];
    }
    
    public function getPosts($tid){
        $this->db->order_by("pos", "asc");
        $query = $this->db->get_where($this->table, array('tid' => $tid));
                
        return $query->result_array();
    }
    
    public function getPostsJoinUser($tid){
        $this->db->order_by("pos", "asc");
        $this->db->join('users', 'users.id = '.$this->table.'.uid');
        $this->db->select(
                'posts.id as posts_id,
                p_pid,
                tid,
                content,
                posts.create_time as posts_create_time,
                posts.edit_time as posts_edit_time,
                depth,
                pos,
                users.id as users_id,
                name,
                usergroup');
        
        $query = $this->db->get_where($this->table, array('tid' => $tid));
                
        return $query->result_array();
    }
    
    public function getPost($pid){
        $query = $this->db->get_where($this->table, array('id' => $pid));
        return $query->row_array();
    }
    
        public function getPostJoinUser($pid){
        $this->db->order_by("pos", "asc");
        $this->db->join('users', 'users.id = '.$this->table.'.uid');
        $this->db->select(
                'posts.id as posts_id,
                p_pid,
                tid,
                content,
                posts.create_time as posts_create_time,
                posts.edit_time as posts_edit_time,
                depth,
                pos,
                users.id as users_id,
                name,
                usergroup');
        
        $query = $this->db->get_where($this->table, array('posts.id' => $pid));
                
        return $query->row_array();
    }
    
    
    
    
    public function addPost($tid, $p_pid, $content){
        $data = array(
            'tid' => $tid,
            'p_pid' => ($p_pid == 'null' ? null : $p_pid),
            'content' => $content,
            'uid' => $this->auth->getUserId()
        );

        $this->db->insert($this->table, $data);
        
        return $this->updatePostsPosition($tid);
    }
    
    public function delPost($pid){
        
    }
    
    public function editPost($pid, $content){
        
    }
    
}