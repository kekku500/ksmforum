<?php 
echo $this->multiform->validation_errors('login');
?>
<div style="border:5px solid; display:inline-block;">    
    <?php
    echo $this->multiform->form_open('login', current_url()); 
    ?>

    <input type="text" name="user" value="<?php echo $this->lang->line('login_user')?>" size="25" /><br>

    <input type="text" name="pass" value="<?php echo $this->lang->line('login_pass')?>" size="50" /><br>

        <div>
            <input type="submit" value="<?php echo $this->lang->line('login_button')?>" />
        </div>
    </form>
</div>



