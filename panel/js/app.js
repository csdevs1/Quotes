$(document).ready(function(){
    var $container = $('.masonry-container');
    $container.masonry({
        columnWidth: '.item',
        itemSelector: '.item'
    });
});

var closeWindow=function(){
    $('#quote-form').hide(500);
    document.getElementById('add-quote').style.display='block';
}
var openWindow=function(el){
    $('#quote-form').show(500);
    el.style.display='none';
}