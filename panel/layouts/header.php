<?php
$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', $uri_path);

$section=$uri_segments[2];
?>

<!-- Aside Start-->
        <aside class="left-panel">
            <!-- brand -->
            <div class="logo">
                <a href="/" class="logo-expanded">
                    <span class="nav-label">portalquote</span>
                </a>
            </div>
            <!-- / brand -->
            <nav class="navigation">
                <ul class="list-unstyled">
                    <li class="has-submenu <?php if($section=='quotes') echo 'active'; ?>"><a href="<?php echo '/panel/quotes/'.$user[0]['username']; ?>/1"><i class="ion-home"></i> <span class="nav-label">
                        <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID']) && $_SESSION['uID'] === $u_id){ ?>
                        Your Quotes
                        <?php } else{ echo $fname."'s Quotes"; } ?>  
                        </span></a></li>
                    <li class="has-submenu <?php if($section=='following' || $section=='followers') echo 'active'; ?>"><a href="#"><i class="ion-android-contacts"></i> <span class="nav-label">Following</span></a>
                        <ul class="list-unstyled">
                            <li <?php if($section=='followers') echo 'class="active"'; ?>><a href="/panel/followers/<?php echo $user[0]['username']; ?>">
                                <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID']) && $_SESSION['uID'] === $u_id){ ?>
                                    Your Followers
                                <?php } else{ echo $fname."'s Followers"; } ?>                                
                                </a></li>
                            <li <?php if($section=='following') echo 'class="active"'; ?>><a href="/panel/following/<?php echo $user[0]['username']; ?>">Following</a></li>
                        </ul>
                    </li>
                    <li class="has-submenu <?php  if($section=='collection' || $section=='quotes-collection') echo 'active'; ?>"><a href="#"><i class="ion-compose"></i> <span class="nav-label"><?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID']) && $_SESSION['uID'] === $u_id){ ?>
                                        Your Collection
                                    <?php } else{ echo $fname."'s Collection"; } ?></span></a>
                        <ul class="list-unstyled">
                            <li><a href="/panel/quotes-liked/<?php echo $_SESSION['uname'];  ?>">Quotes</a></li>
                            <li <?php if($section=='collection') echo 'class="active"'; ?>><a href="/panel/collection/<?php echo $user[0]['username']; ?>">Images</a></li>
                        </ul>
                    </li>
                    <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID']) && $_SESSION['uID'] === $u_id){ ?>
                        <li class="has-submenu <?php if($section=='settings') echo 'active'; ?>"><a href="/panel/settings/<?php echo $_SESSION['uname'];  ?>" rel="nofollow"><i class="ion-wrench"></i> <span class="nav-label">Settings</span></a></li>
                        <li class="has-submenu" onclick="signout()"><a href="#"><i class="ion-grid"></i> <span class="nav-label">Logout</span></a></li>
                    <?php } ?>
                </ul>
            </nav>
        </aside>
        <!-- Aside Ends-->

        <!--Main Content Start -->
        <section class="content">
            
            <!-- Header -->
            <header class="top-head container-fluid">
                <button type="button" class="navbar-toggle pull-left">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <ul class="list-inline navbar-left top-menu top-left-menu">
                    <li itemprop="name"><a href="/users-section/quotes/1" itemprop="url">Users Section</a></li>
                </ul>
                <!-- Search
                <form role="search" class="navbar-left app-search pull-left hidden-xs">
                  <input type="text" placeholder="Search..." class="form-control">
                </form>->
                <!-- Left navbar 
                <nav class=" navbar-default hidden-xs" role="navigation">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                          <a data-toggle="dropdown" class="dropdown-toggle" href="#">English <span class="caret"></span></a>
                            <ul role="menu" class="dropdown-menu">
                                <li class="active"><a href="#">English</a></li>
                                <li><a href="#">Portuguese</a></li>
                                <li><a href="#">Spanish</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                -->
                <!-- Right navbar -->
                <ul class="list-inline navbar-right top-menu top-right-menu">  
                    <!-- mesages
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="fa fa-envelope-o "></i>
                            <span class="badge badge-sm up bg-purple count">4</span>
                        </a>
                        <ul class="dropdown-menu extended fadeInUp animated nicescroll" tabindex="5001">
                            <li>
                                <p>Messages</p>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="pull-left"><img src="img/avatar-2.jpg" class="img-circle thumb-sm m-r-15" alt="img"></span>
                                    <span class="block"><strong>John smith</strong></span>
                                    <span class="media-body block">New tasks needs to be done<br><small class="text-muted">10 seconds ago</small></span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="pull-left"><img src="img/avatar-3.jpg" class="img-circle thumb-sm m-r-15" alt="img"></span>
                                    <span class="block"><strong>John smith</strong></span>
                                    <span class="media-body block">New tasks needs to be done<br><small class="text-muted">3 minutes ago</small></span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="pull-left"><img src="img/avatar-4.jpg" class="img-circle thumb-sm m-r-15" alt="img"></span>
                                    <span class="block"><strong>John smith</strong></span>
                                    <span class="media-body block">New tasks needs to be done<br><small class="text-muted">10 minutes ago</small></span>
                                </a>
                            </li>
                            <li>
                                <p><a href="inbox.html" class="text-right">See all Messages</a></p>
                            </li>
                        </ul>
                    </li>
                    -->
                    <!-- Notification -->
                    <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){ ?>
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#" id="notications">
                            <i class="fa fa-bell-o"></i>
                            <?php if($nNotifications[0]['cnt']>0){ ?>
                                <span class="badge badge-sm up bg-pink count"><?php echo $nNotifications[0]['cnt']; ?></span>
                            <?php } ?>
                        </a>
                        <?php if(count($notifications)>0){ ?>
                            <ul class="dropdown-menu" tabindex="5002">
                                <li class="noti-header">
                                    <p>Notifications</p>
                                </li>
                                <?php foreach($notifications as $key=>$val){
                                        $date = strtotime($notifications[$key]['created_at']);
                                        $date = date('M j, Y', $date);
                                        $diff = date_diff(date_create($date),date_create(date("M j, Y"))); //GET DAY
                                        $diff=$diff->format('%a');
                                        if($diff==1)
                                            $diff.=' day ago';
                                        elseif($diff>1)
                                            $diff.=' days ago';
                                        elseif($diff==0){
                                            $to_time = strtotime(date("Y-m-d H:i:s"));
                                            $from_time = strtotime($notifications[$key]['created_at']);
                                            $diff=floor(abs($to_time - $from_time) / 60); // GET MINUTES
                                            if($diff==1)
                                                $diff.=' minute ago';
                                            elseif($diff>=60){
                                                $diff=floor(abs($to_time - $from_time) / 3600); // GET HOURS
                                                if($diff>1)
                                                    $diff.=' hours ago';
                                                else
                                                    $diff.=' hour ago';
                                            }else
                                                $diff.=' minutes ago';
                                        }
                                ?>
                                    <li data-no="<?php echo $notifications[$key]['notificationID']; ?>" <?php if($notifications[$key]['seen']!=1){ ?>class="notSeen"<?php } ?>>
                                        <div>
                                            <?php echo $notifications[$key]['notification']; ?><br><small class="text-muted"><?php echo $diff; ?></small></span>
                                        </div>
                                    </li>
                                <?php } ?>
                                <li>
                                    <p><a href="#" class="text-right">See all notifications</a></p>
                                </li>
                            </ul>
                        <?php } ?>
                    </li>
                    <?php } ?>
                    <!-- /Notification -->
                    <!-- user login dropdown start-->
                    <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){ ?>
                    <li class="dropdown text-center">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <div style="background-image:url('<?php echo $_SESSION['profile']; ?>')" class="img-circle profile-img thumb-sm profile-pic-bg"></div>
                            <span class="username"><?php echo $_SESSION['uname']; ?> </span> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" tabindex="5003" style="overflow: hidden; outline: none;">
                            <li><a href="/panel/settings/<?php echo $_SESSION['uname'];  ?>"><i class="fa fa-cog"></i> Settings</a></li>
                            <li onclick="signout()"><a href="#"><i class="fa fa-sign-out"></i> Log Out</a></li>
                        </ul>
                    </li>
                    <?php } else{ ?>
                        <li class="text-center"><a href="/">Home</a></li>
                    <?php } ?>
                    <!-- user login dropdown end -->       
                </ul>
                <!-- End right navbar -->

            </header>
            <!-- Header Ends -->