function english(el,nPage,dataARR="") {
    $('.lang-nav li').not(el).removeClass('active');
    $('.has-submenu').not('#quote-menu').removeClass('active');
    $(el).addClass('active');
    document.getElementById("quotes-area").innerHTML="";
    $("#quotes-area").load("language/quotes-en.php",{page:nPage,dataARR:dataARR});
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

function myQuotes(el,nPage) {
    $('.lang-nav li').not(el).removeClass('active');
    $('.has-submenu').not('#quote-menu').removeClass('active');
    $(el).addClass('active');
    document.getElementById("quotes-area").innerHTML="";
    $("#quotes-area").load("language/quotesUser.php",{page:nPage});
}

function authors(el,nPage,dataARR="") {
    $('.lang-nav li').not(el).removeClass('active');
    $('.has-submenu').not(el).removeClass('active');
    $(el).addClass('active');
    document.getElementById("quotes-area").innerHTML="";
    $("#quotes-area").load("content/authors.php",{page:nPage,dataARR:dataARR});
}
/*AUTHORS*/
    function uncompletedAuthors(el) {
        $('.lang-nav li').not(el).removeClass('active');
        $('.has-submenu').not(el).removeClass('active');
        $(el).addClass('active');
        document.getElementById("quotes-area").innerHTML="";
        $("#quotes-area").load("content/uncompletedAuthors.php");
    }
    function completedAuthors(el) {
        $('.lang-nav li').not(el).removeClass('active');
        $('.has-submenu').not(el).removeClass('active');
        $(el).addClass('active');
        document.getElementById("quotes-area").innerHTML="";
        $("#quotes-area").load("content/completedAuthors.php");
    }
    function myAuthors(el,nPage) {
        $('.lang-nav li').not(el).removeClass('active');
        $('.has-submenu').not(el).removeClass('active');
        $(el).addClass('active');
        document.getElementById("quotes-area").innerHTML="";
        $("#quotes-area").load("content/authorsUser.php",{page:nPage});
    }

    function authorsTranslation(id) {
        document.getElementById("quotes-area").innerHTML="";
        $("#quotes-area").load("content/authorTranslate.php",{id:id});
    }
    function professionsLoad(el,dataARR="") {
        $('.lang-nav li').not(el).removeClass('active');
        $('.has-submenu').not(el).removeClass('active');
        $(el).addClass('active');
        document.getElementById("quotes-area").innerHTML="";
        $("#quotes-area").load("content/professions.php",{dataARR:dataARR});
    }
/*AUTHORS*/
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

/*USERS*/
    function users(el) {
        $(el).addClass('active');
        document.getElementById("quotes-area").innerHTML="";
        $("#quotes-area").load("content/Users.php");
    }
    function usrDetails(id) {
        document.getElementById("quotes-area").innerHTML="";
        $("#quotes-area").load("content/usrDetails.php",{id:id});
    }function usrSettings(id) {
        document.getElementById("quotes-area").innerHTML="";
        $("#quotes-area").load("content/usrSettings.php",{id:id});
    }
    function userProfile(el,id) {
        $('.has-submenu').not(el).removeClass('active');
        $(el).addClass('active');
        document.getElementById("quotes-area").innerHTML="";
        $("#quotes-area").load("content/usrDetails.php",{id:id});
    }
    function addUser(msg,el) {
        $(el).addClass('active');
        document.getElementById("quotes-area").innerHTML="";
        $("#quotes-area").load("content/addUser.php");
    }
/*USERS*/

function reports(el) {
    $('.has-submenu').not(el).removeClass('active');
    $(el).addClass('active');
    document.getElementById("quotes-area").innerHTML="";
    $("#quotes-area").load("content/reports-area.php");
}

$(document).ready(function(){
    english('#eng');
});