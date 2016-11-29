<?php
    session_start();
    require_once('../Classes/AppController.php');
    $obj = new AppController();
    $rate = $obj->find_by('payment_rate','userID',$_POST['id']);
    $user = $obj->find_by('dashboard_usrs','id',$_POST['id']);
    $log = $obj->limit('*','dashboard_logs WHERE userID='.$_POST['id'],50,'logID');
    $userName=explode('@',$user[0]['email']);
    $lang=$user[0]['lang'];
    switch($lang){
        case "eng":
            $nQuotes=$obj->custom('SELECT COUNT(quoteID) as "cnt" FROM dashboardUsr_Quote_en WHERE userID='.$_POST['id']);
            $payQuote=$obj->custom('SELECT * FROM dashboardUsr_Quote_en WHERE userID='.$_POST['id'].' AND MONTH(created_at) = MONTH(NOW())'); //SELECT QUOTES THAT WERE INSERTED IN THE CURRENT MONTH TO CALCULATE PAYMENT
            $last_payQuote=$obj->custom('SELECT * FROM dashboardUsr_Quote_en WHERE userID='.$_POST['id'].' AND MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)'); //SELECT QUOTES THAT WERE INSERTED LAST MONTH TO CALCULATE PAYMENT
            //Number of Topics
            $nTopics=$obj->custom('SELECT COUNT(topicID) as "cnt" FROM dashboardUsr_Topic_en WHERE userID='.$_POST['id']);
            $payTopic=$obj->custom('SELECT * FROM dashboardUsr_Topic_en WHERE userID='.$_POST['id'].' AND MONTH(created_at) = MONTH(NOW())'); //SELECT QUOTES THAT WERE INSERTED IN THE CURRENT MONTH TO CALCULATE PAYMENT
            $last_payTopic=$obj->custom('SELECT * FROM dashboardUsr_Topic_en WHERE userID='.$_POST['id'].' AND MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)'); //SELECT QUOTES THAT WERE INSERTED LAST MONTH TO CALCULATE PAYMENT
            $language='English';
            $total=count($payQuote)+count($payTopic);
            $lm_total=count($last_payQuote)+count($last_payTopic);
            break;
        case "pt":
            $nQuotes=$obj->custom('SELECT COUNT(quoteID) as "cnt" FROM dashboardUsr_Quote_pt WHERE userID='.$_POST['id']);
            $payQuote=$obj->custom('SELECT * FROM dashboardUsr_Quote_pt WHERE userID='.$_POST['id'].' AND MONTH(created_at) = MONTH(NOW())'); //SELECT QUOTES THAT WERE INSERTED IN THE CURRENT MONTH TO CALCULATE PAYMENT
            $last_payQuote=$obj->custom('SELECT * FROM dashboardUsr_Quote_pt WHERE userID='.$_POST['id'].' AND MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)'); //SELECT QUOTES THAT WERE INSERTED LAST MONTH TO CALCULATE PAYMENT
            //Number of Topics
            $nTopics=$obj->custom('SELECT COUNT(topicID) as "cnt" FROM dashboardUsr_Topic_pt WHERE userID='.$_POST['id']);
            $payTopic=$obj->custom('SELECT * FROM dashboardUsr_Topic_pt WHERE userID='.$_POST['id'].' AND MONTH(created_at) = MONTH(NOW())'); //SELECT QUOTES THAT WERE INSERTED IN THE CURRENT MONTH TO CALCULATE PAYMENT
            $last_payTopic=$obj->custom('SELECT * FROM dashboardUsr_Quote_pt WHERE userID='.$_POST['id'].' AND MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)'); //SELECT QUOTES THAT WERE INSERTED LAST MONTH TO CALCULATE PAYMENT
            $language='Portuguese';
            $total=count($payQuote)+count($payTopic);
            $lm_total=count($last_payQuote)+count($last_payTopic);
            break;
        case "es":
            $nQuotes=$obj->custom('SELECT COUNT(quoteID) as "cnt" FROM dashboardUsr_Quote_es WHERE userID='.$_POST['id']);
            $payQuote=$obj->custom('SELECT * FROM dashboardUsr_Quote_es WHERE userID='.$_POST['id'].' AND MONTH(created_at) = MONTH(NOW())'); //SELECT QUOTES THAT WERE INSERTED IN THE CURRENT MONTH TO CALCULATE PAYMENT
            $last_payQuote=$obj->custom('SELECT * FROM dashboardUsr_Quote_es WHERE userID='.$_POST['id'].' AND MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)'); //SELECT QUOTES THAT WERE INSERTED LAST MONTH TO CALCULATE PAYMENT
            //Number of Topics
            $nTopics=$obj->custom('SELECT COUNT(topicID) as "cnt" FROM dashboardUsr_Topic_es WHERE userID='.$_POST['id']);
            $payTopic=$obj->custom('SELECT * FROM dashboardUsr_Topic_es WHERE userID='.$_POST['id'].' AND MONTH(created_at) = MONTH(NOW())'); //SELECT QUOTES THAT WERE INSERTED IN THE CURRENT MONTH TO CALCULATE PAYMENT
            $last_payTopic=$obj->custom('SELECT * FROM dashboardUsr_Quote_es WHERE userID='.$_POST['id'].' AND MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)'); //SELECT QUOTES THAT WERE INSERTED LAST MONTH TO CALCULATE PAYMENT
            $language='Spanish';
            $total=count($payQuote)+count($payTopic);
            $lm_total=count($last_payQuote)+count($last_payTopic);
            break;
        default:
            $nQuotesinEng = $obj->custom('SELECT COUNT(quoteID) as "cnt" FROM dashboardUsr_Quote_en WHERE userID='.$_POST['id']);
            $nQuotesinPT = $obj->custom('SELECT COUNT(quoteID) as "cnt" FROM dashboardUsr_Quote_pt WHERE userID='.$_POST['id']);
            $nQuotesinES = $obj->custom('SELECT COUNT(quoteID) as "cnt" FROM dashboardUsr_Quote_es WHERE userID='.$_POST['id']);
            //CALCUTALE PAYMENT
            $payQuoteEN=$obj->custom('SELECT * FROM dashboardUsr_Quote_en WHERE userID='.$_POST['id'].' AND MONTH(created_at) = MONTH(NOW())'); //SELECT QUOTES THAT WERE INSERTED IN THE CURRENT MONTH TO CALCULATE PAYMENT
            $payQuoteES=$obj->custom('SELECT * FROM dashboardUsr_Quote_es WHERE userID='.$_POST['id'].' AND MONTH(created_at) = MONTH(NOW())'); //SELECT QUOTES THAT WERE INSERTED IN THE CURRENT MONTH TO CALCULATE PAYMENT
            $payQuotePT=$obj->custom('SELECT * FROM dashboardUsr_Quote_pt WHERE userID='.$_POST['id'].' AND MONTH(created_at) = MONTH(NOW())'); //SELECT QUOTES THAT WERE INSERTED IN THE CURRENT MONTH TO CALCULATE PAYMENT
            
            $last_payQuoteEN=$obj->custom('SELECT * FROM dashboardUsr_Quote_en WHERE userID='.$_POST['id'].' AND MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)'); //SELECT QUOTES THAT WERE INSERTED LAST MONTH TO CALCULATE PAYMENT
            $last_payQuotePT=$obj->custom('SELECT * FROM dashboardUsr_Quote_pt WHERE userID='.$_POST['id'].' AND MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)'); //SELECT QUOTES THAT WERE INSERTED LAST MONTH TO CALCULATE PAYMENT
            $last_payQuoteES=$obj->custom('SELECT * FROM dashboardUsr_Quote_es WHERE userID='.$_POST['id'].' AND MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)'); //SELECT QUOTES THAT WERE INSERTED LAST MONTH TO CALCULATE PAYMENT
            
            //TOPICS
            $nTopicsinEng = $obj->custom('SELECT COUNT(topicID) as "cnt" FROM dashboardUsr_Topic_en WHERE userID='.$_POST['id']);
            $nTopicsinPT = $obj->custom('SELECT COUNT(topicID) as "cnt" FROM dashboardUsr_Topic_pt WHERE userID='.$_POST['id']);
            $nTopicsinES = $obj->custom('SELECT COUNT(topicID) as "cnt" FROM dashboardUsr_Topic_es WHERE userID='.$_POST['id']);
            //CALCUTALE PAYMENT
            $payTopicEN=$obj->custom('SELECT * FROM dashboardUsr_Topic_en WHERE userID='.$_POST['id'].' AND MONTH(created_at) = MONTH(NOW())'); //SELECT QUOTES THAT WERE INSERTED IN THE CURRENT MONTH TO CALCULATE PAYMENT
            $payTopicES=$obj->custom('SELECT * FROM dashboardUsr_Topic_es WHERE userID='.$_POST['id'].' AND MONTH(created_at) = MONTH(NOW())'); //SELECT QUOTES THAT WERE INSERTED IN THE CURRENT MONTH TO CALCULATE PAYMENT
            $payTopicPT=$obj->custom('SELECT * FROM dashboardUsr_Topic_pt WHERE userID='.$_POST['id'].' AND MONTH(created_at) = MONTH(NOW())'); //SELECT QUOTES THAT WERE INSERTED IN THE CURRENT MONTH TO CALCULATE PAYMENT
            
            $last_payTopicEN=$obj->custom('SELECT * FROM dashboardUsr_Topic_en WHERE userID='.$_POST['id'].' AND MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)'); //SELECT QUOTES THAT WERE INSERTED LAST MONTH TO CALCULATE PAYMENT
            $last_payTopicPT=$obj->custom('SELECT * FROM dashboardUsr_Quote_pt WHERE userID='.$_POST['id'].' AND MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)'); //SELECT QUOTES THAT WERE INSERTED LAST MONTH TO CALCULATE PAYMENT
            $last_payTopicES=$obj->custom('SELECT * FROM dashboardUsr_Quote_es WHERE userID='.$_POST['id'].' AND MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)'); //SELECT QUOTES THAT WERE INSERTED LAST MONTH TO CALCULATE PAYMENT
            
            $total=count($payQuoteES)+count($payQuoteEN)+count($payQuotePT)+count($payTopicEN)+count($payTopicPT)+count($payTopicEN);
            $lm_total=count($last_payQuoteEN)+count($last_payQuotePT)+count($last_payQuoteES)+count($last_payTopicEN)+count($last_payTopicPT)+count($last_payTopicES);
            break;
    }
    $total=$total*$rate[0]['rate'];
    $lm_total=$lm_total*$rate[0]['rate'];
