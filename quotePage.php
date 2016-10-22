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
    $description = $meta_tags->meta_description('\''.$quote[0]['quote'].'\' - '.$quote[0]['author'].". Share with your friends on Facebook, Twitter, Instagram...");
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
            @import url('https://fonts.googleapis.com/css?family=Comfortaa');

            #original-content{margin-top: 10px;}
            .item{
                margin-left: auto;
                margin-right: auto;
                float: none;
                min-height: 250px;
                padding: 0;
                background: #232526;
        
            }
            .item blockquote{
                font-size: 3rem;padding-top: 20%;color: #fff;
                font-family: 'Comfortaa', cursive;
            }
            .item blockquote span{font-size: 3rem;font-family: 'Poiret One', cursive;}
            .item p{width: 100%;padding:5px;text-align: center;font-size: 3rem;color: #fff;font-family: 'Rouge Script', cursive;margin-top: 15%;background: rgba(0,0,0,0.5);width: 100%}
            #quoteImg{text-align: center;margin-top: 20px;}
            #quoteImg img{margin-left: auto;margin-right: auto;}
            #renderedCanva{visibility: hidden;}
            blockquote {border: 0;text-align: center;}
            blockquote span{display: block;margin-top: 10px;}
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
        <?php 
            if(isset($quote[0]['quoteImage']) && !empty($quote[0]['quoteImage'])){
        ?>
            <section id="original-content" role="contentinfo">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12" id="original">
                            <img src="<?php echo $quote[0]['quoteImage']; ?>" class="img-responsive">
                        </div>
                    </div>
                </div>
            </section>
        <?php include 'layouts/footer.php';
        } else{ ?>
            <section id="original-content" role="contentinfo">
                <div class="container">
                    <div class="row">
                        <!--<div class="col-xs-8 col-sm-7 col-md-6 col-lg-5 item quote large-card" id="original">
                            <div class="pad">
                                <?php if(isset($quote[0]['quoteImage']) && !empty($quote[0]['quoteImage'])){ ?>
                                    <img class="img-responsive" src="../images/quotes/<?php echo $quote[0]['quoteImage']; ?>">
                                <?php } ?>
                                <blockquote><?php echo $quote[0]['quote']; ?> <span>- <?php echo $quote[0]['author']; ?></span></blockquote>
                                <p>PortalQuote</p>
                            </div>
                        </div>-->
                        <div class="col-xs-12 item" id="original">
                            <blockquote><?php echo $quote[0]['quote']; ?> <span><?php echo $quote[0]['author']; ?></span></blockquote>
                            <p>PortalQuote</p>
                        </div>
                    </div>
                </div>
            </section>

            <section role="contentinfo">
                <div class="">
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
        <?php } ?>
    </body>
</html>
<?php
} else{
    include('404.html');
    exit();
}
?>