<?php
$alphas = range('A', 'Z');
foreach($alphas as $key=>$val)
    echo '<a href="http://localhost/quotes/authorsPage.php?l='.$val.'">'.$val.'</a> ';

echo $_GET['l'];
?>