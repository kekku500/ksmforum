<?php
/*
* Foorumi array väljad
* $forums elemendid := Array([category_id], [category_name], [forum_id], [forum_name], [topic_count], [post_count])
*/
?>

<table class="table table-hover forum_table">
<?php
$category_id = -1;
foreach ($forums as $forum){
    //kontrolli, kas foorumi kategooria on muutunud
    $new_id = $forum['category_id'];
    if($new_id != $category_id){ //uus kategooria
        $category_id = $new_id;
        $category_name = $forum['category_name'];?> 
        <tr>
            <th><?php echo $category_name; ?></th>
            <th><?php echo $this->lang->line('forum_header_topics'); ?></th>
            <th><?php echo $this->lang->line('topic_header_post_count'); ?></th>
        </tr><?php
    }
    //foorum
    $forum_seg = array('main', 'forum', $forum['forum_id']); //url
    $forum_name = $forum['forum_name'];
    $topic_count = $forum['topic_count'];
    $post_count = $forum['post_count'];?>
    <tr>
        <td><?php echo '<a href="'.site_url($forum_seg).'">'.$forum_name.'</a>'; ?></td>
        <td><?php echo $topic_count; ?></td>
        <td><?php echo $post_count; ?></td>
    </tr>
    <?php
}
?>
</table>