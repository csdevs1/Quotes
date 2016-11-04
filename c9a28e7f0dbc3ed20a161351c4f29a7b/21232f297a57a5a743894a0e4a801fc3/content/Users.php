<?php
    session_start();
    require_once('../Classes/AppController.php');
    $obj = new AppController();
    $users = $obj->custom('SELECT * FROM dashboard_usrs WHERE label <> "root"');
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
        margin-top: 30%;
    }
    .icon-u{position: relative;}
    .icon-u .ion-person{font-size: 8rem;position: absolute;top:0;}
</style>

<div class="container-fluid" style="padding-top: 70px;">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <ul class="list-group">
                <?php foreach($users as $key=>$val){ $user=explode('@',$users[$key]['email']); ?>
                <li class="list-group-item filter-user">
                    <div class="list-item-container">
                        <div class="icon-u col-md-3">
                            <span class="ion-person"></span>
                        </div>
                        <div class="col-md-6">
                            <h2 class="text-center"> <?php echo $user[0]; ?></h2>
                        </div>
                        <div class="col-md-3 text-center">
                            <a href="#" class="btn btn-primary btn-sm" onclick="usrDetails(<?php echo $users[$key]['id'] ?>)">View more</a>
                        </div>
                    </div>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>