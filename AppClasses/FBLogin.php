<?php
    require_once('AppController.php');
    require_once('Token.php');
    $token = new Token();
    include('SocialNetworks.php');

    if(isset($_POST['action'])=='check' && isset($_POST['token']) && $token->check($_POST['token'])){
        $obj=new SocialNetwork($_POST['email']);
        $json_response = array($obj->signup('facebook',$_POST['oauth_uid'],'fname','lname','gender','picture'));
        echo json_encode($json_response);
    }else{
        echo 'Error 500';
    }
?>