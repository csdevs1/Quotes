<?php
    session_start();
    require_once('AppController.php');
    require_once('Token.php');
    $obj = new AppController();
    $tokenObj = new Token();
    if($_POST['login'] && $tokenObj->check($_POST['token'])){
        $username = $_POST['usr'];
        $passwd = $_POST['pass'];
        $check="usrName='".sha1($username)."' AND usrPswd='".sha1($passwd)."'";
        $response = $obj->like('dashboard_usrs', $check);
        if(!empty($response)){
            session_start();
            $_SESSION['id']=$response[0]['id'];
            $_SESSION['userName']=$username;
            $_SESSION['lang']=$response[0]['lang'];
            $_SESSION['label']=$response[0]['label'];
            if($response[0]['insrt'])
                $_SESSION['permission'][0]=$response[0]['insrt'];
            if($response[0]['modif'])
                $_SESSION['permission'][1]=$response[0]['modif'];
            if($response[0]['del'])
                $_SESSION['permission'][2]=$response[0]['del'];
            $json_response = array('response'=>true);
            echo json_encode($json_response);
        } else{
            $json_response = array('response'=>false);
            echo json_encode($json_response);
        }
    }

    if($_POST['logout']){
        if(session_unset()){
            session_destroy();
            $json_response = array('response'=>true);
            echo json_encode($json_response);
        } else{
            $json_response = array('response'=>false);
            echo json_encode($json_response);
        }
    }
?>