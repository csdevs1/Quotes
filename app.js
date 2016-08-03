$('.isotope-wrapper').each(function(){
    var $isotope = $('.isotope-box', this);
    $('#filters .filter').click(function() {
        var rel = $(this).attr('rel');
        $isotope.isotope( {filter: rel});
    });
});

$(document).ready(function(){
    var $container = $('.masonry-container');
    $container.masonry({
        columnWidth: '.item',
        itemSelector: '.item'
    });
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