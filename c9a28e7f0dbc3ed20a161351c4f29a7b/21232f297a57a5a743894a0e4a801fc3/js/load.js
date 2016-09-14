function english(msg="",el) {
    $('.lang-nav li').not(el).removeClass('active');
    $(el).addClass('active');
    document.getElementById("quotes-area").innerHTML="";
    $("#quotes-area").load("language/quotes-en.html",{msg:msg});
}
function spanish(msg="",el) {
    $('.lang-nav li').not(el).removeClass('active');
    $(el).addClass('active');
    document.getElementById("quotes-area").innerHTML="";
    $("#quotes-area").load("language/quotes-spa.html",{msg:msg});
}
function portuguese(msg="",el) {
    $('.lang-nav li').not(el).removeClass('active');
    $(el).addClass('active');
    document.getElementById("quotes-area").innerHTML="";
    $("#quotes-area").load("language/quotes-pt.html",{msg:msg});
}
$(document).ready(function(){
    english('','#eng');
});