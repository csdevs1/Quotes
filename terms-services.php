<?php
    session_start();
    require_once('AppClasses/AppController.php');
    class HeadTags{
        public function titlePage($el) {
            return "PortalQuote: ".$el;
        }
        public function meta_description($el) {
            return $el;
        }
    }

// META TAGS
    $meta_tags = new HeadTags();
    $title = $meta_tags->titlePage('Top Source of Quotes on Family, Love, Life');
    $description = $meta_tags->meta_description('PortalQuote is the best source of quotes about love, family, friend, motivation from popular authors. Share with your friends on Facebook, Twitter, Instagram...');
    $image = "https://portalquote.com/images/thumbnail.png";

$folder='../';
?>
<!doctype html>
<html class="no-js" lang="en">
    <head>
        <?php require_once 'layouts/head.php'; ?>
        <style>
            @import url('https://fonts.googleapis.com/css?family=Londrina+Shadow');
            @import url('https://fonts.googleapis.com/css?family=Passion+One');
            @import url('https://fonts.googleapis.com/css?family=Cormorant+Garamond');
            .banner-topic{background-image: url('https://pixabay.com/get/e83db5072ff6053ed1534705fb0938c9bd22ffd41db9114892f0c570a3/board-1848724_1920.jpg');max-height: 350px !important;}
            .banner-topic h1.topic-info{padding: 60px;margin-top: 50px;font-family: 'Londrina Shadow', cursive;color: #fff;}
            h2{font-family: 'Passion One', cursive;}
            p,strong{font-family: 'Cormorant Garamond', serif;font-size: 2.2rem;text-align: justify;}
            .text-muted{text-align: center;}
            @media only screen and (max-width : 767px) {.banner-topic h1.topic-info{font-size: 4.5rem;}}
            @media only screen and (min-width : 768px) {.banner-topic h1.topic-info{font-size: 8rem;}}
            .or-spacer {
                margin-top: 25px;
                margin-left: auto;
                margin-right: auto;
                width: 400px;
                position: relative;
            }
            .or-spacer .mask {
                overflow: hidden;
                height: 20px;
            }
            .or-spacer .mask:after {
                content: '';
                display: block;
                margin: -25px auto 0;
                width: 100%;
                height: 25px;
                border-radius: 125px / 12px;
                box-shadow: 0 0 8px black;
            }
            .or-spacer span {
                width: 50px;
                height: 50px;
                position: absolute;
                bottom: 100%;
                margin-bottom: -25px;
                left: 50%;
                margin-left: -25px;
                border-radius: 100%;
                box-shadow: 0 2px 4px #999;
                background: white;
            }
        </style>
        <script type="application/ld+json">
            {
                "@context": "http://schema.org",
                "@type": "WebSite",
                "url": "https://portalquote.com/",
                "name": "Portalquote",
                "alternateName": "Portalquote - Best Quotes",
                "potentialAction": {
                    "@type": "SearchAction",
                    "target": "https://portalquote.com/search/quote/{search_term_string}/1",
                    "query-input": "required name=search_term_string"
                }
            }
        </script>
        </style>
    </head>
    <body>
        <section class="banner-topic background" id="banner" role="banner">
            <?php include 'layouts/nav.php'; ?>
            <!-- -->
            <h1 class="topic-info" itemtype="https://schema.org/CreativeWork">Terms of service</h1>
        </section>
        
        <!-- SIGN UP FORM -->
            <?php include 'layouts/signup.php'; ?>
        <!-- -->
        <!-- LOGIN FORM -->
            <?php include 'layouts/login.php'; ?>
        <!-- -->
        
        <section role="main">
            <div class="container">
                <div class="row">
                    <h2>Terms Of Use:</h2>
                    <p>Welcome to <a href="/" role="link">PortalQuote.com</a>  (the "Site"), one of the best sites of quotes on the web. were you can find quotes of the most important people of all time.
This document defines a legally-binding agreement ( "Agreement") governing the terms of our service. BY ACCESSING AND USING THE SITE, YOU AGREE THAT YOU HAVE READ AND UNDERSTOOD THIS AGREEMENT AND THAT YOU AGREE WITH THE TERMS, AS WELL AS OUR PRIVACY POLICY.</p>
                    <h2>License to Access and Use:</h2>
                    <p>You can access to our site for your personal usage. Any other access or use of the site or its content violates this agreement and may break applicable copyright, trademark, or other laws.</p>
                    <p>You may not access, use, or copy any portion of the site or its content through the use of bots, spiders, scrapers, web crawlers, indexing agents, or other automated devices. In no event will you reproduce, redistribute, duplicate, copy, sell, resell, or exploit for any commercial purpose any portion of the Site or its Content or any access to or use of the site or its content.</p>
                    <h2>Copyright:</h2>
                    <p>We do not own the exclusive rights to quotes that other people have said. But we do own copyright to the arrangement of information on our website. You agree not to copy, distribute, display, disseminate, or otherwise reproduce any of the information on our site, or our site itself, without our prior written permission. This includes, but is not limited to, a prohibition on aggregating information on our site that is in the public domain and publishing it elsewhere.</p>
                    <h2>Design Copyright:</h2>
                    <p>You agree not to copy the look of our site or its design, or part of its design, without our prior written consent.</p>
                    <h2>Disclaimer:</h2>
                    <strong>YOU USE THIS SITE AT YOUR OWN RISK. THE SITE AND ITS CONTENT ARE OFFERED WITHOUT WARRANTY OF ANY KIND. IT INCLUDES: (1) THE MERCHANTABILITY OF OUR SERVICE OR FITNESS FOR ANY PARTICULAR PURPOSE (2) THAT THE USE OF THIS SITE OR ANY THIRD PARTY WEBSITE WILL BE UNINTERRUPTED OR ERROR-FREE (3) THAT THE USE OF THIS SITE OR ANY SUCH THIRD PARTY WEBSITE WILL ALLOW YOU TO OBTAIN ANY PARTICULAR RESULTS WHATSOEVER (4) THAT THE  
QUOTES OR ANY OTHER INFORMATION PROVIDED THROUGH THIS SITE OR ANY THIRD PARTY WEBSITE ARE OR WILL BE ACCURATE, CURRENT, COMPLETE, RELIABLE, OR OF ANY PARTICULAR VALUE OR QUALITY (5) THAT ANY DEFECTS IN THE SITE OR ITS CONTENT WILL BE CORRECTED (6) THAT THE SITE AND ITS CONTENTS ARE FREE OF VIRUSES OR OTHER DISABLING DEVICES OR HARMFUL COMPONENTS.</strong>
                    <h2>Limitation of Liability:</h2>
                    <p>IN NO EVENT WILL <a href="/" role="link">PortalQuote.com</a>, ITS CONTRACTORS, SUPPLIERS, CONTENT-PROVIDERS, AND OTHER SIMILAR ENTITIES, AND THE OFFICERS, DIRECTORS, EMPLOYEES, REPRESENTATIVES, AND AGENTS OF EACH OF THE FOREGOING (COLLECTIVELY, OUR "REPRESENTATIVES"), BE LIABLE TO YOU, OR ANY THIRD PARTY FOR ANY LOSSES OR DAMAGES, INCLUDING ANY INDIRECT, CONSEQUENTIAL, INCIDENTAL, PUNITIVE, SPECIAL OR SIMILAR DAMAGES, ALLEGED UNDER ANY LEGAL THEORY IN RELATION TO OR ARISING FROM THIS AGREEMENT OR OUR SERVICE, FOR REASONS INCLUDING, BUT NOT LIMITED TO, FAILURE OF OUR SERVICE, NEGLIGENCE, OR ANY OTHER TORT. TO THE EXTENT THAT APPLICABLE LAW RESTRICTS THE EXCLUSION OR LIMITATION OF LIABILITY FOR CERTAIN DAMAGES, YOU AGREE THAT WE ARE ONLY LIABLE TO YOU FOR THE MINIMUM AMOUNT OF DAMAGES THAT THE LAW RESTRICTS OUR LIABILITY TO, IF SUCH A MINIMUM EXISTS. SOME STATES DO NOT ALLOW THE EXCLUSION OR LIMITATION OF INCIDENTAL OR CONSEQUENTIAL DAMAGES, SO THE ABOVE LIMITATION OR EXCLUSION MAY NOT APPLY TO YOU.</p>
                    <p>WITHOUT LIMITING ANY OF THE FOREGOING, IF <a href="/" role="link">PortalQuote.com</a> OR ANY OF ITS REPRESENTATIVES IS FOUND LIABLE TO YOU OR TO ANY THIRD PARTY AS A RESULT OF ANY CLAIMS OR OTHER MATTERS ARISING UNDER OR IN CONNECTION WITH THIS AGREEMENT, THE SITE, OR YOUR USE OF THE SITE OR ITS CONTENTS, THE MAXIMUM LIABILITY FOR ALL SUCH CLAIMS AND OTHER MATTERS WILL NOT EXCEED $100 IN ANY CALENDAR YEAR.</p>
                    <h2>Amendments:</h2>
                    <p>We may amend this agreement from time to time. When we amend this agreement, we will update this page and indicate the date that it was last modified. You may refuse to agree to the amendments, but if you do, you must immediately cease using our website and our service. You must visit this page each time you come to our website and read and agree to it if the date it was last modified is more recent than the last time you agreed to the agreement.</p>
                    <div class="or-spacer">
                        <div class="mask"></div>
                    </div>
                    <p class="text-muted">2016 PortalQuote.com All Rights Reserved.</p>
                </div>
            </div>
        </section>
        
        <?php include 'layouts/footer.php'; ?>
    </body>
</html>