<?php

    require_once('../../../AppClasses/AppController.php');
    require_once('../../../AppClasses/Token.php');
    $token = new Token();
    $obj = new AppController();

    if(isset($_POST['table']) && !empty($_POST['table']) && isset($_POST['row']) && !empty($_POST['row']) && isset($_POST['val']) && !empty($_POST['val']) && $_POST['action']=='find_by'){
        $table = $_POST['table'];
        $row = $_POST['row'];
        $val = $_POST['val'];

        $json_response = array('response'=>200,$obj->find_by($table,$row,$val));
        echo json_encode($json_response);

    } elseif(isset($_POST['table']) && !empty($_POST['data']) && $_POST['action']=='insert' && $token->check($_POST['token'])){
        $table = $_POST['table'];
        $data = json_decode($_POST['data'],true);

        foreach($data as $key => $val){
            $cols[]=$key;
            $vals[]="'$val'";
        }

        $col = implode(", " , $cols);
        $val= implode(", " , $vals);

        $response=$obj->save($table,$col,$val);
        if($response){
            $json_response = array('response'=>200);
            echo json_encode($json_response);
        } else{
            $json_response = array('response'=>400,$response);
            echo json_encode($json_response);
        }

    } elseif(isset($_POST['table']) && isset($_POST['column']) && !empty($_POST['column']) && isset($_POST['order']) && !empty($_POST['order']) && $_POST['action']=='limit'){
        $table = $_POST['table'];
        $column = $_POST['column'];
        $order = $_POST['order'];
        $limit = $_POST['limit'];

        $response = $response=$obj->limit($column,$table,$limit,$order);

        $json_response = array($response,'response'=>200);
        echo json_encode($json_response);

    } else {
        $json_response = array('response'=>400);
        echo json_encode($json_response);
    }

?>