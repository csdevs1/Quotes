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
        
        displayEditor();
    },
    closeWindow:function(){ //Close Quote textarea
        document.getElementById('textarea-box').style.display="none";
        displayEditor();
    },
    openWindow:function(){ // Open Quote textarea
        document.getElementById('textarea-box').style.display="block";
        displayEditor();
    },
    displayOptions:function(id){ // Open Quote textarea
        $('.popover').not($('#'+id)).hide();
        $('#'+id).slideToggle();
    },    
    changeImage: function(el){
        var imageSrc = el.src;
        $('#quote-img').remove();
        $('#water-mark').css('display', 'block');
        $('#water-mark').addClass('water-mark');
        $('#quote-container').append('<img src="'+imageSrc+'" id="quote-img" class="img-responsive">');
        displayEditor();
    },
    changeText: function(el){
        var text = el.value;
        document.getElementById('text').innerHTML=text;
        displayEditor();
    },
    changeColor: function(el,id,cssAttr){
        var color = el.value;
        $(id).css(cssAttr, color);
        displayEditor();
    },
    changeFont: function(el,alternFont){
        var font = el.innerHTML;
        $('#text').css('font-family', "'"+font+"',"+alternFont+"");
        displayEditor();
    },
    changeFontSize: function(el,size){
        $('#text').css('font-size', size+"px");
        displayEditor();
    },
    textShadow: function(){
        var x= document.getElementById('shadow-x').value+'px';
        var y= document.getElementById('shadow-y').value+'px';
        var blur = document.getElementById('shadow-blur').value+'px';
        var color = document.getElementById('shadow-color').value;
        $('#text').css('text-shadow', x+' '+ y + ' ' + blur + ' '+ color);
        displayEditor();
    },
    changeJustification: function(el,just){
        $('#text').css('text-align', just);
        displayEditor();
    },
    panelSlide: function(id) {
        $('.sub-panel').not($(id)).hide();
        $(id).toggle("slide");
        if($("#from-gallery").css('display')=='block')
            $("#from-gallery").toggle("slide");
    }
}

function displayEditor(){
    $('#quote-container').css('display','inline-block'); // Distplay Editor
    if($('#generated').css('display')=='inline-block'){ // Hide Image
        $('#generated').css('display','none');
    }
}

function hideEditor(){
  $('#quote-container').css('display','none'); //Hide Editor
  $('#generated').css('display','inline-block'); //Show image container
}

$(document).ready(function() {
    $('#water-mark').css('display', 'none');
    //Generate Image
    $('#generate').click(function(){
        html2canvas($("#quote-container"), {
            allowTaint: true,
            onrendered: function(canvas) {
                document.getElementById('generated').innerHTML="";
                $('#generated').prepend(canvas);
                var dataURL = canvas.toDataURL();
                canvas.id = "image-canvas";
                //console.log(dataURL);
                hideEditor();
            }
        });
    });  
    
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