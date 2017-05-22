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
        $u_picture='../..'.$user[0]['picture'];
    else
        $u_picture=$user[0]['picture'];
    $u_banner=$user[0]['banner'];
    $fname=$user[0]['fname'];
    $lname=$user[0]['lname'];
    
    if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){
        $isFollowing=$obj->custom("SELECT * FROM followers WHERE userID=$u_id AND followerID=".$_SESSION['uID']);
        $nNotifications=$obj->custom("SELECT COUNT(userID) AS 'cnt' FROM notifications WHERE userID=".$_SESSION['uID']." AND seen=0");
        $notifications=$obj->custom("SELECT * FROM notifications WHERE userID=".$_SESSION['uID']." ORDER BY seen DESC LIMIT 6");
    }
    $following=$obj->find_by('followers','followerID',$u_id);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="shortcut icon" href="../../images/icon.png">

        <title><?php echo $fname.' '.$lname; ?> - Dashboard</title>
        
        <!-- JQUERY LIBRARIES -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/123941/masonry.js"></script>

        <!-- Google-Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,400,600,700,900,400italic' rel='stylesheet'>


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
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <?php include('layouts/header.php'); ?>

            <div class="wraper container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="portlet"><!-- /primary heading -->
                            <div class="portlet-heading">
                                <h3 class="portlet-title text-dark text-uppercase">
                                    <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID']) && $_SESSION['uID'] === $u_id){ ?>
                                    You're Following...
                                    <?php } else{ echo $fname.' is following...'; } ?>
                                </h3>
                                <div class="clearfix"></div>
                            </div>
                            
                            <div id="portlet1" class="panel-collapse collapse in">
                                <div class="portlet-body">
                                    <section role="main">                                        
                                        <div class="clearfix">
                                            <?php 
                                                foreach($following as $key=>$val){
                                                    $follower=$obj->find_by('users','userID',$following[$key]['userID']);
                                                    $followerQuotes=$obj->custom('SELECT COUNT("userID") as cnt FROM userQuotes WHERE userID='.$following[$key]['userID']);
                                                    $nFollowers=$obj->custom('SELECT COUNT("userID") as cnt FROM followers WHERE userID='.$following[$key]['userID']);
                                                    $nFollowing=$obj->custom('SELECT COUNT("followerID") as cnt FROM followers WHERE followerID='.$following[$key]['userID']);
                                                    if(isset($_SESSION['uID']) && !empty($_SESSION['uID']) && $_SESSION['uID'] === $u_id){
                                                        $isFollowing=$obj->custom("SELECT COUNT('followerID') as cnt FROM followers WHERE userID=".$following[$key]['userID']." AND followerID=".$_SESSION['uID']);
                                                        $isFollowing[0]['cnt']==0 ? $class='light-red nt-follow' : $class='darkred';
                                                    }
                                            ?>
                                                <div class="col-cs-12 col-xs-6 col-md-4 card-profile">
                                                    <div class="user-profile_pic" style="background-image:url('<?php echo $follower[0]['picture']; ?>')"></div>
                                                    <div class="card-profile_visual" style="background-image:url('<?php echo $follower[0]['banner']; ?>')">
                                                        <div class="card-profile_user-infos">
                                                            <a href="/panel/quotes/<?php echo $follower[0]['username']; ?>/1" target="_blank"><span class="infos_name"><?php echo $follower[0]['fname'].' '.$follower[0]['lname']; ?></span></a>
                                                            <a href="/panel/quotes/<?php echo $follower[0]['username']; ?>/1" target="_blank"><span class="infos_nick"><?php echo $follower[0]['username']; ?></span></a>
                                                        </div>
                                                    </div>
                                                    <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID']) && $_SESSION['uID']!=$follower[0]['userID']){ ?>
                                                    <a class="<?php echo $class; ?> usrflw-16516" data-follow='<?php echo $follower[0]['userID'] ?>'>
                                                        <?php if($isFollowing[0]['cnt']){ ?>
                                                        <i class="ion-checkmark"></i>
                                                        <?php }else{?>
                                                        <i class="ion-person-add"></i>
                                                        <?php } ?>
                                                    </a>
                                                    <?php } ?>
                                                    <div class="card-profile_user-stats">
                                                        <div class="stats-holder row">
                                                            <div class="user-stats col-xs-4">
                                                                <strong>Quotes</strong>
                                                                <a href="/panel/quotes/<?php echo $follower[0]['username']; ?>/1" target="_blank"><span><?php echo $followerQuotes[0]['cnt']; ?></span></a>
                                                            </div>
                                                            <div class="user-stats col-xs-4">
                                                                <strong>Following</strong>
                                                                <a href="/panel/following/<?php echo $follower[0]['username']; ?>"><span><?php echo $nFollowing[0]['cnt']; ?></span></a>
                                                            </div>
                                                            <div class="user-stats col-xs-4">
                                                                <strong>Followers</strong>
                                                                <a href="/panel/followers/<?php echo $follower[0]['username']; ?>" target="_blank"><span><?php echo $nFollowers[0]['cnt']; ?></span></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <input type="hidden" id="token56165" value="<?php echo sha1($_SESSION['uID']); ?>">
                                        </div>
                                    </section>
                                </div>
                            </div>
                            
                            <div class="container">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <li>
                                            <a href="#" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <li><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                        <li><a href="#">5</a></li>
                                        <li>
                                            <a href="#" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            
                        </div> <!-- /Portlet -->
                    </div> <!-- end col -->
                </div> <!-- End row -->
            </div>
            <!-- Page Content Ends -->
            <!-- ================== -->
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
        <?php }elseif(isset($_SESSION['uID']) && !empty($_SESSION['uID']) && $_SESSION['uID']!=$u_id){ ?>
        <script src="../js/46b13e139205831924e33e8c10faa847/93ba5d9426226e11930384103fa8ba44.js?<?php echo time(); ?>" type="text/javascript"></script>
        <?php } ?>
        <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){ ?>
        <script src="../js/4236a440a662cc8253d7536e5aa17942/d668aad11dcbabd7f04c3a7aca25f1f7.js?<?php echo time(); ?>" type="text/javascript"></script>
        <?php } ?>
        <script src="../js/jquery.app.js"></script>
    </body>
</html>
<?php }else{
    header("Location:/");
} ?>