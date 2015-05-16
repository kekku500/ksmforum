<div id="auth_header">
    <?php
    if(!$this->auth->isLoggedIn()){
    ?>  
        <button onclick="registerPopup()"><?php echo $this->lang->line('button_register');?></button>
        <button onclick="loginPopup()"><?php echo $this->lang->line('button_login');?></button>
    <?php
        if($this->googleoauth2->hasValidAccessToken()){?>
            <button onclick="registerGooglePopup()"><?php echo $this->lang->line('button_registergoogle');?></button>
    <?php
        }
    }else{
        ?>
            <p><?php echo $this->lang->line('auth_header_user');?> <span><?php echo $user['name']; ?> </span></p>
        <?php
        $segments = array('main', 'logout', base64_encode(current_url()));
        echo anchor(site_url($segments), 'Logi välja');
        
        $segments = array('main', 'userpanel');
        echo ' '.anchor(site_url($segments), 'Seaded');

        if($this->user_model->getUserJoinUserGroup($this->auth->getUserId())['usergroup_name'] == 'admin'){
            $segments = array('main', 'admin');
            echo ' '.anchor(site_url($segments), 'Admin');
        }
    }
    ?>
</div>
