'use strict'
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
      alert(document.getElementById("input-search").value);
    }
});
/**/


$(document).ready(function(){
    $('.modal-body').validator();
    var $container = $('.masonry-container');
    $container.masonry({
        columnWidth: '.item',
        itemSelector: '.item'
    });
    
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

/* Remove this function when coding the real upvoting system*/
var val=true;
var count = 0;
function myFunction(el) {
    val ? count++:count--;
    val ? el.innerHTML = "Liked <span class='heart'>	&#9829;</span>":el.innerHTML = "Like";
    val ? el.setAttribute('class', 'liked'):el.setAttribute('class', 'like');
    el.previousElementSibling.innerHTML = count;
    val=!val;
}
