<?php

class Post_model extends CI_Model {
    
    private $table = 'posts';
    private $users = 'users';
    private $topics = 'topics';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Konstrueerib puu tabeli posts põhjal kasutades parent post id.
     * Läbib puu eesjärjestuses jättes meelde iga tipu positsiooni.
     * Positsioonid kirutatakse posts tabelisse.
     * @param type $tid teema id
     * @return type
     */
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
    
    /**
     * KEY JOIN-ib posts ja user tabelid ning tagastab
     * väljad post_id, p_pid, tid, content, posts_edit_time,
     * depth, pos, user_id, name, usergroup
     * @param type $tid teema id
     * @return type
     */
    public function getPosts($tid){
        $this->db->order_by("pos", "asc");
        $this->db->join($this->users, $this->users.'.id = '.$this->table.'.uid');
        $this->db->select(
                'posts.id as post_id,
                posts.p_pid as parent_post_id,
                content,
                posts.edit_time as post_edit_time,
                depth,
                pos as position,
                users.id as user_id,
                name as user_name,
                posts.deleted as deleted');
        
        $this->db->where('tid', $tid);
        $query = $this->db->get($this->table);
                
        return $query->result_array();
    }
    
    public function getPostsByUser($uid){
        $this->db->order_by("pos", "asc");
        $this->db->join($this->users, $this->users.'.id = '.$this->table.'.uid');
        $this->db->select(
                'posts.id as post_id,
                posts.p_pid as parent_post_id,
                content,
                posts.edit_time as post_edit_time,
                depth,
                pos as position,
                users.id as user_id,
                name as user_name,
                posts.deleted as deleted,
                tid as topic_id');
        
        $this->db->where('uid', $uid);
        $query = $this->db->get($this->table);
                
        return $query->result_array();
    }
    
    /**
     * Seaded: posts.php
     * @param type $root_post_id - Kommentaari id, mis on juureks
     * @param type $page_nr - Milline osa vastustest kuvada
     * @return type kommentaarid
     */
    public function getPostsPaginated($root_post_id, $page_nr = 1, $offset = 0){
        if(!(ctype_digit($root_post_id) || is_int($root_post_id)) || 
                !(ctype_digit($page_nr) || is_int($page_nr)) ||
                !(ctype_digit($offset) || is_int($offset)))
            return;
        $this->config->load('posts');
        //dont even ask
        $query_string = "select 
                            h3.id as post_id,
                            h3.p_pid as parent_post_id,
                            content,
                            h3.edit_time as post_edit_time,
                            depth,
                            pos as position,
                            users.id as user_id,
                            name as user_name,
                            h3.deleted as deleted
                        from 
                            (select *,
                                @num := if(@type = p_pid, @num + 1, 1) type_counter, 
                                @type := p_pid cur_type
                            from
                                (select posts.*, root_depth, root_pos,
                                    (@a:=IF(depth = (root_depth+1), 1, 0)+@a) post_count,
                                    (@b:=IF(pos > root_pos and depth <= root_depth, 0, @b)) valid,
                                    IF(depth >= root_depth+6, concat(p_pid, depth), id) as groupit,
                                    @num := 0, 
                                    @type := ''
                                from posts, 
                                    (select @a := 0, @b := 1, depth root_depth, tid root_tid, pos root_pos from posts where id=".$root_post_id.") h1
                                where 
                                    posts.tid = root_tid and 
                                    posts.pos >= root_pos
                                order by posts.pos asc) h2 
                            where valid = 1 and (post_count = 0 OR 
                                post_count between 
                                ".(($page_nr-1)*$this->config->item('max_post_count')+1+$offset)." and
                                ".($page_nr*$this->config->item('max_post_count')+$offset).") and
                                depth <= root_depth+".($this->config->item('max_post_depth')+1)."
                            order by h2.p_pid asc) h3
                        join users on users.id = h3.uid
                        where type_counter <= IF(depth-root_depth>0, ".$this->config->item('max_post_count')."/(depth-root_depth), ".$this->config->item('max_post_count').")+1
                        group by groupit
                        order by h3.pos asc";
       
        $query = $this->db->query($query_string);
        
        return $query->result_array();
    }
    
    
    public function getPostReplyCount($post_id){
        $this->db->select("count(*) as amount");
        
        $this->db->where(array('p_pid' => $post_id));
        
        $query = $this->db->get($this->table);
        
        return $query->row_array()['amount'];
    }
    
    public function getRootPost($tid){
        $this->db->select("posts.id as post_id");
        
        $this->db->where(array(
            'tid' => $tid,
            'p_pid' => null
                ));
        
        $query = $this->db->get($this->table, 1);
        
        return $query->row_array();
    }
    
    public function getPost($pid){
        $this->db->order_by("pos", "asc");
        $this->db->join($this->users, $this->users.'.id = '.$this->table.'.uid');
        $this->db->join($this->topics, $this->topics.'.id = '.$this->table.'.tid');
        $this->db->select(
                'posts.id as post_id,
                posts.p_pid as parent_post_id,
                content,
                posts.edit_time as post_edit_time,
                depth,
                pos as position,
                users.id as user_id,
                users.name as user_name,
                tid as topic_id,
                topics.name as topic_name,
                fid as forum_id,
                posts.deleted as deleted');
        
        $this->db->where('posts.id', $pid);
        $query = $this->db->get($this->table);
        
        if($query->num_rows() == 0)
            return null;
                
        return $query->row_array();
    }

    
    /**
     * 
     * @param type $tid teema id
     * @param type $p_pid vanema kommentaari id
     * @param type $content sisu
     * @return type tagastab postitused, mille positsioonid muutusid
     */
    public function addPost($tid, $p_pid, $content){

        $data = array(
            'tid' => $tid,
            'p_pid' => ($p_pid == 'null' ? null : $p_pid),
            'content' => $content,
            'uid' => $this->auth->getUserId()
        );
        $this->db->set('create_time', 'NOW()', FALSE);

        $this->db->insert($this->table, $data);
        
        return $this->updatePostsPosition($tid);
    }
    
    /**
     * Muudab kommentaari
     * @param type $pid kommentaari id
     * @param type $content sisu
     */
    public function editPost($pid, $data){
        $this->db->where('id', $pid);
        $this->db->update($this->table, $data);
    }
    
    /**
     * 
     * @param type $pid kommentaari id
     * @return boolean Kas kommentaaril on vastuseid või mõtte
     */
    public function hasReplies($pid){
       $query = $this->db->get_where($this->table, array(
           'p_pid' => $pid
       ));
       if($query->num_rows() == 0)
           return false;
       return true; 
    }
    
    public function isRoot($pid){
      $query = $this->db->get_where($this->table, array(
           'id' => $pid,
           'p_pid' => null
       ));
       if($query->num_rows() == 0)
           return false;
       return true; 
    }
    
    /**
     * 
     * @param type $pid
     */
    public function delPost($pid){
        $this->db->delete($this->table, array('id' => $pid));
    }
    
    public function getTopicMaxCreateTime($tid){
        $this->db->select_max('create_time');
        $this->db->where('tid', $tid);
        
        $query = $this->db->get($this->table);
        
        if($query->num_rows() == 0)
            return null;
                
        return $query->row_array();
    }
    
    
    /**
     * Kustutab järjest kõik postitused, millel on märge, et deleted
     * @param type $post
     * @param type $deleted_posts_ids
     * $return boolean Kas teema kustutati ära või mitte?
     */
    public function delPostRecursive($post){
        if(!$this->hasReplies($post['post_id'])){
            $this->delPost($post['post_id']);
            if(isset($post['parent_post_id']) != null){
                $parent = $this->getPost($post['parent_post_id']);
                if($parent['deleted'])
                    if($this->delPostRecursive($parent)){
                        return true;
                    }
            }else{
                $this->topic_model->delTopic($post['topic_id']);
                return true;
            }
        }else{
            $this->editPost($post['post_id'], array(
                'content' => "",
                'deleted' => 1));
        }
        return false;
    }
    
}

//Kommentaari puu loomiseks ja eesjärjestuse läibimiseks kasutatav mugavusobject.
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