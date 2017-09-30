<?php
session_start();
if(isset($_GET['name']) && !empty($_GET['name'])){
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
   /* $authorArr=explode("-",$_GET['name']);
    foreach($authorArr as $key=>$val){
        if($key != (count($authorArr)-1))
           $author .= ucwords($val)." ";
        else
            $author .= ucwords($val);
    }*/
    $authorDescription = $obj->all('authors WHERE seo_url="'.$_GET['name'].'" OR authorID="'.$_GET['name'].'"');
    $author=$authorDescription[0]['authorName'];
    $authorName=str_replace("'","\'", $authorDescription[0]['authorName']);
    if(isset($authorDescription) && !empty($authorDescription)){
        $professionArr = $obj->find_by('authorProfession','authorID',$authorDescription[0]['authorID']); // GET PROFESSIONS ID
        $profession=array();
        foreach($professionArr as $key=>$val){
            $professions = $obj->find_by('professions','professionID',$professionArr[$key]['professionID']); // GET PROFESSIONS ID
            foreach($professions as $key2=>$val2){
               $profession[]= $professions[$key2]['professionName'];
            }
        }
	//GET BIRTHDAY AND DEAD
        $birthSPLIT=explode('-',$authorDescription[0]['birth']);
        $deathSPLIT=explode('-',$authorDescription[0]['died']);
        if($birthSPLIT[0]!='0000'){
            $birthdate=date_create($authorDescription[0]['birth']);
            $born=date_format($birthdate, 'F j, Y');
            $str=", born in ".$born;
        }if(isset($authorDescription[0]['died']) && !empty($authorDescription[0]['died']) && $deathSPLIT[0]!='0000'){
            $dDate=date_create($authorDescription[0]['died']);
            $dDate=date_format($dDate, 'F j, Y');
            $str.=" and died in ".$dDate;
        }
        // META TAGS
        $meta_tags = new HeadTags();
        $title = $meta_tags->titlePage('Find The Best Quotes From '.$author);
        $description = $meta_tags->meta_description("Find the best quotes by $author, ".join(', ',$profession)."".$str.". Share with your friends on Facebook, Twitter, Instagram...");
        if(!preg_match('/https:/',$authorDescription[0]['authorImage']))
            $image='https://portalquote.com/images/author-images/'.$authorDescription[0]['authorImage'];
        else
            $image=$authorDescription[0]['authorImage'];
        
        // Pagination
        //$quotes = $obj->find_by('quotes_en','author',$author);        
        $limit = (isset( $_GET['limit'])) ? $_GET['limit'] : 20;
        $page = (isset( $_GET['page'])) ? $_GET['page'] : 1;
        $links = (isset( $_GET['links'])) ? $_GET['links'] : 7;
        $Paginator  = new Paginator("quotes_en WHERE author='$authorName'");
        $quotesARR = $Paginator->getData("quotes_en WHERE author='$authorName'","quoteID",$limit,$page);
        //End of Pagination

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
	<script type="application/ld+json">
            {
                "@context" : "http://schema.org",
                "@type" : "Person",
                "name" : "<?php echo $author; ?>",
                "url" : "http://portalquote.com<?php echo $_SERVER[REQUEST_URI]; ?>",
                "image" : "<?php echo $image; ?>",
                "description" : "<?php echo $description; ?>"
            }
        </script>
    </head>
    <body>
        <section class="banner-topic background" id="banner" role="banner">
            <?php include 'layouts/nav.php'; ?>
            <!-- -->
            
            <h1 itemtype="https://schema.org/Person">
                <meta itemprop="image" content="<?php echo $image; ?>">
                <div class="profile"></div>
                <span itemprop="author"><?php echo $author; ?></span>
                <p class="col-xs-12 col-md-6 biography" itemprop="description"><?php echo add3dots($authorDescription[0]['bio'], '...', 250); ?> <a href="<?php echo $authorDescription[0]['sourceURL']; ?>" target="_blank">Read more</a></p>
                <p class="col-xs-12 col-md-6"><span class="strong">Profession: </span><?php echo join(', ',$profession); ?></p><p class="col-xs-12 col-md-6"><?php if($birthSPLIT[0]!='0000'){ ?><span class="strong">Born: </span><span itemprop="birthDate"><?php echo $born; ?></span><?php } if(isset($authorDescription[0]['died']) && !empty($authorDescription[0]['died']) && $deathSPLIT[0]!='0000'){ ?> - <span class="strong">Died: </span><span itemprop="deathDate"><?php echo $dDate; ?></span></p><?php } ?>
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
                            $quotes=$quotesARR->data;
                            foreach($quotes as $key=>$val){
                                $qID=$quotes[$key]['quoteID'];
                                $quote=$quotes[$key]['quote'];
                                $qImage=$quotes[$key]['tinyImg'];
                                $acive=$quotes[$key]['active_img'];
                                $topics = $obj->custom('SELECT topics_en.topicID,topics_en.topicName,topics_en.seo_url FROM topics_en INNER JOIN quotesTopicEN ON topics_en.topicID=quotesTopicEN.topicID WHERE quoteID='.$qID); // USE join() FUNCTION
                                $nLikes=$obj->custom("SELECT COUNT(quoteID) AS 'cnt' FROM likes_en WHERE quoteID=$qID");
                                $authorURL=$obj->find_by('authors','authorName',str_replace("'","''",$quotes[$key]['author']));
                                $seo_url=$authorURL[0]['seo_url'];
                                $count=0;
                                $arrEN=array();
                                if(!empty($topics)){
                                    foreach($topics as $key=>$val){// DELETE THISLOOP AND USE ONLY JOIN LIKE BELOW
                                        $arrEN[$count]=$topics[$key]['topicName']; // TOPIC'S NAME IN SPANISH
                                        $arrSEO[$count]=$topics[$key]['seo_url']; // TOPIC'S SEO URL
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
                                    if(isset($qImage) && !empty($qImage) && $acive!=0){
                                ?>
                                    <img class="img-responsive" src="https://portalquote.com/images/quotes/<?php echo $qImage; ?>" alt="<?php echo $author; ?> Quote" title="<?php echo join(',', $arrEN); ?>">
                                <?php } ?>
                                <blockquote itemprop="citation"><a href="https://portalquote.com/quote/<?php echo $seo_url.'/'.$share_url; ?>" class="quote-txt"><?php echo $quote; ?></a><span itemprop="author">- <a href="" rel="author" itemprop="url"><?php echo $author; ?></a></span></blockquote>
                                <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="https://portalquote.com/quote/<?php echo $seo_url.'/'.$share_url; ?>" data-title="Hey, check out this #quote by <?php echo $author; ?> | PortalQuote #quoteoftheday <?php foreach($arrEN as $key=>$val) echo '#'.$arrEN[$key].' '; ?>" data-description="<?php echo '\''.$quote.'\' - '.$author.". Share with your friends on Facebook, Twitter, Instagram..." ?>"></div>
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
            $(window).scroll(function(){var a=$(window).scrollTop(),b=$(window).height();$(".banner-topic h1").css({opacity:(b-a)/b})}),$(document).ready(function(){function a(){var a=Math.floor(9*Math.random())+1;$(".banner-topic").css({"background-image":"url(../../../images/author-gallery/"+a+".jpg)"})}$('[data-toggle="popover"]').popover({html:!0}),a()});
        </script>
    </body>
</html>
<?php 
        } else{
            include('404.html');
            exit();
        }
    }else{
        include('404.html');
        exit();
    }
?>