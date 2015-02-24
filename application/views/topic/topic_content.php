<?php


    $level  = $row_item['depth'];?>
 <div style="border:1px solid;position: relative;right: <?php echo -20*$level; ?>px;">
     <h5 style="margin-top: 0px;padding-top: 0px">
         <?php echo $row_item['posts_create_time'].' - user['.$row_item['name'].'] - id['.$row_item['posts_id'].']'.' - parent['.$row_item['p_pid'].']'; ?>
        
        <?php
        if ($this->auth->isLoggedIn()){
            $segments = array('main', 'addpost', $row_item['tid'], $row_item['posts_id']);
           ?>
           <a style="padding-left: 10px;" href="<?php echo site_url($segments); ?>">Vasta</a>
        <?php
        }
        ?>
     </h5>
    
     <p><?php echo $row_item['content']; ?></p>
 </div>
    





