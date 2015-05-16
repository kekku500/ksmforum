<div class="any_form">    
    <p><?php echo 'Kustuta kasutaja' ?></p>

    <?php 
    echo $this->multiform->validation_errors(); 
    ?>

    <?php 
    echo $this->multiform->form_open(current_url(), array('value' => 'deluser')); 
    ?>
        <input type="radio" name="delete" value="1">Jah<br>
        <input type="radio" name="delete" value="2">Ei
        
        <div>  
            <input id="deluser_button" type="submit" value="<?php echo 'Kustuta kasutaja'; ?>" />
        </div>

    </form>
</div>



