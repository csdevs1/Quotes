<?php
    session_start();
    require_once('../AppClasses/AppController.php');
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
    $user = $obj->like('users','username="'.$_GET['uname'].'" AND active=1');
if(isset($user) && !empty($user)){
    $u_id=$user[0]['userID'];
    if($user[0]['picture']=='/images/profile/male.png' || $user[0]['picture']=='/images/profile/female.png')
        $u_picture='../../../'.$user[0]['picture'];
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
    
    $getURL=explode('_',$_GET['quoteid']);
    $qRes=$obj->find_by('userQuotes','quoteID',$getURL[0]);
    $q=str_replace($remove, "", $qRes[0]['quote']);
    $uri=$getURL[0].'_'.implode('-', array_slice(explode(' ', $q), 0, 10));
    
    if(strtolower($uri)!=$_GET['quoteid'])
        header('Location:'.strtolower($uri));
    
    
    //GET QUOTE
    $qID=$qRes[0]['quoteID'];
    $quote=$qRes[0]['quote'];
    $qImage=$qRes[0]['quoteImage'];
    $author=$qRes[0]['author'];
    $arrEN=explode(',',$qRes[0]['keywords']);
    $nLikes=$obj->custom("SELECT COUNT(quoteID) AS 'cnt' FROM userQuotes_like WHERE quoteID=$qID");
    $current_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    //META TAGS
    $remove2 = '"';
    $meta_tags = new HeadTags();
    $title = $meta_tags->titlePage('&quot;'.add3dots(str_replace($remove2, "", $quote),'',150).'...&quot; - '.$author);
    $description = $meta_tags->meta_description('At PortalQuote you can create your own quotes, connect with other people, share quotes with your friends and more.');
    
    if(isset($_SESSION['go_back']) && !empty($_SESSION['go_back']))
        $go_back=$_SESSION['go_back'];
    else
        $go_back="/panel/quotes/".$user[0]['username']."/1";
    $img=rand(1,9).'.jpg';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <script type="text/javascript">
            (new Image()).src="/panel/img/frame.png";
        </script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="shortcut icon" href="../../../../images/icon.png">

        <title><?php echo $fname.' '.$lname; ?> - Dashboard</title>
        
        <!-- JQUERY LIBRARIES -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/123941/masonry.js"></script>

        <!-- Google-Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,400,600,700,900,400italic' rel='stylesheet'>


        <!-- Bootstrap core CSS -->
        <link href="../../../css/bootstrap.min.css?<?php echo time(); ?>" rel="stylesheet">
        <link href="../../../css/bootstrap-reset.css" rel="stylesheet">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <!--Animation css-->
        <link href="../../../css/animate.css" rel="stylesheet">

        <!-- sweet alerts -->
        <link href="../../../assets/sweet-alert/sweetalert.css" rel="stylesheet">
        <script src="../../../assets/sweet-alert/sweetalert.min.js"></script>

        <!--Icon-fonts css-->
        <link href="../../../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="../../../assets/ionicon/css/ionicons.min.css" rel="stylesheet" />

        <!-- Custom styles for this template -->
        <link href="../../../css/style.css?<?php echo time(); ?>" rel="stylesheet">
        <link href="../../../css/helper.css" rel="stylesheet">
        <link href="../../../css/style-responsive.css" rel="stylesheet" />
        <link href="../../../assets/tagsinput/jquery.tagsinput.css" rel="stylesheet" />
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
        <meta name="twitter:image" content="<?php echo $qImage; ?>">
        <style>
            @import url('https://fonts.googleapis.com/css?family=Comfortaa|Passion+One');
            .quote blockquote{
                cursor: default;
                 -webkit-touch-callout: none; /* iOS Safari */
                -webkit-user-select: none; /* Chrome/Safari/Opera */
                 -khtml-user-select: none; /* Konqueror */
                   -moz-user-select: none; /* Firefox */
                    -ms-user-select: none; /* Internet Explorer/Edge */
                        user-select: none;
            }
            .quote blockquote:before {left: 1px; font-size: 2.3em;}
            .item.quote{margin-left: auto;margin-right: auto;float: none !important;margin-bottom: 50px;}
            .quote .pad{box-shadow: -3px 2px 5px #ccc;}
            @media only screen and (min-width : 320px) {
                .quote blockquote{font-size: 1.5rem;}
                .quote blockquote span {font-size: 1.3rem;}
            }
            @media only screen and (min-width : 600px) {
                .quote blockquote{font-size: 1.7rem;}
                .quote blockquote span {font-size: 1.5rem;}
            }
            /* Extra Small Devices, Phones */ 
            @media only screen and (min-width : 768px) {.quote blockquote{font-size: 1.9rem;}
            .quote blockquote span {font-size: 1.7rem;}}
            
            .quote-box{position: relative;width: 640px;margin: auto;}
            .quote-box img{margin: auto;}
            .quote-box blockquote{position: absolute;top:50px;text-align: center;margin: auto;border: 0;padding-left: 50px;padding-right: 50px;color: #000;background-color: rgba(0,0,0,0.2);width: 630px;left:4px;}
            blockquote p{font-family: 'Comfortaa', cursive;color: #222;font-size: 2rem;}
            blockquote span{font-family: 'Passion One', cursive;color: #222;font-size: 4rem;position: relative;}
            .frame{position: absolute;left: 1px;-webkit-filter: contrast(200%); /* Safari */
    filter: contrast(200%); }
            .quote-img-box{margin-top: 30px;}
            .download-container{padding-bottom: 10px;}
            .download-container a {width: 100%;}
            .at-icon-wrapper{width:40px !important;height:40px !important;}
            .at-icon-wrapper svg{width:40px !important;height:40px !important;}.at-share-btn-elements{text-align: center;}
            .slideInLeft{display: none;}
            .share{text-align: center;}
        </style>
        
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
                        <div class="portlet clearfix"><!-- /primary heading -->
                            <!--<div class="portlet-heading">
                                <h3 class="portlet-title text-dark text-uppercase">
                                    <a href="<?php echo $go_back; ?>" role="link">Go Back</a>
                                </h3>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-xs-12 col-md-8 col-lg-4 item quote" itemtype="https://schema.org/CreativeWork">
                                <div class="pad clearfix">
                                    <?php
                                        if(isset($qImage) && !empty($qImage)){
                                    ?>
                                    <img class="img-responsive" src="<?php echo $qImage; ?>" alt="<?php echo $author; ?> Quote" title="<?php echo $author; ?>">
                                    <?php } ?>
                                    <blockquote itemprop="citation"><?php echo $quote; ?> <span itemprop="author"> - <?php echo $author; ?></span></blockquote>
                                    <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="<?php echo $current_url; ?>" data-title="<?php echo add3dots(str_replace($remove2, "", $quote),'...',169); ?>" data-description="<?php echo $author ?> | At PortalQuote you can create your own quotes, connect with other people, share quotes with your friends and more." <?php if(isset($qImage) && !empty($qImage)){ echo 'data-media="'.$qImage.'"'; }?>></div>
                                    <?php 
                                        if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){
                                            $liked=$obj->like('userQuotes_like', "userID=".$_SESSION['uID']." AND quoteID=$qID");
                                    ?>
                                    <div class="col-xs-4 col-md-4"><p><span><?php echo $nLikes[0]['cnt']; ?></span><a class="like qtLikeUsr <?php if(count($liked)>0) echo "liked qtDislikeUsr";?>" role="button" data-qtlike="<?php echo $qID; ?>"><?php if(count($liked)>0) echo "Liked <span class='glyphicon glyphicon-heart liked'></span>"; elseif($nLikes[0]['cnt']>1) echo 'Likes'; else echo 'Like'; ?></a></p></div>
                                    <?php }else{ ?>
                                    <div class="col-xs-4 col-md-4"><p><span><?php echo $nLikes[0]['cnt']; ?></span><a class="like disable" role="button" data-toggle="popover" data-placement="top" data-title="Want to like this?" data-content="You need to sign up or sign in...">Like<?php if($nLikes[0]['cnt']>1 || $nLikes[0]['cnt']==0) echo 's'; ?></a></p></div>
                                    <?php } ?>
                                    <div class="col-xs-12 _user-posted text-muted">
                                        Poster by: <a href="/panel/quotes/<?php echo $user[0]['username']; ?>/1" role="link" class=""><?php echo $user[0]['username']; ?></a>
                                    </div>
                                </div>
                            </div>-->
                            <div class="quote-box">
                                <img src="/panel/img/backgrounds/<?php echo $img; ?>" class="img-responsive thumbnail">
                                <blockquote>
                                    <p><?php echo $quote; ?></p>
                                    <span>
                                        <img src="/panel/img/frame.png" class="frame img-responsive">
                                        <?php echo $author; ?>
                                    </span>
                                </blockquote>                                
                            </div>
                            
                            <div class="quote-img-box">
                                <img class="img-responsive" id="img-user-quote" alt="<?php foreach($arrEN as $key=>$val) echo $arrEN[$key].', '; ?>" title="<?php echo $quote; ?>" style="display: none;">
                            </div>
                            
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 download-container">
                                        <a href="#" class="btn btn-primary btn-success" id="download" download><span class="glyphicon glyphicon-download-alt"></span> Download</a>
                                    </div>
                                    <div class="col-sm-12 share">
                                        <h3>Share This Quote</h3>
                                        <div class="addthis_sharing_toolbox" data-url="https://portalquote.com/panel/quote/<?php echo $user[0]['username'].'/'.$author.'/'.$_GET['quoteid']; ?>" data-title="Hey, check out this #quote by <?php echo $author; ?> | PortalQuote <?php foreach($arrEN as $key=>$val) echo '#'.$arrEN[$key].' '; ?>" data-description="<?php echo '\''.$quote.'\' - '.$author.". Share with your friends on Facebook, Twitter, Instagram..." ?>"></div>
                                    </div>
                                </div>
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
        <script src="/javascript/html2canvas.js"></script>
        <script src="../../../js/app.js?<?php echo date(); ?>"></script>
        <script src="../../../assets/tagsinput/jquery.tagsinput.min.js"></script>
        <script src="../../../js/bootstrap.min.js"></script>
        <script src="../../../js/pace.min.js"></script>
        <script src="../../../js/modernizr.min.js"></script>
        <script src="../../../js/wow.min.js"></script>
        <script src="../../../js/jquery.scrollTo.min.js"></script>
        <script src="../../../js/jquery.nicescroll.js" type="text/javascript"></script>
        <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID']) && $_SESSION['uID'] === $u_id){ ?>
        <script src="../../../js/84628a0974ef75ce8cbcfdaf79ce37d619c81cfd/7facc5a9f1b1539c570b57de3134b78dd6f1fdfe.js?<?php echo time(); ?>" type="text/javascript"></script>
        <script src="../../../js/349f7cad324a745042c675789bcb9cc245fbebf1/816f940ad8ab9401522a2e5e280dc9ddb5c0ef4a.js?<?php echo time(); ?>" type="text/javascript"></script>
        <script src="../js/0cfd653d5d3e1e9fdbb644523d77971d/2fd613c5d3017793d99ee18721e0924a.js?<?php echo time(); ?>" type="text/javascript"></script>
        <?php }elseif(isset($_SESSION['uID']) && !empty($_SESSION['uID']) && $_SESSION['uID']!=$u_id){ ?>
        <script src="../../../js/46b13e139205831924e33e8c10faa847/93ba5d9426226e11930384103fa8ba44.js?<?php echo time(); ?>" type="text/javascript"></script>
        <?php } ?>
        <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){ ?>
        <script src="../../../js/4236a440a662cc8253d7536e5aa17942/d668aad11dcbabd7f04c3a7aca25f1f7.js?<?php echo time(); ?>" type="text/javascript"></script>
        <script src="/javascript/b59ac58c7256fd0ee084d8adb9654bc1249d3197/c3d137ad7f14c18ef0d0d2e64cdb62f7c9cb3a39.js?<?php echo time(); ?>"></script>
        <?php } ?>
        <script src="../../../js/jquery.app.js"></script>
        <!-- Go to www.addthis.com/dashboard to customize your tools -->
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-573fcd941c5a9279"></script>
        <script>
            $('.thumnail').ready(function() {
                html2canvas($(".quote-box"), {
                    allowTaint: true,
                    onrendered: function(canvas) {
                        $('.quote-box').css('display','none');
                        //$('.quote-img-box').prepend(canvas);
                        var dataURL = canvas.toDataURL();
                        document.getElementById('img-user-quote').src=dataURL;
                        document.getElementById('img-user-quote').style.display='block';
                        document.getElementById('download').href=dataURL;
                        $('#img-user-quote').css({'margin':'auto','display':'block'});
                        console.log(dataURL);
                    }    
                });
            });
        </script>
    </body>
</html>
<?php }else{
    header("Location:/");
} ?>