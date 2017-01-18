//logout

var signout=function(){
    var signOut=logout_function();
    signOut.done(function(response){
        if(response)
            window.location='/';
    });
}
function logout_function(){
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {logout:true},
        url: '/quotes/c9dcc9a0e463aca2d9575c58a5e23fb9b12d9fa2/4a72dc8ceda3f3885da0aba3a857aa19abcef5bc'
    });
}