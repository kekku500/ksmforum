<?php 
$this->multiform->setForm('login');
echo $this->multiform->form_error('loginAttempt_field'); 
?>
<div style="border:5px solid; display:inline-block;">    
    <?php
    echo $this->multiform->form_open(current_url()); 
    ?>
    
    <?php echo $this->multiform->form_error('user'); ?>
    <?php echo $this->lang->line('login_user')?>
    <input type="text" name="user" value="<?php echo set_value('user'); ?>" size="25" /><br>

    <?php echo $this->multiform->form_error('pass'); ?>
    <?php echo $this->lang->line('login_pass')?>
    <input type="text" name="pass" value="" size="50" /><br>

        <div>
            <input type="submit" value="<?php echo $this->lang->line('login_button')?>" />
        </div>
    </form>
    
<?php 
if(!$valid_accesstoken){
?>
    <br>
    <?php 
    $this->multiform->setForm('logingoogle');
    echo $this->multiform->validation_errors();
    echo $this->multiform->form_open(current_url()); 
    ?>
        <input type="submit" value="<?php echo $this->lang->line('logingoogle_button')?>" />
    </form>
<?php
}
?>
</div>







