<?php
    session_start();
    require_once('AppClasses/AppController.php');
    class HeadTags{
        public function titlePage($el) {
            return $el." at PortalQuote";
        }
        public function meta_description($el) {
            return $el;
        }
    }
// META TAGS
    $meta_tags = new HeadTags();
    $title = $meta_tags->titlePage('Find The Best Quotes');
    $description = $meta_tags->meta_description('Find the best quotes about topics like love, family, friend, motivation, funny from popular authors. Share with your friends on Facebook, Twitter, Instagram...');
	$image = "https://portalquote.com/images/thumbnail.png";
// Conection
?>
<!doctype html>
<html class="no-js" lang="en" ng-app="quotesApp">
    <head>
        <?php include 'layouts/head.php'; ?>
        <link href="/panel/assets/tagsinput/jquery.tagsinput.css" rel="stylesheet" />
        <style>
            .collection a{padding: 9px;width: 100%;}
            <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){ ?>
                .download a {width: 100%;}
                .download a {float: left;}
                @media only screen and (min-width : 768px) {.copy-form .download{margin-left: 15.6%;}}
            <?php }else{ ?>
                .download a {float: none;}
            <?php } ?>
        </style>
    </head>
    <body>
        
        <div class="textarea-box" id="textarea-box">
            <div class="container">
                <div class="col-xs-12">
                    <div class="col-xs-12 relative-container">
                        <span class="glyphicon glyphicon-remove" onclick="generator.closeWindow()"></span>
                    </div>
                    <textarea oninput="generator.changeText(this)" placeholder="Insert your quote" maxlength="255"></textarea>
                </div>
            </div>
        </div>
        
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
        
        <div class="col-xs-12 panel panel-main">
            <div class="container panel-container">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-sm-offset-3">
                        <nav role="navigation">
                            <ul class="nav navbar-nav">
                                <li id="background" onclick="generator.panelSlide('#background-section')"><span class="glyphicon glyphicon-picture"></span><br>Background</li>
                                <li onclick="generator.openWindow()"><i class="ion-quote"></i><br>Quote</li>
                                <li id="fonts" onclick="generator.panelSlide('#font-style')"><span class="glyphicon glyphicon-font"></span><br>Font Style</li>
                                <li data-toggle="modal" data-target="#img-effect"><span class="glyphicon glyphicon-flash"></span><br>Effects </li>
                                <li id="generate"><span class="glyphicon glyphicon-cd"></span><br>Generate</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="img-effect" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Effects</h4>
                    </div>
                    <div class="modal-body" id="effects-body">
                        <div class="col-xs-12"><label>Background Blur <span id="blur-scale">(0%)</span> <input type="range" id="bgBlur" min="0" max="100" value="0" onchange="generator.imageEffect()"></label></div>
                        <div class="col-xs-12"><label>Background GreyScale <span id="grey-scale">(0%)</span><input type="range" id="bgGrey" min="0" max="100" value="0" onchange="generator.imageEffect()"></label></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- POPOVER FOR EFFECT OPTIONS LIKE BLUR, TO HAVE SLIDERS AND STUFF LIKE THAT

        <div class="popover fade bottom in" role="tooltip" id="popover351098" style="top: 55px;left:-10px; display: block;"><div class="arrow" style="left: 50%;"></div><h3 class="popover-title" style="display: none;"></h3><div class="popover-content">Vivamus sagittis lacus vel augue laoreet rutrum faucibus.</div></div>

        -->
        
        <!-- Background options -->
        <div class="col-xs-12 panel sub-panel" id="background-section">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-sm-offset-3">
                        <nav role="navigation">
                            <ul class="nav navbar-nav">
                                <li class="img-file-container">
                                    <input type="file" id="img-file" onchange="generator.preview(this)" accept="image/*" />
                                    <span id="span"><span class="glyphicon glyphicon-open" aria-hidden="true"></span><br>Upload</span>
                                </li>
                                <li id="gallery"><span class="glyphicon glyphicon-camera"></span><br>Gallery</li>
                                <li><span class="glyphicon glyphicon-th-large"></span><br>Color <input type="color" class="colorSelector" oninput="generator.changeColor(this,'#quote-container','background-color')" /></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div> 
        
        <!-- Font options -->
        <div class="col-xs-12 font-style panel sub-panel" id="font-style">
            <div class="container panel-container">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-sm-offset-3">
                        <nav role="navigation">
                            <ul class="nav navbar-nav">
                                <li>
                                    <div class="dropdown">
                                        <button type="button" id="alignment-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            button
                                        </button>
                                        <span class="glyphicon glyphicon-text-width"></span><br>Font-Family
                                        <ul class="dropdown-menu font-list" aria-labelledby="alignment-menu">
                                            <li onclick="generator.changeFont(this,'sans-serif')" id="abel">Abel</li>
                                            <li onclick="generator.changeFont(this,'cursive')" id="amatic">Amatic SC</li>
                                            <li onclick="generator.changeFont(this,'sans-serif')" id="anton">Anton</li>
                                            <li onclick="generator.changeFont(this,'cursive')" id="dancing">Dancing Script</li>
                                            <li onclick="generator.changeFont(this,'sans-serif')" id="dosis">Dosis</li>
                                            <li onclick="generator.changeFont(this,'sans-serif')" id="josefin">Josefin Sans</li>
                                            <li onclick="generator.changeFont(this,'cursive')" id="lobster">Lobster</li>
                                            <li onclick="generator.changeFont(this,'cursive')" id="lobster-2">Lobster Two</li>
                                            <li onclick="generator.changeFont(this,'cursive')" id="modak">Modak</li>
                                            <li onclick="generator.changeFont(this,'sans-serif')" id="muli">Muli</li>
                                            <li onclick="generator.changeFont(this,'sans-serif')" id="condensed">Open Sans Condensed</li>
                                            <li onclick="generator.changeFont(this,'sans-serif')" id="oswald">Oswald</li>
                                            <li onclick="generator.changeFont(this,'cursive')" id="poiret">Poiret One</li>
                                            <li onclick="generator.changeFont(this,'sans-serif')" id="quicksand">Quicksand</li>
                                            <li onclick="generator.changeFont(this,'sans-serif')" id="raleway">Raleway</li>
                                            <li onclick="generator.changeFont(this,'cursive')" id="rogue">Rouge Script</li>
                                            <li onclick="generator.changeFont(this,'sans-serif')" id="rubik">Rubik</li>
                                        </ul>
                                    </div>
                                </li>
                                
                                <li><span class="glyphicon glyphicon-record"></span><br>Color <input type="color" class="colorSelector" oninput="generator.changeColor(this,'#text','color')" /></li>
                                <li>
                                    <div class="dropdown">
                                        <button type="button" id="alignment-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            button
                                        </button>
                                        <span class="glyphicon glyphicon-align-left"></span><br>Alignment
                                        <ul class="dropdown-menu font-list" aria-labelledby="alignment-menu">
                                            <li onclick="generator.changeJustification(this,'center')"><span class="glyphicon glyphicon-align-center"></span> Center</li>
                                            <li onclick="generator.changeJustification(this,'left')"><span class="glyphicon glyphicon-align-left"></span> Left</li>
                                            <li onclick="generator.changeJustification(this,'right')"><span class="glyphicon glyphicon-align-right"></span> Right</li>
                                            <li onclick="generator.changeJustification(this,'justify')"><span class="glyphicon glyphicon-align-justify"></span> Justify</li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown">
                                        <button type="button" id="font-size" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            button
                                        </button>
                                        <span class="glyphicon glyphicon-resize-full"></span><br>Size
                                        <ul class="dropdown-menu font-list" aria-labelledby="font-size">
                                            <li onclick="generator.changeFontSize(this,16)">16px</li>
                                            <li onclick="generator.changeFontSize(this,32)">32px</li>
                                            <li onclick="generator.changeFontSize(this,48)">48px</li>
                                            <li onclick="generator.changeFontSize(this,64)">64px</li>
                                            <li onclick="generator.changeFontSize(this,80)">80px</li>
                                            <li onclick="generator.changeFontSize(this,96)">96px</li>
                                            <li onclick="generator.changeFontSize(this,112)">112px</li>
                                            <li onclick="generator.changeFontSize(this,128)">128px</li>
                                            <li onclick="generator.changeFontSize(this,144)">144px</li>
                                            <li onclick="generator.changeFontSize(this,160)">160px</li>
                                        </ul>
                                    </div>
                                    
                                </li>
                                <li>
                                    <button type="button" id="font-shadow" style="width:100%;" onclick="generator.displayOptions('shadow-options')">
                                        button
                                    </button>
                                    <span class="glyphicon glyphicon-adjust"></span><br>Font-Shadow
                                    <div class="popover fade bottom in" role="tooltip" id="shadow-options" style="top: 55px;left:-120px;min-width:350px;z-index:5000;">
                                        <div class="arrow" style="left: 50%;"></div>
                                        <h3 class="popover-title">Font Shadow Options</h3>
                                        <div class="popover-content">
                                            <div class="col-xs-12" style="bottom: 5px;"><label>Shadow Color: <input type="color" id="shadow-color" oninput="generator.textShadow()"></label></div>
                                            <div class="col-xs-12" style="bottom: 5px;"><label>Shadow Blur: <input type="range" id="shadow-blur" value="0" min="0" max="50" oninput="generator.textShadow()"></label></div>
                                            <div class="col-xs-12 col-sm-6"><label>Shadow-X:<input type="range" id="shadow-x" value="0" min="-25" max="50" oninput="generator.textShadow()"></label></div>
                                            <div class="col-xs-12 col-sm-6"><label>Shadow-Y:<input type="range" id="shadow-y" value="0" min="-25" max="50" oninput="generator.textShadow()"></label></div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Gallery -->
        <div class="col-xs-12" id="from-gallery">
            <div class="container panel-container">
                <div class="slider responsive">
                    <div class="img-gallery">
                        <img src="images/gallery/gallery-1.jpg" onclick="generator.changeImage(this)">
                    </div>
                    <div class="img-gallery">
                        <img src="images/gallery/gallery-2.jpg" onclick="generator.changeImage(this)">
                    </div>
                    <div class="img-gallery">
                        <img src="images/gallery/gallery-3.jpg" onclick="generator.changeImage(this)">
                    </div>
			<div class="img-gallery">
                        <img src="images/gallery/gallery-4.jpg" onclick="generator.changeImage(this)">
                    </div>
                    <div class="img-gallery">
                        <img src="images/gallery/gallery-5.jpg" onclick="generator.changeImage(this)">
                    </div>
                    <div class="img-gallery">
                        <img src="images/gallery/gallery-6.jpg" onclick="generator.changeImage(this)">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xs-12 preview-container">
            <div class="content" id="quote-container">
                <div class="processing"><img src="images/loading.gif"></div>
                <!-- <div style="height:350px;width:350px;background:#fff;"></div> Do it later -->
                <span class="text" id="text"></span>                
                <span id="water-mark">PortalQuote.com</span>
            </div>
        </div>
        
        <div class="col-xs-12 preview-container">
            <div class="content" id="generated">
            </div>
            
            <div class="container copy-form">
                <div class="form-group col-xs-12 col-sm-6 copy-container">
                    <div class="input-group">
                        <input type="text" class="form-control" id="copyURL">
                        <span class="input-group-addon" onclick="clickToCopy(this);"><button id="copy" class="btn btn-primary"><i class="glyphicon glyphicon-link"></i></button></span>
                    </div>
                </div>
                <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){ ?>
                    <div class="col-xs-12 col-sm-6 copy-container form-group">
                        <div class="input-group">
                            <input id="title" class="form-control" placeholder="Give it a title!" maxlength="255" required>
                            <span class="input-group-addon"><button class="btn btn-primary"><i class="glyphicon glyphicon-star"></i></button></span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 copy-container form-group">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control" id="topic" data-error="Field required" aria-describedby="topic" placeholder="Enter Topic" value="">
                        </div>
                    </div>
                <?php } ?>
                <div class="col-xs-12 col-sm-4 download copy-container">
                    <a href="" target="_blank" download><i class="glyphicon glyphicon-circle-arrow-down"></i> Download Image</a>
                </div>
                <?php if(isset($_SESSION['uID']) && !empty($_SESSION['uID'])){ ?>
                    <div class="col-xs-12 col-sm-4 collection">
                        <a class="btn btn-default" id="clc-usr" role="button"><i class="glyphicon glyphicon-paperclip"></i> Save to my collection</a>
                    </div>
                <?php } ?>
            </div>
        </div>
        
        <!-- FOOTER -->        
        <?php include 'layouts/footer.php'; ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css">
        <script src="https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
        <script src="/javascript/generator.js?<?php echo time(); ?>"></script>
        <script src="/panel/assets/tagsinput/jquery.tagsinput.min.js"></script>
        <script>
            $(document).ready(function($) {
                // Tags Input
                $('#topic').tagsInput({width:'auto'});
            });
        </script>
    </body>
</html>
