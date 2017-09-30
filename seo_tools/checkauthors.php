<?php
    require_once '../AppClasses/AppController.php';
    $obj = new AppController();
    $authors = $obj->all('authors');
    $count=0;
    foreach($authors as $key=>$val){
        $count++;
        echo $obj->update('authors','authorID="'.$count.'"','authorID',$topics[$key]['authorID']).'<br>';
    }
?>