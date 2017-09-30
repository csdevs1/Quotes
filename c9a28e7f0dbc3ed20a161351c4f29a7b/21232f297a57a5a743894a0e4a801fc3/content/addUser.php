<?php
require_once('../Classes/Token.php');
$tokenObj = new Token();
$token=$tokenObj->generate();
?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><i class="ion-person-add"></i> Add New User</h3></div>
            <div class="panel-body">
                <div class=" form">
                    <div class="cmxform form-horizontal tasi-form" id="commentForm">
                        <div class="form-group ">
                            <label for="email" class="control-label col-lg-2">E-Mail (*)</label>
                            <div class="col-lg-10">
                                <input class="form-control " id="email" type="email" name="email" required="" oninput='generateUsrname(this)' aria-required="true">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="usrName" class="control-label col-lg-2">Username (*)</label>
                            <div class="col-lg-10">
                                <input class=" form-control" id="usrName" name="usrName" type="text" required="" aria-required="true">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="usrPswd" class="control-label col-lg-2">Password (*)</label>
                            <div class="col-lg-6">
                                <input class="form-control " id="usrPswd" type="text" name="usrPswd" min="7" max="15">
                            </div>
                            <div class="col-lg-2">
                                <input class="btn btn-primary " id="generatePass" type="submit" name="generatePass" value="Generate Password" onclick="generate()">
                            </div>
                        </div>
                        <hr><h4 class="panel-title"><i class="ion-unlocked"></i> User's permission</h4>
                        <div class="form-group ">
                            <label for="insrt" class="control-label col-lg-2 col-sm-3">Insert</label>
                            <div class="col-lg-10 col-sm-9">
                                <input type="checkbox" style="width: 16px" class="checkbox form-control" id="insrt" name="insrt" value='1'>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="modif" class="control-label col-lg-2 col-sm-3">Edit</label>
                            <div class="col-lg-10 col-sm-9">
                                <input type="checkbox" style="width: 16px" class="checkbox form-control" id="modif" name="modif" value='1'>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="del" class="control-label col-lg-2 col-sm-3">Delete</label>
                            <div class="col-lg-10 col-sm-9">
                                <input type="checkbox" style="width: 16px" class="checkbox form-control" id="del" name="del" value='1'>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="lang" class="control-label col-lg-2 col-sm-3">Language</label>
                            <div class="col-lg-10 col-sm-9">
                                <select id="lang" name="lang">
                                    <option value="all">All</option>
                                    <option value="eng">English</option>
                                    <option value="pt">Portuguese</option>
                                    <option value="es">Spanish</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" id="token" value="<?php echo $token; ?>">
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-success" onclick="save()">Save</button>
                            </div>
                        </div>
                    </div>
                </div> <!-- .form -->
            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div> <!-- End row -->

<script>
    var save=function(){
        var usrName=$('#usrName').val(),
            email=$('#email').val(),
            usrPswd=$('#usrPswd').val(),
            lang=$('#lang').val(),
            arr={};
        if(usrName!=''){
            arr['usrName']=usrName;
        }else{
            //usrName Error
        }
        if(email!=''){
            arr['email']=email;
        }else{
            //email Error
        }
        if(usrPswd!='' && usrPswd.length>=7 && usrPswd.length<=15){
            arr['usrPswd']=usrPswd;
        }else{
            //usrPswd Error
        }
        if($('#insrt').is(':checked')){
            arr['insrt']=$('#insrt').val();
        }
        if($('#modif').is(':checked')){
            arr['modif']=$('#modif').val();
        }
        if($('#del').is(':checked')){
            arr['del']=$('#del').val();
        }
        if(Object.keys(arr).length>=3){
            if(usrPswd.length>=7 && usrPswd.length<=15){
                arr['lang']=lang;
                var token=$('#token').val();
                var newUser=signup('dashboard_usrs',arr,token);
                newUser.done(function(response){
                    if(response){
                        swal({title: "Well Done!",text: "A new user has been added",type:"success",confirmButtonText: "OK"},function(isConfirm){if(isConfirm){location.reload();}});
                    }
                });
            }
        }
    }
    
    var generate=function(){
        var text = "";
        // 7 -> 15
        var num=Math.floor(Math.random() * (15 - 7) + 7);
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        for( var i=0; i < num; i++ )
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        $('#usrPswd').val(text);
    }
    var generateUsrname=function(el){
        var s = el.value.split('@')[0];
        $('#usrName').val(s);
    }
</script>