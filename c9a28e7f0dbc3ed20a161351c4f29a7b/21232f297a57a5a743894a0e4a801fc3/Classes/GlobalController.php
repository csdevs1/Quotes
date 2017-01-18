<?php
    session_start();

    require_once('AppController.php');
    require_once('Token.php');
    $token = new Token();
    $obj = new AppController();
    if(isset($_POST['table']) && !empty($_POST['table']) && isset($_POST['row']) && !empty($_POST['row']) && isset($_POST['val']) && !empty($_POST['val']) && $_POST['action']=='find_by'){
        $table = $_POST['table'];
        $row = $_POST['row'];
        $val=str_replace("'","\'", $_POST['val']);
        $json_response = array('response'=>200,$obj->find_by($table,$row,$val));
        echo json_encode($json_response);
    } elseif(isset($_POST['table']) && !empty($_POST['data']) && $_POST['action']=='insert' && $token->check($_POST['token'])){ //check Token function
        $table = $_POST['table'];
        $data = json_decode($_POST['data'],true);
        
        if(isset($_FILES['image']) && !empty($_FILES['image'])){
            $remove[] = "'";
            $remove[] = '"';
            $remove[] = '.';
            $remove[] = ',';
            $remove[] = '&';
            $remove[] = '!';
            $remove[] = ';';
            $remove[] = ':';
            $remove[] = '/';
            $remove[] = '?';
            $remove[] = '`';
            if($table=='quotes_en'){
                $author_n=str_replace($remove, "", strtolower($data['author']));
                $a=implode('-', array_slice(explode(' ', strtolower($author_n)), 0, 10));            
                $q_arr=str_replace($remove, "", strtolower($data['quote']));
                $blankStripped=preg_replace('/\s+/', ' ', $q_arr);
                $q=implode('-', array_slice(explode(' ', strtolower($blankStripped)), 0, 10));
                $name=$a.'_'.$q;
            }elseif($table=='authors'){
                $author_n=str_replace($remove, "", strtolower($data['authorName']));
                $a=implode('-', array_slice(explode(' ', strtolower($author_n)), 0, 10));  
                $name=$a.'_portalquote';
            }elseif($table=='topicsImages'){
                $topic=str_replace($remove, "", strtolower($data['topicName']));
                unset($data['topicName']);
                $t=implode('-', array_slice(explode(' ', strtolower($topic)), 0, 10));  
                $name=$t.'_portalquote';
            }

            $image_name = $_FILES['image']['name'];
            $image_type = $_FILES['image']['type'];
            $image_temp = $_FILES['image']['tmp_name'];
            $img_ext = pathinfo($image_name, PATHINFO_EXTENSION);
            $error = $_FILES['image']['error'];
            if($error > 0) {
                $error = die("Error uploading file! Codigo: $error.");
                $json_response = array('error'=>$error);
            } else {
                if($table=='quotes_en'){
                    if(file_exists("../../../images/quotes/".$name.".".$img_ext)){unlink("../../../images/quotes/".$name.".".$img_ext);clearstatcache();}
                    move_uploaded_file($image_temp, "../../../images/quotes/".$name.".".$img_ext);
                    $data['quoteImage']=$name.".".$img_ext;
                }elseif($table=='authors'){
                    if(file_exists("../../../images/author-images/".$name.".".$img_ext)){unlink("../../../images/author-images/".$name.".".$img_ext);clearstatcache();}
                    move_uploaded_file($image_temp, "../../../images/author-images/".$name.".".$img_ext);
                    $data['authorImage']=$name.".".$img_ext;
                }elseif($table=='topicsImages'){
                    if(file_exists("../../../images/topics-images/".$name.".".$img_ext)){unlink("../../../images/topics-images/".$name.".".$img_ext);clearstatcache();}
                    move_uploaded_file($image_temp, "../../../images/topics-images/".$name.".".$img_ext);
                    $data['img_url']=$name.".".$img_ext;
                }
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
            $json_response = array('response'=>200,$data['quoteImage']);
            echo json_encode($json_response);
        } else{
            $json_response = array('response'=>400,$response);
            echo json_encode($json_response);
        }
    }elseif(isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['table']) && !empty($_POST['data']) && $_POST['action']=='update' && $token->check($_POST['token'])){ //check Token function
        $id = $_POST['id'];
        $table = $_POST['table'];
        $row = $_POST['row'];
        $data = json_decode($_POST['data'],true);
        
        if(isset($_FILES['image']) && !empty($_FILES['image'])){
            if(isset($_SESSION['label']) && !empty($_SESSION['label']) && $_SESSION['label']=='image'){
                if($table=='quotes_en'){
                    // CHECK IF QUOTE ID AND USER ALREADY EXISTS IN dashboardUsr_Quote_en
                    $image_user=$obj->custom('SELECT COUNT(userID) as "cnt" FROM dashboardUsr_Quote_en WHERE userID='.$_SESSION['id'].' AND quoteID='.$id);
                    if($image_user[0]['cnt']<1){ // CHECK IF THERE'S A RELATION BETWEEN THE QUOTE AND THE USER
                        $obj->save('dashboardUsr_Quote_en','userID,quoteID',$_SESSION['id'].','.$id);
                    }
                }elseif($table=='quotes_es'){
                    // CHECK IF QUOTE ID AND USER ALREADY EXISTS IN dashboardUsr_Quote_en
                    $image_user=$obj->custom('SELECT COUNT(userID) as "cnt" FROM dashboardUsr_Quote_es WHERE userID='.$_SESSION['id'].' AND quoteID='.$id);
                    if($image_user[0]['cnt']<1){ // CHECK IF THERE'S A RELATION BETWEEN THE QUOTE AND THE USER
                        $obj->save('dashboardUsr_Quote_es','userID,quoteID',$_SESSION['id'].','.$id);
                    }
                }elseif($table=='quotes_pt'){
                    // CHECK IF QUOTE ID AND USER ALREADY EXISTS IN dashboardUsr_Quote_en
                    $image_user=$obj->custom('SELECT COUNT(userID) as "cnt" FROM dashboardUsr_Quote_pt WHERE userID='.$_SESSION['id'].' AND quoteID='.$id);
                    if($image_user[0]['cnt']<1){ // CHECK IF THERE'S A RELATION BETWEEN THE QUOTE AND THE USER
                        $obj->save('dashboardUsr_Quote_pt','userID,quoteID',$_SESSION['id'].','.$id);
                    }
                }
            }
            $remove[] = "'";
            $remove[] = '"';
            $remove[] = '.';
            $remove[] = ',';
            $remove[] = '&';
            $remove[] = '!';
            $remove[] = ';';
            $remove[] = ':';
            $remove[] = '/';
            $remove[] = '?';
            $remove[] = '`';
            if($table=='quotes_en'){
                $author_n=str_replace($remove, "", strtolower($data['author']));
                $a=implode('-', array_slice(explode(' ', strtolower($author_n)), 0, 10));            
                $q_arr=str_replace($remove, "", strtolower($data['quote']));
                $blankStripped=preg_replace('/\s+/', ' ', $q_arr);
                $q=implode('-', array_slice(explode(' ', strtolower($blankStripped)), 0, 10));
                $name=$a.'_'.$q;
            }elseif($table=='authors'){
                $author_n=str_replace($remove, "", strtolower($data['authorName']));
                $a=implode('-', array_slice(explode(' ', strtolower($author_n)), 0, 10));  
                $name=$a.'_portalquote';
            }elseif($table=='topicsImages'){
                $topic=str_replace($remove, "", strtolower($data['topicName']));
                unset($data['topicName']);
                $t=implode('-', array_slice(explode(' ', strtolower($topic)), 0, 10));  
                $name=$t.'_portalquote';
            }
            
            $image_name = $_FILES['image']['name'];
            $image_type = $_FILES['image']['type'];
            $image_temp = $_FILES['image']['tmp_name'];
            $img_ext = pathinfo($image_name, PATHINFO_EXTENSION);
            $error = $_FILES['image']['error'];
            if($error > 0) {
                $error = die("Error uploading file! Codigo: $error.");
                $json_response = array('error'=>$error);
            } else {
                if($table=='quotes_en'){
                    if(file_exists("../../../images/quotes/".$name.".".$img_ext)){unlink("../../../images/quotes/".$name.".".$img_ext);clearstatcache();}
                    move_uploaded_file($image_temp, "../../../images/quotes/".$name.".".$img_ext);
                    $data['quoteImage']=$name.".".$img_ext;
                }elseif($table=='authors'){
                    if(file_exists("../../../images/author-images/".$name.".".$img_ext)){unlink("../../../images/author-images/".$name.".".$img_ext);clearstatcache();}
                    move_uploaded_file($image_temp, "../../../images/author-images/".$name.".".$img_ext);
                    $data['authorImage']=$name.".".$img_ext;
                }elseif($table=='topicsImages'){
                    if(file_exists("../../../images/topics-images/".$name.".".$img_ext)){unlink("../../../images/topics-images/".$name.".".$img_ext);clearstatcache();}
                    move_uploaded_file($image_temp, "../../../images/topics-images/".$name.".".$img_ext);
                    $data['img_url']=$name.".".$img_ext;
                }
            }
        }
        
        foreach($data as $key => $val){
            if($key=='usrPswd'){
                $val=sha1($val);
            }
            $vals[] = $key.'="'.str_replace('"','\"',$val).'"';
        }
        $values = implode(',',$vals);
        $response =$obj->update($table,$values,$row,$id);
        if($response){
            $json_response = array('response'=>200,$data['quoteImage']);
            echo json_encode($json_response);
        } else{
            $json_response = array('response'=>400,$response);
            echo json_encode($json_response);
        }
    }elseif($_POST['action']=='delete' && $token->check($_POST['token'])){
        $val = $_POST['val'];
        $row = $_POST['row'];
        $table = $_POST['table'];
        $response =$obj->delete($_POST['table'],$row,$val);        
        $json_response = array('response'=>200,$response);
        echo json_encode($json_response);
    }
    elseif(isset($_POST['table']) && isset($_POST['column']) && !empty($_POST['column']) && isset($_POST['order']) && !empty($_POST['order']) && $_POST['action']=='limit'){
        $table = $_POST['table'];
        $column = $_POST['column'];
        $order = $_POST['order'];
        $limit = $_POST['limit'];
        $response = $obj->limit($column,$table,$limit,$order);
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
    }elseif(isset($_POST['table']) && $_POST['action']=='all'){
        $table = $_POST['table'];
        $response = $response=$obj->all($table);
        $json_response = array($response,'response'=>200);
        echo json_encode($json_response);
    }elseif(isset($_POST['table']) && $_POST['action']=='order_by'){
        $table = $_POST['table'];
        $row = $_POST['row'];
        $order = $_POST['order'];
        $val=str_replace("'","\'", $_POST['val']);
        $q=' ORDER BY '.$row.' '.$order;
        $table.=$q;
        $json_response = array('response'=>200,$obj->all($table));
        echo json_encode($json_response);
    } else {
        $json_response = array('response'=>400);
        echo json_encode($json_response);
    }
?>