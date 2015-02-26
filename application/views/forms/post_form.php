<p><?php echo $title ?></p>

<?php 
echo $this->multiform->validation_errors($callback); 
?>

<?php 
$segments = array('main', $callback, $row_item['tid'], $row_item['post_id']);
$this->multiform->form_open($callback, site_url($segments)); 
?>

    <?php echo form_textarea(array(
        'name' => 'content',
        'value' => $content
    ));?>

    <div>
        <input type="submit" value="<?php echo $submit; ?>" />
    </div>

</form>



