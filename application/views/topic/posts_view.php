<?php
/*
* $topic := Array([id], [name])
* $posts elemendid := Array([post_id], [parent_post_id], [content], 
 * [post_edit_time], [depth], [position[,[user_id], [user_name])
*/

// TIITEL?>
<h3><?php echo $topic['name']; ?></h3>
<?php
// KOMMENTAARID
foreach($posts as $post){?>
    <div class='post_container' style="right: <?php echo -20*$post['depth']; ?>px;">
        <h5>
      <?php echo $post['post_edit_time'].' - user['.$post['user_name'].'] - id['.$post['post_id'].']'.' - parent['.$post['parent_post_id'].']'; 
            if ($this->auth->isLoggedIn()){
                //if($this->auth->getUserId() != $post['user_id']){ //kui praegune kasutaja ei loonud seda kommentaari
                    $segmentsadd = array('main', 'addpost', $topic['id'], $post['post_id']);?>
                    <a href="<?php echo site_url($segmentsadd); ?>"><?php echo $this->lang->line('post_anchor_add'); ?></a><?php 
                //}
                if($this->auth->getUserId() == $post['user_id']){ //looja saab kommentaari muuta
                    $segmentsedit = array('main', 'editpost', $topic['id'], $post['post_id']);?>
                    <a href="<?php echo site_url($segmentsedit); ?>"><?php echo $this->lang->line('post_anchor_edit'); ?></a>
                <?php
                }
            }
            ?>
        </h5>
        
        <p><?php echo $this->security->xss_clean($post['content']); ?></p>
    </div>
<?php
}?>
    





