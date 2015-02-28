<div style="border:1px solid blue;text-align:center;display: inline-block;padding:2px;">
    <?php
    if(!$this->auth->isLoggedIn()){
    ?>
        <a style="padding:5px" href="#">Registreeri</a>
        <a style="padding:5px" href="#">Logi sisse</a>
    <?php
    }else{
        ?>
        Kasutaja: <strong><?php echo $user['name']; ?> </strong>
        <?php
        $segments = array('main', 'logout', base64_encode(current_url()));
        echo anchor(site_url($segments), 'Logi välja');
        
        $segments = array('main', 'userpanel');
        echo ' '.anchor(site_url($segments), 'Seaded');

        if($this->usergroup_model->getActiveUserGroup()['name'] == 'admin'){
            $segments = array('main', 'admin');
            echo ' '.anchor(site_url($segments), 'Admin');
        }
    }
    ?>
</div>
