//CHANGE BANNER AND PROFILE PICTURE

var toImgur = function(file){
    var formData = new FormData();
    formData.append("image", file);
    return $.ajax({
        url: "https://api.imgur.com/3/image",
        type: "POST",
        datatype: "json",
        headers: {
            "Authorization": "Client-ID 4571ccbf369395f",
            Accept: 'application/json'
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

var updateImg = function(col,val){
    var formData = new FormData();
    formData.append("col", col);
    formData.append("val", val);
    formData.append("action", 'update');
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

function preview(el,id){
    var elmnt=document.getElementById(id),
        img=URL.createObjectURL(el.files[0]),
        file=$(el).prop('files')[0];
    if(elmnt.nodeName=='IMG')
        document.getElementById(id).src = img;
    else{
        elmnt.style.backgroundImage = "url('"+img+"')";
    }
    
    swal({
        title: "Update image",
        text: "Are you sure you want to change set this image?",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    },
         function(isConfirm){
        if (isConfirm) {
            var uplImg=toImgur(file);
            uplImg.done(function(response){
                var url=response.data.link.replace('http','https'),
                    col=id.split('-');
                var update=updateImg(col[0],url);
                update.done(function(data){
                    if(data){
                        swal("Image updated correctly!");
                    }else{
                        swal("Error", "There's been an error, try again later!", "error");
                    }
                });
            });
        } else {
            //swal("Cancelled", "Your imaginary file is safe :)", "error");
        }
    });
}