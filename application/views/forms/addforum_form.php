<p><?php echo $this->lang->line('addforum_header');?></p>

<p><?php echo $this->multiform->getSuccessMessage(); ?></p>
<?php 
echo $this->multiform->validation_errors();

echo $this->multiform->form_open(current_url());  ?>

    <?php echo $this->lang->line('addforum_name'); ?>
    <input type="text" name="name" value="<?php echo set_value('name'); ?>" size="50" /><br>

    <p style="margin-bottom: 0px;"><?php echo $this->lang->line('addforum_parent');?></p>
    <select name="p_fid">
        <option value="0">-</option>
        <?php
        foreach($forums as $forum){
            echo '<option value="'.$forum['id'].'">'.$forum['name'].'</option>';
        }
        ?>
    </select>

    <div><input type="submit" value="<?php echo $this->lang->line('addforum_button'); ?>" /></div>


</form>