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
        window.myImage = new Image();
        window.myImage.src = imageUrl;
        // End of new content
        
        //displayEditor();
    },
    closeWindow:function(){ //Close Quote textarea
        document.getElementById('textarea-box').style.display="none";
        //displayEditor();
    },
    openWindow:function(){ // Open Quote textarea
        document.getElementById('textarea-box').style.display="block";
        //displayEditor();
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
        //displayEditor();
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
        //displayEditor();
    },
    changeFontSize: function(el,size){
        $('#text').css('font-size', size+"px");
        //displayEditor();
    },
    textShadow: function(){
        var x= document.getElementById('shadow-x').value+'px';
        var y= document.getElementById('shadow-y').value+'px';
        var blur = document.getElementById('shadow-blur').value+'px';
        var color = document.getElementById('shadow-color').value;
        $('#text').css('text-shadow', x+' '+ y + ' ' + blur + ' '+ color);
        //displayEditor();
    },
    changeJustification: function(el,just){
        $('#text').css('text-align', just);
        //displayEditor();
    },
    /*imageEffect:function(){
        var img=window.myImage,
            blur=document.getElementById('bgBlur').value,
            greyscale=document.getElementById('bgGrey').value;
        $('#blur-scale').text(blur+'%');
        $('#grey-scale').text(greyscale+'%');
        document.getElementById('quote-img').src=effects(img,blur,greyscale);
    },*/
    imageEffect:function(){
        var img=window.myImage,
            blur=document.getElementById('bgBlur').value,
            greyscale=document.getElementById('bgGrey').value;
        $('#blur-scale').text(blur+'%');
        $('#grey-scale').text(greyscale+'%');
        $('#quote-img').css('-webkit-filter','grayscale('+greyscale+'%) blur('+blur+'px)',
                         'filter','grayscale('+greyscale+'%) blur('+blur+'px)');
    },
    panelSlide: function(id) {
        $('.sub-panel').not($(id)).hide();
        $(id).toggle("slide");
        if($("#from-gallery").css('display')=='block')
            $("#from-gallery").toggle("slide");
    }
}

function effects(imgObj,blur,grey) {
    var canvas = document.createElement('canvas');
    var canvasContext = canvas.getContext('2d');
  
    var imgW = imgObj.width;
    var imgH = imgObj.height;
    canvas.width = imgW;
    canvas.height = imgH;
    canvasContext.filter = "blur("+blur+"px) grayscale("+grey+"%)";
  
    canvasContext.drawImage(imgObj, 0, 0,imgW,imgH);
  
    return canvas.toDataURL();
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
    $('#generated').css('visibility','hidden');
    $('#water-mark').css('display', 'none');
    //Generate Image    
    $('#generate').click(function(){
        // APPLY EFFECTS
        var imageUrl = URL.createObjectURL(document.getElementById('img-file').files[0]);
        var img=window.myImage,
            blur=document.getElementById('bgBlur').value,
            greyscale=document.getElementById('bgGrey').value;
        document.getElementById('quote-img').src=effects(img,blur,greyscale);
        // APPLY EFFECTS
        
        html2canvas($("#quote-container"), {
            allowTaint: true,
            onrendered: function(canvas) {
                document.getElementById('generated').innerHTML="";
                $('#generated').prepend(canvas);
                var dataURL = canvas.toDataURL();
                canvas.id = "image-canvas";
                $('.processing').css('display','block');
                uploadImage(this);
                //hideEditor();
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

/*document.getElementById("textarea").addEventListener("keyup", function(event) {
    event.preventDefault();
    if (event.keyCode == 13) {
        document.getElementById("textarea").value+="<br>";
    }
});*/

var uploadImage = function(el){
    $(el).attr('disabled','disabled');
    // Conver canvas to be uploaded
    var canvas = document.getElementById('image-canvas');
    var dataURL = canvas.toDataURL();
    var blobBin = atob(dataURL.split(',')[1]);
    var array = [];
    for(var i = 0; i < blobBin.length; i++) {
        array.push(blobBin.charCodeAt(i));
    }
    if($('#img-file').val()!=''){
        var ext = $('#img-file').prop('files')[0].name.split('.').pop();
        var file=new Blob([new Uint8Array(array)], {type: 'image/'+ext});
    } else{
        var file=new Blob([new Uint8Array(array)], {type: 'image/png'});
    }
    //console.log(ext);
    var response = toImgur(file);
    response.done(function(response){
        $('.copy-form').css('display','inline-block');
        $('.download a').css('display','inline-block');
        $('#update').removeAttr('disabled');
        $('.processing').css('display','none');
        console.log(response.data.link);
        $('#copyURL').val(response.data.link);
        $('.download a').attr('href',response.data.link);
         $("#copyURL").focus();
    });
}

var toImgur = function(file){
    var formData = new FormData();
    formData.append("image", file);
    
    return $.ajax({
        url: "https://api.imgur.com/3/image",
        type: "POST",
        datatype: "json",
        headers: {
            "Authorization": "Client-ID 4571ccbf369395f",
            Accept: 'application/json'
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

// Copy Generated URL to clipboard
var clickToCopy = function(el) {
    copyToClipboard(document.getElementById("copyURL"));
    $(el).addClass('clicked-btn');
    setTimeout(function() {
        $(el).removeClass('clicked-btn');
    }, 1000);
}

function copyToClipboard(elem) {
	  // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    // copy the selection
    var succeed;
    try {
    	  succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }
    
    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
}

navigator.sayswho= (function(){
    var ua= navigator.userAgent, tem, 
    M= ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
    if(/trident/i.test(M[1])){
        tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
        return 'IE '+(tem[1] || '');
    }
    if(M[1]=== 'Chrome'){
        tem= ua.match(/\b(OPR|Edge)\/(\d+)/);
        if(tem!= null) return tem.slice(1).join(' ').replace('OPR', 'Opera');
    }
    M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
    if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
    return M.join(' ');
})();

var browser=navigator.sayswho;
if((browser.split(' ')[0]!='Chrome' && browser.split(' ')[1]<52) || (browser.split(' ')[0]=='Firefox' && browser.split(' ')[1]>=49)){$('#effects-body').html('Your browser doesn\'t support Effects');}