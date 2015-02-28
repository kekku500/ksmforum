<p>Kustuta foorumeid</p>

<?php 
echo $this->multiform->validation_errors();

echo $this->multiform->form_open(current_url()); ?>

<p style="margin-bottom: 0px;">Valik</p>
<select name="fid">
    <option value="null"></option>
    <?php
    foreach($forums as $forum){
        echo '<option value="'.$forum['id'].'">'.$forum['name'].'</option>';
    }
    ?>
</select>

<div><input type="submit" value="Kustuta foorum" /></div>


</form>