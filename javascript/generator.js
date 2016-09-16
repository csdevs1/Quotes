var generator = {
    preview: function(el){
        /*var file = el.files[0].name;
        var dflt = $(el).attr("placeholder");
        alert(dflt);
        if($(el).val()!=""){
        $(el).next().text(file);
        } else {
        $(el).next().text(dflt);
        }*/
        
        var imageUrl = URL.createObjectURL(el.files[0]);
        //New content
        $('#quote-img').remove();
        $('#water-mark').css('display', 'block');
        $('#water-mark').addClass('water-mark');
        $('#quote-container').append('<img src="'+imageUrl+'" id="quote-img" class="img-responsive">');
        // End of new content
        
        //displayEditor();
    },
    closeWindow:function(){ //Close Quote textarea
        document.getElementById('textarea-box').style.display="none";
    },
    openWindow:function(){ // Open Quote textarea
        document.getElementById('textarea-box').style.display="block";
    },
    changeImage: function(el){
        var imageSrc = el.src;
        $('#quote-img').remove();
        $('#water-mark').css('display', 'block');
        $('#water-mark').addClass('water-mark');
        $('#quote-container').append('<img src="'+imageSrc+'" id="quote-img" class="img-responsive">');
    },
    changeText: function(el){
        var text = el.value;
        document.getElementById('text').innerHTML=text;
        //displayEditor();
    },
    changeColor: function(el,id,cssAttr){
        var color = el.value;
        $(id).css(cssAttr, color);
        //displayEditor();
    },
    changeFont: function(el,alternFont){
        var font = el.innerHTML;
        $('#text').css('font-family', "'"+font+"',"+alternFont+"");
        // displayEditor();
    },
    changeFontSize: function(el){
        var size= el.value;
        $('#text').css('font-size', size+"px");
        //displayEditor();
    },
    changeJustification: function(el){
        var just= el.value;
        $('#text').css('text-align', just);
        //displayEditor();
    },
    panelSlide: function(id) {
        $('.sub-panel').not($(id)).hide();
        $(id).toggle("slide");
        if($("#from-gallery").css('display')=='block')
            $("#from-gallery").toggle("slide");
    }
}

$(document).ready(function() {
    $('#water-mark').css('display', 'none');
    //Draggable element
    $("#text").draggable({scroll: false});
    
    $('#gallery').click(function() {
        $("#from-gallery").toggle("slide");
        $('.responsive').resize();
    });
  
  // CAROUSEL
    $('.responsive').slick({
        dots: false,
        infinite: true,
        autoplay: false,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true,
        responsive: [{
            breakpoint: 800,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 2,
                infinite: true
            }
        }, {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                infinite: true
            }
        }, {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true
            }
        }]
    });
    
});

document.getElementById("textarea").addEventListener("keyup", function(event) {
    event.preventDefault();
    if (event.keyCode == 13) {
        document.getElementById("textarea").value+="<br>";
    }
});