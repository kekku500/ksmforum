<?php
/*
* $topic := Array([id], [name])
* $root_post := Array([post_id])
* $next_page_valid
* $cur_page
* $page_offset
*/
if($cur_page > 1 || $next_page_valid){
    ?>
    <div class='post_container'>
        <?php 
        if($cur_page > 1){
            $segments_prevpage = array('main', 'topic', $topic['id'], $cur_page-1, $root_post['post_id']);?>
            <a href="<?php echo site_url($segments_prevpage); ?>"><?php echo 'Tagasi'; ?></a>
        <?php 
        }
        if($next_page_valid){
            $segments_nextpage = array('main', 'topic', $topic['id'], $cur_page+1, $root_post['post_id']);?>
            <a href="<?php echo site_url($segments_nextpage); ?>"><?php echo 'Edasi'; ?></a>
            
            <button onclick="loadPostContent(
            <?php echo "'".base_url()."','".$topic['id']."', '".($cur_page+1)."', '".$root_post['post_id']."', '".$page_offset."'";?>
                                            )">Ajax edasi</button> 
        <?php
        }
        ?>
    </div>
    <?php
}




    





