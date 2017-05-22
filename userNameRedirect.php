<?php
    require_once('AppClasses/AppController.php');
    $obj = new AppController();
    $user = $obj->like('users','username="'.$_GET['uname'].'" AND active=1');
    if(!empty($user[0]['username']) && isset($user[0]['username']))
        header('Location: https://portalquote.com/panel/quotes/'.$_GET['uname'].'/1');
    else
        header('Location: https://portalquote.com');
?>