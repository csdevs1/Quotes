<?php
    require_once('AppController.php');
    require_once('Token.php');
    $token = new Token();
    include('SocialNetworks.php');

    if(isset($_POST['action'])=='check' && isset($_POST['token']) && $token->check($_POST['token'])){
        $email=$_POST['usr_info']['email'];
        $oauth_uid=$_POST['usr_info']['oauth_uid'];
        $fname=$_POST['usr_info']['fname'];
        $lname=$_POST['usr_info']['lname'];
        $gender=$_POST['usr_info']['gender'];
        $obj=new SocialNetwork($email);
        $json_response = array($obj->signup('facebook',$oauth_uid,$fname,$lname,$gender));
        echo json_encode($json_response);
    }else{
        echo 'Error 500';
    }
?>