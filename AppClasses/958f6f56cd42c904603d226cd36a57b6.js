var insert = function(table,data,token,image=''){
    var formData = new FormData();
    formData.append("data", JSON.stringify(data));
    formData.append("table", table);
    formData.append("action", 'insert');
    formData.append("token", token);
    if(image!=''){
        formData.append("image", image);
    }
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType:  false,
        data: formData,
        url: '/15c563887e7fe28109af91fda7a3532f/df93a32d352b782e852806917765483c',
        async:false
    });
}

var find_by = function(table,row,val){
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {table:table,row:row,val:val,action:'find_by'},
        url: '15c563887e7fe28109af91fda7a3532f/df93a32d352b782e852806917765483c',
        async:false
    });
}

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i); // Regex para correos validos.
    return pattern.test(emailAddress);
}

$("#save").click(function() {
    var fname=$('#fname').val(),
      lname=$('#lname').val(),
      email=$('#email').val(),
      passwd=$('#passwd').val(),
      gender=$('#gender').val(),
      errors={},
      arr={};
    if(fname==''){
        errors['fname']="Name can't be empty";
    } else{
        arr['fname']=fname;
    }
    if(lname==''){
        errors['lname']="Last Name can't be empty";
    } else{
        arr['lname']=lname;
    }
    if(email=='' || !isValidEmailAddress(email)){
        errors['email']="Email can't be empty";
    } else{
        arr['email']=email;
    }
    if(passwd==''){
        errors['passwd']="Password can't be empty";
    } else{
        arr['passwd']=passwd;
    }
    if(Object.keys(errors).length>0){
        for(var i in errors){
            $('#'+i).addClass('error-box');
        }
        setTimeout(function() {
            $('.error-box').removeClass('error-box');
        }, 5000);
    } else{
        var checkUser = find_by('users','email',email);
        checkUser.done(function(checked){
            if(Object.keys(checked[0]).length>0){
                console.log('User Exist');
            }else{
                $('#save').attr('disabled','disabled');
                this.innerHTML = "Registering...";
                arr['gender']=gender;
                var token=$('#token').val();
                var signUp = insert('users',arr,token);
                signUp.done(function(response){
                    console.log(response);
                    $('#save').removeAttr('disabled');
                    document.getElementById('save').innerHTML = "Sign up";
                    swal({title: "Well Done!",text: "An email has been sent to your account.",type:"success",confirmButtonText: "OK",closeOnConfirm: false},function(isConfirm){if(isConfirm){location.reload();}});
                });
            }
        });
    }
});

var isUnavailable = function(el){
    var checkUser = find_by('users','email',el.value);
    checkUser.done(function(checked){
        if(Object.keys(checked[0]).length>0){
            return true;
        }else{
            return false;
        }
    });
}

$('#terms').change(function(){
    if(this.checked) {
        $('#save').removeAttr('disabled');
    }else{
        $('#save').attr('disabled','disabled');
    }
});

$(document).ready(function(){
    $('#save').attr('disabled','disabled');
});
