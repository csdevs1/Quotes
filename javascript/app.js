'use strict'

// JUST FOR FUN
var css = "text-shadow: -1px 1px 5px #555;color:red;font-size:1.5rem;";
var css2 = "text-shadow: -1px 1px 5px #888;color:#000;font-size:1rem;";
var css3 = "border: 2px solid #fff;border-radius: 25px;padding:20px;background:rgba(0,0,0,0.8);color:#fff;font-size:1rem;";
var css4 = "color:#000;font-size:0.8rem;background-color:#555;color:#eee;padding:5px;";

console.log("%cHey bro!%s", css, ' Welcome to PortalQuote');
console.log("%cCheck out my site at:", css2);
console.log("\n");
console.log('%cgabrielpinangoresume.com.ve',css3);
console.log("\n\n");
console.log("%cOr I can take you there if you type:%s", css4, ' take_me();');

var take_me = function(){
	var win = window.open('https://gabrielpinangoresume.com.ve', '_blank');
    win.focus();
}
// END OF JOY

$('.isotope-wrapper').each(function(){
    var $isotope = $('.isotope-box', this);
    $('#filters .filter').click(function() {
        var rel = $(this).attr('rel');
        $isotope.isotope( {filter: rel});
    });
});

/*SEARCH BOX*/
function showSearch(el){
    document.getElementById('search-box').style.display="block";
    document.getElementById("input-search").focus();
}
function closeSearch(el){
    document.getElementById('search-box').style.display="none";
}

document.getElementById("input-search").addEventListener("keyup", function(event) {
    event.preventDefault();
    if (event.keyCode == 13) {
        var t=$('input[name=search]:checked').val(),
            q=$('#input-search').val();
        var url='/quotes/search/'+t+'/'+escape(q)+'/1';
        window.location=url;
    }
});
$('#search-btn').click(function(){
    var t=$('input[name=search]:checked').val(),
        q=$('#input-search').val();
    var url='/quotes/search/'+t+'/'+escape(q)+'/1';
    window.location=url;
});
/**/

$(document).ready(function(){
    /*var $container = $('.masonry-container');
    $container.masonry({
        columnWidth: '.item',
        itemSelector: '.item'
    });*/
    var $container = $('.masonry-container');
    $container.imagesLoaded( function() {
        $container.masonry({
            columnWidth: '.item',
            itemSelector: '.item'
        });
    });    
    $('.modal-body').validator();

    $('#arrow').on('click', function(event){
        $('#banner').removeClass('current');
        $('#popular-topics').addClass('current');
        event.preventDefault();
        smoothScroll($(this.hash));
    });
    
    function smoothScroll(target) {
        $('body,html').animate(
            {'scrollTop':target.offset().top},
            600
        );
    }
});
$(window).load(function() {
    $(this).resize();
});
/*
"use strict";function showSearch(e){document.getElementById("search-box").style.display="block",document.getElementById("input-search").focus()}function closeSearch(e){document.getElementById("search-box").style.display="none"}var css="text-shadow: -1px 1px 5px #555;color:red;font-size:1.5rem;",css2="text-shadow: -1px 1px 5px #888;color:#000;font-size:1rem;",css3="border: 2px solid #fff;border-radius: 25px;padding:20px;background:rgba(0,0,0,0.8);color:#fff;font-size:1rem;",css4="color:#000;font-size:0.8rem;background-color:#555;color:#eee;padding:5px;";console.log("%cHey bro!%s",css," Welcome to PortalQuote"),console.log("%cCheck out my site at:",css2),console.log("\n"),console.log("%cgabrielpinangoresume.com.ve",css3),console.log("\n\n"),console.log("%cOr I can take you there if you type:%s",css4," take_me();");var take_me=function(){var e=window.open("https://gabrielpinangoresume.com.ve","_blank");e.focus()};$(".isotope-wrapper").each(function(){var e=$(".isotope-box",this);$("#filters .filter").click(function(){var o=$(this).attr("rel");e.isotope({filter:o})})}),document.getElementById("input-search").addEventListener("keyup",function(e){if(e.preventDefault(),13==e.keyCode){var o=$("input[name=search]:checked").val(),t=$("#input-search").val(),n="/search/"+o+"/"+escape(t)+"/1";window.location=n}}),$("#search-btn").click(function(){var e=$("input[name=search]:checked").val(),o=$("#input-search").val(),t="/search/"+e+"/"+escape(o)+"/1";window.location=t}),$(document).ready(function(){function e(e){$("body,html").animate({scrollTop:e.offset().top},600)}var o=$(".masonry-container");o.masonry({columnWidth:".item",itemSelector:".item"}),$(".modal-body").validator(),$("#arrow").on("click",function(o){$("#banner").removeClass("current"),$("#popular-topics").addClass("current"),o.preventDefault(),e($(this.hash))})}),function(e){e(window).load(function(){e(this).trigger("resize")})}(jQuery);*/