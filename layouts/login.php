<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="login">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="Label">Login</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="email" class="control-label">Email:</label>
                        <input type="email" class="form-control" id="email-login">
                    </div>
                    <div class="form-group">
                        <label for="passwd" class="control-label">Password:</label>
                        <input type="password" class="form-control" id="passwd-login">
                    </div>
                </form>
            </div>
            <hr>
            <h4>Or Log in with</h4>
            <div class="form-group social-network">
                <a  href="<?php echo $authUrl; ?>" class="col-xs-12">
                    <i class="ion-social-googleplus"></i> Gmail
                </a>
                <a onclick="fbLogin('<?php echo $token;  ?>');" style="cursor:pointer;" class="col-xs-12">
                    <i class="ion-social-facebook"></i> Facebook
                </a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="login-btn">Login</button>
            </div>
        </div>
    </div>
</div>