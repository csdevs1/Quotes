<?php
    session_start();
    require_once('../../AppClasses/AppController.php');
    $obj = new AppController();
    $quotes2=$obj->find_by('userQuotes','userID',$_SESSION['uID']);
?>
<div class="masonry-container">
    <?php
    foreach($quotes2 as $key=>$val){
        $qID=$quotes2[$key]['quoteID'];
        $quote=$quotes2[$key]['quote'];
        $qImage=$quotes2[$key]['quoteImage'];
        $author=$quotes2[$key]['author'];
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
            <blockquote itemprop="citation"><?php echo $quote; ?>. <span itemprop="author">- <a href="" rel="author" itemprop="url"><?php echo $author; ?></a></span></blockquote>
            <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="https://portalquote.com/quote/<?php echo 'sda'; ?>" data-title="Hey, check out this quote by <?php echo $author; ?> | PortalQuote"></div>
            <?php 
        if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){/*
        $liked=$obj->like('likes_en', "userID=".$_SESSION['uID']." AND quoteID=$qID");
            ?>

                                                            <div class="col-xs-4 col-md-4"><p><span><?php echo $nLikes[0]['cnt']; ?></span><a class="like qtLikeLink <?php if(count($liked)>0) echo "liked qtDislikeLink";?>" role="button" data-qtlike="<?php echo $qID; ?>"><?php if(count($liked)>0) echo "Liked <span class='glyphicon glyphicon-heart liked'></span>"; elseif($nLikes[0]['cnt']>1) echo 'Likes'; else echo 'Like'; ?></a></p></div>
                                                            <?php */}else{ ?>
            <div class="col-xs-4 col-md-4"><p><span><?php //echo $nLikes[0]['cnt']; ?></span><a class="like disable" role="button" data-toggle="popover" data-placement="top" data-title="Want to like this?" data-content="<a href='' data-toggle='modal' data-target='#signup'>Sign up</a> or <a href='' data-toggle='modal' data-target='#login'>Login</a>">Like<?php /*if($nLikes[0]['cnt']>1) echo 's';*/ ?></a></p></div>
            <?php } ?>
        </div>
    </div>
    <?php
    }
    ?>
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