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