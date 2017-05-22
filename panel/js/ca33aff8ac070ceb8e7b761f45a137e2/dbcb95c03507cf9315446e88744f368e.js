//SETTINGS
var reset_pswd=function(){
    var formData = new FormData();
    formData.append("action", 'reset_pswd');
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType:  false,
        data: formData,
        url: '/c9dcc9a0e463aca2d9575c58a5e23fb9b12d9fa2/4a72dc8ceda3f3885da0aba3a857aa19abcef5bc',
        async:false
    });
}

var update = function(arr){
    var formData = new FormData();
    formData.append("data", JSON.stringify(arr));
    formData.append("action", 'up_settings');
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType:  false,
        data: formData,
        url: '/c9dcc9a0e463aca2d9575c58a5e23fb9b12d9fa2/4a72dc8ceda3f3885da0aba3a857aa19abcef5bc',
        async:false
    });
}

var check_uname = function(row,val){
    var formData = new FormData();
    formData.append("row", row);
    formData.append("val", val);
    formData.append("action", 'uname');
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType:  false,
        data: formData,
        url: '/c9dcc9a0e463aca2d9575c58a5e23fb9b12d9fa2/4a72dc8ceda3f3885da0aba3a857aa19abcef5bc',
        async:false
    });
}

$('#psw-rs_916871').click(function(){
    swal({
        title: "Are you sure?",
        text: "You're about to change your password!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, let's change it!",
        closeOnConfirm: false
    },
    function(){
        var reset=reset_pswd();
        reset.done(function(data){
            if(data){
                swal({title: "Check your email!",text: "An email has been sent to you...",type:"success",confirmButtonText: "OK",closeOnConfirm: false},function(isConfirm){if(isConfirm){location.reload();}});
            }
        });
    });
});

$('#_up_496-ixb').click(function(){
    var fname=$('#fname').val(),
        lname=$('#lname').val(),
        email=$('#email').val(),
        uname=$('#uname').val(),
        website=$('#website').val(),
        facebook=$('#facebook').val(),
        twitter=$('#twitter').val(),
        instagram=$('#instagram').val(),
        about=$('#about').val(),
        arr={};
    arr['website']=website;
    arr['facebook']=facebook;
    arr['twitter']=twitter;
    arr['instagram']=instagram;
    arr['about']=about;
    if(fname!='')
        arr['fname']=fname;
    if(lname!='')
        arr['lname']=lname;
    if(email!='')
        arr['email']=email;
    if(uname!='')
        arr['username']=uname;
    if(Object.keys(arr).length > 1){
        var el=this;
        el.innerHTML='<div class="la-ball-fall"><div></div><div></div><div></div></div>';
        $(el).attr('disabled');
        var up_usr=update(arr);
        up_usr.done(function(data){
            setTimeout(function() {
                swal({title: "Nice!",text: "Your profile has been updated correctly.",type:"success",confirmButtonText: "OK",closeOnConfirm: false},function(isConfirm){if(isConfirm){window.location.href = 'https://portalquote.com/panel/settings/'+uname;}});
            }, 2000);
        });
    }
});

document.getElementById('uname').oninput=function(){
    this.value = this.value.replace(/\s/g, "");
    if(this.value!='')
        document.getElementById('yourpage').innerHTML=this.value;
    else
        document.getElementById('yourpage').innerHTML="<Can't be blank>";
    var u_name=check_uname('username',this.value);
    u_name.done(function(response){
        console.log(response['response']);
        if(response['response']){
            $('.alert.alert-danger.uname').show();
        }else{
            $('.alert.alert-danger.uname').hide();
        }
    });
}