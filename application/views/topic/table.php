<?php
/*
* Foorumi array väljad
* $forum := Array([name])
* $topics elemendid := Array([topic_id], [topic_name], [topic_edit_time], 
 *                          [topic_views, topic_post_count, user_name])
*/
?>

<table class="table table-hover forum_table small">
<?php

if($this->auth->isLoggedIn()){
    $segments = array('main', 'addtopic', $fid);
  ?><p>
      <a id ="add_topic_link" href="<?php echo site_url($segments); ?>">
        <?php echo $this->lang->line('addtopics_ref_link'); ?></a>
    </p><?php 
} 

if(count($topics) > 0){
    //header ?>
    <tr>
        <th><?php echo sprintf($this->lang->line('topic_header_name'), $forum['name']); ?></th>
        <th><?php echo $this->lang->line('topic_header_post_count'); ?></th>
        <th><?php echo $this->lang->line('topic_header_views'); ?></th>
    </tr><?php
    //topics
    foreach ($topics as $topic){
        //foorum
        $topic_seg = array('main', 'topic', $topic['topic_id']); //url
        $topic_name = $topic['topic_name'];
        $views = $topic['topic_views'];
        $post_count = $topic['topic_post_count'];?>
        <tr>
            <td><?php echo '<a href="'.site_url($topic_seg).'">'.$topic_name.'</a>'; ?></td>
            <td><?php echo $post_count; ?></td>
            <td><?php echo $views; ?></td>
        </tr>
        <?php
    }
}
?>
</table>