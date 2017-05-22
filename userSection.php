<?php
    session_start();
    require_once('AppClasses/AppController.php');
    class HeadTags{
        public function titlePage($el) {
            return "PortalQuote: ".$el;
        }
        public function meta_description($el) {
            return $el;
        }
    }
    // META TAGS
    $meta_tags = new HeadTags();
    $title = $meta_tags->titlePage('Find other users\' quotes and more');
    $description = $meta_tags->meta_description("Follow other users, share their quotes and discover new ones in the Users' Section at PortalQuote.");
    $image = $authorDescription[0]['authorImage'];

	$folder='../../';
    if($_GET['type']=='quotes')
        $_SESSION['go_back']="https://portalquote.com/users-section/quotes/".$_GET['page'];
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
        
        <div class=" _outer-box">
            <div class="row">
                <a href="/users-section/quotes/1" role="link">
                    <span class="col-xs-6 col-sm-4 mn-box _box1">
                        <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                        Users' Quotes
                    </span>
                </a>
                <a href="/users-section/images/1" role="link">
                    <span class="col-xs-6 col-sm-4 mn-box _box2">
                        <span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
                        Users' Images
                    </span>
                </a>
                <a href="/users-section/users/1" role="link">
                    <span class="col-xs-12 col-sm-4 mn-box _box3">
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                        Discover Users
                    </span>
                </a>
            </div>
        </div>
        
        <section role="main" id="_users-section">
            <div class="container" id="_load">
                <!-- CONTENT -->
            </div>
            <input type="hidden" id="page" value="<?php echo $_GET['page']; ?>">
        </section>
        <!-- FOOTER -->
        <?php include 'layouts/footer.php'; ?>
        <?php if($_GET['type']=='quotes'){ ?>
            <script>
                function users_quotes(){var a=$("#page").val();document.getElementById("_load").innerHTML="",$("#_load").load("/layouts/users-section/quotes.php",{page:a})}$(document).ready(function(){users_quotes()});
            </script>
        <?php }elseif($_GET['type']=='images'){ ?>
            <script>
                function users_images(){var a=$("#page").val();document.getElementById("_load").innerHTML="",$("#_load").load("/layouts/users-section/images.php",{page:a})}$(document).ready(function(){users_images()});
            </script>
        <?php }elseif($_GET['type']=='users'){ ?>
            <script>
                function users_list(){var a=$("#page").val();document.getElementById("_load").innerHTML="",$("#_load").load("/layouts/users-section/users.php",{page:a})}$(document).ready(function(){users_list()});
            </script>
        <?php }?>
    </body>
</html>