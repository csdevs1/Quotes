/***********************/
var closeWindow=function(){
    $('#quote-form').hide(500);
    document.getElementById('add-quote').style.display='block';
    // Change dynamically for every language
    $('.up-label').html('Upload an Image');
    $('#save').attr('onclick','save(this)');
    document.getElementById('save').innerHTML="Save";
}
var openWindow=function(el){
    $('#quote-form').show(500);
    el.style.display='none';
}
/**********************/


var all = function(table){
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {table:table,action:'all'},
        url: 'Classes/GlobalController.php'
    });
}

var find_by = function(table,row,val){
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {table:table,row:row,val:val,action:'find_by'},
        url: 'Classes/GlobalController.php',
        async:false
    });
}

function limit(table,column,order,limit){
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {table:table,column:column,limit:limit,order:order,action:'limit'},
        url: 'Classes/GlobalController.php'
    });
}

function like(table,col,pattern){
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {table:table,column:col,pattern:pattern,action:'like'},
        url: 'Classes/GlobalController.php'
    });
}

var insert = function(table,data,token,image=''){
    var formData = new FormData();
    formData.append("data", JSON.stringify(data));
    formData.append("table", table);
    formData.append("action", 'insert');
    formData.append("token", token);
    if(image!=''){
        formData.append("image", image);
    }
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType:  false,
        data: formData,
        url: 'Classes/GlobalController.php',
        async:false
    });
}

var insertLog = function(table,data,action){
    var formData = new FormData();
    formData.append("data", JSON.stringify(data));
    formData.append("table", table);
    formData.append("action", action);
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType:  false,
        data: formData,
        url: 'Classes/LogController.php',
        async:false
    });
}

var signup = function(table,data,token){
    var formData = new FormData();
    formData.append("data", JSON.stringify(data));
    formData.append("table", table);
    formData.append("action", 'signup');
    formData.append("token", token);
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType:  false,
        data: formData,
        url: 'Classes/SignUp.php',
        async:false
    });
}

var update = function(table,arr,row,id,token,image=''){
    var formData = new FormData();
    formData.append("data", JSON.stringify(arr));
    formData.append("table", table);
    formData.append("row", row);
    formData.append("id", id);
    formData.append("action", 'update');
    formData.append("token", token);
    if(image!=''){
        formData.append("image", image);
    }
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType:  false,
        data: formData,
        url: 'Classes/GlobalController.php',
        async:false
    });
}

var delete_function = function(table,row,val,token){
    var formData = new FormData();
    formData.append("table", table);
    formData.append("row", row);
    formData.append("val", val);
    formData.append("token", token);
    formData.append("action", 'delete');
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType:  false,
        data: formData,
        url: 'Classes/GlobalController.php',
        async:false
    });
}

function search(table,column,text,id,action){
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {table:table,col:column,text:text,id:id,action:action},
        url: 'Classes/SearchController.php'
    });
}

var generateToken = function(){
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'Classes/GenerateToken.php',
        async:false
    });
}

function imgur_upload(image_file) {
    var formData = new FormData();
    formData.append("image", image_file);
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