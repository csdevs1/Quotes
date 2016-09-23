var all = function(){
    return $.ajax({
        type: 'POST',
        dataType: 'json',
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

var generateToken = function(){
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '../../AppClasses/GenerateToken.php',
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