<div id="auth_header">
    <?php
    if(!$this->auth->isLoggedIn()){
    ?>
        <a style="padding:5px" onclick="registerPopup()" href="#">Registreeri</a>
        <a onclick="loginPopup()" style="padding:5px" href="#">Logi sisse</a>
    <?php
        if($this->googleoauth2->hasValidAccessToken()){?>
            <a onclick="registerGooglePopup()" style="padding:5px" href="#">Registreeri Google</a>
    <?php
        }
    }else{
        ?>
        Kasutaja: <strong><?php echo $user['name']; ?> </strong>
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
