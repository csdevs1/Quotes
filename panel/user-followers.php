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
    
    if(isset($_SESSION['uID']) && !empty($_SESSION['uID']))
        $isFollowing=$obj->custom("SELECT * FROM followers WHERE userID=$u_id AND followerID=".$_SESSION['uID']);
    if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){
        $nNotifications=$obj->custom("SELECT COUNT(userID) AS 'cnt' FROM notifications WHERE userID=".$_SESSION['uID']." AND seen=0");
        $notifications=$obj->custom("SELECT * FROM notifications WHERE userID=".$_SESSION['uID']." ORDER BY seen DESC LIMIT 6");
    }
    $followers=$obj->find_by('followers','userID',$u_id);
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
        <style>
            .card-profile {
                background: #fff;
                border-radius: 10px;
                z-index: 1;
            }
            .card-profile_visual{
                height: 300px;
                overflow: hidden;
                position: relative;
                background: #fff;
                border-top-left-radius: 10px;
                border-top-right-radius: 10px;
                background-color: #777;
                background-repeat: no-repeat;
                background-position:  center center/cover;
                text-align: center;
                border-right: 1px solid #ccc;
            }
            .user-profile_pic{display:inline-block; width: 120px;height: 120px;border-radius: 50%;margin-top:20px;background: url(<?php echo $u_picture; ?>) no-repeat center center/cover;box-shadow: 0 36px 64px -34px #222, 0 16px 14px -14px rgba(0, 0, 0, 0.6), 0 22px 18px -18px rgba(0, 0, 0, 0.4), 0 22px 38px -18px #222;z-index: 1000;position: absolute;margin: auto;left: 0;right: 0;top:50px}
            
            .card-profile_user-infos{position: absolute;bottom: 0;padding-bottom: 10px;padding-top: 180px; text-align: center;width: 100%;background: rgba(0,0,0,0.5);height: 100%;}
            .card-profile_user-infos span{display: block;color: #fff;}
            .card-profile_user-infos .infos_nick{color: #ccc;}
            
            .card-profile a {
                text-align: center;
                padding: 20px 20px 20px 20px;
                top: 265px !important;
                z-index: 1000;
                width: 60px;
                height: 60px;
                position: absolute;
                left: 0;
                right: 0;
                margin: auto;
                background-color: #F96B4C;
                display: block;
                clear: both;
                margin: auto;
                border-radius: 100%;
                top: calc(500% + 66px);
                box-shadow: 0 2px 0 #D42D78, 0 3px 10px rgba(243, 49, 128, 0.15), 0 0px 10px rgba(243, 49, 128, 0.15), 0 0px 4px rgba(0, 0, 0, 0.35), 0 5px 20px rgba(243, 49, 128, 0.25), 0 15px 40px rgba(243, 49, 128, 0.75), inset 0 0 15px rgba(255, 255, 255, 0.05);
                overflow: hidden;
            }.card-profile a i{color: #fff;font-size: 2rem;text-shadow: 1px 1px 5px #000;}
            
            .light-red{background: #f85032;
                background: -webkit-linear-gradient(to left, #f85032 , #e73827);
                background: linear-gradient(to left, #f85032 , #e73827);}.darkred{background-image: -webkit-linear-gradient(#F96B4C, #F23182);
                background-image: linear-gradient(#F96B4C, #F23182);}
            
            .card-profile_user-stats{position: relative;height: 100px; border-right: 1px solid #ddd;box-shadow: 0 36px 64px -34px #ccc, 0 16px 14px -14px rgba(0, 0, 0, 0.6), 0 22px 18px -18px rgba(0, 0, 0, 0.4), 0 22px 38px -18px #ccc;}
            .stats-holder{text-align: center;padding: 10px;width: 100%;position: absolute;bottom: 0;}
            .user-stats{width:33%;}
            .user-stats span{display: block;}
            
            /* Extra Small Devices, Phones */ 
            @media only screen and (max-width : 640px) {
                .col-cs-12{width: 100%;}
            }
        </style>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <!-- Aside Start-->
        <aside class="left-panel">
            <!-- brand -->
            <div class="logo">
                <a href="index.html" class="logo-expanded">
                    <img src="img/single-logo.png" alt="logo">
                    <span class="nav-label">quotesite</span>
                </a>
            </div>
            <!-- / brand -->
            <nav class="navigation">
                <ul class="list-unstyled">
                    <li class="has-submenu"><a href="/panel/quotes/<?php echo $user[0]['username']; ?>"><i class="ion-home"></i> <span class="nav-label">
                        <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID']) && $_SESSION['uID'] === $u_id){ ?>
                        Your Quotes
                        <?php } else{ echo $fname."'s Quotes"; } ?>  
                        </span></a></li>
                    <li class="has-submenu active"><a href="#"><i class="ion-android-contacts"></i> <span class="nav-label">Following</span></a>
                        <ul class="list-unstyled">
                            <li class="active"><a href="/panel/followers/<?php echo $user[0]['username']; ?>">
                                <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID']) && $_SESSION['uID'] === $u_id){ ?>
                                    Your Followers
                                <?php } else{ echo $fname."'s Followers"; } ?>                                
                                </a></li>
                            <li><a href="portlets.html">Following</a></li>
                        </ul>
                    </li>
                    <li class="has-submenu"><a href="#"><i class="ion-compose"></i> <span class="nav-label"><?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID']) && $_SESSION['uID'] === $u_id){ ?>
                                        Your Collection
                                    <?php } else{ echo $fname."'s Collection"; } ?></span></a>
                        <ul class="list-unstyled">
                            <li><a href="form-elements.html">Quotes</a></li>
                            <li><a href="/panel/collection/<?php echo $user[0]['username']; ?>">Images</a></li>
                        </ul>
                    </li>
                    <li class="has-submenu" onclick="signout()"><a href="#"><i class="ion-grid"></i> <span class="nav-label">Logout</span></a></li>
                </ul>
            </nav>
        </aside>
        <!-- Aside Ends-->

        <!--Main Content Start -->
        <section class="content">
            
            <!-- Header -->
            <header class="top-head container-fluid">
                <button type="button" class="navbar-toggle pull-left">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                <!-- Search -->
                <form role="search" class="navbar-left app-search pull-left hidden-xs">
                  <input type="text" placeholder="Search..." class="form-control">
                </form>
                <!-- Left navbar 
                <nav class=" navbar-default hidden-xs" role="navigation">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                          <a data-toggle="dropdown" class="dropdown-toggle" href="#">English <span class="caret"></span></a>
                            <ul role="menu" class="dropdown-menu">
                                <li class="active"><a href="#">English</a></li>
                                <li><a href="#">Portuguese</a></li>
                                <li><a href="#">Spanish</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                -->
                <!-- Right navbar -->
                <ul class="list-inline navbar-right top-menu top-right-menu">  
                    <!-- Notification -->
                    <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){ ?>
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="fa fa-bell-o"></i>
                            <?php if($nNotifications[0]['cnt']>0){ ?>
                                <span class="badge badge-sm up bg-pink count"><?php echo $nNotifications[0]['cnt']; ?></span>
                            <?php } ?>
                        </a>
                        <?php if($nNotifications[0]['cnt']>0){ ?>
                            <ul class="dropdown-menu extended fadeInUp animated nicescroll" tabindex="5002">
                                <li class="noti-header">
                                    <p>Notifications</p>
                                </li>
                                <?php foreach($notifications as $key=>$val){
                                        $date = strtotime($notifications[$key]['created_at']);
                                        $date = date('M j, Y', $date);
                                        $diff = date_diff(date_create($date),date_create(date("M j, Y"))); //GET DAY
                                        $diff=$diff->format('%a');
                                        if($diff==1)
                                            $diff.=' day ago';
                                        elseif($diff>1)
                                            $diff.=' days ago';
                                        elseif($diff==0){
                                            $to_time = strtotime(date("Y-m-d H:i:s"));
                                            $from_time = strtotime($notifications[$key]['created_at']);
                                            $diff=floor(abs($to_time - $from_time) / 60); // GET MINUTES
                                            if($diff==1)
                                                $diff.=' minute ago';
                                            elseif($diff>=60){
                                                $diff=floor(abs($to_time - $from_time) / 3600); // GET HOURS
                                                if($diff>1)
                                                    $diff.=' hours ago';
                                                else
                                                    $diff.=' hour ago';
                                            }else
                                                $diff.=' minutes ago';
                                        }
                                ?>
                                    <li>
                                        <div>
                                            <?php echo $notifications[$key]['notification']; ?><br><small class="text-muted"><?php echo $diff; ?></small></span>
                                        </div>
                                    </li>
                                <?php } ?>
                                <li>
                                    <p><a href="#" class="text-right">See all notifications</a></p>
                                </li>
                            </ul>
                        <?php } ?>
                    </li>
                    <?php } ?>
                    <!-- /Notification -->

                    <!-- user login dropdown start-->
                    <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){ ?>
                    <li class="dropdown text-center">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <img alt="" src="<?php echo $_SESSION['profile']; ?>" class="img-circle profile-img thumb-sm">
                            <span class="username"><?php echo $_SESSION['uname']; ?> </span> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu extended pro-menu fadeInUp animated" tabindex="5003" style="overflow: hidden; outline: none;">
                            <li><a href="profile.html"><i class="fa fa-briefcase"></i>Profile</a></li>
                            <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                            <li><a href="#"><i class="fa fa-bell"></i> Friends <span class="label label-info pull-right mail-info">5</span></a></li>
                            <li onclick="signout()"><a href="#"><i class="fa fa-sign-out"></i> Log Out</a></li>
                        </ul>
                    </li>
                    <?php } else{ ?>
                        <li class="text-center"><a href="/">Home</a></li>
                    <?php } ?>
                    <!-- user login dropdown end -->       
                </ul>
                <!-- End right navbar -->
            </header>
            <!-- Header Ends -->

            <div class="wraper container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="portlet"><!-- /primary heading -->
                            <div class="portlet-heading">
                                <h3 class="portlet-title text-dark text-uppercase">
                                    Your Followers
                                </h3>
                                <div class="clearfix"></div>
                            </div>
                            
                            <div id="portlet1" class="panel-collapse collapse in">
                                <div class="portlet-body">
                                    <section role="main">                                        
                                        <div class="clearfix">
                                            <?php 
                                                foreach($followers as $key=>$val){
                                                    $follower=$obj->find_by('users','userID',$followers[0]['followerID']);
                                                    $followerQuotes=$obj->custom('SELECT COUNT("userID") as cnt FROM userQuotes WHERE userID='.$followers[0]['followerID']);
                                                    $nFollowers=$obj->custom('SELECT COUNT("userID") as cnt FROM followers WHERE userID='.$followers[0]['followerID']);
                                                    $nFollowing=$obj->custom('SELECT COUNT("followerID") as cnt FROM followers WHERE followerID='.$followers[0]['followerID']);
                                                    $isFollowing=$obj->custom("SELECT COUNT('followerID') as cnt FROM followers WHERE userID=".$followers[0]['followerID']." AND followerID=".$_SESSION['uID']);
                                                    
                                                    $isFollowing[0]['cnt']==0 ? $class='light-red nt-follow' : $class='darkred';
                                            ?>
                                                <div class="col-cs-12 col-xs-6 col-md-3 card-profile">
                                                    <div class="user-profile_pic" style="background-image:url('<?php echo $follower[0]['picture']; ?>')"></div>
                                                    <div class="card-profile_visual">
                                                        <div class="card-profile_user-infos">
                                                            <span class="infos_name"><?php echo $follower[0]['fname'].' '.$follower[0]['lname']; ?></span>
                                                            <span class="infos_nick"><?php echo $follower[0]['username']; ?></span>
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
                                                                <span><?php echo $followerQuotes[0]['cnt']; ?></span>
                                                            </div>
                                                            <div class="user-stats col-xs-4">
                                                                <strong>Following</strong>
                                                                <span><?php echo $nFollowing[0]['cnt']; ?></span>
                                                            </div>
                                                            <div class="user-stats col-xs-4">
                                                                <strong>Followers</strong>
                                                                <span><?php echo $nFollowers[0]['cnt']; ?></span>
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