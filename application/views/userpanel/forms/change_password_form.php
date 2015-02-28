<div style="border:5px solid;">    
    <p><?php echo $this->lang->line('changepassword_header'); ?></p>
    <?php 
    echo $this->multiform->validation_errors();
    ?>

    <?php
    echo $this->multiform->form_open(current_url()); 
    ?>
    
    <?php echo $this->lang->line('changepassword_oldpassword'); ?>
    <input type="text" name="oldpass" size="50" <?php if($pass_null == true) echo 'disabled value="-"';?> /><br>

    <?php echo $this->lang->line('changepassword_newpassword'); ?>
    <input type="text" name="pass" value="" size="50" /><br>

    <?php echo $this->lang->line('changepassword_newpassword_2'); ?>
    <input type="text" name="passconf" value="" size="50" /><br>

    <div>
        <input type="submit" value="<?php echo $this->lang->line('changepassword_button'); ?>" />
    </div>
    </form>
</div>



