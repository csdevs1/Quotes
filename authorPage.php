<?php
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
    $authorArr=explode("-",$_GET['name']);
    foreach($authorArr as $key=>$val){
        if($key != (count($authorArr)-1))
           $author .= ucwords($val)." ";
        else
            $author .= ucwords($val);
    }
    $authorDescription = $obj->find_by('authors','authorName',$author);
    
    if(isset($authorDescription) && !empty($authorDescription)){
        // META TAGS
        $meta_tags = new HeadTags();
        $title = $meta_tags->titlePage('Find The Best Quotes By '.$author);
        $description = $meta_tags->meta_description("Find the best quotes from $author, ".$authorDescription[0]['profession'].", born in ".$authorDescription[0]['birth'].". Share with your frinds on Facebook, Twitter, Instagram...");
        $image = $authorDescription[0]['authorImage'];
        
        // Pagination
        //$quotes = $obj->find_by('quotes_en','author',$author);        
        $limit = (isset( $_GET['limit'])) ? $_GET['limit'] : 10;
        $page = (isset( $_GET['page'])) ? $_GET['page'] : 1;
        $links = (isset( $_GET['links'])) ? $_GET['links'] : 7;
        $Paginator  = new Paginator('quotes_en','author',$author);
        $quotesARR = $Paginator->getData('quotes_en','author',$author,$limit,$page);
        //End of Pagination
?>

<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="canonical" href="http://portalquote.com<?php echo $_SERVER[REQUEST_URI]; ?>">
        <link rel="icon" type="image/png" href="../../images/icon.png" />
        <title><?php echo $title; ?></title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/g/isotope@2.0.0(jquery.isotope.min.js)"></script>
        <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/123941/masonry.js"></script>        
        <script src="../../javascript/smoothScroll.js"></script>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <!-- Boostrap Validator -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
        <!-- End of Bootstrap -->
        <!-- IO ICONS -->
        <link href="../../Assets/ionicon/css/ionicons.min.css" rel="stylesheet" />
        <!-- Custom CSS -->
        <link rel="stylesheet" href="../../Assets/stylesheet/app.css?<?php echo time(); ?>">
        <!-- Meta tags -->
        <meta name="google" content="notranslate">
        <meta name="description" content="<?php echo $description; ?>">
        <meta name="robots" content="index,follow">
            <!-- Facebook metatags -->
        <meta property="od:site_name" content="PortalQuote">
        <meta property="od:title" content="<?php echo $title; ?>">
        <meta property="od:type" content="article">
        <meta property="od:image" content="image">
            <!-- Twitter metatags -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:title" content="<?php echo $title; ?>">
        <meta property="twitter:description" content="<?php echo $description; ?>">
        <meta property="twitter:image" content="<?php echo $image; ?>">
        <style>
            .profile{
                background-image: url('<?php echo $image; ?>');
            }
        </style>
    </head>
    <body>
        <section class="banner-topic background" id="banner" role="banner">
            <div class="nav-container">
                <header class="container">
                    <nav role="navigation">
                        
                        <div class="container-fluid">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu-items" aria-expanded="false" role="button">
                                    <span class="glyphicon glyphicon-send"></span>
                                </button>
                                <h2 class="navbar-toggle" style="float:left;">PortalQuote</h2>
                            </div>
                            
                            <div class="collapse navbar-collapse" id="menu-items">
                                <ul class="nav navbar-nav" itemscope itemtype="http://www.schema.org/SiteNavigationElement">
                                    <li itemprop="name"><a href="" role="link" itemprop="url"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                                    <li itemprop="name"><a href="" role="link" itemprop="url">Topics</a></li>
                                    <li itemprop="name"><a href="" role="link" itemprop="url">Authors</a></li>
                                    <li itemprop="name"><a href="quote-generator.html" itemprop="url">Quote Generator</a></li>
                                    <li><a onclick="showSearch(this)" role="button"><span class="glyphicon glyphicon-search"></span> Search</a></li>
                                </ul>
                                <ul class="nav navbar-nav navbar-right">
                                    <li><a href="#login" role="link"><span class="glyphicon glyphicon-log-in"></span> Log In</a></li>
                                    <li><a href="#signup" role="link" data-toggle="modal" data-target="#signup"><span class="glyphicon glyphicon-pencil"></span> Sign up</a></li>
                                </ul>
                            </div>
                            
                        </div>
                    </nav>
                </header>
            </div>
            
            <!--Search box -->
            <div id="search-box">
                <div class="container">
                    <div class="col-xs-12 col-sm-12 col-md-10"><button onclick="closeSearch(this)"><span class="glyphicon glyphicon-remove"></span></button></div>
                    <div class="col-xs-12">
                        <input class="input-search" id="input-search" type="search" placeholder="Search" autofocus role="search">
                        <ul>
                            <li><label><input type="radio" name="search">Quote</label></li>
                            <li><label><input type="radio" name="search">Author</label></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- -->
            
            <h1 itemtype="https://schema.org/Person">
                <meta itemprop="image" content="<?php echo $image; ?>"></meta>
                <div class="profile"></div>
                <span itemprop="author"><?php echo $author; ?></span>
                <p class="col-xs-12 col-md-6 biography" itemprop="description"><?php echo add3dots($authorDescription[0]['bio'], '...', 250); ?><a href="<?php echo $authorDescription[0]['sourceURL'] ?>" target="_blank">Read more</a></p>
                <p class="col-xs-12 col-md-6"><span class="strong">Profession: </span><?php echo $authorDescription[0]['profession'] ?></p><p class="col-xs-12 col-md-6"><span class="strong">Born: </span><span itemprop="birthDate"><?php echo $authorDescription[0]['birth'] ?></span> - <span class="strong">Died: </span><span itemprop="deathDate"><?php echo $authorDescription[0]['died'] ?></span></p>
            </h1>
        </section>
        
        <!-- SIGN UP FORM -->
        <div class="modal fade" id="signup" tabindex="-1" role="dialog" aria-labelledby="signuplLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Sign Up</h4>
                    </div>
                    <div class="modal-body" role="form">
                        
                        <div class="form-group col-xs-12">
                            <label for="fname" class="control-label">First Name</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="ion-android-contact"></i></span>
                                <input type="text" class="form-control" id="fname" data-error="Field required" aria-describedby="FirstName" placeholder="Enter First Name">
                            </div>
                        </div>
                        
                        <div class="form-group col-xs-12">
                            <label for="lname" class="control-label">Last Name</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="ion-android-contact"></i></span>
                                <input type="text" class="form-control" id="lname" data-error="Field required" aria-describedby="LastName" placeholder="Enter Last Name">
                            </div>
                        </div>
                        
                        <div class="form-group col-xs-12">
                            <label for="email" class="control-label">Email address</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="ion-android-mail"></i></span>
                                <input type="email" class="form-control" id="email" data-error="Email address is invalid" aria-describedby="emailAddress" placeholder="Enter email" required>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        
                        <div class="form-group col-xs-12">
                            <label for="passwd" class="control-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-sunglasses"></i></span>
                                <input type="password" class="form-control" id="passwd" data-error="Min: 7, Max: 10" aria-describedby="password" minlength="7" maxlength="10" placeholder="Enter password" required>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        
                        <div class="form-group col-xs-12">
                            <label for="gender" class="control-label">Gender</label>
                            <div class="input-group col-xs-12">
                                <select class="form-control">
                                    <option role="option">F</option>
                                    <option role="option">M</option>
                                </select>
                            </div>
                        </div>
                        
                        <h4>Or sign up with</h4>
                        <div class="form-group col-xs-12 social-network">
                            <a href="" class="col-xs-12 col-md-4">
                                <i class="ion-social-googleplus"></i> Gmail
                            </a>
                            <a  href="" class="col-xs-12 col-md-4">
                                <i class="ion-social-facebook"></i> Facebook
                            </a>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>        
        <!-- -->
        
        
<!--        <div class="row">
            <nav>
                <ul class="menu" id="filters">
                    <li><a  href="#One" class="filter" rel="*" name="isotope-filter">One</a></li>
                    <li><a  href="#Two" class="filter" rel=".geek" name="isotope-filter">Two</a></li>
                    <li><a  href="#Three" class="filter" rel=".nature" name="isotope-filter">Three</a></li>
                    <li><a  href="#Four" class="filter" rel=".entertainment" name="isotope-filter">Four</a></li>
                </ul>
            </nav>
        </div>
        -->
        <section id="quotes-day" role="contentinfo">
            <div class="container">
                <div class="row">
                    <div class="masonry-container">
                        <?php
                            $quotes=$quotesARR->data;
                            foreach($quotes as $key=>$val){
                                $qID=$quotes[$key]['quoteID'];
                                $quote=$quotes[$key]['quote'];
                                $qImage=$quotes[$key]['quoteImage'];
                                $topics = $obj->custom('SELECT topics_en.topicID,topics_en.topicName FROM topics_en INNER JOIN quotesTopicEN ON topics_en.topicID=quotesTopicEN.topicID WHERE quoteID='.$qID); // USE join() FUNCTION
                                $count=0;
                                if(!empty($topics)){
                                    foreach($topics as $key=>$val){// DELETE THISLOOP AND USE ONLY JOIN LIKE BELOW
                                        $arrEN[$count]=$topics[$key]['topicName']; // TOPIC'S NAME IN SPANISH
                                        $count++;
                                    }
                                }
                        ?>
                        <div class="col-xs-12 col-sm-6 col-md-4 item quote" itemtype="https://schema.org/CreativeWork">
                            <div class="pad">
                                <?php 
                                    if(isset($qImage) && !empty($qImage)){
                                ?>
                                    <img class="img-responsive" src="<?php echo $qImage; ?>" alt="<?php echo $author; ?> Quote" title="<?php echo join(',', $arrEN); ?>">
                                <?php } ?>
                                <blockquote itemprop="citation"><?php echo $quote; ?>. <span itemprop="author">- <a href="" rel="author" itemprop="url"><?php echo $author; ?></a></span></blockquote>
                                <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="http://portalquote.com/quote/1" data-title="<?php echo $author; ?> | PortalQuote"></div>
                                <div class="col-xs-4 col-md-4"><p><span>0</span><a class="like" onclick="return myFunction(this)">Like</a></p></div>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                        <!--
                        <div class="col-xs-12 col-sm-6 col-md-4 item quote">
                            <div class="pad">
                                <img class="img-responsive" src="images/1.jpg" alt="image description" title="Quote Tags">
                                <blockquote>Contrary to popular belief, Lorem Ipsum is not simply random text. <span>- <a href="" rel="author">Albert Einstein</a></span></blockquote>
                                <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="http://portalquote.com/quote/1" data-title="Author's Name"></div>
                                <div class="col-xs-4 col-md-4"><p><span>0</span><a class="like" onclick="return myFunction(this)">Like</a></p></div>
                            </div>
                        </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 item quote">
                        <div class="pad">
                            <blockquote>It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock. <span>- <a href="" rel="author">Albert Einstein</a></span></blockquote>
                            <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="http://portalquote.com/quote/1" data-title="Author's Name"></div>
                            <div class="col-xs-4 col-md-4"><p><span>0</span><a class="like" onclick="return myFunction(this)">Like</a></p></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 item quote">
                        <div class="pad">
                            <img class="img-responsive" src="images/2.jpg" alt="image description" title="Quote Tags">
                            <blockquote>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC. <span>- <a href="" rel="author">Albert Einstein</a></span></blockquote>
                            <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="http://portalquote.com/quote/1" data-title="Author's Name"></div>
                            <div class="col-xs-4 col-md-4"><p><span>0</span><a class="like" onclick="return myFunction(this)">Like</a></p></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 item quote">
                        <div class="pad">
                            <img class="img-responsive" src="images/3.jpg" alt="image description" title="Love, Friendship, Family">
                            <blockquote>Contrary to popular belief, Lorem Ipsum is not simply random text. <span>- <a href="" rel="author">Albert Einstein</a></span></blockquote>
                            <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="http://portalquote.com/quote/1" data-title="Author's Name"></div>
                            <div class="col-xs-4 col-md-4"><p><span>0</span><a class="like" onclick="return myFunction(this)">Like</a></p></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 item quote">
                        <div class="pad">
                            <blockquote>It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock. <span>- <a href="" rel="author">Albert Einstein</a></span></blockquote>
                            <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="http://portalquote.com/quote/1" data-title="Author's Name"></div>
                            <div class="col-xs-4 col-md-4"><p><span>0</span><a class="like" onclick="return myFunction(this)">Like</a></p></div>
                        </div>
                        </div>-->
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
        <footer>
            <div class="container" itemscope itemtype="http://www.schema.org/SiteNavigationElement">
                <div class="row">
                    <div class="col-xs-6 col-sm-4">
                        <h3>Follow us on</h3>
                        <ul class="list-unstyled">
                            <li><a href="/" target="_blank" role="link" rel="me" itemprop="sameAs"><i class="ion-social-facebook"></i>acebook</a></li>
                            <li><a href="https://twitter.com/PortalQuote" target="_blank" role="link" rel="me" itemprop="sameAs"><i class="ion-social-twitter"></i> Twitter</a></li>
                            <li><a href="/" target="_blank" role="link" rel="me" itemprop="sameAs"><i class="ion-social-instagram-outline"></i> Instagram</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-6 col-sm-4">
                        <h3>Site</h3>
                        <ul class="list-unstyled">
                            <li itemprop="name"><a href="/" role="link" itemprop="url">Home</a></li>
                            <li itemprop="name"><a href="/" role="link" itemprop="url">Authors</a></li>
                            <li itemprop="name"><a href="/" role="link" itemprop="url">Topics</a></li>
                            <li itemprop="name"><a href="/" role="link" itemprop="url">Quotes Generator</a></li>
                        </ul>
                    </div>
                    <hr class="col-sm-12 visible-xs">
                    <div class="col-sm-4">
                        <h3>About Us</h3>
                        <ul class="list-unstyled">
                            <li itemprop="name"><a href="/" role="link" rel="help" itemprop="url">Contact Us</a></li>
                            <li itemprop="name"><a href="/" role="link" rel="help" itemprop="url">Terms</a></li>
                            <li itemprop="name"><a href="/" role="link" rel="help" itemprop="url">Privacy</a></li>
                        </ul>                        
                    </div>
                </div>
                <div class="row">
                    <hr class="col-sm-12">
                    <div class="col-xs-12 col-sm-6">
                        <h3>Subscribe to our newsletter</h3>
                        <div class="form-group col-xs-12">
                            <div class="input-group">
                                <input type="email" class="form-control" id="newsemail" placeholder="Enter your email" requird>
                                <span class="input-group-addon"><input type="submit" id="subscribe" class="btn btn-primary" value="Subscribe"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        
        <script src="../../javascript/app.js?<?php echo time(); ?>"></script>
        <script>
            $(window).scroll(function(){
                var scrollTop = $(window).scrollTop();
                var height = $(window).height();
                $('.banner-topic h1').css({
                    'opacity': ((height - scrollTop) / height)
                });
            });
            $(document).ready(function(){
                function randomWallpaper(){
                    // 1 -> 5
                    var num = Math.floor(Math.random() * 5) + 1;
                    $('.banner-topic').css({'background-image':'url(../../images/author-gallery/'+num+'.jpg)'});
                }
                randomWallpaper();
            });
        </script>
        <!-- Go to www.addthis.com/dashboard to customize your tools -->
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-573fcd941c5a9279"></script>
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
