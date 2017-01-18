<?php
session_start();
if(isset($_GET['t']) && !empty($_GET['t']) && isset($_GET['q']) && !empty($_GET['q'])){
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
    // META TAGS
    $meta_tags = new HeadTags();
    $title = $meta_tags->titlePage('Looking for "'.$_GET['q'].'"');
    $description = $meta_tags->meta_description('Looking for \''.$_GET['q'].'\'. Share with your friends on Facebook, Twitter, Instagram...');
    // Pagination
    //$query='"'.str_replace("'","\'",$_GET['q']).'"';
    $query=str_replace("'","\'",$_GET['q']);
    $limit = (isset( $_GET['limit'])) ? $_GET['limit'] : 20;
    $page = (isset( $_GET['page'])) ? $_GET['page'] : 1;
    $links = (isset( $_GET['links'])) ? $_GET['links'] : 7;
    if($_GET['t']=='author'){
        $Paginator  = new Paginator("quotes_en WHERE author LIKE '%$query%'");
        $quotesARR = $Paginator->getData("quotes_en WHERE author LIKE '%$query%'","quoteID",$limit,$page);
        
        $rand=rand(0,count($quotesARR->data)-1);
        $qRand = $obj->find_by('quotes_en','quoteID',$quotesARR->data[$rand]['quoteID']);
        $randQuote=$qRand[0]['quote'];
        $randAuthor=$qRand[0]['author'];
    }elseif($_GET['t']=='quotes' || $_GET['t']=='keyword'){
        $Paginator  = new Paginator("quotes_en WHERE MATCH(quote) AGAINST('".$query."' IN BOOLEAN MODE) OR  quote LIKE '%".$query."%'");
        $quotesARR = $Paginator->getData("quotes_en WHERE MATCH(quote) AGAINST('".$query."' IN BOOLEAN MODE) OR  quote LIKE '%".$query."%'","quoteID",$limit,$page);
        
        $rand=rand(0,count($quotesARR->data)-1);
        $qRand = $obj->find_by('quotes_en','quoteID',$quotesARR->data[$rand]['quoteID']);
        $randQuote=$qRand[0]['quote'];
        $randAuthor=$qRand[0]['author'];
    }elseif($_GET['t']=='topic'){
        /*$topics=$obj->custom("SELECT * FROM topics_en WHERE topicName LIKE '%".$query."%' OR keywords LIKE '%".$query."%' OR MATCH(topicName) AGAINST('".$query."' IN BOOLEAN MODE) OR MATCH(keywords) AGAINST('".$query."' IN BOOLEAN MODE) OR soundex(topicName)=soundex('".$query."')");
        $Paginator  = new Paginator("quotesTopicEN WHERE topicID='".$topics[0]['topicID']."'");
        $quotesARR = $Paginator->getData("quotesTopicEN WHERE topicID='".$topics[0]['topicID']."'","id",$limit,$page);
        
        $rand=rand(0,count($quotesARR->data)-1);
        $qRand = $obj->find_by('quotes_en','quoteID',$quotesARR->data[$rand]['quoteID']);
        $randQuote=$qRand[0]['quote'];
        $randAuthor=$qRand[0]['author'];*/

        $topics=$obj->custom("SELECT * FROM topics_en WHERE topicName LIKE '%".$query."%' OR keywords LIKE '%".$query."%' OR MATCH(topicName) AGAINST('".$query."' IN BOOLEAN MODE) OR MATCH(keywords) AGAINST('".$query."' IN BOOLEAN MODE) OR soundex(topicName)=soundex('".$query."')"); //OR MATCH(topicName) AGAINST('".$query."' IN BOOLEAN MODE) OR MATCH(keywords) AGAINST('".$query."' IN BOOLEAN MODE) OR soundex(topicName)=soundex('".$query."')
        
        $topicARR=array();
        foreach($topics as $key=>$val){
            $topicARR[$key]=$topics[$key]['topicID'];
        }
        
        $topicQUERY=join(' OR topicID=',$topicARR);
        $Paginator  = new Paginator("quotesTopicEN WHERE topicID=".$topicQUERY." GROUP BY quoteID");
        $quotesARR = $Paginator->getData("quotesTopicEN WHERE topicID=".$topicQUERY." GROUP BY quoteID","id",$limit,$page);
        $rand=rand(0,count($quotesARR->data)-1);
        $qRand = $obj->find_by('quotes_en','quoteID',$quotesARR->data[$rand]['quoteID']);
        $randQuote=$qRand[0]['quote'];
        $randAuthor=$qRand[0]['author'];        
    }
    //End of Pagination
    $quoteData=$quotesARR->data;
	$folder='../../../';
?>

<!doctype html>
<html class="no-js" lang="en">
    <head>
        <?php include 'layouts/head.php'; ?>
        <style>
            .profile{
                background-image: url('<?php echo $image; ?>');
            }
        </style>
    </head>
    <body>
        <section class="banner-topic background" id="banner" role="banner">
            <?php include 'layouts/nav.php'; ?>
            <!-- -->
            
            <h1 class="topic-info">
                <span>"<?php echo $_GET['q']; ?>"</span>
                <p class="col-xs-12 col-md-6 biography random-quote" itemprop="citation"><span class="quote">
                    <?php
                        if(!empty($randQuote) && isset($randQuote))
                            echo $randQuote; 
                        else
                            echo 'Sorry, it seems we couldn\'t find what you were looking for!';
                    ?>
                    </span></p>
                <p class="col-xs-12 col-md-6 biography random-author" itemprop="author"><span><?php if(!empty($randAuthor) && isset($randAuthor)) echo ' - '.$randAuthor; ?></span></p>
            </h1>
        </section>
        
        <!-- SIGN UP FORM -->
        <?php include 'layouts/signup.php'; ?>     
        <!-- -->
        <!-- LOGIN FORM -->
        <?php include 'layouts/login.php'; ?>
        <!-- -->
        
        <section id="quotes-day" role="contentinfo">
            <div class="container">
                <div class="row">
                    <div class="masonry-container">
                        <?php
                            if(!empty($quoteData) && isset($quoteData)){
                                foreach($quoteData as $key=>$val){
                                    $quotes = $obj->find_by('quotes_en','quoteID',$quoteData[$key]['quoteID']);
                                    $qID=$quotes[0]['quoteID'];
                                    $quote=$quotes[0]['quote'];
                                    $qImage=$quotes[0]['quoteImage'];
                                    $topicsArr = $obj->custom('SELECT topics_en.topicID,topics_en.topicName,topics_en.seo_url FROM topics_en INNER JOIN quotesTopicEN ON topics_en.topicID=quotesTopicEN.topicID WHERE quotesTopicEN.quoteID='.$qID); // USE join() FUNCTION
                                    $authorURL=$obj->find_by('authors','authorName',$quotes[0]['author']);
                                    $nLikes=$obj->custom("SELECT COUNT(quoteID) AS 'cnt' FROM likes_en WHERE quoteID=$qID");
                                    $count=0;
                                    $arrEN=array();
                                    if(!empty($topicsArr)){
                                        foreach($topicsArr as $key=>$val){
                                            $arrEN[$count]=$topicsArr[$key]['topicName']; // TOPIC'S NAME
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
                        ?>
                        <div class="col-xs-12 col-sm-6 col-md-4 item quote" itemtype="https://schema.org/CreativeWork">
                            <div class="pad clearfix">
                                <?php 
                                    if(isset($qImage) && !empty($qImage)){
                                ?>
                                    <img class="img-responsive" src="/images/quotes/<?php echo $qImage; ?>" alt="<?php echo $quotes[0]['author']; ?> Quote" title="<?php echo join(',', $arrEN); ?>">
                                <?php } ?>
                                <blockquote itemprop="citation"><a href="https://portalquote.com/quote/<?php echo $share_url; ?>"><?php echo $quote; ?></a> <span itemprop="author">- <a href="/author/quotes/<?php echo $authorURL[0]['seo_url'].'/1'; ?>" rel="author" itemprop="url"><?php echo $quotes[0]['author']; ?></a></span></blockquote>
                                <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="https://portalquote.com/quote/<?php echo $share_url; ?>" data-title="Hey, check out this quote by <?php echo $quotes[0]['author']; ?> | PortalQuote <?php foreach($arrEN as $key=>$val) echo '#'.$arrEN[$key].' '; ?>" data-description="<?php echo '\''.$quote.'\' - '.$quotes[0]['author'].". Share with your friends on Facebook, Twitter, Instagram..." ?>"></div>
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
                            </div>
                        </div>
                        <?php
                                }
                            } else{
                                $listURL='<a href="/authors/1/" role="link">AUTHORS</a>, <a href="/topics" role="link">TOPICS</a> and
                                              <a href="/quotes/keywords" role="link">KEYWORDS</a>';
                        ?>
                        <div class="col-xs-12 not-found">
                            <div class="col-xs-12"><span class="ion-sad"></span></div>
                            <span>Didn't find what you were looking for? Don't worry, check out this list of <?php echo $listURL; ?> to help you find the quote you're looking for.</span>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <?php if(!empty($quoteData) && isset($quoteData)){ ?>
        <div class="container">
            <nav aria-label="Page navigation">
                <?php echo $Paginator->createLinks($links, 'pagination pagination-sm',dirname($_SERVER[REQUEST_URI])); ?> 
            </nav>
        </div>
        <?php } ?>
        
        <!-- FOOTER -->
        <?php include 'layouts/footer.php'; ?>
        <script>
            $(window).scroll(function(){
                var scrollTop = $(window).scrollTop();
                var height = $(window).height();
                $('.banner-topic h1').css({
                    'opacity': ((height - scrollTop) / height)
                });
            });
            $(document).ready(function(){
                $('[data-toggle="popover"]').popover({html: true}); 
                function randomWallpaper(){
                    // 1 -> 5
                    var num = Math.floor(Math.random() * 5) + 1;
                    $('.banner-topic').css({'background-image':'url(../../../images/author-gallery/'+num+'.jpg)'});
                }
                randomWallpaper();
            });
        </script>
    </body>
</html>
<?php
    }else{
        include('404.html');
	exit();
    }
?>
