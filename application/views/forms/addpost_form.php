<p>Lisa uus kommentaar</p>

<?php echo validation_errors(); ?>

<?php 

$segments = array('browser', 'addpost', $row_item['tid'], $row_item['id']);

echo form_open(site_url($segments)); ?>

<input type="hidden" name="form" value="addpost" />

<?php echo form_textarea(array(
    'name' => 'content',
    'value' => 'Kirjuta kommentaar siia'
));?>

<div><input type="submit" value="Lisa" /></div>

</form>



