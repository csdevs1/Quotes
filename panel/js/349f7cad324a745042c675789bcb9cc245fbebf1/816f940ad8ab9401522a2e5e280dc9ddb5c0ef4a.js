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
        url: '/a36a5ffa6e0dcfb64fac1b2b3d6fb176de9689de/03158f8543bd7d64c672b2fdfe38668a653487f0',
        async:false
    });
}

var delete_function = function(arr,u_id){
    var formData = new FormData();
    formData.append("arr", JSON.stringify(arr));
    formData.append("uID", u_id);
    formData.append("action", 'delete');
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType:  false,
        data: formData,
        url: '/a36a5ffa6e0dcfb64fac1b2b3d6fb176de9689de/03158f8543bd7d64c672b2fdfe38668a653487f0'
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
    $("#q-contItem").load("/panel/layouts/quotes.php");
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
                var url=response.data.link;
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
                        //$('#keywords').tagsinput('removeAll');
                        //quotePanel();
                        location.reload();
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
                    //quotePanel();
                    location.reload();
                    closeWindow();
                }
            });
        }
    }else{
        el.innerHTML='Save';
        $(el).removeAttr('disabled');
    }
});

function del_quote(el,id){
    swal({title: "Are you sure?",text: "You're about to delete a quote!",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){
        var arr={},
            u_id=$('#token').val();
        arr['id']=id;
        deleted = delete_function(arr,u_id);
        deleted.done(function(response){
            console.log(response);
            //quotePanel();
            location.reload();
            swal("Deleted!", "Your quote has been deleted.", "success");
        });
    });
}