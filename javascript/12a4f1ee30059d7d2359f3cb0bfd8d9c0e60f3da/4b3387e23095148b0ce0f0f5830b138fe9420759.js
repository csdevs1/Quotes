// LOGIN FUNCTION

var login = function(email,passwd,token){
    var formData = new FormData();
    formData.append("email", email);
    formData.append("passwd", passwd);
    formData.append("action", 'login');
    formData.append("token", token);
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType:  false,
        data: formData,
        url: '/quotes/c9dcc9a0e463aca2d9575c58a5e23fb9b12d9fa2/4a72dc8ceda3f3885da0aba3a857aa19abcef5bc',
        async:false
    });
}

$("#login-btn").click(function(){
    var email=$('#email-login').val(),passwd=$('#passwd-login').val(),token=$('#token').val();
    var logged=login(email,passwd,token);
    logged.done(function(response){
        console.log(response);
        if(response[0]){
            location.reload();
        }else{
            swal({title: "Incorrect User",   text: "Check your email or password!",   type: "error",   showCancelButton: false,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Ok!",   closeOnConfirm: true });
        }
    });
});

document.getElementById("email-login").addEventListener("keyup", function(event) {
    event.preventDefault();
    if (event.keyCode == 13) {
        var email=$('#email-login').val(),passwd=$('#passwd-login').val(),token=$('#token').val();
        if(email!='' || passwd!=''){
            var logged=login(email,passwd,token);
            logged.done(function(response){
                console.log(response);
                if(response[0]){
                    location.reload();
                }else{
                    swal({title: "Incorrect User",   text: "Check your email or password!",   type: "error",   showCancelButton: false,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Ok!",   closeOnConfirm: true });
                }
            });
        }
    }
});

document.getElementById("passwd-login").addEventListener("keyup", function(event) {
    event.preventDefault();
    if (event.keyCode == 13) {
        var email=$('#email-login').val(),passwd=$('#passwd-login').val(),token=$('#token').val();
        if(email!='' || passwd!=''){
            var logged=login(email,passwd,token);
            logged.done(function(response){
                console.log(response);
                if(response[0]){
                    location.reload();
                }else{
                    swal({title: "Incorrect User",   text: "Check your email or password!",   type: "error",   showCancelButton: false,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Ok!",   closeOnConfirm: true });
                }
            });
        }
    }
});