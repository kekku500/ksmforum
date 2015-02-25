<p>Lisa uus teema: <?php echo $row_item['name']; ?></p>

<?php 
if($this->input->post('form') == 'addtopic')
    echo validation_errors(); ?>

<?php 

$segments = array('main', 'addtopic', $row_item['id']);

echo form_open(site_url($segments)); ?>

<input type="hidden" name="form" value="addtopic">

<input type="text" name="title" value="Pealkiri" size="50" /><br>

<?php echo form_textarea(array(
    'name' => 'content',
    'value' => 'The sisu'
));?>

<div><input type="submit" value="Lisa" /></div>

</form>



