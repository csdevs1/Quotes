<?php
    session_start();
    if(isset($_SESSION['uID']) && !empty($_SESSION['uID']) /*&& sha1($_SESSION['uID'])==$_POST['uID']*/){
        require_once('AppController.php');
        $obj = new AppController();
        if(isset($_POST['arr']) && $_POST['action']=='save'){
            $data = json_decode($_POST['arr'],true);
            $data['userID']=$_SESSION['uID'];
            foreach($data as $key => $val){
                $cols[]=$key;
                $vals[]='"'.str_replace('"','\"',$val).'"';
            }
            $col = implode(", " , $cols);
            $val= implode(", " , $vals);
            $response=$obj->save('userImagesCollection',$col,$val);
            if($response){
                $json_response = array($response,'user'=>'example');
                echo json_encode($json_response);
            } else{
                $json_response = array($response);
                echo json_encode($json_response);
            }
        }
    }
?>