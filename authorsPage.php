<?php
if(isset($_GET['page']) && !empty($_GET['page'])){
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

    $alphas = range('A', 'Z');
    $meta_tags = new HeadTags();
    if(isset($_GET['l']) && !empty($_GET['l'])){
        $title = $meta_tags->titlePage('Find Quotes From Authors By Letter \''.$_GET['l'].'\'');
        $description = $meta_tags->meta_description("Find the best quotes from authors whose name starts with '".$_GET['l']."'. Share with your friends on Facebook, Twitter, Instagram...");
        // Pagination
            $limit = (isset( $_GET['limit'])) ? $_GET['limit'] : 14;
            $page = (isset( $_GET['page'])) ? $_GET['page'] : 1;
            $links = (isset( $_GET['links'])) ? $_GET['links'] : 7;
            $Paginator  = new Paginator("authors WHERE authorName LIKE '".$_GET['l']."%'");
            $authorsArr = $Paginator->getData("authors WHERE authorName LIKE '".$_GET['l']."%'","authorID",$limit,$page);
        //End of Pagination
        
    } else{
        $title = $meta_tags->titlePage("Find Your Favorite Authors At PortalQuote");
        $description = $meta_tags->meta_description("Find the best quotes from your favorite authors regarding topics like love, friendship, family, motivational, inspirational and more. Share with your friends...");
        // Pagination
            $limit = (isset( $_GET['limit'])) ? $_GET['limit'] : 14;
            $page = (isset( $_GET['page'])) ? $_GET['page'] : 1;
            $links = (isset( $_GET['links'])) ? $_GET['links'] : 7;
            $Paginator  = new Paginator('authors');
            $authorsArr = $Paginator->getData("authors","authorName",$limit,$page);
        //End of Pagination
    }
    $authors = $authorsArr->data;
    $image = "https://portalquote.com/images/thumbnail.png";
	$folder='../../';
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

        <section role="navigation">
            <div class="container">
                <div class="row abc">
                    <ul class="list-inline">
                        <?php
                        foreach($alphas as $key=>$val){
                        ?>
                            <li><a href="/authors/1/<?php echo strtolower($val); ?>" role="link"><?php echo $val ?></a></li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
                <div class="row"><h1>Authors</h1></div>
            </div>
        </section>
        
        <section role="contentinfo">
            <div class="container">
                <div class="row" itemtype="https://schema.org/Person">
                    <?php
                    if(isset($authors) && !empty($authors)){
                        foreach($authors as $key=>$val){
                            $split=explode(" ",strtolower($authors[$key]['authorName']));
                            $seoURL = join("-",$split);
                    ?>
                    <div class="col-xs-12 col-sm-6 author-list">
                        <div class="img-circle img-media" style="background-image:url('<?php echo $authors[$key]['authorImage']; ?>')"></div>
                        <!--<img itemprop="image" src="<?php echo $authors[$key]['authorImage']; ?>" class="img-circle img-media" alt="<?php echo $authors[$key]['authorName']; ?>" title="<?php echo $authors[$key]['authorName']; ?>">-->
                        <h4 itemprop="author"><a href="/author/quotes/<?php echo $authors[$key]['seo_url']; ?>/1" itemprop="url"><?php echo $authors[$key]['authorName']; ?></a></h4>
                    </div>
                    <?php
                        }
                    } else{
                        echo "<h1>Sorry, authors not found!</h1>";
                    }
                    ?>
                </div>
            </div>
        </section>
        <div class="container">
            <nav aria-label="Page navigation">
                <?php echo $Paginator->createLinks($links, 'pagination pagination-sm','/authors','/'.$_GET['l']); ?> 
            </nav>
        </div>
        
        <!-- FOOTER -->
        <?php include 'layouts/footer.php'; ?>
    </body>
</html>
<?php
} else{
    include('404.html');
    exit();
}
?>