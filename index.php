<?php
    require_once('AppClasses/AppController.php');
    class HeadTags{
        public function titlePage($el) {
            return $el." at PortalQuote";
        }
        public function meta_description($el) {
            return $el;
        }
    }
// META TAGS
    $meta_tags = new HeadTags();
    $title = $meta_tags->titlePage('Find The Best Quotes');
    $description = $meta_tags->meta_description('Find the best quotes about topics like love, family, friend, motivation, funny from popular authors. Share with your friends on Facebook, Twitter, Instagram...');
    $image = "https://portalquote.com/images/thumbnail.png";
// Conection
    $obj = new AppController();
    $topics = $obj->custom("SELECT topicID, COUNT(topicID) AS 'cnt' FROM quotesTopicEN GROUP BY topicID ORDER BY cnt DESC LIMIT 8;");
?>
<!doctype html>
<html class="no-js" lang="en">
    <head>
        <?php include 'layouts/head.php'; ?>
        <script type="application/ld+json">
            {
              "@context" : "http://schema.org",
              "@type" : "WebSite",
              "name" : "PortalQuote",
              "alternateName": "PortalQuote - Popular Quotes",
              "url" : "http://portalquote.com",
              "thumbnailUrl" : "images/icon.png",
              "description" : "Find the best quotes about topics like love, family, friend, motivation, funny from popular authors.",
              "keywords" : "Quotes, Love, Family, Friendship, Leadership, Motivational, Inspirational, Authors, Topics",
              "image" : "https://portalquote.com/images/thumbnail.png";
              "sameAs" : [
                "https://www.facebook.com/PortalQuote",
                "https://twitter.com/PortalQuote",
                "https://instagram.com/portalquote"
              ],
              "potentialAction": {
                  "@type": "SearchAction",
                  "target": "https://portalquote.com/search/{search_term_string}",
                  "query-input": "required name=search_term_string"
              }
            }
        </script>
        <style>
            <?php
                foreach($topics as $key=>$val){
                    $images = $obj->find_by('topicsImages','tID',$val['topicID']);
                    $topic = $obj->find_by('topics_en','topicID',$val['topicID']);
                    $num = rand(0,count($images)-1);
                    $lower = strtolower($topic[0]['topicName']);
                    $tName=split(' ',$lower);
                    $id=join('-',$tName);
                    echo '#'.$id.'{background-image: url("'.$images[$num]['img_url'].'");}';
                }
            ?>
        </style>
    </head>
    <body>
        <section class="banner background current" id="banner" role="banner">
            <video playsinline autoplay muted loop id="background-video">
                <source type="video/mp4">
            </video>
            
            <?php include 'layouts/nav.php'; ?>
            
            <h1>
                PortalQuote
                <br><a href="" role="link" data-toggle="modal" data-target="#signup">Sign up</a>
            </h1>
            <div class="col-xs-12 arrow">
                <a href="#popular-topics" id="arrow" role="link"><p>View more</p>
                <span class="glyphicon glyphicon-hand-down"></span></a>
            </div>
        </section>
        
        <!-- SIGN UP FORM -->
            <?php include 'layouts/signup.php'; ?>
        <!-- -->
        
        <section id="popular-topics" role="contentinfo">
            <div class="container">
                <div class="row">
                    <h2 class="title">Popular topics</h2>
                    
                    <?php
                        foreach($topics as $key=>$val){
                            $images = $obj->find_by('topicsImages','tID',$val['topicID']);
                            $topic = $obj->find_by('topics_en','topicID',$val['topicID']);
                            $num = rand(0,count($images)-1);
                            $lower = strtolower($topic[0]['topicName']);
                            $tName=split(' ',$lower);
                            $id=join('-',$tName);
                            //echo $images[$num]['img_url'].'<br>';
                    ?>
                    <div class="col-xs-12 col-sm-6 col-md-4 category-content">
                        <div class="category background topic-animation" id="<?php echo $id; ?>">
                            <h3><a href="" role="link"><?php echo $topic[0]['topicName']; ?></a></h3>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                    
                   <!-- <div class="col-xs-12 col-sm-6 col-md-4 category-content">
                        <div class="category background" id="motivational">
                            <h3><a href="" role="link">Motivational</a></h3>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 category-content">
                        <div class="category background" id="inspirational">
                            <h3><a href="" role="link">Inspirational</a></h3>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 category-content">
                        <div class="category background" id="love">
                           <h3><a href="" role="link">Love</a></h3>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 category-content">
                        <div class="category background" id="life">
                            <h3><a href="" role="link">Life</a></h3>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 category-content">
                        <div class="category background" id="friendship">
                            <h3><a href="" role="link">Friendship</a></h3>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 category-content">
                        <div class="category background" id="leadership">
                            <h3><a href="" role="link">Leadership</a></h3>
                        </div>
                    </div>-->
                    <div class="col-xs-12 category-content">
                        <h3><a href="" class="btn btn-primary" role="link">View more</a></h3>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="quotes-day" role="contentinfo">
            <div class="container">
                <div class="row">
                    <h2 class="title">Quotes of the Day</h2>
                    <div class="masonry-container">
                    <div class="col-xs-12 col-sm-6 col-md-4 item quote">
                        <div class="pad">
                            <img class="img-responsive" src="images/1.jpg" alt="image description" title="Quote Tags">
                            <blockquote>Contrary to popular belief, Lorem Ipsum is not simply random text. <span>- <a href="" rel="author">Albert Einstein</a></span></blockquote>
                            <!-- Go to www.addthis.com/dashboard to customize your tools -->
                            <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="http://portalquote.com/quote/1" data-title="Author's Name"></div>
                            <div class="col-xs-4 col-md-4"><p><span>0</span><a class="like" onclick="return myFunction(this)">Like</a></p></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 item quote">
                        <div class="pad">
                            <blockquote>It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock. <span>- <a href="" rel="author">Albert Einstein</a></span></blockquote>
                            <!-- Go to www.addthis.com/dashboard to customize your tools -->
                            <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="http://portalquote.com/quote/1" data-title="Author's Name"></div>
                            <div class="col-xs-4 col-md-4"><p><span>0</span><a class="like" onclick="return myFunction(this)">Like</a></p></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 item quote">
                        <div class="pad">
                            <img class="img-responsive" src="images/2.jpg" alt="image description" title="Quote Tags">
                            <blockquote>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC. <span>- <a href="" rel="author">Albert Einstein</a></span></blockquote>
                            <!-- Go to www.addthis.com/dashboard to customize your tools -->
                            <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="http://portalquote.com/quote/1" data-title="Author's Name"></div>
                            <div class="col-xs-4 col-md-4"><p><span>0</span><a class="like" onclick="return myFunction(this)">Like</a></p></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 item quote">
                        <div class="pad">
                            <img class="img-responsive" src="images/3.jpg" alt="image description" title="Love, Friendship, Family">
                            <blockquote>Contrary to popular belief, Lorem Ipsum is not simply random text. <span>- <a href="" rel="author">Albert Einstein</a></span></blockquote>
                            <!-- Go to www.addthis.com/dashboard to customize your tools -->
                            <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="http://portalquote.com/quote/1" data-title="Author's Name"></div>
                            <div class="col-xs-4 col-md-4"><p><span>0</span><a class="like" onclick="return myFunction(this)">Like</a></p></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 item quote">
                        <div class="pad">
                            <blockquote>It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock. <span>- <a href="" rel="author">Albert Einstein</a></span></blockquote>
                            <!-- Go to www.addthis.com/dashboard to customize your tools -->
                            <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="http://portalquote.com/quote/1" data-title="Author's Name"></div>
                            <div class="col-xs-4 col-md-4"><p><span>0</span><a class="like" onclick="return myFunction(this)">Like</a></p></div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="popular-authors" role="contentinfo">
            <div class="container">
                <div class="row">
                    <h2 class="title">Popular Authors</h2>
                    <div class="col-xs-12 author">
                        <h3 class="title"><a href="" role="link" rel="author">Albert Einstein</a></h3>
                        <div class="col-xs-12 col-sm-4 image-container">
                            <img src="images/einstein.png" class="img-responsive author-img" alt="albert-einstein" title="Albert Einstein" role="img">
                        </div>
                        <div class="col-xs-12 col-sm-8 quote author-quote">
                            <blockquote><h3>Imagination is more important than knowledge. <span>- Albert Einstein</span></h3></blockquote>
                        </div>
                    </div>
                    
                    <div class="col-xs-12 reorder-xs author">
                        <h3 class="title"><a href="" role="link" rel="author">Winston Churchill</a></h3>
                        <div class="col-xs-12 col-sm-8 quote author-quote">
                            <blockquote class="blockquote-reverse"><h3>Success consists of going from failure to failure without loss of enthusiasm.
 <span>- Winston Churchill</span></h3></blockquote>
                        </div>
                        <div class="col-xs-12 col-sm-4 image-container">
                            <img src="images/winston-churchill.png" class="img-responsive author-img even" alt="winston-churchill" title="Winston Churchill" role="img">
                        </div>
                    </div>
                    
                    <div class="col-xs-12 author">
                        <h3 class="title"><a href="" role="link" rel="author">Mahatma Gandhi</a></h3>
                        <div class="col-xs-12 col-sm-4 image-container">
                            <img src="images/gandhi.png" class="img-responsive author-img" alt="mahatma-gandhi" title="Mahatma Gandhi" role="img">
                        </div>
                        <div class="col-xs-12 col-sm-8 quote author-quote">
                            <blockquote><h3>You must not lose faith in humanity. Humanity is an ocean; if a few drops of the ocean are dirty, the ocean does not become dirty.<span>- Mahatma Gandhi</span></h3></blockquote>
                        </div>
                    </div>
                    
                    <div class="col-xs-12 category-content">
                        <h3><a href="" class="btn btn-primary" role="link">View more</a></h3>
                    </div>
                </div>
            </div>
        </section>
        
        <?php include 'layouts/footer.php'; ?>
        <script>
            $(document).ready(function(){
                var count=0;
                document.getElementById('background-video').removeAttribute("controls"); // Remove video control
                function randomVideo(){
                    //Download videos in 2K (1440p)
                    var num = Math.floor(Math.random() * 2) + 1;
                    var video = document.getElementById('background-video');
                    var sources = video.getElementsByTagName('source');
                    sources[0].src = 'Assets/videos/'+num+'.mp4';
                    video.load();
                    video.play();
                }
                randomVideo();
                
                function randomWallpaper(){
                    // 1 -> 12
                    var num = Math.floor(Math.random() * 12) + 1;
                    $('#banner').css({'background-image':'url(images/'+num+'.jpg)'});
                }
                
                if(window.innerWidth <= 767){
                    randomWallpaper();
                    count++;
                }
                
                $(window).resize(function(){
                    var isBackground = document.getElementById('banner').style.backgroundImage;
                    if(window.innerWidth <= 767){
                        if(count<1 || isBackground == '')
                            randomWallpaper();
                        else {
                            console.log('Hi there!');
                        }
                    } else {
                        $('#banner').css({'background-image':''});
                    }
                    count++;
                });
                //randomWallpaper();
                
                function supportType(vidType) {
                    var vid = document.getElementById('background-video');
                    isSupp = vid.canPlayType(vidType);
                    if (isSupp == "")
                        return false;
                    else
                        return true;
                }
                if(!supportType("video/mp4"))
                    randomWallpaper();
            });
        </script>
    </body>
</html>