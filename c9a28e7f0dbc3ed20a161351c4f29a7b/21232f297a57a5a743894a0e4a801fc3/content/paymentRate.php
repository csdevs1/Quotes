<?php
    session_start();
    if(isset($_SESSION['label']) && !empty($_SESSION['label']) && $_SESSION['label'] =='root'){
        require_once('../Classes/AppController.php');
        $obj = new AppController();
        $rate = $obj->all('payment_rate');
?>
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
                <button type="button" class="btn btn-primary" onclick="updateRate(this)">Update</button>
            </div>
        </div>
    </div>
</div>

<script>
    var updateRate=function(el){
        var rate=$('#rate').val(),
            arr={},
            token = generateToken();
        token.done(function(generatedToken){
            arr['rate']=rate;
            var update_topic = update('payment_rate',arr,'id',1,generatedToken);
            update_topic.done(function(data){
                paymentRate('#rate-menu');
            });
        });
    }
</script>

<?php } ?>