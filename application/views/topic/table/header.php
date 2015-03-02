
<?php if($this->auth->isLoggedIn()){?>
<p><?php
$segments = array('main', 'addtopic', $fid);
?>
<a id ="add_topic_link" href="<?php echo site_url($segments); ?>">Loo uus teema</a>
</p>
<?php }?>    

<table class="forum_table">
    <tr>
        <th><?php printf($this->lang->line('topic_header_name'), $header['name']); ?></th>
        <th><?php echo $this->lang->line('topic_header_post_count'); ?></th>
        <th><?php echo $this->lang->line('topic_header_views'); ?></th>
    </tr>
        
