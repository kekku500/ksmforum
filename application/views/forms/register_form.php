<?php 
if($this->input->post('form') == 'register')
    echo validation_errors();

?>
<div style="border:5px solid; display:inline-block;">    
<?php
//$segments = array('main', 'register');
echo form_open(current_url()); 
?>
    
<input type="hidden" name="form" value="register" />

<input type="text" name="user" value="Kasutajanimi" size="50" /><br>

<input type="text" name="email" value="Email" size="50" /><br>

<input type="text" name="pass" value="Salasõna" size="50" /><br>

<input type="text" name="passconf" value="Korda salasõna" size="50" /><br>

<div><input type="submit" value="Registreeri" /></div>

</form>
</div>



