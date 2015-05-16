<?php
/*
* Foorumi array väljad
* $parent_forum := Array([name])
* $forums elemendid := Array([id], [name], [topic_count], [post_count])
*/
?>

<table class="forum_table">
<?php //table-condensed table-hover  small
if(count($forums) > 0){
    //header ?>
    <tr>
        <th><?php echo sprintf($this->lang->line('subforum_header_name'), $parent_forum['name']); ?></th>
        <th><?php echo $this->lang->line('topic_header_post_count'); ?></th>
        <th><?php echo $this->lang->line('forum_header_topics'); ?></th> 
    </tr><?php
    //forums
    foreach ($forums as $forum){
        //foorum
        $forum_seg = array('main', 'forum', $forum['id']); //url
        $forum_name = $forum['name'];
        $topic_count = $forum['topic_count'];
        $post_count = $forum['post_count'];?>
        <tr>
            <td><?php echo '<a href="'.site_url($forum_seg).'">'.$forum_name.'</a>'; ?></td>
            
            <td><?php echo $post_count; ?></td>
            <td><?php echo $topic_count; ?></td>
        </tr>
        <?php
    }
}
?>
</table>
<br>