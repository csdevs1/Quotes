<?php
    require_once('AppController.php');
    require_once('Token.php');
    session_start();
    $obj = new AppController();
    if($_SESSION['label']!='root'){
        if(isset($_POST['table']) && !empty($_POST['data']) && $_POST['action']=='logs'){
            $table = $_POST['table'];
            $data = json_decode($_POST['data'],true);
            $data['log']=$_SESSION['userName'].''.$data['log'];
            $data['userID']=$_SESSION['id'];
            foreach($data as $key => $val){
                $cols[]=$key;
                $vals[]='"'.str_replace('"','\"',$val).'"';
            }
            $col = implode(", " , $cols);
            $val= implode(", " , $vals);
            $response=$obj->save($table,$col,$val);
            if($response){
                $json_response = array('response'=>200,$response);
                echo json_encode($json_response);
            } else{
                $json_response = array('response'=>400,$response);
                echo json_encode($json_response);
            }
        }elseif(isset($_POST['table']) && !empty($_POST['data']) && $_POST['action']=='relation'){
            $table = $_POST['table'];
            $data = json_decode($_POST['data'],true);
            $data['userID']=$_SESSION['id'];
            foreach($data as $key => $val){
                $cols[]=$key;
                $vals[]="'$val'";
            }
            $col = implode(", " , $cols);
            $val= implode(", " , $vals);
            $response=$obj->save($table,$col,$val);
            if($response){
                $json_response = array('response'=>200,$response);
                echo json_encode($json_response);
            } else{
                $json_response = array('response'=>400,$response);
                echo json_encode($json_response);
            }
        }
    }else{
        $json_response = array('response'=>200,false);
        echo json_encode($json_response);
    }
?>