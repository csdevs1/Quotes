<?php
    require_once 'AppClasses/Paginator.php';
    $limit = (isset( $_GET['limit'])) ? $_GET['limit'] : 10;
    $page = (isset( $_GET['page'])) ? $_GET['page'] : 1;
    $links = (isset( $_GET['links'])) ? $_GET['links'] : 7;
    $Paginator  = new Paginator();
    $results = $Paginator->getData($limit,$page);
?>

<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Find awesome quotes at 'Site's Name'</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/g/isotope@2.0.0(jquery.isotope.min.js)"></script>
        <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/123941/masonry.js"></script>        
        <script src="javascript/smoothScroll.js"></script>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <!-- Boostrap Validator -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
        <!-- End of Bootstrap -->
        <!-- IO ICONS -->
        <link href="user/assets/ionicon/css/ionicons.min.css" rel="stylesheet" />
        <!-- Custom CSS -->
        <link rel="stylesheet" href="app.css">
        <!-- Meta tags -->
        <meta name="description" content="At 'Site Name' you can find awesome quotes to share with your friends and family. You can also share your personal and favorite quotes with us, be it a motivational or inspirational quote, a funny quote or quotes about life.">
        <meta name="keywords" content="quotes, quote, quotes about family, quotes about friendship, quotes about love, quotes about life, motivational quotes, popular quotes, funny, inspirational, motivational, love, brainy, life, success, positive, happiness, friendship, best, smile, gandhi, confucio, winston churchill, martin luther king, web, site, page, article">
        <meta name="robots" content="index,follow">
        <meta property="od:site_name" content="Sites Name">
        <meta property="od:title" content="Find awesome quotes at Site Name">
        <meta property="od:type" content="article">
    </head>
    <body>
        <table class="table table-striped table-condensed table-bordered table-rounded">
            <thead>
                <tr>
                    <th>authorID</th>
                    <th width="20%">Name</th>
                    <th width="20%">Image</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($results->data as $key=>$val) { ?>
                    <tr>
                        <td><?php echo $results->data[$key]['authorID']; ?></td>
                        <td><?php echo $results->data[$key]['authorName']; ?></td>
                        <td><img src="<?php echo $results->data[$key]['authorImage']; ?>" class="img-responsive"></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php echo $Paginator->createLinks($links, 'pagination pagination-sm'); ?> 
    </body>
</html>