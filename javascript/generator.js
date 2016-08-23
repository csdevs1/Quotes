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
    changeText: function(el){
        var text = el.value;
        document.getElementById('text').innerHTML=text;
        //displayEditor();
    },
    changeColor: function(el){
        var color = el.value;
        $('#text').css('color', color);
        //displayEditor();
    },
    changeFont: function(el){
        var font = el.value;
        $('#text').css('font-family', font);
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
    }
}

$(document).ready(function() {
    $('#water-mark').css('display', 'none');
    var text_max = 150;
    $('#textarea_feedback').html('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ( ' + text_max + ' characters left)');
    $('#textarea').keyup(function() {
        var text_length = $('#textarea').val().length;
        var text_remaining = text_max - text_length;
        $('#textarea_feedback').html('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ( ' + text_remaining + ' characters left)');
    });
    //REFACTOR FUNCTION BELOW
    
    $('#background').click(function() {
        $('.sub-panel').not($("#background-section")).hide();
        $("#background-section").toggle("slide");
        if($("#from-gallery").css('display')=='block')
            $("#from-gallery").toggle("slide");
    });
    
    $('#fonts').click(function() {
        $('.sub-panel').not($("#font-style")).hide();
        $("#font-style").toggle("slide");
    });
    
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

document.getElementById("textarea") // Adds line breaks on enter
    .addEventListener("keyup", function(event) {
    event.preventDefault();
    if (event.keyCode == 13) {
        document.getElementById("textarea").value+="<br>";
    }
});