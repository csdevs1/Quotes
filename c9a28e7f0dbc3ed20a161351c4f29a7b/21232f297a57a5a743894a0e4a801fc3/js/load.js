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
    $("#quotes-area").load("language/quotes-spa.php",{msg:msg});
}
function portuguese(msg="",el) {
    $('.lang-nav li').not(el).removeClass('active');
    $('.has-submenu').not('#quote-menu').removeClass('active');
    $(el).addClass('active');
    document.getElementById("quotes-area").innerHTML="";
    $("#quotes-area").load("language/quotes-pt.php",{msg:msg});
}
function quotesTranslation(id) {
    document.getElementById("quotes-area").innerHTML="";
    $("#quotes-area").load("language/quotes-translation.php",{id:id});
}
function authors(msg="",el) {
    $('.lang-nav li').not(el).removeClass('active');
    $('.has-submenu').not(el).removeClass('active');
    $(el).addClass('active');
    document.getElementById("quotes-area").innerHTML="";
    $("#quotes-area").load("content/authors.php",{msg:msg});
}
function topics(msg="",el) {
    $('.lang-nav li').not(el).removeClass('active');
    $('.has-submenu').not('#topics-menu').removeClass('active');
    $(el).addClass('active');
    document.getElementById("quotes-area").innerHTML="";
    $("#quotes-area").load("content/topics.php",{msg:msg});
}
function topicsPT(msg="",el) {
    $('.lang-nav li').not(el).removeClass('active');
    $('.has-submenu').not('#topics-menu').removeClass('active');
    $(el).addClass('active');
    document.getElementById("quotes-area").innerHTML="";
    $("#quotes-area").load("content/topics-pt.php",{msg:msg});
}
function topicsES(msg="",el) {
    $('.lang-nav li').not(el).removeClass('active');
    $('.has-submenu').not('#topics-menu').removeClass('active');
    $(el).addClass('active');
    document.getElementById("quotes-area").innerHTML="";
    $("#quotes-area").load("content/topics-spa.php",{msg:msg});
}
function topicsTranslation(id) {
    document.getElementById("quotes-area").innerHTML="";
    $("#quotes-area").load("content/topicsTranslation.php",{id:id});
}
$(document).ready(function(){
    english('','#eng');
});