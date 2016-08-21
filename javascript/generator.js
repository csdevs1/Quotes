$(document).ready(function() {
    var text_max = 150;
    $('#textarea_feedback').html('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ( ' + text_max + ' characters left)');
    $('#textarea').keyup(function() {
        var text_length = $('#textarea').val().length;
        var text_remaining = text_max - text_length;
        $('#textarea_feedback').html('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ( ' + text_remaining + ' characters left)');
    });
    //REFACTOR FUNCTION BELOW
    $('#fonts').click(function() {
        $('.sub-panel').not($("#font-style")).hide();
        $("#font-style").toggle("slide");
        $('.panel-main li').removeClass('active');
        $(this).addClass('active');
    });
    $('#gallery').click(function() {
        $('.sub-panel').not($("#from-gallery")).hide();    
        $("#from-gallery").toggle("slide");
        $('.panel-main li').removeClass('active');    
        $(this).addClass('active');
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

$("#img-file").on("change", function(){
    // Name of file and placeholder
    var file = this.files[0].name;
    var dflt = $(this).attr("placeholder");
    if($(this).val()!=""){
        $(this).next().text(file);
    } else {
        $(this).next().text(dflt);
    }
});