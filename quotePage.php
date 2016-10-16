<?php
if(isset($_GET['quoteid']) && !empty($_GET['quoteid'])){
    require_once('AppClasses/AppController.php');
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
    $quote=$obj->find_by('quotes_en','quoteID',$_GET['quoteid']);
    $meta_tags = new HeadTags();
    $title = $meta_tags->titlePage('Find The Best Quotes At PortalQuote');
    $description = $meta_tags->meta_description('"'.$quote[0]['quote'].'" -'.$quote[0]['author'].". Share with your friends on Facebook, Twitter, Instagram...");
    $topicsArr=$obj->custom("SELECT topics_en.topicID, topics_en.topicName FROM topics_en INNER JOIN quotesTopicEN ON topics_en.topicID=quotesTopicEN.topicID WHERE quotesTopicEN.quoteID=".$quote[0]['quoteID']);
    $count=0;
    $topics=array();
    foreach($topicsArr as $key=>$val){
        $topics[$count]=$topicsArr[$key]['topicName'];
        $count++;
    }
    $topic=join(",",$topics);
    if(isset($quote[0]['quoteImage']) && !empty($quote[0]['quoteImage']))
        $image = "https://portalquote.com/images/quotes/".$quote[0]['quoteImage'];
    else
        $image = "image";
    $folder='../';
?>

<!doctype html>
<html class="no-js" lang="en">
    <head>
        <?php include 'layouts/head.php'; ?>
        <style>
            .quote .pad{margin-top: 20px;padding-bottom: 0 !important;}
            .quote blockquote:before {
                content:"";
            }
            .large-card{margin-left: auto;margin-right: auto;float: none;}
            .large-card blockquote{font-size: 1.7rem;}
            .large-card blockquote span{font-size: 1.5rem;}
            .large-card p{width: 100%;padding:5px;text-align: center;font-size: 3rem;color: #bbb;font-family: 'Rouge Script', cursive;}
            #quoteImg{text-align: center;margin-top: 20px;}
            #quoteImg img{margin-left: auto;margin-right: auto;}
            #renderedCanva{visibility: hidden;}
        </style>
    </head>
    <body>
        <section class="background" id="banner" role="banner">
            <?php include 'layouts/nav.php'; ?>
            <!-- -->
        </section>
        
        <!-- SIGN UP FORM -->
        <?php include 'layouts/signup.php'; ?>
        <!-- -->        
        <section id="original-content" role="contentinfo">
            <div class="container">
                <div class="row">
                    <div class="col-xs-8 col-sm-7 col-md-6 col-lg-5 item quote large-card" id="original">
                        <div class="pad">
                            <?php if(isset($quote[0]['quoteImage']) && !empty($quote[0]['quoteImage'])){ ?>
                                <img class="img-responsive" src="../images/quotes/<?php echo $quote[0]['quoteImage']; ?>">
                            <?php } ?>
                            <blockquote><?php echo $quote[0]['quote']; ?> <span>- <?php echo $quote[0]['author']; ?></span></blockquote>
                            <p>PortalQuote</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section role="contentinfo">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12" id="quoteImg">
                        <img class="img-responsive" id="renderedCanva" title="<?php echo $quote[0]['author']; ?>" alt="<?php echo $topic;  ?>">
                    </div>
                </div>
            </div>
        </section>
        
        <!-- FOOTER -->
        <?php include 'layouts/footer.php'; ?>
        <script>
            window.onload=function(){
                html2canvas($("#original"), {
                    allowTaint: true,
                    onrendered: function(canvas) {
                        var dataURL = canvas.toDataURL();
                        document.getElementById('renderedCanva').src=dataURL;
                        canvas.id = "image-canva";
                        $('#original-content').hide();
                        $('#renderedCanva').css('visibility','visible');
                    }
                });
            }
        </script>
    </body>
</html>
<?php
} else{
    include('404.html');
    exit();
}
?>