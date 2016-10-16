<?php
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
        // Pagination
        //$quotes = $obj->find_by('quotes_en','author',$author);        
        $limit = (isset( $_GET['limit'])) ? $_GET['limit'] : 10;
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
                background-image: url('<?php echo $images[$num]['img_url']; ?>');
                background-position: top;
            }
        </style>
    </head>
    <body>
        <section class="banner-topic background" id="banner" role="banner">
            <?php include 'layouts/nav.php'; ?>
            <!-- -->
            
            <h1 class="topic-info" itemtype="https://schema.org/CreativeWork">
                <meta itemprop="image" content="<?php echo $images[$num]['img_url']; ?>"></meta>
                <meta itemprop="keywords" content="<?php echo $topicDescription[0]['keywords']; ?>"></meta>
                <span><?php echo $topic; ?></span>
                <p class="col-xs-12 col-md-6 biography random-quote" itemprop="citation"><span class="quote"><?php echo $randomQuote[0]['quote']; ?></span></p>
                <p class="col-xs-12 col-md-6 biography random-author" itemprop="author"><span> - <?php echo $randomQuote[0]['author']; ?></span></p>
            </h1>
        </section>
        
        <!-- SIGN UP FORM -->
        <?php include 'layouts/signup.php'; ?>     
        <!-- -->

        <section id="quotes-day" role="contentinfo">
            <div class="container">
                <div class="row">
                    <div class="masonry-container">
                        <?php
                            foreach($quoteData as $key=>$val){
                                $quotes = $obj->find_by('quotes_en','quoteID',$quoteData[$key]['quoteID']);
                                $qID=$quotes[0]['quoteID'];
                                $quote=$quotes[0]['quote'];
                                $qImage=$quotes[0]['quoteImage'];
                                $topicsArr = $obj->custom('SELECT topics_en.topicID,topics_en.topicName FROM topics_en INNER JOIN quotesTopicEN ON topics_en.topicID=quotesTopicEN.topicID WHERE quoteID='.$qID); // USE join() FUNCTION
                                $count=0;
                                if(!empty($topicsArr)){
                                    foreach($topicsArr as $key=>$val){// DELETE THISLOOP AND USE ONLY JOIN LIKE BELOW
                                        $arrEN[$count]=$topicsArr[$key]['topicName']; // TOPIC'S NAME IN SPANISH
                                        $count++;
                                    }
                                }
                        ?>
                        <div class="col-xs-12 col-sm-6 col-md-4 item quote" itemtype="https://schema.org/CreativeWork">
                            <div class="pad">
                                <?php 
                                    if(isset($qImage) && !empty($qImage)){
                                ?>
                                    <img class="img-responsive" src="https://portalquote.com/images/quotes/<?php echo $qImage; ?>" alt="<?php echo $quotes[0]['author']; ?> Quote" title="<?php echo join(',', $arrEN); ?>">
                                <?php } ?>
                                <blockquote itemprop="citation"><?php echo $quote; ?>. <span itemprop="author">- <a href="" rel="author" itemprop="url"><?php echo $quotes[0]['author']; ?></a></span></blockquote>
                                <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="http://portalquote.com/quote/1" data-title="<?php echo $author; ?> | PortalQuote"></div>
                                <div class="col-xs-4 col-md-4"><p><span>0</span><a class="like" onclick="return myFunction(this)">Like</a></p></div>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
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