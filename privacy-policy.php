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
            .banner-topic{background-image: url('/quotes/images/mke1JrB.jpg');max-height: 350px !important;}
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
            <h1 class="topic-info" itemtype="https://schema.org/CreativeWork">Privacy Policies</h1>
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
                    <h2>Privacy</h2>
                    <p>cookie use: The DoubleClick cookie
The DoubleClick cookie is used by Google in the ads served on the websites of its partners, such as websites displaying AdSense ads or participating in Google certified ad networks. When users visit a partner's website and either view or click on an ad, the cookie may be dropped on that end user's browser.
Third party vendors, including Google, use cookies to serve ads based on a user's prior visits Google's use of the DoubleClick cookie enables it to serve its users based on their sites and / or other sites on the Internet.
                        Users may opt out of the use of the DoubleClick cookie for interest-based advertising by visiting Ads Settings.</p>
                        <strong>Information supplied </strong><p>
We may request access to or otherwise receive information about your device location when you access the Site. Your location data may be based on your IP address. We use location data in connection with providing the Site and to help improve user experience with the Site. By submitting content to our site, you grant and authorize sublicenses of the foregoing. We'd also point out that we do not pay for anything you submit to us via our submission form or suggestion email inbox simply because you provide it of your own volition. By submitting material to us, you acknowledge that you have the right to do so, and that you completely transfer rights to the content to us.</p>
                    <h2>DISCLOSE YOUR INFORMATION</h2>
                    <p>We may share non-personal information with others, such as advertisers, sponsors and business partners, in aggregate anonymous form (meaning the information shared will not contain any personally identifiable information about you).
We will not sell, share, rent or otherwise disclose to third parties your personally identifiable information without your permission.
We may sell, rent or share your personally identifiable information, provided we have received your prior permission, Your personally identifiable information may be transferred to third parties such as technical agents, payment processing vendors, consultants, advertising companies 
All companies working for and with us provide with your personally identifiable information are contractually required to protect your personally identifiable information and keep it confidential; They are not permitted to sell or otherwise disclose your information to third parties except as authorized by you and as permitted by law.
In the event of a sale, merger, consolidation, change in control, transfer of substantial assets, reorganization or liquidation, we may transfer, sell or assign to third parties information concerning your relationship with us, including personally identifiable information that you provide and other Information regarding your relationship with us.
We may disclose your personally identifiable information if permitted by law or required by law or where we believe such action is necessary in order to protect or defend our interests or the interests of our customers or users of our Site, Application or Services.
By agreeing to this Privacy Policy, you are authorizing us to share your personally identifiable information with and among affiliated companies.</p>
                    <p><small class="text-muted">HOW DO WE USE THE INFORMATION WE COLLECT:</small></p>
                    <ul>
                        <li>Fulfill your requests for Services</li>
                        <li>Improve its services</li>
                        <li>Contact and communicate with you</li>
                    </ul>                    
                    <h2>Children</h2>
                    <p><a href="/" role="link">Portaquotes.com</a> is not geared for children under the age of 13, As such,we do not collect personal information from anyone under the age of 13. If we learn that a child under 13 has provided personal information to us. We will promptly delete information from our files</p>
                    <h2>Third Party</h2>
                    <p>We may link to third party websites from our own Site. We have no control over, and are not responsible for, these third party websites or their use of your personally identifiable information. This Privacy Policy does not apply to those websites. If you decide to access any external website through a link within our Site, you are solely at your own risk, we will have no liability for any damages arising from your access or use of any external website.</p>
                    <h2>Termination of user's access</h2>
                    <p>We reserve the right in its sole discretion to terminate your access to all or part of the site without notice or liability. We can do this for any reason including but not limited to, the breach of any agreement between you and PortalQuote.com  including without limitation, this Agreement.</p>
                    <h2>Changes to this Privacy Policy</h2>
                    <strong>We may change or update the Privacy Policy from time to time, and the amended version will be posted on the Site in place of the old version.</strong>
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