<div style="border:1px solid blue;text-align:center;display: inline-block;padding:2px;">
 
<?php
if(!$this->auth->isLoggedIn()){
    $segments = array('register');
    ?>
    <a style="padding:5px" href="<?php echo site_url($segments); ?>">Registreeri</a>
    <a style="padding:5px" href="#">Logi sisse</a>
    <?php
}else{
    $segments = array('main', 'logout', base64_encode(current_url()));
    echo anchor(site_url($segments), 'Logi välja');
    if($this->usergroup_model->getActiveUserGroup()['name'] == 'admin'){
        $segments = array('admin');
        echo ' '.anchor(site_url($segments), 'Admin');
    }
}
?>
</div>
