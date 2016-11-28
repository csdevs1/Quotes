<?php
$obj = new AppController();
$user = $obj->like('users','userID="'.$_SESSION['uID'].'" AND active=1');
if($user[0]['picture']=='/images/profile/male.png' || $user[0]['picture']=='/images/profile/female.png')
        $u_picture='../..'.$user[0]['picture'];
else
    $u_picture=$user[0]['picture'];
?>

<div class="nav-container">
    <header class="container">
        <nav role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu-items" aria-expanded="false" role="button">
                        <span class="glyphicon glyphicon-send"></span>
                    </button>
                    <h2 class="navbar-toggle" style="float:left;"><a href="/">PortalQuote</a></h2>
                </div>
                
                <div class="collapse navbar-collapse" id="menu-items">
                    <ul class="nav navbar-nav" itemscope itemtype="http://www.schema.org/SiteNavigationElement">
                        <li itemprop="name"><a href="/" role="link" itemprop="url"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                        <li itemprop="name"><a href="/topics" role="link" itemprop="url">Topics</a></li>
                        <li itemprop="name"><a href="/authors/1/a" role="link" itemprop="url">Authors</a></li>
                        <li itemprop="name"><a href="/quote-generator" itemprop="url">Quote Generator</a></li>
                        <li><a onclick="showSearch(this)" role="button"><span class="glyphicon glyphicon-search"></span> Search</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php if(!isset($_SESSION['fname']) && empty($_SESSION['fname'])){ ?>
                            <li><a href="" role="buttom"  data-toggle="modal" data-target="#login"><span class="glyphicon glyphicon-log-in"></span> Log In</a></li>
                            <li><a href="" role="buttom" data-toggle="modal" data-target="#signup"><span class="glyphicon glyphicon-pencil"></span> Sign up</a></li>
                        <?php } else{ ?>
                        <li>
                            <div class="dropdown drop-lang">
                                <a href="" id="my-profile" role="link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="<?php echo $u_picture; ?>" class="profile-small"> 
                                    <?php echo $_SESSION['fname']; ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="my-profile">
                                    <li><a href="<?php echo '/panel/quotes/'.$_SESSION['uname'];?>" role="link"> My Profile</a></li>
                                    <li><a href="<?php echo '/panel/quotes/'.$_SESSION['uname'];?>" role="link"> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                        <?php }?>
                        <li>
                            <div class="dropdown drop-lang">
                                <a href="" id="lang" role="link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-globe"></span> Language</a>
                                <ul class="dropdown-menu" aria-labelledby="lang">
                                    <li><img src="images/pt.png"> Portuguese</li>
                                    <li><img src="images/es.png"> Spanish</li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                
            </div>
        </nav>
    </header>
</div>

<!--Search box -->
<div id="search-box">
    <div class="container">
        <div class="col-xs-12 col-sm-12 col-md-10"><button onclick="closeSearch(this)"><span class="glyphicon glyphicon-remove"></span></button></div>
        <div class="col-xs-12">
            <input class="input-search" id="input-search" type="search" placeholder="Search" autofocus role="search">
            <ul>
                <li><label><input type="radio" name="search" value="quotes" checked>Quote</label></li>
                <li><label><input type="radio" name="search" value="author">Author</label></li>
                <li><label><input type="radio" name="search" value="topic">Topic</label></li>
            </ul>
        </div>
    </div>
</div>
<!-- -->