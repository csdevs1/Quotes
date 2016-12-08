<?php
    session_start();
    require_once('../../AppClasses/AppController.php');
    require_once('../../AppClasses/Paginator.php');
    $obj = new AppController();

    $limit = (isset( $_GET['limit'])) ? $_GET['limit'] : 15;
    $page = (isset( $_POST['page'])) ? $_POST['page'] : 1;
    $links = (isset( $_GET['links'])) ? $_GET['links'] : 7;
    $Paginator  = new Paginator("userImagesCollection");
    $imgARR = $Paginator->getData("userImagesCollection","created_at",$limit,$page);
    $images = $imgARR->data;
?>

<div class="row collection-cont">
    <?php foreach($images as $key=>$val){
            $user=$obj->find_by('users','userID',$images[$key]['userID']); ?>
        <div class="col-xs-4 col-md-3 col-lg-2">
            <a href="<?php echo $images[$key]['url']; ?>" target="_blank"><img class="img-responsive img-thumbnail" src="<?php echo $images[$key]['url']; ?>"></a>
            <br><span class="text-muted">Poster by:<a href="/panel/collection/<?php echo $user[0]['username']; ?>" target="_blank"><?php echo $user[0]['username']; ?></a></span>
        </div>
    <?php } ?>
</div>

<div class="container">
    <nav aria-label="Page navigation">
        <?php echo $Paginator->createLinks($links, 'pagination pagination-sm','/quotes/users-section/images'); ?> 
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