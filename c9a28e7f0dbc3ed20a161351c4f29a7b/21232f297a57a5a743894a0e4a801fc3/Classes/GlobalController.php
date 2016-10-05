<?php
    require_once('AppController.php');
    require_once('Token.php');
    $token = new Token();
    $obj = new AppController();
    if(isset($_POST['table']) && !empty($_POST['table']) && isset($_POST['row']) && !empty($_POST['row']) && isset($_POST['val']) && !empty($_POST['val']) && $_POST['action']=='find_by'){
        $table = $_POST['table'];
        $row = $_POST['row'];
        $val = $_POST['val'];
        $json_response = array('response'=>200,$obj->find_by($table,$row,$val));
        echo json_encode($json_response);
    } elseif(isset($_POST['table']) && !empty($_POST['data']) && $_POST['action']=='insert' && $token->check($_POST['token'])){ //check Token function
        $table = $_POST['table'];
        $data = json_decode($_POST['data'],true);
        
        if(isset($_FILES['image']) && !empty($_FILES['image'])){
            $image_name = $_FILES['image']['name'];
            $image_type = $_FILES['image']['type'];
            $image_temp = $_FILES['image']['tmp_name'];
            $img_ext = pathinfo($image_name, PATHINFO_EXTENSION);
            $error = $_FILES['image']['error'];
            $random = rand(1000, 99000);
            if($error > 0) {
                $error = die("Error uploading file! Codigo: $error.");
                $json_response = array('error'=>$error);
            } else {
                move_uploaded_file($image_temp, "../../../images/quotes/".$random.".".$img_ext);
                $data['quoteImage']=$random.".".$img_ext;
            }
        }
        
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
    }elseif(isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['table']) && !empty($_POST['data']) && $_POST['action']=='update' && $token->check($_POST['token'])){ //check Token function
        $id = $_POST['id'];
        $table = $_POST['table'];
        $data = json_decode($_POST['data'],true);
        
        if(isset($_FILES['image']) && !empty($_FILES['image'])){
            $image_name = $_FILES['image']['name'];
            $image_type = $_FILES['image']['type'];
            $image_temp = $_FILES['image']['tmp_name'];
            $img_ext = pathinfo($image_name, PATHINFO_EXTENSION);
            $error = $_FILES['image']['error'];
            $random = rand(1000, 99000);
            if($error > 0) {
                $error = die("Error uploading file! Codigo: $error.");
                $json_response = array('error'=>$error);
            } else {
                move_uploaded_file($image_temp, "../../../images/quotes/".$random.".".$img_ext);
                $data['quoteImage']=$random.".".$img_ext;
            }
        }
        
        foreach($data as $key => $val){
            $vals[] = "$key='$val'";
        }
        $values = implode(',',$vals);
        $response =$obj->update($table,$values,$id);
        if($response){
            $json_response = array('response'=>200,$response);
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
    }elseif(isset($_POST['table']) && isset($_POST['column']) && !empty($_POST['column']) && isset($_POST['pattern']) && !empty($_POST['pattern']) && $_POST['action']=='like'){
        $table = $_POST['table'];
        $column = $_POST['column'];
        $p = $_POST['pattern'];
        foreach($column as $key => $val){
            $like[] = "$val LIKE '$p'";
        }
        $pattern = implode(' OR ',$like);
        $response = $response=$obj->like($table,$pattern);
        $json_response = array($response,'response'=>200);
        echo json_encode($json_response);
    } else {
        $json_response = array('response'=>400);
        echo json_encode($json_response);
    }
?>