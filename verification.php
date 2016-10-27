<?php
if(isset($_GET['digest']) && !empty($_GET['digest'])){
    require_once('AppClasses/AppController.php');
    $obj = new AppController();
    $digest=$obj->find_by('pswd_digest','digest',$_GET['digest']);
    if(isset($digest) && !empty($digest)){
        $obj->update('users','active="1"','userID',$digest[0]['userID']);
        $obj->delete('pswd_digest','digestID',$digest[0]['digestID']);
        $folder='../';
?>
<!doctype html>
<html class="no-js" lang="en">
    <head>
        <?php include 'layouts/head.php'; ?>
    </head>
    <body>
        <script>
            swal({
                title: "Well Done!",
                text: "Your account has been verified",
                type: "success",
                showCancelButton: false,
                confirmButtonText: "Ok",
            }, function(isConfirm){
                if(isConfirm){
                    window.location = "/quotes/";
                }
            });
        </script>
    </body>
</html>
<?php
    }else{
        include('404.html');
        exit();
    }
} else{
    include('404.html');
    exit();
}
?>