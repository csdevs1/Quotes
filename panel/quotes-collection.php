<?php
    session_start();
    require_once('../AppClasses/AppController.php');
    require_once '../AppClasses/Paginator.php';

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
        
    $limit = (isset( $_GET['limit'])) ? $_GET['limit'] : 20;
    $page = (isset( $_GET['page'])) ? $_GET['page'] : 1;
    $links = (isset( $_GET['links'])) ? $_GET['links'] : 7;
    $Paginator  = new Paginator("likes_en WHERE userID='$u_id'");
    $quotesARR = $Paginator->getData("likes_en WHERE userID='$u_id'","quoteID ASC",$limit,$page);
    $nQuotes=$obj->custom("SELECT COUNT(quoteID) AS 'cnt' FROM likes_en WHERE userID=$u_id");
    $quotes=$quotesARR->data;
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

            <div class="wraper container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="portlet"><!-- /primary heading -->
                            <div class="portlet-heading">
                                <h3 class="portlet-title text-dark text-uppercase">
                                    Your Collection
                                </h3>
                                <div class="clearfix"></div>
                            </div>
                            
                            <div id="portlet1" class="panel-collapse collapse in">
                                    <div class="portlet-body">
                                        <section role="contentinfo">
                                            <div class="container q-container">
                                                <div class="row" id="q-contItem">
                                                    <div class="masonry-container">
                                                        <?php
                                                            foreach($quotes as $key=>$val){
                                                                $qID=$quotes[$key]['quoteID'];
                                                                $quoteArr=$obj->find_by('quotes_en','quoteID',$qID);
                                                                $quote=$quoteArr[0]['quote'];                                                                
                                                                if(isset($quoteArr[0]['tinyImg']) && !empty($quoteArr[0]['tinyImg']))
                                                                    $qImage = "https://portalquote.com/images/quotes/".$quoteArr[0]['tinyImg'];
                                                                else
                                                                    $qImage = $quoteArr[0]['quoteImage'];
                                                                
                                                                $author=$quoteArr[0]['author'];
                                                                $u_id=$quoteArr[0]['userID'];
                                                                $active=$quoteArr[0]['active_img'];
                                                                $user=$obj->find_by('users','userID',$u_id);
                                                                $nLikes=$obj->custom("SELECT COUNT(quoteID) AS 'cnt' FROM likes_en WHERE quoteID=$qID");
                                                                $topics = $obj->custom('SELECT topics_en.topicID,topics_en.topicName,topics_en.seo_url FROM topics_en INNER JOIN quotesTopicEN ON topics_en.topicID=quotesTopicEN.topicID WHERE quoteID='.$qID); 
                                                                $count=0;
                                                                $arrEN=array();
                                                                if(!empty($topics)){
                                                                    foreach($topics as $key=>$val){// DELETE THISLOOP AND USE ONLY JOIN LIKE BELOW
                                                                        $arrEN[$count]=$topics[$key]['topicName']; // TOPIC'S NAME IN SPANISH
                                                                        $arrSEO[$count]=$topics[$key]['seo_url']; // TOPIC'S SEO URL
                                                                        $count++;
                                                                    }
                                                                }

                                                                $share_url=$qID.'_'.implode('-', array_slice(explode(' ', strtolower($quote)), 0, 10));
                                                                
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
                                                                $q=str_replace($remove, "", $quote);
                                                                $blankStrippedq=preg_replace('/\s+/', ' ', $q);
                                                                $share_url=$qID.'_'.implode('-', array_slice(explode(' ', strtolower($blankStrippedq)), 0, 10));
                                                                
                                                                $a=str_replace($remove, "", $author);
                                                                $blankStripped=preg_replace('/\s+/', ' ', $a);        
                                                                $author_seo=implode('-', array_slice(explode(' ', strtolower($blankStripped)), 0, 10));
                                                                $authorURL=$obj->find_by('authors','authorName',str_replace("'","\'", $author));
                                                            ?>
                                                            <div class="col-xs-12 col-sm-6 col-md-4 item quote" itemtype="https://schema.org/CreativeWork">
                                                                <div class="pad clearfix">
                                                                    <?php 
                                                                        if(isset($qImage) && !empty($qImage) && $active-=0){
                                                                    ?>
                                                                        <img class="img-responsive" src="<?php echo $qImage; ?>" alt="<?php echo $quotes[0]['author']; ?> Quote" title="<?php echo join(',', $arrEN); ?>">
                                                                    <?php } ?>
                                                                    <blockquote itemprop="citation"><a href="/quote/<?php echo $authorURL[0]['seo_url'].'/'.$share_url; ?>" class="quote-txt"><?php echo $quote; ?></a><span itemprop="author">- <a href="/author/quotes/<?php echo $authorURL[0]['seo_url'].'/1'; ?>" rel="author" itemprop="url"><?php echo $author; ?></a></span></blockquote>
                                                                    <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="https://portalquote.com/quote/<?php echo $authorURL[0]['seo_url'].'/'.$share_url; ?>" data-title="Hey, check out this #quote by <?php echo $quotes[0]['author']; ?> | PortalQuote #quoteoftheday <?php foreach($arrEN as $key=>$val) echo '#'.$arrEN[$key].' '; ?>" data-description="<?php echo '\''.$quote.'\' - '.$quotes[0]['author'].". Share with your friends on Facebook, Twitter, Instagram..." ?>"></div>
                                                                    <?php 
                                                                            if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){
                                                                                $liked=$obj->like('likes_en', "userID=".$_SESSION['uID']." AND quoteID=$qID");
                                                                    ?>

                                                                        <div class="col-xs-4 col-md-4"><p><span><?php echo $nLikes[0]['cnt']; ?></span><a class="like qtLikeLink <?php if(count($liked)>0) echo "liked qtDislikeLink";?>" role="button" data-qtlike="<?php echo $qID; ?>"><?php if(count($liked)>0) echo "Liked <span class='glyphicon glyphicon-heart liked'></span>"; elseif($nLikes[0]['cnt']>1) echo 'Likes'; else echo 'Like'; ?></a></p></div>
                                                                    <?php }/*else{ ?>
                                                                        <div class="col-xs-4 col-md-4"><p><span><?php echo $nLikes[0]['cnt']; ?></span><a class="like disable" role="button" data-toggle="popover" data-placement="top" data-title="Want to like this?" data-content="<a href='' data-toggle='modal' data-target='#signup'>Sign up</a> or <a href='' data-toggle='modal' data-target='#login'>Login</a>">Like<?php if($nLikes[0]['cnt']>1) echo 's'; ?></a></p></div>
                                                                    <?php }*/ ?>
                                                                    <div class="col-xs-12 related-t">
                                                                        <?php
                                                                            $tagsLinksArray = array();
                                                                            foreach($arrEN as $key=>$val) {
                                                                                $tagName = $val;
                                                                                $tagsLinksArray[] = '<a href="/topic/quotes/'.$arrSEO[$key].'/1" role="link">'.$tagName.'</a>';
                                                                            }
                                                                            echo join(', ', $tagsLinksArray);
                                                                        ?>
                                                                    </div>
                                                                    <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){ ?>
                                                                    <div class="col-xs-12">
                                                                        <i class="ion-flag _rp" title="Report" data-toggle="modal" data-target=".report-qt" data-qt="<?php echo $qID; ?>"></i>
                                                                    </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <?php
                                                                }
                                                            ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>                            
                            <div class="container">
                                <nav aria-label="Page navigation">
                                    <?php
                                        if($nQuotes[0]['cnt']>20)
                                            echo $Paginator->createLinks($links, 'pagination pagination-sm',dirname($_SERVER[REQUEST_URI])); 
                                    ?> 
                                </nav>
                            </div>
                            
                        </div> <!-- /Portlet -->
                    </div> <!-- end col -->
                </div> <!-- End row -->
            </div>
            <!-- Page Content Ends -->
            <!-- ================== -->
        <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){ ?>
                            <div class="modal fade report-qt" tabindex="-1" role="dialog" aria-labelledby="reportQuote">
                                <div class="modal-dialog modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Help us improve</h4>
                                        </div>
                                        <div class="modal-body">
                                            <h5 class="text-muted">Tell us what's wrong with this quote</h5>

                                            <div class="modal-body" role="form">
                                                <div class="radio">
                                                    <label><input type="radio" name="optradio" value="0" checked="checked" >There's a misspelling.</label>
                                                </div>
                                                <div class="radio">
                                                    <label><input type="radio" name="optradio" value="1">There's something wrong with the picture.</label>
                                                </div>
                                                <div class="radio">
                                                    <label><input type="radio" name="optradio" value="2">This quote is offensive.</label>
                                                </div>
                                                <div class="radio">
                                                    <label><input type="radio" name="optradio" value="3">Other</label>
                                                </div>
                                                <br>
                                                <div class="form-group">
                                                    <label for="email" class="control-label small text-muted">Tell us more about it:</label>
                                                    <div class="input-group col-xs-12">
                                                        <textarea class="report-text"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="_report-it">Send Report</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
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
        <script src="../js/0cfd653d5d3e1e9fdbb644523d77971d/2fd613c5d3017793d99ee18721e0924a.js?<?php echo time(); ?>" type="text/javascript"></script>
        <?php }elseif(isset($_SESSION['uID']) && !empty($_SESSION['uID']) && $_SESSION['uID']!=$u_id){ ?>
        <script src="../js/46b13e139205831924e33e8c10faa847/93ba5d9426226e11930384103fa8ba44.js?<?php echo time(); ?>" type="text/javascript"></script>
        <?php } ?>
        <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){ ?>
        <script src="../js/4236a440a662cc8253d7536e5aa17942/d668aad11dcbabd7f04c3a7aca25f1f7.js?<?php echo time(); ?>" type="text/javascript"></script>
        <?php } ?>
        <script src="../js/jquery.app.js"></script>
        <script src="/javascript/e98d2f001da5678b39482efbdf5770dc/8fa4cfdbaa51e010dbe9124e0e7392c2.js?<?php echo time(); ?>"></script>
    </body>
</html>
<?php }else{
    header("Location:/");
} ?>
