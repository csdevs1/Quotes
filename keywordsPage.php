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

    $meta_tags = new HeadTags();
    $title = $meta_tags->titlePage('Search Quotes by Keywords');
    $description = $meta_tags->meta_description("Check out this list of keywords to help find the quote you're looking for. Share with your friends on Facebook, Twitter, Instagram...");
    $image = "https://portalquote.com/images/thumbnail.png";
    $folder='../';
    $arr=$obj->custom("SELECT SUM(total_count) as total, value
    FROM (

    SELECT count(*) AS total_count, REPLACE(REPLACE(REPLACE(x.value,'?',''),'.',''),'!','') as value
    FROM (
    SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(t.quote, ' ', n.n), ' ', -1) value
      FROM quotes_en t CROSS JOIN 
    (
       SELECT a.N + b.N * 10 + 1 n
         FROM 
        (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a
       ,(SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b
        ORDER BY n
    ) n
     WHERE n.n <= 1 + (LENGTH(t.quote) - LENGTH(REPLACE(t.quote, ' ', '')))
     ORDER BY value

    ) AS x
    GROUP BY x.value

    ) AS y
    GROUP BY value ORDER BY total DESC LIMIT 1300;
    ");
    $remove[] = '"';
    $remove[] = '.';
    $remove[] = ',';
    $remove[] = ' ';
    $uWords[] = 'its';
    $uWords[] = 'it\'s';
    $uWords[] = 'Its';
    $uWords[] = 'It\'s';
    $uWords[] = 'Can\'t';
    $uWords[] = 'can\'t';
    $uWords[] = 'Because';
    $uWords[] = 'because';
    $uWords[] = 'that';
    $uWords[] = 'then';
    $uWords[] = 'Then';
    $uWords[] = 'them';
    $uWords[] = 'Them';
    $uWords[] = 'than';
    $uWords[] = 'Than';
    $uWords[] = 'They';
    $uWords[] = 'they';
    $uWords[] = 'which';
    $uWords[] = 'Which';
    $uWords[] = 'when';
    $uWords[] = 'When';
    $uWords[] = 'Where';
    $uWords[] = 'where';
    $uWords[] = 'What';
    $uWords[] = 'what';
    $uWords[] = 'this';
    $uWords[] = 'This';
    $uWords[] = 'Will';
    $uWords[] = 'will';
    $uWords[] = 'with';
    $uWords[] = 'With';
    $uWords[] = 'have';
    $uWords[] = 'Have';
    $uWords[] = 'their';
    $uWords[] = 'Their';
    $uWords[] = 'there';
    $uWords[] = 'There';
    $uWords[] = 'want';
    $uWords[] = 'Want';
    $uWords[] = 'your';
    $uWords[] = 'Your';
    $uWords[] = 'Dont';
    $uWords[] = 'dont';
    $uWords[] = 'don\'t';
    $uWords[] = 'Don\'t';
    $uWords[] = 'Some';
    $uWords[] = 'some';
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
                        <h2>KEYWORDS</h2>
                    </div>
                    <div class="col-xs-12">
                        <span>Didn't find what you were looking for at <a href="topics" role="link">Topics</a>? Don't worry, check out this list of keywords to help find the quote you're looking for. <strong>Enjoy</strong>!</span>
                    </div>
                    <?php
                    foreach($arr as $key=>$val){
                        $keywords=str_replace($remove, "", $arr[$key]['value']);
                        if(strlen($arr[$key]['value']) > 3 && !in_array($arr[$key]['value'], $uWords, true )){
                    ?>
                    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 keywords">
                        <a href="keywords" class="keyword" onclick="return false;" role="link"><?php echo ucwords($keywords); ?></a>
                    </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <div class="col-xs-12 col-sm-6 category-content">
                    <h3><a class="btn btn-primary" role="button" id="loadMore">Load more</a></h3>
                </div>
                <div class="col-xs-12 col-sm-6 category-content">
                    <h3><a class="btn btn-success" role="button" id="showLess">Show less</a></h3>
                </div>
            </div>
        </section>
        <!-- FOOTER -->
        <?php include 'layouts/footer.php'; ?>
        <script>
        $(document).ready(function () {
            size_li = $('.row .keywords').length;
            x=72;
            $('.row .keywords:lt('+x+')').show();
            $('#loadMore').click(function () {
                x= (x+72 <= size_li) ? x+72 : size_li;
                $('.row .keywords:lt('+x+')').show();
            });
            $('#showLess').click(function () {
                x=(x-72<=0) ? 72 : x-72;
                $('.row .keywords').not(':lt('+x+')').hide();
            });
        });
        </script>
    </body>
</html>