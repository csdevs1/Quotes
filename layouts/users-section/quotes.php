<?php
    session_start();
    require_once('../../AppClasses/AppController.php');
    require_once('../../AppClasses/Paginator.php');
    $obj = new AppController();

    $limit = (isset( $_GET['limit'])) ? $_GET['limit'] : 20;
    $page = (isset( $_POST['page'])) ? $_POST['page'] : 1;
    $links = (isset( $_GET['links'])) ? $_GET['links'] : 7;
    $Paginator  = new Paginator("userQuotes");
    $quotesARR = $Paginator->getData("userQuotes","created_at",$limit,$page);
    $quotes = $quotesARR->data;
?>

<div class="masonry-container">
    <?php
    foreach($quotes as $key=>$val){
        $qID=$quotes[$key]['quoteID'];
        $quote=$quotes[$key]['quote'];
        $qImage=$quotes[$key]['quoteImage'];
        $author=$quotes[$key]['author'];
        $u_id=$quotes[$key]['userID'];
        $user=$obj->find_by('users','userID',$u_id);
        /* $nLikes=$obj->custom("SELECT COUNT(quoteID) AS 'cnt' FROM likes_en WHERE quoteID=$qID");
        $count=0;
        if(!empty($topics)){
        foreach($topics as $key=>$val){// DELETE THISLOOP AND USE ONLY JOIN LIKE BELOW
        $arrEN[$count]=$topics[$key]['topicName']; // TOPIC'S NAME IN SPANISH
        $count++;
        }
        }
        
        $share_url=$qID.'_'.implode('-', array_slice(explode(' ', strtolower($quote)), 0, 10));*/
    ?>
    <div class="col-xs-12 col-sm-6 col-md-4 item quote" itemtype="https://schema.org/CreativeWork">
        <div class="pad clearfix">
            <?php
                if(isset($qImage) && !empty($qImage)){
            ?>
            <img class="img-responsive" src="<?php echo $qImage; ?>" alt="<?php echo $author; ?> Quote" title="">
            <?php } ?>
            <blockquote itemprop="citation"><?php echo $quote; ?>. <span itemprop="author">- <?php echo $author; ?></span></blockquote>
            <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="https://portalquote.com/quote/<?php echo 'sda'; ?>" data-title="Hey, check out this quote by <?php echo $author; ?> | PortalQuote"></div>
            <div class="col-xs-4 col-md-4"><p><span><?php //echo $nLikes[0]['cnt']; ?></span><a class="like disable" role="button" data-toggle="popover" data-placement="top" data-title="Want to like this?" data-content="<a href='' data-toggle='modal' data-target='#signup'>Sign up</a> or <a href='' data-toggle='modal' data-target='#login'>Login</a>">Like<?php /*if($nLikes[0]['cnt']>1) echo 's';*/ ?></a></p></div>
            <?php 
        /*if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){
        $liked=$obj->like('likes_en', "userID=".$_SESSION['uID']." AND quoteID=$qID");
            ?>
            <div class="col-xs-4 col-md-4"><p><span><?php echo $nLikes[0]['cnt']; ?></span><a class="like qtLikeLink <?php if(count($liked)>0) echo "liked qtDislikeLink";?>" role="button" data-qtlike="<?php echo $qID; ?>"><?php if(count($liked)>0) echo "Liked <span class='glyphicon glyphicon-heart liked'></span>"; elseif($nLikes[0]['cnt']>1) echo 'Likes'; else echo 'Like'; ?></a></p></div>
            <?php }else{ ?>
            <div class="col-xs-4 col-md-4"><p><span><?php //echo $nLikes[0]['cnt']; ?></span><a class="like disable" role="button" data-toggle="popover" data-placement="top" data-title="Want to like this?" data-content="<a href='' data-toggle='modal' data-target='#signup'>Sign up</a> or <a href='' data-toggle='modal' data-target='#login'>Login</a>">Like<?php if($nLikes[0]['cnt']>1) echo 's'; ?></a></p></div>
            <?php }*/ ?>
            <div class="col-xs-12 _user-posted text-muted">
                Poster by: <a href="/panel/quotes/<?php echo $user[0]['username']; ?>" role="link" class=""><?php echo $user[0]['username']; ?></a>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
</div>

<div class="container">
    <nav aria-label="Page navigation">
        <?php echo $Paginator->createLinks($links, 'pagination pagination-sm','/quotes/users-section/quotes'); ?> 
    </nav>
</div>

<script>
    $(document).ready(function(){
        var $container = $('.masonry-container');
        $container.masonry({
            columnWidth: '.item',
            itemSelector: '.item'
        });
        $('[data-toggle="popover"]').popover({html: true});
    });
</script>