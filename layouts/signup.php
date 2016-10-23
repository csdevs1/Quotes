<?php 
    include('AppClasses/GmailLogin.php');
    require_once('AppClasses/Token.php');
    $tokenObj = new Token();
    $token=$tokenObj->generate();
?>
<div class="modal fade" id="signup" tabindex="-1" role="dialog" aria-labelledby="signuplLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Sign Up</h4>
            </div>
            <div class="modal-body" role="form">
                
                <div class="form-group col-xs-12">
                    <label for="fname" class="control-label">First Name</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="ion-android-contact"></i></span>
                        <input type="text" class="form-control" id="fname" data-error="Field required" aria-describedby="FirstName" placeholder="Enter First Name">
                    </div>
                </div>
                
                <div class="form-group col-xs-12">
                    <label for="lname" class="control-label">Last Name</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="ion-android-contact"></i></span>
                        <input type="text" class="form-control" id="lname" data-error="Field required" aria-describedby="LastName" placeholder="Enter Last Name">
                    </div>
                </div>
                
                <div class="form-group col-xs-12">
                    <label for="email" class="control-label">Email address</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="ion-android-mail"></i></span>
                        <input type="email" class="form-control" id="email" data-error="Email address is invalid" aria-describedby="emailAddress" placeholder="Enter email" required>
                    </div>
                    <div class="help-block with-errors"></div>
                </div>
                
                <div class="form-group col-xs-12">
                    <label for="passwd" class="control-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-sunglasses"></i></span>
                        <input type="password" class="form-control" id="passwd" data-error="Min: 7, Max: 10" aria-describedby="password" minlength="7" maxlength="10" placeholder="Enter password" required>
                    </div>
                    <div class="help-block with-errors"></div>
                </div>
                
                <div class="form-group col-xs-12">
                    <label for="gender" class="control-label">Gender</label>
                    <div class="input-group col-xs-12">
                        <select class="form-control" id="gender">
                            <option role="option">F</option>
                            <option role="option">M</option>
                        </select>
                    </div>
                </div>
                
                <h4>Or sign up with</h4>
                <div class="form-group col-xs-12 social-network">
                    <a  href="<?php echo $authUrl; ?>" class="col-xs-12 col-md-4">
                        <i class="ion-social-googleplus"></i> Gmail
                    </a>
                    <a class="col-xs-12 col-md-4" onclick="fbLogin('<?php echo $token;  ?>');" style="cursor:pointer;">
                        <i class="ion-social-facebook"></i> Facebook
                    </a>
                </div>
                
                <div class="col-xs-12">
                    <label class="agreed-terms">
                        <input type="checkbox" id="terms"> <span>I agree with the <a href="">Terms of Service</a> and <a href="">Privacy Policy</a></span>
                    </label>
                </div>
            </div>
            <input type="hidden" name="token" id="token" value="<?php echo $token;  ?>">
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save">Sign up</button>
            </div>
        </div>
    </div>
</div>    