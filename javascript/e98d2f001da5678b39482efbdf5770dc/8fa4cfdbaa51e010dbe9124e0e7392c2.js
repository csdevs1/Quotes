// Report JS
var reportQuote = function(id,msg,t){
    var formData = new FormData();
    formData.append("id", id);
    formData.append("msg", msg);
    formData.append("t", t);
    formData.append("action", 'report');
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType:  false,
        data: formData,
        url: '/quotes/9ec32af426fcca6983f23e74d69a93df/06488b7665cdb7f944afb98298a2a276'
    });
}

var $qID
$('._rp').click(function(){
    $qID=this.getAttribute("data-qt");
});

$('#_report-it').click(function(){
    var t=$( "input:radio[name=optradio]:checked" ).val(),
        msg=$('.report-text').val();
    var reported=reportQuote($qID,msg,t);
    $(this).attr('disabled','disabled');
    reported.done(function(response){
        $('#_report-it').removeAttr('disabled');
        if(response){
            $('.report-text').val('');
            swal("Your message has been sent!");
        }
    });    
});
