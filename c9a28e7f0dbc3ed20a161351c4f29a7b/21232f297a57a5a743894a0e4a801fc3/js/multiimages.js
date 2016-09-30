function addTextBox(){    
    var x = document.createElement("INPUT"); //file
    var image = document.createElement("IMG");
    var i_Tag = document.createElement("I");
    var span = document.createElement("SPAN");
    var col = document.createElement("DIV");
    
    // div
    col.setAttribute("class", "form-group col-xs-12 col-sm-6 col-md-3 img-container");
    
    // Input file attributes
    x.setAttribute("type", "file");
    x.setAttribute("name", "images[]");
    x.setAttribute("class", "form-control img-file");
    x.setAttribute("aria-describedby","Image");
    x.setAttribute("accept","image/*");
    x.setAttribute("onchange","preview(this);changePlaceholder(this)");
    
    // Image
    image.setAttribute('src','images/placeholder.svg');
    image.setAttribute('class','img-responsive');
    
    // Span
    span.setAttribute('class','up-label');
    span.innerHTML='Upload an image';
    
    // I TAG
    i_Tag.setAttribute('class','ion-close-circled close');
    i_Tag.setAttribute('onclick','deleteField(this)');
    
    // Append elements to Col
    col.appendChild(i_Tag);
    col.appendChild(image);
    col.appendChild(x);
    col.appendChild(span);
    
    document.getElementById('image-box').appendChild(col);
}

function deleteField(e) {
    e.parentNode.parentNode.removeChild(e.parentNode);
}

function preview(el){
    el.previousElementSibling.src = URL.createObjectURL(el.files[0]);
}