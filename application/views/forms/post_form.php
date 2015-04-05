<p><?php echo $title ?></p>

<?php 
echo $this->multiform->validation_errors(); 
?>

<?php 
//$segments = array('main', $this->multiform->getForm(), $row_item['tid'], $row_item['post_id']);
//site_url($segments)
echo $this->multiform->form_open(current_url(), array('value' => 'addpost')); 
?>
    <div id="addPostContentWrapper">
        <?php echo form_textarea(array(
            'name' => 'content',
            'value' => $content
        ));?>
    </div>
    <div>  
        <input id="addpost_button" type="submit" value="<?php echo $submit; ?>" />
    </div>

</form>
    <div>     
        <button type="button" class="ajax_button" onClick="return clickedAddPost('<?php echo $post['post_id']; ?>')"><?php echo $submit." AJAX"; ?></button>
    </div>



