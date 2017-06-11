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
if(isset($user) && !empty($user)){
    $u_id=$user[0]['userID'];
    if($user[0]['picture']=='/images/profile/male.png' || $user[0]['picture']=='/images/profile/female.png')
        $u_picture='../../'.$user[0]['picture'];
    else
        $u_picture=$user[0]['picture'];
    $u_banner=$user[0]['banner'];
    $fname=$user[0]['fname'];
    $lname=$user[0]['lname'];
    
    if(isset($_SESSION['uID']) && !empty($_SESSION['uID']))
        $isFollowing=$obj->custom("SELECT * FROM followers WHERE userID=$u_id AND followerID=".$_SESSION['uID']);
    if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){
        $nNotifications=$obj->custom("SELECT COUNT(userID) AS 'cnt' FROM notifications WHERE userID=".$_SESSION['uID']." AND seen=0");
        $notifications=$obj->custom("SELECT * FROM notifications WHERE userID=".$_SESSION['uID']." ORDER BY seen DESC LIMIT 6");
    }
    
    $image=$obj->find_by('userImagesCollection','id',$_GET['imageid']);
        
    $current_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="shortcut icon" href="../../../images/icon.png">

        <title><?php echo $fname.' '.$lname; ?> - Dashboard</title>
        
        <!-- JQUERY LIBRARIES -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/123941/masonry.js"></script>

        <!-- Google-Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,400,600,700,900,400italic' rel='stylesheet'>


        <!-- Bootstrap core CSS -->
        <link href="../../css/bootstrap.min.css?<?php echo time(); ?>" rel="stylesheet">
        <link href="../../css/bootstrap-reset.css" rel="stylesheet">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <!--Animation css-->
        <link href="../../css/animate.css" rel="stylesheet">

        <!-- sweet alerts -->
        <link href="../../assets/sweet-alert/sweetalert.css" rel="stylesheet">
        <script src="../../assets/sweet-alert/sweetalert.min.js"></script>

        <!--Icon-fonts css-->
        <link href="../../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="../../assets/ionicon/css/ionicons.min.css" rel="stylesheet" />

        <!-- Custom styles for this template -->
        <link href="../../css/style.css?<?php echo time(); ?>" rel="stylesheet">
        <link href="../../css/helper.css" rel="stylesheet">
        <link href="../../css/style-responsive.css" rel="stylesheet" />
        <link href="../../assets/tagsinput/jquery.tagsinput.css" rel="stylesheet" />
        <style>
            .img-container{
                text-align: center;
            }.img-container img{max-width: 768px;}
            .at-icon-wrapper{width: 25px !important;height: 25px !important;}
            .at-icon-wrapper svg{width: 25px !important;height: 25px !important;}.at-share-btn-elements{text-align: center;}
        </style>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <?php include('layouts/header.php'); ?>

            <div class="wraper container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="addthis_sharing_toolbox col-xs-12" data-url="https://portalquote.com/panel/image/<?php echo $user[0]['username'].'/'.$_GET['imageid']; ?>" data-title="Hey, check out this image created by <?php echo $user[0]['username']; ?> | PortalQuote"></div>
                    </div>
                    <div class="col-lg-12 img-container">
                        <img src="<?php echo $image[0]['url']; ?>" title="<?php echo $_GET['uname']; ?>" alt="<?php echo $_GET['uname'].' - image quote at PortalQuote' ?>">
                    </div> <!-- end col -->
                </div> <!-- End row -->
            </div>
            <!-- Page Content Ends -->
            <!-- ================== -->
        </section>
        <!-- Main Content Ends -->
        <!-- js placed at the end of the document so the pages load faster -->
        <script src="../../js/app.js?<?php echo date(); ?>"></script>
        <script src="../../assets/tagsinput/jquery.tagsinput.min.js"></script>
        <script src="../../js/bootstrap.min.js"></script>
        <script src="../../js/pace.min.js"></script>
        <script src="../../js/modernizr.min.js"></script>
        <script src="../../js/wow.min.js"></script>
        <script src="../../js/jquery.scrollTo.min.js"></script>
        <script src="../../js/jquery.nicescroll.js" type="text/javascript"></script>
        <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID']) && $_SESSION['uID'] === $u_id){ ?>
        <script src="../../js/84628a0974ef75ce8cbcfdaf79ce37d619c81cfd/7facc5a9f1b1539c570b57de3134b78dd6f1fdfe.js?<?php echo time(); ?>" type="text/javascript"></script>
        <script src="../../js/349f7cad324a745042c675789bcb9cc245fbebf1/816f940ad8ab9401522a2e5e280dc9ddb5c0ef4a.js?<?php echo time(); ?>" type="text/javascript"></script>
        <script src="../js/0cfd653d5d3e1e9fdbb644523d77971d/2fd613c5d3017793d99ee18721e0924a.js?<?php echo time(); ?>" type="text/javascript"></script>
        <?php }elseif(isset($_SESSION['uID']) && !empty($_SESSION['uID']) && $_SESSION['uID']!=$u_id){ ?>
        <script src="../../js/46b13e139205831924e33e8c10faa847/93ba5d9426226e11930384103fa8ba44.js?<?php echo time(); ?>" type="text/javascript"></script>
        <?php } ?>
        <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){ ?>
        <script src="../../js/4236a440a662cc8253d7536e5aa17942/d668aad11dcbabd7f04c3a7aca25f1f7.js?<?php echo time(); ?>" type="text/javascript"></script>
        <script src="/javascript/b59ac58c7256fd0ee084d8adb9654bc1249d3197/c3d137ad7f14c18ef0d0d2e64cdb62f7c9cb3a39.js?<?php echo time(); ?>"></script>
        <?php } ?>
        <script src="../../js/jquery.app.js"></script>
        <!-- Go to www.addthis.com/dashboard to customize your tools -->
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-573fcd941c5a9279"></script>
    </body>
</html>
<?php }else{
    header("Location:/");
} ?>
