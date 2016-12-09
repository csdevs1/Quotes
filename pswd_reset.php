<?php
if(isset($_GET['digest']) && !empty($_GET['digest'])){
    require_once('AppClasses/AppController.php');
    $obj = new AppController();
    $digest=$obj->find_by('pswd_digest','digest',$_GET['digest']);
    if(isset($digest) && !empty($digest)){
        $obj->delete('pswd_digest','digestID',$digest[0]['digestID']);
        $folder='../';
?>
<!doctype html>
<html class="no-js" lang="en">
    <head>
        <?php include 'layouts/head.php'; ?>
        <input type="hidden" id="isdfon" value="<?php echo $digest[0]['userID']; ?>">
    </head>
    <body>
        <script>
            var sdvds=function(pswd,uID){
                var formData = new FormData();
                formData.append("action", 'pswd_set');
                formData.append("pswd", pswd);
                formData.append("uID", uID);
                return $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    processData: false,
                    contentType:  false,
                    data: formData,
                    url: '/quotes/c9dcc9a0e463aca2d9575c58a5e23fb9b12d9fa2/4a72dc8ceda3f3885da0aba3a857aa19abcef5bc',
                    async:false
                });
            }
            swal({
              title: "Password reset!",
              text: "Set your new password below",
              type: "input",
              inputType: "password",
              showCancelButton: true,
              closeOnConfirm: false,
              animation: "slide-from-top",
              inputPlaceholder: "New Passowrd"
            },
            function(inputValue){
                var uID=$('#isdfon').val();
                if (inputValue === false) return false;
                if (inputValue === "") {
                    swal.showInputError("You need to write something!");
                    return false
                }
                if(inputValue.length<7 || inputValue.length>10){
                    swal.showInputError("Password should be between 7 and 10 characters!");
                    return false;
                }
                var iof=sdvds(inputValue,uID);
                iof.done(function(response){
                    if(response){
                        swal({
                            title: "Nice!",
                            text: "Your new password has been set",
                            timer: 3000,
                            showConfirmButton: false
                        });
                        setTimeout(function() {
                            window.location = "/";
                        }, 3000);
                    }
                });
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