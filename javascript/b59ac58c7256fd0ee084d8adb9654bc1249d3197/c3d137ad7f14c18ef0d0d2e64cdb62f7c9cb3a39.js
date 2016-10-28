// LIKE SYSTEM

var likeQuote=function(quoteID,action){
    var formData = new FormData();
    formData.append("quoteID", quoteID);
    formData.append("action", action);
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType:  false,
        data: formData,
        url: '/quotes/fc4a695f02a8a53a129dcb9ace91e91ee1e7feb9/c3f5f65ee96aaa8376f9d1647b843329262a12d0',
        async:false
    });
}

$('.qtLikeLink').click(function(){
    var el=this;
    var quoteID=$(this).attr('data-qtlike');
    if($(el).hasClass('qtDislikeLink')){
        var disliked=likeQuote(quoteID,'dislikeQT');
        disliked.done(function(response){
            console.log(response);
            el.previousElementSibling.innerHTML = response[0][0]['cnt'];
            $(el).removeClass('qtDislikeLink');
            $(el).removeClass('liked');
            el.innerHTML = "Like";
        });
    } else{
        var liked=likeQuote(quoteID,'likeQT');
        liked.done(function(response){
            console.log(response);
            el.previousElementSibling.innerHTML = response[0][0]['cnt'];
            el.innerHTML = "Liked <span class='glyphicon glyphicon-heart liked'></span>";
            $(el).addClass('liked qtDislikeLink');
        });
    }
});