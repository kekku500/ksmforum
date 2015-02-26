
<?php if($this->auth->isLoggedIn()){?>
<p><?php
$segments = array('main', 'addtopic', $fid);
?>
<a style="padding-left: 10px;" href="<?php echo site_url($segments); ?>">Loo uus teema</a>
</p>
<?php }?>    

<table border="1px" style="width:50%">
    <th><?php printf($this->lang->line('topic_header_name'), $header['name']); ?></th>
        <th><?php echo $this->lang->line('topic_header_post_count'); ?></th>
        <th><?php echo $this->lang->line('topic_header_views'); ?></th>
        
