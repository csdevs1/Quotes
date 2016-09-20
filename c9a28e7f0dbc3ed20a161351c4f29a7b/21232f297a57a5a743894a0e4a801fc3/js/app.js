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

var insert = function(table,data,token){
    var formData = new FormData();
    formData.append("data", JSON.stringify(data));
    formData.append("table", table);
    formData.append("action", 'insert');
    formData.append("token", token);
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