?>
<style>
    .container{padding-top: 10px;padding-bottom: 10px;}
    .btn-container{text-align: center;}
    .btn-container a{width: 30%;}
</style>

<!--Widget-2 -->
<?php if($lang!='all'){ ?>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <div class="widget-panel widget-style-1 bg-pink">
                <i class="fa fa-comments-o"></i> 
                <h2 class="m-0 counter"><?php echo $nQuotes[0]['cnt']; ?></h2>
                <div>Quotes translated in <?php echo $language; ?></div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="widget-panel widget-style-1 bg-warning">
                <i class="fa fa-hand-o-up"></i> 
                <h2 class="m-0 counter"><?php echo $nTopics[0]['cnt']; ?></h2>
                <div>Topics translated in <?php echo $language; ?></div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="widget-panel widget-style-1 bg-purple">
                <i class="fa fa-book" aria-hidden="true"></i>
                <h2 class="m-0 counter">1268</h2>
                <div>Authors translated</div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="widget-panel widget-style-1 bg-success">
                <i class="fa fa-usd" aria-hidden="true"></i>
                <h2 class="m-0 counter"><?php echo $total.'$';  ?></h2>
                <div>Current Income</div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="widget-panel widget-style-1 bg-success">
                <i class="fa fa-usd" aria-hidden="true"></i>
                <h2 class="m-0 counter h2 text-purple"><?php echo $lm_total.'$';  ?></h2> <!-- Needs to add paytQuotePT -->
                <div class="text-purple">Last Month Income</div>
            </div>
        </div>
    </div>
    </div><!-- End row -->
</div><!-- End row -->
<?php }else{ ?>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <div class="widget-panel widget-style-1 bg-pink">
                <i class="fa fa-comments-o"></i> 
                <h2 class="m-0 counter"><?php echo $nQuotesinEng[0]['cnt']; ?></h2>
                <div>Quotes translated in English</div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="widget-panel widget-style-1 bg-warning">
                <i class="fa fa-comments-o"></i>
                <h2 class="m-0 counter"><?php echo $nQuotesinES[0]['cnt']; ?></h2>
                <div>Quotes translated in Spanish</div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="widget-panel widget-style-1 bg-info">
                <i class="fa fa-comments-o"></i>
                <h2 class="m-0 counter"><?php echo $nQuotesinPT[0]['cnt']; ?></h2>
                <div>Quotes translated in Portuguese</div>
            </div>
        </div>
    </div><!-- End row -->
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <div class="widget-panel widget-style-1 bg-purple">
                <i class="fa fa-hand-o-up"></i> 
                <h2 class="m-0 counter"><?php echo $nTopicsinEng[0]['cnt']; ?></h2>
                <div>Topics translated in English</div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="widget-panel widget-style-1 bg-primary">
                <i class="fa fa-hand-o-up"></i> 
                <h2 class="m-0 counter"><?php echo $nTopicsinES[0]['cnt']; ?></h2>
                <div>Topics translated in Spanish</div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="widget-panel widget-style-1 bg-danger">
                <i class="fa fa-hand-o-up"></i> 
                <h2 class="m-0 counter"><?php echo $nTopicsinPT[0]['cnt']; ?></h2>
                <div>Topics translated in Portuguese</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="widget-panel widget-style-1 bg-success">
                <i class="fa fa-usd" aria-hidden="true"></i>
                <h2 class="m-0 counter"><?php echo $total.'$';  ?></h2> <!-- Needs to add paytQuotePT -->
                <div>Current Income</div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="widget-panel widget-style-1 bg-success">
                <i class="fa fa-usd" aria-hidden="true"></i>
                <h2 class="m-0 counter h2 text-purple"><?php echo $lm_total.'$';  ?></h2> <!-- Needs to add paytQuotePT -->
                <div class="text-purple">Last Month Income</div>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<!-- SET PAYMENT RATE -->
<?php if(isset($_SESSION['label']) && !empty($_SESSION['label']) && $_SESSION['label'] =='root'){ ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <label for="pwd">Payment Rate:</label>
                    <input type="number" class="form-control" step=".0001" id="rate" min="0" value="<?php echo $rate[0]['rate'];  ?>">
                </div>
            </div>
            <div class="form-group col-xs-12">
                <div class="input-group">
                    <button type="button" class="btn btn-primary" onclick="updateRate(this,<?php echo $_POST['id'] ?>)">Update</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- LOG -->
<div class="container">
    <h2><?php echo $userName[0]; ?></h2>
    <p>This log contains the latest User's action by date:</p>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Message</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($log as $key=>$val){
                $created_at=date_create($log[$key]['created_at']);
                $date=date_format($created_at, 'g:ia \o\n l j F Y');
            ?>
            <tr>
                <td>[<?php echo $date; ?>]</td>
                <td><?php echo $log[$key]['log']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php if(count($log)>50){ ?>
    <div class="container btn-container"><a href="" class="btn btn-primary">View More</a></div>
    <?php } ?>
</div>

<?php if(isset($_SESSION['label']) && !empty($_SESSION['label']) && $_SESSION['label'] =='root'){ ?>
    <script>
        var updateRate=function(el,uID){
            var rate=$('#rate').val(),
                arr={},
                hasRate = find_by('payment_rate','userID',uID);
            hasRate.done(function(response){
                if(response[0].length>0){
                    var token = generateToken();
                    token.done(function(generatedToken){
                        arr['rate']=rate;
                        var update_rate = update('payment_rate',arr,'userID',uID,generatedToken);
                        update_rate.done(function(data){
                            usrDetails(uID);
                        });
                    });
                } else{
                    var token = generateToken();
                    token.done(function(generatedToken){
                        arr['rate']=rate;
                        arr['userID']=uID;
                        var insert_rate = insert('payment_rate',arr,generatedToken);
                        insert_rate.done(function(data){
                            usrDetails(uID);
                        });
                    });
                }
            });
        }
    </script>
<?php } ?>