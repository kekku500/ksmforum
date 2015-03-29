<?php
/*
* $topic := Array([id], [name])
* $root_post := Array([post_id])
* $next_page_valid
* $cur_page
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
        <?php
        }
        ?>
    </div>
    <?php
}



    





