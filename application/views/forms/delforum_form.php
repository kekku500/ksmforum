<div class="any_form">  
<p><?php echo $this->lang->line('delforum_header');?></p>

<p><?php echo $this->multiform->getSuccessMessage(); ?></p>
<?php 
echo $this->multiform->validation_errors();

echo $this->multiform->form_open(current_url()); ?>

    <p class="admin_item_box"><?php echo $this->lang->line('delforum_choice'); ?></p>
    <select name="fid">
        <option value="null"></option>
        <?php
        foreach($forums as $forum){
            echo '<option value="'.$forum['id'].'">'.$forum['name'].'</option>';
        }
        ?>
    </select>

    <div><input type="submit" value="<?php echo $this->lang->line('delforum_button'); ?>" /></div>


</form>
</div>