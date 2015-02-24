<?php 
echo validation_errors();

?>
<div style="border:5px solid; display:inline-block;">    
<?php
echo form_open(current_url()); 
?>
    
<input type="hidden" name="form" value="login" />
    
<input type="text" name="user" value="Kasutajanimi" size="50" /><br>

<input type="text" name="pass" value="Salasõna" size="50" /><br>

<div>
    <input type="submit" value="Logi sisse" />
</p>
        
</div>

</form>
</div>



