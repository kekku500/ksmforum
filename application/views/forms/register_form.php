
<div id="register_form_outer">    
	<div id="register_form_inner">
		<?php 
		echo $this->multiform->validation_errors();
		?>
	
		<?php
		echo $this->multiform->form_open(current_url()); 
		?>
		<?php echo $this->lang->line('login_user'); ?>
		<input type="text" name="user" value="<?php echo $this->multiform->set_value('user'); ?>" size="25" /><br>

		<?php echo $this->lang->line('register_email'); ?>
		<input type="text" name="email" value="<?php echo $this->multiform->set_value('email'); ?>" size="50" /><br>

		<?php echo $this->lang->line('login_pass'); ?>
		<input type="text" name="pass" value="" size="50" /><br>

		<?php echo $this->lang->line('register_pass_2'); ?>
		<input type="text" name="passconf" value="" size="50" /><br>

		<div>
			<input type="submit" value="<?php echo $this->lang->line('register_button'); ?>" />
		</div>
		</form>
	</div>
</div>



