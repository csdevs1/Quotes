// Image Collection
function delete_image(val,row){
    var formData = new FormData();
    formData.append("val", val);
    formData.append("row", row);
    formData.append("action", 'delete');
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType:  false,
        data: formData,
        url: '/6c56037e24fc0902ac2481df5583edcc/1882f952ad7b6f9bdeaa6584bc352f56'
    });
}

$('.delete-img').click(function(){
    var el=this,
        imgId=$(this).attr('data-img');
    swal({title: "Are you sure?",text: "You're about to remove this image",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!",   closeOnConfirm: true }, function(){
            var del=delete_image(imgId,'id');
        del.done(function(r){
            console.log(r);
            el.parentNode.parentNode.removeChild(el.parentNode);
        });
    });
});