<div class="nav-container">
    <header class="container">
        <nav role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu-items" aria-expanded="false" role="button">
                        <span class="glyphicon glyphicon-send"></span>
                    </button>
                    <h2 class="navbar-toggle" style="float:left;">PortalQuote</h2>
                </div>
                
                <div class="collapse navbar-collapse" id="menu-items">
                    <ul class="nav navbar-nav" itemscope itemtype="http://www.schema.org/SiteNavigationElement">
                        <li itemprop="name"><a href="" role="link" itemprop="url"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                        <li itemprop="name"><a href="" role="link" itemprop="url">Topics</a></li>
                        <li itemprop="name"><a href="" role="link" itemprop="url">Authors</a></li>
                        <li itemprop="name"><a href="quote-generator.html" itemprop="url">Quote Generator</a></li>
                        <li><a onclick="showSearch(this)" role="button"><span class="glyphicon glyphicon-search"></span> Search</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="" role="link"  data-toggle="modal" data-target="#login"><span class="glyphicon glyphicon-log-in"></span> Log In</a></li>
                        <li><a href="" role="link" data-toggle="modal" data-target="#signup"><span class="glyphicon glyphicon-pencil"></span> Sign up</a></li>
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
                <li><label><input type="radio" name="search">Quote</label></li>
                <li><label><input type="radio" name="search">Author</label></li>
            </ul>
        </div>
    </div>
</div>
<!-- -->