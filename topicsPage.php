<?php
    session_start();
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

    $alphas = range('A', 'Z');
    $meta_tags = new HeadTags();
    $title = $meta_tags->titlePage('Quotes by Topics');
    $description = $meta_tags->meta_description("Check out our great collection of topics regarding Love, Inspiration, Motivation and more. Share with your friends on Facebook, Twitter, Instagram...");
    $image = "https://portalquote.com/images/thumbnail.png";
?>

<!doctype html>
<html class="no-js" lang="en">
    <head>
        <?php include 'layouts/head.php'; ?>
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
        
        <section role="main">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 title title-topic">
                        <h2>TOPICS</h2>
                    </div>
                    <div class="col-xs-12">
                        <span>Check out our great collection of topics regarding love, inspiration, motivation, friendship, success and more. <strong>Enjoy</strong>!</span>
                    </div>
                    <?php
                        foreach($alphas as $key=>$val){
                            $topics = $obj->custom("SELECT quotesTopicEN.topicID,topics_en.topicName,topics_en.seo_url,topics_en.topicID,COUNT(quotesTopicEN.topicID) AS 'cnt' FROM quotesTopicEN INNER JOIN topics_en ON topics_en.topicID=quotesTopicEN.topicID WHERE topics_en.topicName LIKE '".$val."%' GROUP BY quotesTopicEN.topicID ORDER BY COUNT(quotesTopicEN.topicID) DESC LIMIT 4;");
                            if(isset($topics) && !empty($topics)){
                    ?>
                    <div class="col-xs-6 col-sm-4 col-md-3 list-topics">
                        <h2><?php echo $val?></h2>
                        <ul class="list-unstyled">
                            <?php
                                foreach($topics as $key2=>$val2){
                            ?>
                                <li><a href="/topic/quotes/<?php echo $topics[$key2]['seo_url']; ?>/1"><?php echo $topics[$key2]['topicName']; ?></a></li>
                            <?php
                                }
                            ?>
                        </ul>
                        <a href="/topics/<?php echo strtolower($val); ?>/1">View more</a>
                    </div>
                    <?php
                            }
                        }
                    ?>
                </div>
                
                <div class="row explore-more">
                    <div class="col-xs-12">Want to explore more?</div>
                    <div class="col-xs-12"><a href="/quotes/keywords" class="btn btn-primary">CHECKOUT OUR LIST OF KEYWORDS!</a></div>
                </div>
            </div>
        </section>
        
        <!-- FOOTER -->
        <?php include 'layouts/footer.php'; ?>
    </body>
</html>