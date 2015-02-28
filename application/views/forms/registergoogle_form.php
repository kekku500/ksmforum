<?php 
echo $this->multiform->validation_errors();
?>
<div style="border:5px solid; display:inline-block;">    
    <?php
    echo $this->multiform->form_open(current_url()); 
    ?>
    
    <?php echo $this->lang->line('login_user'); ?>
    <input type="text" name="user" value="<?php echo set_value('user'); ?>" size="25" /><br>
    
    <?php echo $this->lang->line('register_email'); ?>
    <input disabled type="text" name="dontcare_meh" value="<?php echo $google_email; ?>" size="30" /><br>

    <div>
        <input type="submit" value="<?php echo $this->lang->line('registergoogle_button'); ?>" />
    </div>
    </form>
</div>



