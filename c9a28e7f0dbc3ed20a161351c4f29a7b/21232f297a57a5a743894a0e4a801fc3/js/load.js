function english(msg="",el) {
    $('.lang-nav li').not(el).removeClass('active');
    $('.has-submenu').not('#quote-menu').removeClass('active');
    $(el).addClass('active');
    document.getElementById("quotes-area").innerHTML="";
    $("#quotes-area").load("language/quotes-en.php",{msg:msg});
}
function spanish(msg="",el) {
    $('.lang-nav li').not(el).removeClass('active');
    $('.has-submenu').not('#quote-menu').removeClass('active');
    $(el).addClass('active');
    document.getElementById("quotes-area").innerHTML="";
    $("#quotes-area").load("language/quotes-spa.html",{msg:msg});
}
function portuguese(msg="",el) {
    $('.lang-nav li').not(el).removeClass('active');
    $('.has-submenu').not('#quote-menu').removeClass('active');
    $(el).addClass('active');
    document.getElementById("quotes-area").innerHTML="";
    $("#quotes-area").load("language/quotes-pt.html",{msg:msg});
}
function authors(msg="",el) {
    $('.lang-nav li').not(el).removeClass('active');
    $('.has-submenu').not(el).removeClass('active');
    $(el).addClass('active');
    document.getElementById("quotes-area").innerHTML="";
    $("#quotes-area").load("content/authors.html",{msg:msg});
}
$(document).ready(function(){
    english('','#eng');
});