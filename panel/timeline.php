<?php
    session_start();
    require_once('../AppClasses/AppController.php');
    require_once '../AppClasses/Paginator.php';
    class HeadTags{
        public function titlePage($el) {
            return $el." | PortalQuote";
        }
        public function meta_description($el) {
            return $el;
        }
    }
    function add3dots($string, $repl, $limit){
        if(strlen($string) > $limit){
            return substr($string, 0, $limit) . $repl;
        }
        else {
            return $string;
        }
    }

    $obj = new AppController();
    $user = $obj->like('users','username="'. $_SESSION['uname'].'" AND active=1');
if(isset($user) && !empty($user)){
    $u_id=$user[0]['userID'];
    /*if($user[0]['picture']=='/images/profile/male.png' || $user[0]['picture']=='/images/profile/female.png')
        $u_picture='../..'.$user[0]['picture'];
    else*/
        $u_picture=$user[0]['picture'];
    $u_banner=$user[0]['banner'];
    $fname=$user[0]['fname'];
    $lname=$user[0]['lname'];
    //USERS QUOTES
    //$quotes=$obj->find_by('userQuotes','userID',$u_id);
    
    //META TAGS
    $remove2[] = '"';
    $meta_tags = new HeadTags();
    $title = $meta_tags->titlePage($user[0]['username'].' Quotes');
    $description = $meta_tags->meta_description('At PortalQuote you can create your own quotes, connect with other people, share quotes with your friends and more.');
    $image = "https://portalquote.com/images/thumbnail.png";
    $all_quotes=$obj->all('userQuotes ORDER BY created_at DESC');
    $users_quotes=array();
    foreach($all_quotes as $k=>$v){
        $users_following=$obj->custom('SELECT userID FROM followers WHERE userID="'.$v['userID'].'" AND followerID='.$u_id);
        if(isset($users_following) && !empty($users_following)){
            $user_f = $obj->like('users','userID='. $users_following[0]['userID']);
            array_push($users_quotes,['quote'=>$v['quote'],'quoteID'=>$v['quoteID'],'author'=>$v['author'],'profile'=>$user_f[0]['picture'],'uname'=>$user_f[0]['username']]);
        }
    }
    $folder='/panel/';        
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
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,400,600,700,900,400italic' rel='stylesheet'>


        <!-- Bootstrap core CSS -->
        <link href="<?php echo $folder; ?>css/bootstrap.min.css?<?php echo time(); ?>" rel="stylesheet">
        <link href="<?php echo $folder; ?>css/bootstrap-reset.css" rel="stylesheet">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <!--Animation css-->
        <link href="<?php echo $folder; ?>css/animate.css" rel="stylesheet">
        
        <!-- Cropper -->
        <link href="<?php echo $folder; ?>assets/cropper/cropper.css" rel="stylesheet">
        
        <!-- sweet alerts -->
        <link href="<?php echo $folder; ?>assets/sweet-alert/sweetalert.css" rel="stylesheet">
        <script src="<?php echo $folder; ?>assets/sweet-alert/sweetalert.min.js"></script>

        <!--Icon-fonts css-->
        <link href="<?php echo $folder; ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="<?php echo $folder; ?>assets/ionicon/css/ionicons.min.css" rel="stylesheet" />

        <!-- Custom styles for this template -->
        <link href="<?php echo $folder; ?>css/style.css?<?php echo time(); ?>" rel="stylesheet">
        <link href="<?php echo $folder; ?>css/helper.css" rel="stylesheet">
        <link href="<?php echo $folder; ?>css/style-responsive.css" rel="stylesheet" />
        <link href="<?php echo $folder; ?>assets/tagsinput/jquery.tagsinput.css" rel="stylesheet" />
        <!-- Meta tags -->
        <meta name="google" content="notranslate">
        <meta name="description" content="<?php echo $description; ?>">
        <meta name="robots" content="index,follow">
            <!-- Facebook metatags -->
        <meta property="og:site_name" content="PortalQuote">
        <meta property="og:title" content="<?php echo $title; ?>">
        <meta property="og:type" content="article">
        <meta property="og:image" content="<?php echo $image; ?>">
        <meta property="og:description" content="<?php echo $description; ?>" />
            <!-- Twitter metatags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@portalquote">
        <meta name="twitter:title" content="<?php echo $title; ?>">
        <meta name="twitter:description" content="<?php echo $description; ?>">
        <meta name="twitter:image" content="<?php echo $image; ?>">        
        <style>
            .bg-picture{
                background-image:url('<?php echo $u_banner; ?>');
                background-color: #000;
                background-repeat: no-repeat;
                background-size:cover;
            }
        </style>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <?php include('layouts/header.php'); ?>
        <div class="container">
            <h1 class="project-name">People's Thought</h1>
            <div id="timeline">
                <?php 
                    $c=1;
                    foreach($users_quotes as $k=>$v){
                        if($c%2==0)
                            $right='right';
                        $c++;
                        
                        $remove[] = "'";
                        $remove[] = '"';
                        $remove[] = '.';
                        $remove[] = ',';
                        $remove[] = '&';
                        $remove[] = '!';
                        $remove[] = ';';
                        $remove[] = ':';
                        $remove[] = '/';
                        $remove[] = '?';
                        $remove[] = '`';
                        $remove2[] = '"';
                        $q=str_replace($remove, "", $v['quote']);
                        $blankStrippedq=preg_replace('/\s+/', ' ', $q);
                        $share_url=$v['quoteID'].'_'.implode('-', array_slice(explode(' ', strtolower($blankStrippedq)), 0, 10));
                        
                        $a=str_replace($remove, "", $v['author']);
                        $blankStripped=preg_replace('/\s+/', ' ', $a);
                        $author_seo=implode('-', array_slice(explode(' ', strtolower($blankStripped)), 0, 10));
                ?>
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <img src="<?php echo $v['profile']; ?>" class="img-responsive">
                    </div>
                    <div class="timeline-content <?php echo $right; ?>">
                        <h2><?php echo $v['uname']; ?></h2>
                        <p>
                            <?php echo $v['quote']; ?>
                        </p>
                        <a href="/panel/quote/<?php echo $v['uname'].'/'.$author_seo.'/'.$share_url; ?>" class="btn-timeline">View</a>
                    </div>
                </div>
                <?php
                    } 
                ?>
<!--
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <img src="https://content-static.upwork.com/uploads/2014/10/02123010/profile-photo_friendly.jpg" class="img-responsive">
                    </div>
                    <div class="timeline-content right">
                        <h2>LOREM IPSUM DOLOR</h2>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque, facilis quo. Maiores magnam modi ab libero praesentium blanditiis consequatur aspernatur accusantium maxime molestiae sunt ipsa.
                        </p>
                        <a href="#" class="btn-timeline">View</a>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-icon">
                        <img src="https://content-static.upwork.com/uploads/2014/10/02123010/profile-photo_friendly.jpg" class="img-responsive">                        
                    </div>
                    <div class="timeline-content">
                        <h2>LOREM IPSUM DOLOR</h2>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque, facilis quo. Maiores magnam modi ab libero praesentium blanditiis consequatur aspernatur accusantium maxime molestiae sunt ipsa.
                        </p>
                        <a href="#" class="btn-timeline">View</a>
                    </div>
                </div>
                -->
            </div>
        </div>
        
        <script src="<?php echo $folder; ?>js/app.js?<?php echo time(); ?>"></script>
        <script src="<?php echo $folder; ?>assets/tagsinput/jquery.tagsinput.min.js"></script>
        <script src="<?php echo $folder; ?>js/bootstrap.min.js"></script>
        <script src="<?php echo $folder; ?>js/pace.min.js"></script>
        <script src="<?php echo $folder; ?>js/modernizr.min.js"></script>
        <script src="<?php echo $folder; ?>js/wow.min.js"></script>
        <script src="<?php echo $folder; ?>js/jquery.scrollTo.min.js"></script>
        <script src="<?php echo $folder; ?>js/jquery.nicescroll.js" type="text/javascript"></script>
        <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID']) && $_SESSION['uID'] === $u_id){ ?>
        <script src="<?php echo $folder; ?>js/84628a0974ef75ce8cbcfdaf79ce37d619c81cfd/7facc5a9f1b1539c570b57de3134b78dd6f1fdfe.js?<?php echo time(); ?>" type="text/javascript"></script>
        <script src="<?php echo $folder; ?>js/349f7cad324a745042c675789bcb9cc245fbebf1/816f940ad8ab9401522a2e5e280dc9ddb5c0ef4a.js?<?php echo time(); ?>" type="text/javascript"></script>
        <script src="<?php echo $folder; ?>assets/cropper/cropper.min.js"></script>
        <?php }elseif(isset($_SESSION['uID']) && !empty($_SESSION['uID']) && $_SESSION['uID']!=$u_id){ ?>
        <script src="<?php echo $folder; ?>js/46b13e139205831924e33e8c10faa847/93ba5d9426226e11930384103fa8ba44.js?<?php echo time(); ?>" type="text/javascript"></script>
        <?php } ?>
        <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){ ?>
        <script src="<?php echo $folder; ?>js/4236a440a662cc8253d7536e5aa17942/d668aad11dcbabd7f04c3a7aca25f1f7.js?<?php echo time(); ?>" type="text/javascript"></script>
        <script src="/javascript/b59ac58c7256fd0ee084d8adb9654bc1249d3197/c3d137ad7f14c18ef0d0d2e64cdb62f7c9cb3a39.js?<?php echo time(); ?>"></script>
        <script src="<?php echo $folder; ?>js/0cfd653d5d3e1e9fdbb644523d77971d/2fd613c5d3017793d99ee18721e0924a.js?<?php echo time(); ?>" type="text/javascript"></script>
        <?php } ?>
        <script src="<?php echo $folder; ?>js/jquery.app.js"></script>
        <!-- Go to www.addthis.com/dashboard to customize your tools -->
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-573fcd941c5a9279"></script>
    </body>
</html>
<?php }else{
    header("Location:/");
} ?>