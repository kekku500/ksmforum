<p><?php echo $title ?></p>

<?php 
echo $this->multiform->validation_errors(); 
?>

<?php 
//$segments = array('main', $this->multiform->getForm(), $row_item['tid'], $row_item['post_id']);
//site_url($segments)
echo $this->multiform->form_open(current_url()); 
?>

    <?php echo form_textarea(array(
        'name' => 'content',
        'value' => $content
    ));?>

    <div>
        <input type="submit" value="<?php echo $submit; ?>" />
    </div>

</form>



