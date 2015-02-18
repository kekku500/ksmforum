<?php

foreach ($forums as $forum_item){ 
    $segments = array('forum_browser_test', 'forums', $forum_item['id'])?>
    <h5><?php echo '<a href="'.site_url($segments).'">'.$forum_item['name'].'</a>'; ?></h5>
<?php } ?>

