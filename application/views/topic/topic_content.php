<?php
$level  = $row_item['depth'];
?>
 <div style="border:1px solid;position: relative;right: <?php echo -20*$level; ?>px;">
     <h5 style="margin-top: 0px;padding-top: 0px">
        <?php echo $row_item['post_edit_time'].' - user['.$row_item['name'].'] - id['.$row_item['post_id'].']'.' - parent['.$row_item['p_pid'].']'; ?>
        
        <?php
        if ($this->auth->isLoggedIn()){
            $segmentsadd = array('main', 'addpost', $row_item['tid'], $row_item['post_id']);
            $segmentsedit = array('main', 'editpost', $row_item['tid'], $row_item['post_id']);
           ?>
           <a style="padding-left: 10px;" href="<?php echo site_url($segmentsadd); ?>">Vasta</a>
           <?php 
           if($this->auth->getUserId() == $row_item['user_id']){?>
          <a style="padding-left: 10px;" href="<?php echo site_url($segmentsedit); ?>">Muuda</a>
           <?php
           }
        }
        ?>
     </h5>
    
     <p><?php echo $row_item['content']; ?></p>
 </div>
    





