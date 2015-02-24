<p>Loo foorumeid</p>
<?php echo validation_errors(); 

$segments = array('admin');
echo form_open(site_url($segments)); ?>

<input type="hidden" name="form" value="addforum" />

<input type="text" name="name" value="Nimi" size="50" /><br>

<p style="margin-bottom: 0px;">Vanem</p>
<select name="p_fid">
    <option value="null"></option>
    <?php
    foreach($forums as $forum){
        echo '<option value="'.$forum['id'].'">'.$forum['name'].'</option>';
    }
    ?>
</select>

<div><input type="submit" value="Loo foorum" /></div>


</form>