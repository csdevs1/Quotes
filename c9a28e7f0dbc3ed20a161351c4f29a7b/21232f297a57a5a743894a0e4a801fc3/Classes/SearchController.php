<?php
    session_start();
    if(isset($_SESSION['userName']) && !empty($_SESSION['userName'])){
        require_once('AppController.php');
        $obj = new AppController();
        
        $table=$_POST['table'];
        $column=$_POST['col'];
        $text=str_replace("'","\'", $_POST['text']);
        $id=$_POST['id'];
        //MATCH
        if(isset($_POST['action']) && $_POST['action']=='match' && empty($_POST['option'])){
            //$quotes=$obj->custom("SELECT * FROM ".$table." WHERE MATCH(".$column.") AGAINST('".$text."') OR quoteID LIKE '%".$text."' ORDER BY MATCH(".$column.") AGAINST('".$text."') DESC;");
            $quotes=$obj->custom("SELECT * FROM ".$table." WHERE MATCH(".$column.") AGAINST('".$text."') OR ".$column." LIKE '%".$text."%' OR soundex(".$column.")=soundex('".$text."') ORDER BY MATCH(".$column.") AGAINST('".$text."') DESC;");
            $qRel=$obj->like('quotes',$id.'='.$quotes[0]['quoteID']);
            similar_text($quotes[0]['quote'],$text,$percent);
            $percentage=number_format((float)$percent, 2, '.', '');
            $json_response = array('percent'=>$percentage,'quoteID'=>$quotes[0]['quoteID'],'relID'=>$qRel[0]['id'],'quote'=>$quotes[0]['quote']);
            echo json_encode($json_response);
        }elseif(isset($_POST['action']) && $_POST['action']=='search'){ //SEARCH
            if($_POST['option']==0)
                $response=$obj->custom("SELECT * FROM ".$table." WHERE ".$id."='".$text."'");
            elseif($_POST['option']==1)
                $response=$obj->custom("SELECT * FROM ".$table." WHERE ".$column." LIKE '%".$text."%'");
            //$response=$obj->custom("SELECT * FROM ".$table." WHERE MATCH(".$column.") AGAINST('".$text."') OR ".$id."='".$text."' OR ".$column." LIKE '%".$text."%' OR soundex(".$column.")=soundex('".$text."')");
            //$response=$obj->custom("SELECT * FROM ".$table." WHERE ".$column." LIKE '%".$text."%' OR ".$id."='".$text."'");
            echo json_encode($response);
        }
    } else{
        $json_response = array('response'=>400,$response);
        echo json_encode($json_response);
    }
?>