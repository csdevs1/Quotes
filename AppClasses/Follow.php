<?php
    session_start();
    if(isset($_POST['data']) && !empty($_POST['data']) && sha1($_POST['data'])==$_POST['uID']){
        require_once('AppController.php');
        $obj = new AppController();
        if(isset($_POST['data']) && !empty($_POST['data']) && $_POST['action'] === 'follow'){
            $uID=$_POST['data'];
            $followerID=$_SESSION['uID'];
            $response=$obj->save('followers','userID,followerID',"$uID,$followerID");
            if($response){
                $obj->save('notifications','userID,notification',$uID.',"<span class=\'pull-left\'><i class=\'fa fa-user-plus fa-2x text-info\'></i></span><span> <a href=\'/panel/quotes/'.$_SESSION['uname'].'\' rel=\'nofollow\'>'.$_SESSION['uname'].'</a> is following you"');
                $response2=$obj->custom("SELECT COUNT(userID)  AS 'cnt' FROM followers WHERE userID=$uID");
                $json_response=array($response2);
                echo json_encode($json_response);
            }
        }elseif(isset($_POST['data']) && !empty($_POST['data']) && $_POST['action'] === 'unfollow'){
            $uID=$_POST['data'];
            $followerID=$_SESSION['uID'];
            $response=$obj->custom("DELETE FROM followers WHERE userID=$uID AND followerID=$followerID");
            $response2=$obj->custom("SELECT COUNT(userID)  AS 'cnt' FROM followers WHERE userID=$uID");
            $json_response=array($response2);
            echo json_encode($json_response);
        }
    }
?>