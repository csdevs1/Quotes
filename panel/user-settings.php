<?php
    session_start();
    require_once('../AppClasses/AppController.php');
    class HeadTags{
        public function titlePage($el) {
            return $el." at PortalQuote";
        }
        public function meta_description($el) {
            return $el;
        }
    }
    $obj = new AppController();
    $user = $obj->like('users','username="'.$_GET['uname'].'" AND active=1');
if(isset($user) && !empty($user) && $_SESSION['uID']==$user[0]['userID']){
    $u_id=$user[0]['userID'];
    if($user[0]['picture']=='/images/profile/male.png' || $user[0]['picture']=='/images/profile/female.png')
        $u_picture='../..'.$user[0]['picture'];
    else
        $u_picture=$user[0]['picture'];
    $u_banner=$user[0]['banner'];
    $fname=$user[0]['fname'];
    $lname=$user[0]['lname'];
    $uname=$user[0]['username'];
    $email=$user[0]['email'];
    $website=$user[0]['website'];
    $facebook=$user[0]['facebook'];
    $instagram=$user[0]['instagram'];
    $twitter=$user[0]['twitter'];
    $about=$user[0]['about'];
    
    if(isset($_SESSION['uID']) && !empty($_SESSION['uID']) && $_SESSION['uID']!=$u_id)
        $isFollowing=$obj->custom("SELECT * FROM followers WHERE userID=$u_id AND followerID=".$_SESSION['uID']);
    if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){
        $nNotifications=$obj->custom("SELECT COUNT(userID) AS 'cnt' FROM notifications WHERE userID=".$_SESSION['uID']." AND seen=0");
        $notifications=$obj->custom("SELECT * FROM notifications WHERE userID=".$_SESSION['uID']." ORDER BY seen DESC LIMIT 6");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="robots" content="noindex">
        <link rel="shortcut icon" href="../../images/icon.png">

        <title><?php echo $fname.' '.$lname; ?> - Dashboard</title>
        
        <!-- JQUERY LIBRARIES -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/123941/masonry.js"></script>

        <!-- Google-Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,400,600,700,900,400italic' rel='stylesheet'>


        <!-- Bootstrap core CSS -->
        <link href="../css/bootstrap.min.css?<?php echo time(); ?>" rel="stylesheet">
        <link href="../css/bootstrap-reset.css" rel="stylesheet">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <!--Animation css-->
        <link href="../css/animate.css" rel="stylesheet">

        <!-- sweet alerts -->
        <link href="../assets/sweet-alert/sweetalert.css" rel="stylesheet">
        <script src="../assets/sweet-alert/sweetalert.min.js"></script>

        <!--Icon-fonts css-->
        <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="../assets/ionicon/css/ionicons.min.css" rel="stylesheet" />

        <!-- Custom styles for this template -->
        <link href="../css/style.css?<?php echo time(); ?>" rel="stylesheet">
        <link href="../css/helper.css" rel="stylesheet">
        <link href="../css/style-responsive.css" rel="stylesheet" />
        <link href="../assets/tagsinput/jquery.tagsinput.css" rel="stylesheet" />
        <style>.alert{padding: 0 !important;background: none !important;display: none;}</style>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <?php include('layouts/header.php'); ?>
    
            <!-- Form-validation -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h3 class="panel-title">User's Settings</h3></div>
                        <div class="panel-body">
                            <div class=" form">
                                <div class="cmxform form-horizontal tasi-form" id="settingsUpdate">
                                    <div class="form-group ">
                                        <label for="firstname" class="control-label col-lg-2">First name *</label>
                                        <div class="col-lg-10">
                                            <input class=" form-control" id="fname" name="firstname" type="text" value="<?php echo $fname; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="lastname" class="control-label col-lg-2">Last name  *</label>
                                        <div class="col-lg-10">
                                            <input class=" form-control" id="lname" name="lastname" type="text" value="<?php echo $lname; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="username" class="control-label col-lg-2">Page Name *</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " id="uname" name="username" type="text" value="<?php echo $uname; ?>">
                                            <small>How it looks: https://portalquote.com/page/<span id="yourpage" class="text-danger"><?php echo $_SESSION['uname']; ?></span></small>
                                            <span class="alert alert-danger uname">Username already taken...</span>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="email" class="control-label col-lg-2">Email *</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " id="email" name="email" type="email" value="<?php echo $email; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="email" class="control-label col-lg-2">Your Website</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " id="website" name="website" type="text" value="<?php echo $website; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="email" class="control-label col-lg-2">Facebook Page</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " id="facebook" name="facebook" type="text" value="<?php echo $facebook; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="email" class="control-label col-lg-2">Twitter</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " id="twitter" name="twitter" type="text" value="<?php echo $twitter; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="email" class="control-label col-lg-2">Instagram</label>
                                        <div class="col-lg-10">
                                            <input class="form-control " id="instagram" name="instagram" type="text" value="<?php echo $instagram; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="email" class="control-label col-lg-2">About You</label>
                                        <div class="col-lg-10">
                                            <textarea maxlength="255" id="about" name="about" class="textarea"><?php echo $about; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button class="btn btn-success" type="submit" id='_up_496-ixb'>Update</button>
                                        </div>
                                    </div>
                                    <hr>
                                    <button type="button" class="btn btn-block btn-lg btn-inverse" id="psw-rs_916871">Reset Password</button>
                                </div>
                            </div> <!-- .form -->
                        </div> <!-- panel-body -->
                    </div> <!-- panel -->
                </div> <!-- col -->
            </div> <!-- End row -->
            
        </section>
        <!-- Main Content Ends -->
    <!-- js placed at the end of the document so the pages load faster -->
        <script src="../js/app.js?<?php echo date(); ?>"></script>
        <script src="../assets/tagsinput/jquery.tagsinput.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/pace.min.js"></script>
        <script src="../js/modernizr.min.js"></script>
        <script src="../js/wow.min.js"></script>
        <script src="../js/jquery.scrollTo.min.js"></script>
        <script src="../js/jquery.nicescroll.js" type="text/javascript"></script>
        <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID']) && $_SESSION['uID'] === $u_id){ ?>
        <script src="../js/84628a0974ef75ce8cbcfdaf79ce37d619c81cfd/7facc5a9f1b1539c570b57de3134b78dd6f1fdfe.js?<?php echo time(); ?>" type="text/javascript"></script>
        <script src="../js/349f7cad324a745042c675789bcb9cc245fbebf1/816f940ad8ab9401522a2e5e280dc9ddb5c0ef4a.js?<?php echo time(); ?>" type="text/javascript"></script>
        <script src="../js/ca33aff8ac070ceb8e7b761f45a137e2/dbcb95c03507cf9315446e88744f368e.js?<?php echo time(); ?>" type="text/javascript"></script>
        <?php }elseif(isset($_SESSION['uID']) && !empty($_SESSION['uID']) && $_SESSION['uID']!=$u_id){ ?>
        <script src="../js/46b13e139205831924e33e8c10faa847/93ba5d9426226e11930384103fa8ba44.js?<?php echo time(); ?>" type="text/javascript"></script>
        <?php } ?>
        <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){ ?>
        <script src="../js/4236a440a662cc8253d7536e5aa17942/d668aad11dcbabd7f04c3a7aca25f1f7.js?<?php echo time(); ?>" type="text/javascript"></script>
        <script src="/javascript/b59ac58c7256fd0ee084d8adb9654bc1249d3197/c3d137ad7f14c18ef0d0d2e64cdb62f7c9cb3a39.js?<?php echo time(); ?>"></script>
        <?php } ?>
        <script src="../js/jquery.app.js"></script>
    </body>
</html>
<?php }else{
    header("Location:/");
} ?>