<?php
if (substr_count($_SERVER[‘HTTP_ACCEPT_ENCODING’], ‘gzip’)) ob_start(“ob_gzhandler”); else ob_start();

session_start();
if(isset($_GET['topic']) && !empty($_GET['topic'])){
    require_once('AppClasses/AppController.php');
    require_once 'AppClasses/Paginator.php';
    $obj = new AppController();

    class HeadTags{
        public function titlePage($el) {
            return $el." at PortalQuote";
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
    
    // Get Author's Name
   /* $topicArr=explode("-",$_GET['topic']);
    foreach($topicArr as $key=>$val){
        if($key != (count($topicArr)-1))
           $topic .= ucwords($val)." ";
        else
            $topic .= ucwords($val);
    }*/
    $seourl = strtolower($_GET['topic']);
    $topicDescription = $obj->find_by('topics_en','seo_url',$seourl);
    $topic = $topicDescription[0]['topicName'];

    if(isset($topicDescription) && !empty($topicDescription)){
        // META TAGS
        $meta_tags = new HeadTags();
        $title = $meta_tags->titlePage('Find The Best '.$topic.' Quotes');
        $description = $meta_tags->meta_description("Find the best quotes about ".strtolower($topic).", ".$topicDescription[0]['keywords']." and more by the best authors and famous people. Share with your friends on Facebook, Twitter, Instagram...");
        
        $images = $obj->find_by('topicsImages','tID',$topicDescription[0]['topicID']);
        $num = rand(0,count($images)-1); // TO SELECT A RANDOM IMAGE
        $image=$images[$num]['img_url'];
        if(!preg_match('/https:/',$image))
            $image='https://portalquote.com/images/topics-images/'.$image;
        else{
            $image = $image;
        }
        
        // Pagination
        //$quotes = $obj->find_by('quotes_en','author',$author);        
        $limit = (isset( $_GET['limit'])) ? $_GET['limit'] : 20;
        $page = (isset( $_GET['page'])) ? $_GET['page'] : 1;
        $links = (isset( $_GET['links'])) ? $_GET['links'] : 7;
        $Paginator  = new Paginator("quotesTopicEN WHERE topicID='".$topicDescription[0]['topicID']."'");
        $quotesARR = $Paginator->getData("quotesTopicEN WHERE topicID='".$topicDescription[0]['topicID']."'","id",$limit,$page);
        $quoteData = $quotesARR->data;
        $num2 = rand(0,count($quoteData)-1); // TO SELECT A RANDOM QUOTE
        $randomQuote = $obj->find_by('quotes_en','quoteID',$quoteData[$num2]['quoteID']);
        //End of Pagination
	$folder='../../../';
?>

<!doctype html>
<html class="no-js" lang="en">
    <head>
        <?php include 'layouts/head.php'; ?>
        <style>
            .background{
                background-image: url('<?php echo $image; ?>');
                background-position: top;
            }
        </style>
    </head>
    <body>
        <section class="banner-topic background" id="banner" role="banner">
            <?php include 'layouts/nav.php'; ?>
            <!-- -->
            
            <h1 class="topic-info" itemtype="https://schema.org/CreativeWork">
                <meta itemprop="image" content="<?php echo $image; ?>">
                <meta itemprop="keywords" content="<?php echo $topicDescription[0]['keywords']; ?>">
                <span><?php echo $topic; ?></span>
                <p class="col-xs-12 col-md-6 biography random-quote" itemprop="citation"><span class="quote"><?php echo $randomQuote[0]['quote']; ?></span></p>
                <p class="col-xs-12 col-md-6 biography random-author" itemprop="author"><span> - <?php echo $randomQuote[0]['author']; ?></span></p>
            </h1>
        </section>
        
        <!-- SIGN UP FORM -->
        <?php include 'layouts/signup.php'; ?>     
        <!-- -->
	<!-- LOGIN FORM -->
        <?php include 'layouts/login.php'; ?>
        <!-- -->

        <section id="quotes-day" role="main">
            <div class="container">
                <div class="row">
                    <div class="masonry-container">
                        <?php
                            foreach($quoteData as $key=>$val){
                                $quotes = $obj->find_by('quotes_en','quoteID',$quoteData[$key]['quoteID']);
                                $qID=$quotes[0]['quoteID'];
                                $quote=$quotes[0]['quote'];
                                $qImage=$quotes[0]['tinyImg'];
                                $acive=$quotes[$key]['active_img'];
                                $topicsArr = $obj->custom('SELECT topics_en.topicID,topics_en.topicName,topics_en.seo_url FROM topics_en INNER JOIN quotesTopicEN ON topics_en.topicID=quotesTopicEN.topicID WHERE quoteID='.$qID); // USE join() FUNCTION
                                $nLikes=$obj->custom("SELECT COUNT(quoteID) AS 'cnt' FROM likes_en WHERE quoteID=$qID");
                                $count=0;
                                $arrEN=array();
                                if(!empty($topicsArr)){
                                    foreach($topicsArr as $key=>$val){// DELETE THISLOOP AND USE ONLY JOIN LIKE BELOW
                                        $arrEN[$count]=$topicsArr[$key]['topicName']; // TOPIC'S NAME IN SPANISH
                                        $arrSEO[$count]=$topicsArr[$key]['seo_url']; // TOPIC'S SEO URL
                                        $count++;
                                    }
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
                                $q=str_replace($remove, "", $quote);
                                $blankStripped=preg_replace('/\s+/', ' ', $q);
                                $share_url=$qID.'_'.implode('-', array_slice(explode(' ', strtolower($blankStripped)), 0, 10));
                                $authorURL=$obj->find_by('authors','authorName',str_replace("'","\'", $quotes[0]['author']));
                        ?>
                        <div class="col-xs-12 col-sm-6 col-md-4 item quote" itemtype="https://schema.org/CreativeWork">
                            <div class="pad clearfix">
                                <?php 
                                    if(isset($qImage) && !empty($qImage) && $acive!=0){
                                ?>
                                    <img class="img-responsive" src="https://portalquote.com/images/quotes/<?php echo $qImage; ?>" alt="<?php echo $quotes[0]['author']; ?> Quote" title="<?php echo join(',', $arrEN); ?>">
                                <?php } ?>
                                <blockquote itemprop="citation"><a href="/quote/<?php echo $authorURL[0]['seo_url'].'/'.$share_url; ?>" class="quote-txt"><?php echo $quote; ?></a><span itemprop="author">- <a href="/author/quotes/<?php echo $authorURL[0]['seo_url'].'/1'; ?>" rel="author" itemprop="url"><?php echo $quotes[0]['author']; ?></a></span></blockquote>
                                <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="https://portalquote.com/quote/<?php echo $authorURL[0]['seo_url'].'/'.$share_url; ?>" data-title="Hey, check out this #quote by <?php echo $quotes[0]['author']; ?> | PortalQuote #quoteoftheday <?php foreach($arrEN as $key=>$val) echo '#'.$arrEN[$key].' '; ?>" data-description="<?php echo '\''.$quote.'\' - '.$quotes[0]['author'].". Share with your friends on Facebook, Twitter, Instagram..." ?>"></div>
                                <?php 
                                        if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){
                                            $liked=$obj->like('likes_en', "userID=".$_SESSION['uID']." AND quoteID=$qID");
                                ?>
                                    
                                    <div class="col-xs-4 col-md-4"><p><span><?php echo $nLikes[0]['cnt']; ?></span><a class="like qtLikeLink <?php if(count($liked)>0) echo "liked qtDislikeLink";?>" role="button" data-qtlike="<?php echo $qID; ?>"><?php if(count($liked)>0) echo "Liked <span class='glyphicon glyphicon-heart liked'></span>"; elseif($nLikes[0]['cnt']>1) echo 'Likes'; else echo 'Like'; ?></a></p></div>
                                <?php }else{ ?>
                                    <div class="col-xs-4 col-md-4"><p><span><?php echo $nLikes[0]['cnt']; ?></span><a class="like disable" role="button" data-toggle="popover" data-placement="top" data-title="Want to like this?" data-content="<a href='' data-toggle='modal' data-target='#signup'>Sign up</a> or <a href='' data-toggle='modal' data-target='#login'>Login</a>">Like<?php if($nLikes[0]['cnt']>1) echo 's'; ?></a></p></div>
                                <?php } ?>
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
                </div>
            </div>
        </section>
        
        <div class="container">
            <nav aria-label="Page navigation">
                <?php echo $Paginator->createLinks($links, 'pagination pagination-sm',dirname($_SERVER[REQUEST_URI])); ?> 
            </nav>
        </div>
        
        <!-- FOOTER -->
        <?php include 'layouts/footer.php'; ?>
        <script>
	    $(document).ready(function(){
                $('[data-toggle="popover"]').popover({html: true});
            });
            $(window).scroll(function(){
                var scrollTop = $(window).scrollTop();
                var height = $(window).height();
                $('.banner-topic h1').css({
                    'opacity': ((height - scrollTop) / height)
                });
            });
        </script>
    </body>
</html>
<?php 
    } else{
            include('404.html');
            exit();
        }
    } else{
        include('404.html');
        exit();
    }
?>