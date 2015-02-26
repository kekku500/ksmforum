<?php 
echo $this->multiform->validation_errors('register');
?>
<div style="border:5px solid; display:inline-block;">    
    <?php
    echo $this->multiform->form_open('register', current_url()); 
    ?>

    <input type="text" name="user" value="<?php echo $this->lang->line('login_user'); ?>" size="25" /><br>

    <input type="text" name="email" value="<?php echo $this->lang->line('register_email'); ?>" size="50" /><br>

    <input type="text" name="pass" value="<?php echo $this->lang->line('login_pass'); ?>" size="50" /><br>

    <input type="text" name="passconf" value="<?php echo $this->lang->line('register_pass_2'); ?>" size="50" /><br>

    <div>
        <input type="submit" value="<?php echo $this->lang->line('register_button'); ?>" />
    </div>
    </form>
</div>



