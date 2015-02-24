<a href="<?php echo base_url(); ?>">Kodu</a>
<?php 
echo validation_errors();

?>
<div style="border:5px solid; display:inline-block;">    
<?php
$segments = array('register');
echo form_open(site_url($segments)); 
?>

<input type="text" name="user" value="Kasutajanimi" size="50" /><br>

<input type="text" name="email" value="Email" size="50" /><br>

<input type="text" name="pass" value="Salasõna" size="50" /><br>

<input type="text" name="passconf" value="Korda salasõna" size="50" /><br>

<div><input type="submit" value="Registreeri" /></div>

</form>
</div>



