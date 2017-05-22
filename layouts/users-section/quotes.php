<?php
    session_start();
    require_once('../../AppClasses/AppController.php');
    require_once('../../AppClasses/Paginator.php');
    $folder='../../';
    $obj = new AppController();

    $limit = (isset( $_GET['limit'])) ? $_GET['limit'] : 20;
    $page = (isset( $_POST['page'])) ? $_POST['page'] : 1;
    $links = (isset( $_GET['links'])) ? $_GET['links'] : 7;
    $Paginator  = new Paginator("userQuotes");
    $quotesARR = $Paginator->getData("userQuotes","created_at",$limit,$page);
    $quotes = $quotesARR->data;
    
    function add3dots($string, $repl, $limit){
        if(strlen($string) > $limit){
            return substr($string, 0, $limit) . $repl;
        }
        else {
            return $string;
        }
    }
echo $_GET['page'];
?>

<div class="masonry-container container">
    <?php
    foreach($quotes as $key=>$val){
        $qID=$quotes[$key]['quoteID'];
        $quote=$quotes[$key]['quote'];
        $qImage=$quotes[$key]['quoteImage'];
        $author=$quotes[$key]['author'];
        $u_id=$quotes[$key]['userID'];
        $user=$obj->find_by('users','userID',$u_id);
        $nLikes=$obj->custom("SELECT COUNT(quoteID) AS 'cnt' FROM userQuotes_like WHERE quoteID=$qID");
                
        $created_at=date_create($quotes[$key]['created_at']);
        $created_at=date_format($created_at, 'F j, Y');
        /*$count=0;
        if(!empty($topics)){
            foreach($topics as $key=>$val){// DELETE THISLOOP AND USE ONLY JOIN LIKE BELOW
                $arrEN[$count]=$topics[$key]['topicName']; // TOPIC'S NAME IN SPANISH
                $count++;
            }
        }
        
        $share_url=$qID.'_'.implode('-', array_slice(explode(' ', strtolower($quote)), 0, 10));*/
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
        $remove2[] = '"';
        $q=str_replace($remove, "", $quote);
        $blankStrippedq=preg_replace('/\s+/', ' ', $q);
        $share_url=$qID.'_'.implode('-', array_slice(explode(' ', strtolower($blankStrippedq)), 0, 10));
        
        $a=str_replace($remove, "", $author);
        $blankStripped=preg_replace('/\s+/', ' ', $a);        
        $author_seo=implode('-', array_slice(explode(' ', strtolower($blankStripped)), 0, 10));
    ?>
    <div class="col-xs-12 col-sm-6 col-md-4 item quote" itemtype="https://schema.org/CreativeWork">
        <div class="pad clearfix">
            <?php
                if(isset($qImage) && !empty($qImage)){
            ?>
            <img class="img-responsive" src="<?php echo $qImage; ?>" alt="<?php echo $author; ?> Quote" title="">
            <?php } ?>
            <blockquote itemprop="citation"><a href="https://portalquote.com/panel/quote/<?php echo $user[0]['username'].'/'.$author_seo.'/'.$share_url; ?>" role="link" class="quote-txt"><?php echo $quote; ?></a> <span itemprop="author">- <?php echo $author; ?></span></blockquote>
            <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="https://portalquote.com/panel/quote/<?php echo $user[0]['username'].'/'.$author_seo.'/'.$share_url; ?>" data-title="<?php echo add3dots(str_replace($remove2, "", $quote),'...',169); ?>" data-description="<?php echo $author ?> | Share with your friends, create your own quotes and more!" <?php if(isset($qImage) && !empty($qImage)){ echo 'data-media="'.$qImage.'"'; }?>> </div>
            <?php 
                if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){
                    $liked=$obj->like('userQuotes_like', "userID=".$_SESSION['uID']." AND quoteID=$qID");
            ?>
                <div class="col-xs-4 col-md-4"><p><span><?php echo $nLikes[0]['cnt']; ?></span><a class="like qtLikeUsr <?php if(count($liked)>0) echo "liked qtDislikeUsr";?>" role="button" data-qtlike="<?php echo $qID; ?>"><?php if(count($liked)>0) echo "Liked <span class='glyphicon glyphicon-heart liked'></span>"; elseif($nLikes[0]['cnt']>1) echo 'Likes'; else echo 'Like'; ?></a></p></div>
            <?php }else{ ?>
                <div class="col-xs-4 col-md-4"><p><span><?php echo $nLikes[0]['cnt']; ?></span><a class="like disable" role="button" data-toggle="popover" data-placement="top" data-title="Want to like this?" data-content="<a href='' data-toggle='modal' data-target='#signup'>Sign up</a> or <a href='' data-toggle='modal' data-target='#login'>Login</a>">Like<?php if($nLikes[0]['cnt']>1 || $nLikes[0]['cnt']==0) echo 's'; ?></a></p></div>
            <?php } ?>
            <div class="col-xs-6 _user-posted text-muted">
                Poster by: <a href="/panel/quotes/<?php echo $user[0]['username']; ?>/1" role="link" class=""><?php echo $user[0]['username']; ?></a>
            </div>
            <div class="col-xs-6 _user-posted text-muted">
                <?php echo $created_at; ?>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
</div>

<div class="container">
    <nav aria-label="Page navigation">
        <?php echo $Paginator->createLinks($links, 'pagination pagination-sm','/users-section/quotes'); ?> 
    </nav>
</div>

<?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){ ?>
    <script src="<?php echo $folder; ?>javascript/b59ac58c7256fd0ee084d8adb9654bc1249d3197/c3d137ad7f14c18ef0d0d2e64cdb62f7c9cb3a39.js?<?php echo time(); ?>"></script>
<?php } ?>
<script>
    $(window).load(function(){var o=$(".masonry-container");o.masonry({columnWidth:".item",itemSelector:".item"}),$('[data-toggle="popover"]').popover({html:!0}),$(this).resize()});
</script>