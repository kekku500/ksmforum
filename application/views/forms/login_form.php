<?php 
$this->multiform->setForm('login');
?>
<div id="login_cover" onClick="popupOff()"></div>
<div id="login_form_outer">    
	<div id="login_form_inner">
		<?php
                echo $this->multiform->form_error('loginAttempt_field'); 
                
		echo $this->multiform->form_open(current_url()); 
		?>
		
		<?php echo $this->multiform->form_error('user'); ?>
               

                <?php echo $this->lang->line('login_user')?><br>
                <input type="text" name="user" value="<?php echo $this->multiform->set_value('user'); ?>" size="25" /><br>

                <?php echo $this->multiform->form_error('pass'); ?>


                <?php echo $this->lang->line('login_pass')?><br>
                <input type="text" name="pass" value="" size="30" /><br>

                
                <input type="submit" value="<?php echo $this->lang->line('login_button')?>" />

		</form>
		
	<?php 
	if(!$valid_accesstoken){
	?>
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
</div>







