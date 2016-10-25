<?php
    require_once('Token.php');
    $obj = new Token();
    $json_response = array($obj->generate());
    echo json_encode($json_response);
?>