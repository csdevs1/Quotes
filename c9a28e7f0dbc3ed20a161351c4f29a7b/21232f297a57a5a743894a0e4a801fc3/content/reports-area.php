<?php
    session_start();
    require_once('../Classes/AppController.php');
    $obj = new AppController();
    $reports = $obj->custom('SELECT * FROM reports');
    function add3dots($string, $repl, $limit){
        if(strlen($string) > $limit){
            return substr($string, 0, $limit) . $repl;
        }
        else {
            return $string;
        }
    }
?>

<style>
    .list-group{padding-bottom: 10px;}
    .list-item-container {
        width: 100%;
        overflow: hidden;
        display: table;
    }
    .list-item-container div {
        display: table-cell;
        vertical-align: middle;
    }
    .list-item-container div h2 {
        padding-top: 20px;
        text-align: left;
    }
    .list-item-container .btn {
        width: 100%;
    }
    .icon-u{position: relative;}
    .icon-u .ion-person{font-size: 8rem;position: absolute;top:0;}
</style>

<div class="container-fluid" style="padding-top: 70px;">
    <div class="row">
        <div class="col-md-12">
            <?php foreach($reports as $key=>$val){
                    $title=$val['reason']; 
                    $msg=add3dots($val['description'], '...', 25);
                    $created_at=$val['created_at']; 
            ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Date Sent</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $title; ?></td>
                            <td><?php echo $msg; ?></td>
                            <td><?php echo $created_at; ?></td>
                        </tr>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </div>
</div>