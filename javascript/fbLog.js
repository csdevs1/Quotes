window.fbAsyncInit = function() {
    FB.init({
        appId      : '1811295922425676',
        xfbml      : true,
        version    : 'v2.8'
    });
};
(function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function fbLogin(token){
    FB.login(function(response) {
        if (response.authResponse) {
            console.log('Welcome!  Fetching your information.... ');
            /*FB.api('/me', function(response) {
                console.log(response);
            });*/
            getInfo(token);
        } else {
            console.log('User cancelled login or did not fully authorize.');
        }
    });
}
function getInfo(token){
    FB.api('/me', 'GET', {fields: 'first_name,last_name,email,gender,id',access_token:'EAAZAvXTIKD0wBAAfUwosEK2Egl8mBLtzKYkfDIvCCda2VTabIXoHujxk3co3yK0zW4w8ZCxDHtOQpnNEzrur5SndLWj08QyaF7FPH9MF2df7r7Vorfa5gE1uLZCD2ZBv5wARLyNfJRmYcpizMGNG'}, function(response) {
        var usr_info={email:response.email,fname:response.first_name,lname:response.last_name,gender:response.gender[0],oauth_uid:response.id};
        var checked=checkUser(usr_info,token);
        checked.done(function(usrData){
            console.log(usrData);
        });
    });
}
        
function logout(){
    FB.logout(function(response) {
        console.log("See ya!");
    });
}

var checkUser=function(usr_info,token){
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {usr_info:usr_info,token:token,action:'check'},
        url: 'AppClasses/FBLogin.php',
        async:false
    });
}