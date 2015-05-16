<div class="any_form">
    <p>
    <?php echo sprintf($this->lang->line('addtopic_header'), $row_item['name']);?>
    </p>

    <?php 
    echo $this->multiform->validation_errors();

    echo $this->multiform->form_open(current_url());  ?>

        <?php echo $this->lang->line('addtopic_title'); ?><br>
        <input type="text" name="title" value="<?php echo $this->multiform->set_value('title'); ?>" size="50" /><br>

        <?php echo $this->lang->line('addtopic_content'); ?><br>
        <?php echo form_textarea(array(
            'name' => 'content',
            'value' => set_value('content')
        ));?>

        <div><input type="submit" value="<?php echo $this->lang->line('addtopic_button'); ?>" /></div>

    </form>
</div>



