<?php
    session_start();
    require_once('../../AppClasses/AppController.php');
    require_once('../../AppClasses/Paginator.php');
    $obj = new AppController();
    $limit = (isset( $_GET['limit'])) ? $_GET['limit'] : 15;
    $page = (isset( $_POST['page'])) ? $_POST['page'] : 1;
    $links = (isset( $_GET['links'])) ? $_GET['links'] : 7;
    $Paginator  = new Paginator("users");
    $usersARR = $Paginator->getData("users","created_at",$limit,$page);
    $users = $usersARR->data;
?>
<div class="container" style="margin-bottom:10px;">
    <div class="row">
        <div class="col-xs-11" style="display:flex;">
            <div class="input-group">
                <span class="input-group-addon glyphicon glyphicon-search" id="search-icon"></span>
                <input type="search" class="form-control" id="search_user" name="search_user" placeholder="Search User..." aria-describedby="search-user">
            </div>
            <a class="btn btn-primary user-btn-search" href="#">Search</a>
        </div>
    </div>
</div>
<div class="clearfix">
    <?php 
        foreach($users as $key=>$val){
            $userQuotes=$obj->custom('SELECT COUNT("userID") as cnt FROM userQuotes WHERE userID='.$users[$key]['userID']);
            $nFollowers=$obj->custom('SELECT COUNT("userID") as cnt FROM followers WHERE userID='.$users[$key]['userID']);
            $nFollowing=$obj->custom('SELECT COUNT("followerID") as cnt FROM followers WHERE followerID='.$users[$key]['userID']);
            if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){
                $isFollowing=$obj->custom("SELECT COUNT('followerID') as cnt FROM followers WHERE userID=".$users[$key]['userID']." AND followerID=".$_SESSION['uID']);
                $isFollowing[0]['cnt']==0 ? $class='light-red nt-follow' : $class='darkred';
            }
    ?>
    <div class="col-cs-12 col-xs-6 col-md-4 card-profile">
        <div class="user-profile_pic" style="background-image:url('<?php echo $users[$key]['picture']; ?>')"></div>
        <div class="card-profile_visual" style="background-image:url('<?php echo $users[$key]['banner']; ?>');">
            <div class="card-profile_user-infos">
                <a href="/panel/quotes/<?php echo $users[$key]['username']; ?>/1" target="_blank"><span class="infos_name"><?php echo $users[$key]['fname'].' '.$users[$key]['lname']; ?></span></a>
                <a href="/panel/quotes/<?php echo $users[$key]['username']; ?>/1" target="_blank"><span class="infos_nick"><?php echo $users[$key]['username']; ?></span></a>
            </div>
        </div>
        <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID']) && $_SESSION['uID']!=$users[$key]['userID']){ ?>
            <a class="<?php echo $class; ?> usrflw-16516" data-follow='<?php echo $users[$key]['userID'] ?>'>
                <?php if($isFollowing[0]['cnt']){ ?>
                    <i class="ion-checkmark"></i>
                <?php }else{?>
                    <i class="ion-person-add"></i>
                <?php } ?>
            </a>
        <?php } ?>
        <div class="card-profile_user-stats">
            <div class="stats-holder row">
                <div class="user-stats col-xs-4">
                    <strong>Quotes</strong>
                    <a href="/panel/quotes/<?php echo $users[$key]['username']; ?>/1" target="_blank"><span><?php echo $userQuotes[0]['cnt']; ?></span></a>
                </div>
                <div class="user-stats col-xs-4">
                    <strong>Following</strong>
                    <a href="/panel/following/<?php echo $users[$key]['username']; ?>"><span><?php echo $nFollowing[0]['cnt']; ?></span></a>
                </div>
                <div class="user-stats col-xs-4">
                    <strong>Followers</strong>
                    <a href="/panel/followers/<?php echo $users[$key]['username']; ?>" target="_blank"><span><?php echo $nFollowers[0]['cnt']; ?></span></a>
                </div>
            </div>
        </div>
    </div>
    <?php }
        if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){ ?>
            <input type="hidden" id="token56165" value="<?php echo sha1($_SESSION['uID']); ?>">
    <?php } ?>
</div>

<div class="container">
    <nav aria-label="Page navigation">
        <?php echo $Paginator->createLinks($links, 'pagination pagination-sm','/users-section/users'); ?>
    </nav>
</div>

<script>
    var find_user=function(username){
        return $.ajax({
            type: 'POST',
            dataType: 'json',
           // processData: false,
            //contentType:  false,
            data: {username:username},
            url: '/userSection.php'
        });
    }
    $('.user-btn-search').on('click',function(){
        var username=$('#search_user').val();
        var request=find_user(username);
        request.done(function(user){
            console.log(user);
        });
    });
</script>

<?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){ ?>
    <script src="/panel/js/46b13e139205831924e33e8c10faa847/93ba5d9426226e11930384103fa8ba44.js?<?php echo time(); ?>" type="text/javascript"></script>
<?php } ?>
