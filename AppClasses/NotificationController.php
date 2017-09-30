<?php
    session_start();
    if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){
        require_once('AppController.php');
        $obj = new AppController();
        if($_POST['action'] === 'last_six'){
            $uID=$_POST['data'];
            $followerID=$_SESSION['uID'];
            $response=$obj->custom("UPDATE notifications SET seen=1 WHERE userID='".$_SESSION['uID']."'");
            $json_response=array($response);
            echo json_encode($json_response);
        }elseif(isset($_POST['data']) && !empty($_POST['data']) && $_POST['action'] === 'all_notification'){
            /*$uID=$_POST['data'];
            $followerID=$_SESSION['uID'];
            $response=$obj->custom("DELETE FROM followers WHERE userID=$uID AND followerID=$followerID");
            $response2=$obj->custom("SELECT COUNT(userID)  AS 'cnt' FROM followers WHERE userID=$uID");
            $json_response=array($response2);
            echo json_encode($json_response);*/
        }
    }
?>