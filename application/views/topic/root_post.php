<?php
/*
* $topic := Array([id], [name])
* $post := Array([post_id], [parent_post_id], [content], 
* [post_edit_time], [depth], [position[,[user_id], [user_name], [deleted])
* topic_root_post_id
*/

// TIITEL?>

<h3 class="lead"><?php echo $topic['name']; ?></h3>

<?php
if(!isset($response_disabled))
    $response_disabled = false;


$cur_url_encoded = base64_encode(current_url());
if($post['parent_post_id'] != null){
    $segments_root = array('main', 'topic', $topic['id'], 1, $topic_root_post_id);
  ?><a href="<?php echo site_url($segments_root); ?>"><?php echo 'Algusesse'; ?></a>
      <br><?php
    $segments_upper = array('main', 'topic', $topic['id'], 1, $post['parent_post_id']);
  ?><a href="<?php echo site_url($segments_upper); ?>"><?php echo 'Ülespoole'; ?></a><?php
}
?>

<div class='post_container small' <?php echo 'id="'.$post['post_id'].'"'; ?>>
    <h5>
  <?php echo $post['user_name']." - ".$post['post_edit_time']; 
        if ($this->auth->isLoggedIn() && !$post['deleted'] && !$response_disabled){
            //if($this->auth->getUserId() != $post['user_id']){ //kui praegune kasutaja ei loonud seda kommentaari
                $segmentsadd = array('main', 'addpost', $post['post_id'], $cur_url_encoded);?>
                <a href="<?php echo site_url($segmentsadd); ?>"><?php echo $this->lang->line('post_anchor_add'); ?></a><?php 
            //}
            if($this->auth->getUserId() == $post['user_id']){ //looja saab kommentaari muuta ja kustutada
                $segmentsedit = array('main', 'editpost', $post['post_id'], $cur_url_encoded);?>
                <a href="<?php echo site_url($segmentsedit); ?>"><?php echo $this->lang->line('post_anchor_edit'); ?></a>
            <?php
                $segmentsdel = array('main', 'delpost', $post['post_id'], $cur_url_encoded);?>
                <a href="<?php echo site_url($segmentsdel); ?>"><?php echo $this->lang->line('post_anchor_del'); ?></a>
          <?php
            }
        }
        ?>
    </h5>

    <p>
        <?php 
        if($post['deleted']){
            echo $this->lang->line('post_deleted_content');
        }else{
            echo $this->security->xss_clean($post['content']); 
        }


        ?>
    </p>
</div>
<hr>   





