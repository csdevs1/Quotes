// Notifications FILE
var change_last_six=function(){
    var formData = new FormData();
    formData.append("action", 'last_six');
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType:  false,
        data: formData,
        url: '/quotes/00f6b23d0b02d36148b35cc4e65e0c51/ae540687e4c25bcd1546846e96a63790',
        async:false
    });
}

$('#notications').on("click", function() {
    var changeStatus=change_last_six();
    changeStatus.done(function(data){
        console.log(data);
        $('.badge.badge-sm.up.bg-pink.count').remove();
    });
});