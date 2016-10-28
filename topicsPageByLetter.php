<?php
session_start();
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
    
    $meta_tags = new HeadTags();
    $title = $meta_tags->titlePage('Find Quotes From Topics By Letter \''.$_GET['l'].'\'');
    $description = $meta_tags->meta_description("Find the best quotes by topics which start with '".$_GET['l']."'. Share with your friends on Facebook, Twitter, Instagram...");
        // Pagination
            $limit = (isset( $_GET['limit'])) ? $_GET['limit'] : 12;
            $page = (isset( $_GET['page'])) ? $_GET['page'] : 1;
            $links = (isset( $_GET['links'])) ? $_GET['links'] : 7;
            $Paginator  = new Paginator("topics_en WHERE topicName LIKE '".$_GET['l']."%'");
            $topicsArr = $Paginator->getData("topics_en WHERE topicName LIKE '".$_GET['l']."%'","topicID",$limit,$page);
    $topics = $topicsArr->data;
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
        
        <section role="main">
            <div class="container">
                <div class="row title"><h2>Topics Starting With <?php echo ucfirst($_GET['l']); ?></h2></div>
                <div class="row">
                    <ol class="breadcrumb">
                        <li><a href="/">Home</a></li>
                        <li><a href="/topics">Topics</a></li>
                        <li class="active"><?php echo ucfirst($_GET['l']); ?></li>
                    </ol>
                </div>
                <div class="row">
                    <?php
                    if(isset($topics) && !empty($topics)){
                        foreach($topics as $key=>$val){
                            $images = $obj->find_by('topicsImages','tID',$topics[$key]['topicID']);
                            $num = rand(0,count($images)-1);
                    ?>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 card-container">
                            <div class="col-xs-12 card-header" style="background-image:url('<?php echo $images[$num]['img_url']; ?>');">
                                <h3><a href="/topic/quotes/<?php echo $topics[$key]['seo_url']; ?>/1"><?php echo $topics[$key]['topicName']; ?></a></h3>
                            </div>
                            <div class="col-xs-12 card-content">
                                <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="https://portalquote.com/topic/quotes/<?php echo $topics[$key]['seo_url']; ?>/1" data-title="Find the best quotes about <?php echo $topics[$key]['topicName']; ?> at PortalQuote" data-description="<?php echo "Find the best quotes about ".strtolower($topics[$key]['topicName']).", ".$topics[$key]['keywords']."and more by the best authors and famous people"; ?>. Share with your friends on Facebook, Twitter, Instagram..."></div>
                                <a class="btn btn-primary" href="/topic/quotes/<?php echo $topics[$key]['seo_url']; ?>/1">View</a>
                            </div>
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
                <?php echo $Paginator->createLinks($links, 'pagination pagination-sm',dirname($_SERVER[REQUEST_URI])); ?> 
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