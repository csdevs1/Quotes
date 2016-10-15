<?php
    session_start();
    if(isset($_SESSION['userName']) && !empty($_SESSION['userName'])){
        header("Location:/quotes/c9a28e7f0dbc3ed20a161351c4f29a7b/21232f297a57a5a743894a0e4a801fc3");
    } else{
    require_once('Classes/Token.php');
    $tokenObj = new Token();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <link rel="shortcut icon" href="img/favicon_1.ico">
        <title>Admin Dashboard</title>
        <!-- Google-Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,400,600,700,900,400italic' rel='stylesheet'>
        
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="css/bootstrap-reset.css" rel="stylesheet">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <!--Animation css-->
        <link href="css/animate.css" rel="stylesheet">

        <!--Icon-fonts css-->
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/ionicon/css/ionicons.min.css" rel="stylesheet" />

        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/helper.css" rel="stylesheet">
        <link href="css/style-responsive.css" rel="stylesheet" />

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="wrapper-page animated fadeInDown">
            <div class="panel panel-color panel-primary">
                <div class="panel-heading">
                    <h3 class="text-center m-t-10"> Sign In to <strong>Dashboard</strong> </h3>
                </div>
                
                <div class="form-horizontal m-t-40">
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" id="user" name="user" oninput='oninputValidate(this);' maxlength="15" type="text" placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" id="password" name="password" placeholder="Password">
                        </div>
                    </div>
                    <input type="hidden" name="token" id="token" value="<?php echo $tokenObj->generate(); ?>">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="btn btn-purple w-md" name="submit" id="submit" type="submit" value="Log in" onclick="login(this);return false;" value="Log In">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- js placed at the end of the document so the pages load faster -->
        <script src="js/pace.min.js"></script>
        <script src="js/wow.min.js"></script>
        <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
        
        <!--common script for all pages-->
        <script src="js/jquery.app.js"></script>
        <script>
            var validateUserRegex=function(str){
                var regexp = /^[a-zA-Z0-9-_]+$/;
                var val=str.value;
                if (val.search(regexp) == -1 || val.length > 15){ return false; }
                else{ return true; }
            }
            
            var oninputValidate=function(el){
                if(validateUserRegex(el)){
                    
                }else
                    console.log('error');
            }
            
            var login=function(el){
                var usrEl=document.getElementById('user');
                if(validateUserRegex(usrEl)){
                    el.value="Loging in";
                    $(el).attr('disabled','disabled');
                    var userName=$('#user').val(),pass=$('#password').val(),token=$('#token').val();
                    var checked = checkUser(userName,pass,token);
                    checked.done(function(response){
                        console.log(response['response']);
                        if(response['response'])
                            window.location='/quotes/c9a28e7f0dbc3ed20a161351c4f29a7b/21232f297a57a5a743894a0e4a801fc3';
                        else{
                            $(el).removeAttr('disabled','disabled');
                            el.value="Ingresar";
                            $('.error').show(500);
                            setTimeout(function() {
                                $('.error').hide(500);
                            }, 4000);
                        }
                    });
                }else{
                    console.log('Error');
                }
            }
            
            document.onkeydown = function(e){
                if(e.keyCode == 13){
                    login(document.getElementById('submit'));
                }
            }
            
            function checkUser(usr,pass,token){
                return $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    data: {usr:usr,pass:pass,token:token,login:true},
                    url: 'Classes/SignIn.php'
                });
            }
        </script>
    </body>
</html>
<?php } ?>