<?php
session_start();
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
    
    $remove[] = "'";
    $remove[] = '"';
    $remove[] = '.';
    $remove[] = ',';
    $remove2 = '"';
    
    $getURL=explode('_',$_GET['quoteid']);
    $quote=$obj->find_by('quotes_en','quoteID',$getURL[0]);
    $q=str_replace($remove, "", $quote[0]['quote']);
    $uri=$getURL[0].'_'.implode('-', array_slice(explode(' ', $q), 0, 10));
    
    if(strtolower($uri)!=$_GET['quoteid'])
        header('Location:'.strtolower($uri));
    
    $meta_tags = new HeadTags();
    $title = $meta_tags->titlePage('Find The Best Quotes');
    $description = $meta_tags->meta_description(str_replace($remove2, "'", $quote[0]['quote']).' - '.$quote[0]['author'].". Share with your friends on Facebook, Twitter, Instagram...");
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
        $image = "https://portalquote.com/images/thumbnail.png";
    $folder='../';
?>
<!doctype html>
<html class="no-js" lang="en">
    <head>
        <?php include 'layouts/head.php'; ?>
        <style>
            @import url('https://fonts.googleapis.com/css?family=Comfortaa');
            @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro');
            @import url('https://fonts.googleapis.com/css?family=PT+Serif');
            #renderedCanva{box-shadow: -2px 2px 3px #ccc;}
            #original-content{margin-top: 10px;}
            #original{overflow: hidden;width:1200px;height: 720px;} /*DELETE STATIC WIDTH AND HEIGHT*/
            .item{
                margin-left: auto;
                margin-right: auto;
                float: none;
                min-height: 250px;
                padding: 0;
                background: #232526;
        
            }
            .item blockquote{
                color: #fff;
                font-family: 'Comfortaa', cursive;
            }
            .item blockquote div{margin-top: 45px;}
            .item blockquote div span{font-family: 'Poiret One', cursive;padding-top: 5px;border-top: 1px solid #999;}
            .item p{width: 100%;padding:5px;text-align: center;color: #fff;font-family: 'PT Serif', serif;background: rgba(0,0,0,0);width: 100%}
            #quoteImg{text-align: center;margin-top: 20px;}
            #quoteImg img{margin-left: auto;margin-right: auto;}
            #renderedCanva{visibility: hidden;}
            blockquote {border: 0;text-align: center;}
            
            .item blockquote{font-size: 3rem;padding-top: 12%;}
            .item blockquote div span{font-size: 3.8rem;}
            .item p{font-size: 4.5rem;margin-top: 100px;}
           /*@media only screen and (min-width : 320px) {
                .item blockquote{font-size: 2rem;padding-top: 12%;}
                .item blockquote div span{font-size: 2rem;}
                .item p{font-size: 3rem;margin: 0 !important;margin-top: 5px;}
            }
            @media only screen and (min-width : 480px) {
                .item blockquote{font-size: 2.1rem;padding-top: 7%;}
                .item blockquote div span{font-size: 2.1rem;}
            }
            @media only screen and (min-width : 768px) {
                .item blockquote{font-size: 2.4rem;padding-top: 8%;}
                .item blockquote div span{font-size: 2.4rem;}
            }
            @media only screen and (min-width : 992px) {
                .item blockquote{font-size: 2.5rem;padding-top: 9%;}
                .item blockquote div span{font-size: 2.5rem;}
            }*/
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
        <!-- LOGIN FORM -->
        <?php include 'layouts/login.php'; ?>
        <!-- -->
        
        <?php 
            if(isset($quote[0]['quoteImage']) && !empty($quote[0]['quoteImage'])){
        ?>
            <section id="original-content" role="contentinfo">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
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
                        <div class="col-xs-12 col-sm-10 col-md-8 item" id="original">
                            <blockquote><?php echo $quote[0]['quote']; ?> <div><span><?php echo $quote[0]['author']; ?></span></div></blockquote>
                            <p>- PortalQuote.com -</p>
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