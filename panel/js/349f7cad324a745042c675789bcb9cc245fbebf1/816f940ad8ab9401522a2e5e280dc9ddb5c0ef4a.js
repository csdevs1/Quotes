//save quote

var saveQuote=function(arr,token){
    var formData = new FormData();
    formData.append("arr", JSON.stringify(arr));
    formData.append("uID", token);
    formData.append("action", 'save');
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType:  false,
        data: formData,
        url: '/quotes/a36a5ffa6e0dcfb64fac1b2b3d6fb176de9689de/03158f8543bd7d64c672b2fdfe38668a653487f0',
        async:false
    });
}

$("#image").on("change", function(){
    var imgType = $(this).prop('files')[0].type;
    if(imgType.split('/')[0] == 'image'){
        // Name of file and placeholder
        var file = this.files[0].name;
        var dflt = $(this).attr("placeholder");
        if($(this).val()!=""){
            $(this).next().text(file);
        } else {
            $(this).next().text(dflt);
        }
    } else {
        document.getElementById("image").value = "";
        $(this).next().text("Oops! that's not an image!");
    }
});

function quotePanel() {
    document.getElementById("q-contItem").innerHTML="";
    $("#q-contItem").load("/quotes/panel/layouts/quotes.php");
}

$('#pq_qts').click(function(){
    var el=this;
    el.innerHTML='<div class="la-ball-fall"><div></div><div></div><div></div></div>';
    $(el).attr('disabled','disabled');
    var author=$('#authorN').val(),
        quote=$('#quoteI').val(),
        keywords=$('#keywords').val(),
        u_id=$('#token').val(),
        n_keywords=keywords.split(',');
        arr={};
    if(quote!='' && keywords!='' && n_keywords.length <= 5){
        arr['quote']=quote;
        arr['keywords']=keywords;
        if(author!='')
            arr['author']=author;
        if($('#image').val() && $('#image').val() !=''){
            var image=$('#image').prop('files')[0];
            var upimg=toImgur(image);
            upimg.done(function(response){
                var url=response.data.link.replace('http','https');
                arr['quoteImage']=url;
                var save = saveQuote(arr,u_id);
                save.done(function(data){
                    if(response){
                        document.getElementById('nQuotes').innerHTML=document.getElementById('nQuotes').innerHTML+1;
                        el.innerHTML='Save';
                        $(el).removeAttr('disabled');
                        $('#authorN').val('');
                        $('#quoteI').val('');
                        $('#image').val('');
                        $('#image').next().text('Upload an Image');
                        $('#keywords').tagsinput('removeAll');
                        quotePanel();
                        closeWindow();
                    }
                });
            });
        }else{
            var save = saveQuote(arr,u_id);
            save.done(function(response){
                if(response){
                    var num=parseInt(document.getElementById('nQuotes').innerHTML);
                    document.getElementById('nQuotes').innerHTML=num+1;
                    el.innerHTML='Save';
                    $(el).removeAttr('disabled');
                    $('#quoteI').val('');
                    $('#authorN').val('');
                    quotePanel();
                    closeWindow();
                }
            });
        }
    }else{
        el.innerHTML='Save';
        $(el).removeAttr('disabled');
    }
});