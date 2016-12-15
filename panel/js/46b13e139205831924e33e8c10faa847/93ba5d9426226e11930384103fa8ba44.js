//Following

var toFollow=function(data,action,token){
    var formData = new FormData();
    formData.append("data", data);
    formData.append("action", action);
    formData.append("uID", token);
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType:  false,
        data: formData,
        url: '/quotes/fd30fda6a3d920b6798126d7fb48c3cd/3903aab323863bd2e9b68218a7a65ebd',
        async:false
    });
}

$(document).on('click','#flw-qt',function(){
    var el=this;
    if(!($(el).hasClass('fllwing'))){
        var isFollowing=$(this).attr('data-follow');
        var token=$('#tokenusr').val();
        var follow=toFollow(isFollowing,'follow',token);
        follow.done(function(response){
            console.log(response);
            $('.nfllwr').text(response[0][0]['cnt']);
            el.innerHTML='Following <span class="caret"></span>';
            $(el).removeAttr('data-follow');
            $(el).removeClass('btn-default');
            $(el).addClass('btn-primary fllwing');
            $(el).parent().append('<ul class="dropdown-menu dropdown-menu-right" role="menu"><li><a data-unfollow="'+isFollowing+'" id="unfwd">Unfollow</a></li></ul>');
        });
    }
});

$(document).on('click','#unfwd',function(){
    var el=this;
    var unFollowing=$(this).attr('data-unfollow');
    var token=$('#tokenusr').val();
    var unfollow=toFollow(unFollowing,'unfollow',token);
    unfollow.done(function(response){
        $(el).parent().parent().remove();
        $('.nfllwr').text(response[0][0]['cnt']);
        document.getElementById('flw-qt').innerHTML='Follow';
        $('#flw-qt').attr('data-follow',unFollowing);
        $('#flw-qt').removeClass('btn-primary');
        $('#flw-qt').removeClass('fllwing');
        $('#flw-qt').addClass('btn-default');
    });
});

$('.usrflw-16516').click(function(){
    var el=this;
    if($(el).hasClass('nt-follow')){
        var isFollowing=$(this).attr('data-follow'),
            token=$('#token56165').val(),
            follow=toFollow(isFollowing,'follow',token);
        follow.done(function(response){
            $(el).removeClass('nt-follow');
            $(el).removeClass('light-red');
            $(el).addClass('darkred');
            $(el).html('<i class="ion-checkmark"></i>');
        });
    }else{
        var unFollowing=$(this).attr('data-follow'),
            token=$('#token56165').val(),
            unfollow=toFollow(unFollowing,'unfollow',token);
        unfollow.done(function(response){
            $(el).removeClass('darkred');
            $(el).addClass('light-red nt-follow');
            $(el).html('<i class="ion-person-add"></i>');
        });
    }
});