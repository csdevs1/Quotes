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
    }
    .icon-u{position: relative;}
    .icon-u .ion-person{font-size: 8rem;position: absolute;top:0;}
</style>

<div class="container-fluid" style="padding-top: 70px;">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <ul class="list-group">
                <?php foreach($users as $key=>$val){ $user=$users[$key]['usrName']; ?>
                <li class="list-group-item filter-user">
                    <div class="list-item-container">
                        <div class="icon-u col-md-3">
                            <span class="ion-person"></span>
                        </div>
                        <div class="col-md-4">
                            <h2 class="text-center"> <?php echo $user; ?></h2>
                        </div>
                        <div class="col-md-3 text-center">
                            <p><a href="#" class="btn btn-primary btn-sm" onclick="usrDetails(<?php echo $users[$key]['id'] ?>)">View more</a></p>
                            <p><a href="#" class="btn btn-inverse btn-sm" onclick="usrSettings(<?php echo $users[$key]['id'] ?>)">Settings</a></p>
                            <p><a href="#" class="btn btn-danger btn-sm" onclick="deleteUsr(this,<?php echo $users[$key]['id'].",'".$user."'"; ?>)">Delete User</a></p>
                        </div>
                        <div class="col-md-3 text-center">
                            
                        </div>
                    </div>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>

<script>
    function deleteUsr(el,id,name){
        swal({title: "Are you sure?",text: "You're about to delete "+name+"!",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){
            var token = generateToken();
            token.done(function(generatedToken){
                var deleted = delete_function('dashboard_usrs','id',id,generatedToken);
                deleted.done(function(response){
                    swal("Deleted!", name+" has been deleted.", "success");
                    $(el).parent().parent().parent().parent().remove();
                });
            });     
        });
    }
</script>