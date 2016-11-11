<?php
    require_once('AppController.php');
    session_start();
    require_once('Token.php');
    $obj = new AppController();
    $token=new Token();
    include('UserController.php');

    if(isset($_POST['table']) && !empty($_POST['table']) && isset($_POST['row']) && !empty($_POST['row']) && isset($_POST['val']) && !empty($_POST['val']) && $_POST['action']=='find_by'){
        $table = $_POST['table'];
        $row = $_POST['row'];
        $val = $_POST['val'];
        $json_response = array('response'=>200,$obj->find_by($table,$row,$val));
        echo json_encode($json_response);
    }elseif(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['passwd']) && !empty($_POST['passwd']) && !empty($_POST['token']) && $_POST['action']=='login'){ //check Token function
        $email = $_POST['email'];
        $passwd = $_POST['passwd'];
        $token = $_POST['token'];
        $user=new User();
        $response=$user->signin($email,$passwd,$token);
        if($response){
            $json_response = array('response'=>200,$response);
            echo json_encode($json_response);
        } else{
            $json_response = array('response'=>400,$response);
            echo json_encode($json_response);
        }
    }elseif(isset($_POST['col']) && !empty($_POST['val']) && $_POST['action']=='update'){ //check Token function
        $col = $_POST['col'];
        $val = $_POST['val'];
        $user=new User();
        $response=$user->changePicture($col,$val,$_SESSION['uID']);
        if($response){
            $json_response = array('response'=>200,$response);
            echo json_encode($json_response);
        } else{
            $json_response = array('response'=>400,$response);
            echo json_encode($json_response);
        }
    }else{
        $json_response = array('response'=>400);
            echo json_encode($json_response);
    }
?>