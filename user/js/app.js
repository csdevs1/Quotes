$(document).ready(function(){
    var $container = $('.masonry-container');
    $container.masonry({
        columnWidth: '.item',
        itemSelector: '.item'
    });
});

var closeWindow=function(){
    document.getElementById('textarea-box').style.display="none";
}
var openWindow=function(){
    document.getElementById('textarea-box').style.display="block";
}