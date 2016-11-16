<?php
    require_once('AppController.php');
    $obj = new AppController();
    echo $obj->custom("SELECT * FROM quotes_en WHERE MATCH(quote) AGAINST('Awesome') ORDER BY MATCH(quote) AGAINST('Awesome') DESC;");
?>