<?php
session_start();
require_once('AppController.php');
$obj = new AppController();

if(isset($_POST['quoteID']) && !empty($_POST['quoteID']) && $_POST['action'] === 'likeQT'){
    $quoteID=$_POST['quoteID'];
    //$userID=$_SESSION['uID'];
    $userID=3;
    $response=$obj->save('likes_en','quoteID,userID',"$quoteID,$userID");
    if($response){
        $response2=$obj->custom("SELECT COUNT(quoteID)  AS 'cnt' FROM likes_en WHERE quoteID=$quoteID");
        $json_response=array($response2);
        echo json_encode($json_response);
    }
}elseif(isset($_POST['quoteID']) && !empty($_POST['quoteID']) && $_POST['action'] === 'dislikeQT'){
    $quoteID=$_POST['quoteID'];
    //$userID=$_SESSION['uID'];
    $userID=3;
    $response=$obj->custom("DELETE FROM likes_en WHERE userID=$userID AND quoteID=$quoteID");
    $response2=$obj->custom("SELECT COUNT(quoteID)  AS 'cnt' FROM likes_en WHERE quoteID=$quoteID");
    $json_response=array($response2);
    echo json_encode($json_response);
}
?>