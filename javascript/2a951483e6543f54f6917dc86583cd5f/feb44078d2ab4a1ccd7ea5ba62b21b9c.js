//SAVE TO IMAGE COLLECTION
var saveToCollection = function(arr){
    var formData = new FormData();
    formData.append("arr", JSON.stringify(arr));
    formData.append("action", 'save');
    //formData.append("token", token);
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType:  false,
        data: formData,
        url: '/6c56037e24fc0902ac2481df5583edcc/1882f952ad7b6f9bdeaa6584bc352f56',
        async:false
    });
}

$("#clc-usr").click(function(){
    if($('#copyURL').val()!=''){
        var arr={};
        arr['url']=$('#copyURL').val();
        arr['title']=$('#title').val();
        var saveImage=saveToCollection(arr);
        saveImage.done(function(response){
            if(response[0]){
                swal({title:"This image has been saved in <a href='/panel/collection/"+response['user']+"'>Your Collection</a>",html: true});
            }
        });
    }
});