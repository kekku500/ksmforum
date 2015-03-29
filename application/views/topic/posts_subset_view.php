<?php
/*
* $topic := Array([id], [name])
* $posts elemendid := Array([post_id], [parent_post_id], [content], 
* [post_edit_time], [depth], [position[,[user_id], [user_name], [deleted])
*/
?>
<?php
// KOMMENTAARID
$max_depth = $this->config->item('max_post_depth')+$posts[0]['depth'];
$prev_post_id = -1;
$root_depth = $posts[0]['depth'];
$post_count_stack = array();
$prev_post_id = $posts[0]['post_id'];
$posts_count = count($posts);
$cur_url_encoded = base64_encode(current_url());
for($i = 1;$i<$posts_count;$i++){
    $post = $posts[$i];
    $stack_size = count($post_count_stack);
    if($post['depth'] > $stack_size){ //depth inc
        array_push($post_count_stack, array(1, $prev_post_id));
    }else{ //same depth or depth dec
        $temp = 1;
        if($post['depth'] < $stack_size){ //depth dec
            array_pop($post_count_stack);
            $temp++;
        }
        $post_count_stack[$stack_size-$temp][0]++; //inc last element*/
    }
    $prev_post_id = $post['post_id'];
    ?>
    <div class='post_container' style="right: <?php echo -20*($post['depth']-$root_depth-1); ?>px;">
        <?php
        if($post['depth']-$root_depth > 0){
            $max_post_count = $this->config->item('max_post_count')/($post['depth']-$root_depth);
            if(end($post_count_stack)[0] > $max_post_count){ //post count limit
                $segments_deeper = array('main', 'topic', $topic['id'], 1, end($post_count_stack)[1]);
                ?><a href="<?php echo site_url($segments_deeper); ?>"><?php echo 'Edasi'; ?></a>
                </div><?php
                continue;
            }
        }
        if($post['depth'] > $max_depth){
            $segments_deeper = array('main', 'topic', $topic['id'], 1, $prev_post_id);
            ?><a href="<?php echo site_url($segments_deeper); ?>"><?php echo 'Sügavamale'; ?></a><?php
        }else{?>
            <h5>
          <?php echo $post['post_edit_time'].' - user['.$post['user_name'].'] - id['.$post['post_id'].']'.' - parent['.$post['parent_post_id'].']'; 
                if ($this->auth->isLoggedIn() && !$post['deleted']){
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
        <?php
        }
        ?>
    </div>
<?php
    $prev_post_id = $post['post_id'];
}

    





