<?php
    require_once('AppController.php');
    session_start();
    require_once('Token.php');
    $obj = new AppController();
    include('UserController.php');

    if(isset($_POST['table']) && !empty($_POST['table']) && isset($_POST['row']) && !empty($_POST['row']) && isset($_POST['val']) && !empty($_POST['val']) && $_POST['action']=='find_by'){
        $table = $_POST['table'];
        $row = $_POST['row'];
        $val = $_POST['val'];
        $json_response = array('response'=>200,$obj->find_by($table,$row,$val));
        echo json_encode($json_response);
    }elseif(isset($_POST['table']) && !empty($_POST['data']) && $_POST['action']=='insert' && !empty($_POST['token'])){ //check Token function
        $table = $_POST['table'];
        $token = $_POST['token'];
        $data = json_decode($_POST['data'],true);
        $data['username']=substr($data['email'], 0, strpos($data['email'], "@"));
        $user=new User($table,$data);
        $response=$user->signup($token);
        if($response){
            $json_response = array('response'=>200,$response);
            echo json_encode($json_response);
        } else{
            $json_response = array('response'=>400,$response);
            echo json_encode($json_response);
        }
    }
?>