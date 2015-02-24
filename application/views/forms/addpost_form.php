<p><?php echo $title ?></p>

<?php echo validation_errors(); ?>

<?php 

$segments = array('main', $callback, $row_item['tid'], $row_item['posts_id']);

echo form_open(site_url($segments)); ?>

<input type="hidden" name="form" value="<?php echo $callback; ?>" />

<?php echo form_textarea(array(
    'name' => 'content',
    'value' => $content
));?>

<div><input type="submit" value="<?php echo $submit; ?>" /></div>

</form>



