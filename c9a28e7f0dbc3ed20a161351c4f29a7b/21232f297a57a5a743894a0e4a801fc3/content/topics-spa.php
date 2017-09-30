<?php
    session_start();
    require_once('../Classes/AppController.php');
    $obj = new AppController();
    $topics = $obj->all('topics_es');
?>

<div class="portlet-heading">
    <h3 class="portlet-title text-dark text-uppercase">
        Tema
    </h3>
    <div class="clearfix"></div>
<?php if(isset($_SESSION['label']) && !empty($_SESSION['label']) && $_SESSION['label'] =='root'){ //Permission to insert ?>
    <div class="col-lg-12 text-dark"><span id="add-quote" onclick="openWindow(this);closeUpdate()"><span class="glyphicon glyphicon-edit"></span> Agregar un nuevo tema</span></div>
<?php } ?>
</div>
<?php if(isset($_SESSION['label']) && !empty($_SESSION['label']) && $_SESSION['label'] =='root'){ //Permission to insert ?>
<div class="container quote-form" id="quote-form">
    <div class="row">
        <div class="col-xs-12 relative-container">
            <label onclick="closeWindow()"><span class="glyphicon glyphicon-remove"></span> Ocultar</label>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="topic" data-error="Field required" aria-describedby="topic" placeholder="Ingresa tema..."  oninput="checkAvailability(this)">
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="keywords" data-error="Field required" aria-describedby="topic" placeholder="Keywords separados por coma...">
                
            </div>
        </div>
        
        <!-- -->
        
        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-6">
                        <button type="button" class="btn btn-warning" onclick="addTextBox('image-box')"><span class="glyphicon glyphicon-plus"></span> Agregar nueva imagen</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12" id="image-box">
            </div>
        </div>
        <!-- -->
        <div class="form-group col-xs-12">
            <div class="input-group">
                <button type="button" class="btn btn-primary" onclick="save(this)">Guardar</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<!-- Update Form -->
<?php if(isset($_SESSION['permission'][1]) && !empty($_SESSION['permission'][1]) && isset($_SESSION['lang']) && !empty($_SESSION['lang']) && $_SESSION['label'] !='author' && $_SESSION['label'] !='image'){
    if($_SESSION['lang']=='es' || $_SESSION['lang']=='all'){ ?>
<div class="container quote-form" id="update-form">
    <div class="row">
        <div class="col-xs-12 relative-container">
            <label onclick="closeUpdate()"><span class="glyphicon glyphicon-remove"></span> Ocultar</label>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="topic-up" data-error="Field required" aria-describedby="topic" placeholder="Ingresa tema..."  oninput="checkAvailability(this)">
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="keywords-up" data-error="Field required" aria-describedby="topic" placeholder="Keywords separados por coma...">
                
            </div>
        </div>
        
        <!-- -->
        
        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-6">
                        <button type="button" class="btn btn-warning" onclick="addTextBox('image-box2')"><span class="glyphicon glyphicon-plus"></span> Agregar una nueva imagen</button>
                    </div>
                </div>
            </div>
        </div>
       <div class="row">
           <div class="col-xs-12" id="image-box2">
           </div>
        </div>
        <!-- -->
        <div class="form-group col-xs-12">
            <div class="input-group">
                <button type="button" class="btn btn-primary" id="update">Actualizar</button>
            </div>
        </div>
    </div>
</div>
<?php } } ?>


<div class="container">
    <div class="row">
        <?php
            foreach($topics as $key=>$val){
                $topicID = $obj->find_by('topics','tES_id',$topics[$key]['topicID']);
                $images = $obj->find_by('topicsImages','tID',$topicID[0]['id']);
        ?>
        <div class="col-xs-12 col-sm-6 col-md-4 box-content">
            <?php if($_SESSION['label'] !='author' && $_SESSION['label'] !='image'){ ?><div class="circle-ref" onclick="topicsTranslation(<?php echo $topicID[0]['id']; ?>)"><?php echo $topicID[0]['id']; ?></div><?php } ?>
            <div class="inner-box background" style="background-image:url('<?php echo $images[0]['img_url'] ?>');">
                <h3 data-placement="top" title="Edit Topic" <?php if(isset($_SESSION['permission'][1]) && !empty($_SESSION['permission'][1]) && isset($_SESSION['lang']) && !empty($_SESSION['lang']) && $_SESSION['label'] !='author' && $_SESSION['label'] !='image'){if($_SESSION['lang']=='es' || $_SESSION['lang']=='all'){ ?>onclick="openUpdate(<?php echo $topics[$key]['topicID'] ?>,<?php echo $topicID[0]['id']; ?>)"<?php } } ?>><a><?php echo $topics[$key]['topicName'] ?></a></h3>
            </div>
            
            <div class="col-xs-8 col-md-8">
                Lang:
                <?php if(isset($topicID[0]['tEN_id']) && !empty($topicID[0]['tEN_id'])){ ?>
                <img src="images/eng.png" width="25px" height="25px">
                <?php } ?>
                <?php if(isset($topicID[0]['tPT_id']) && !empty($topicID[0]['tPT_id'])){ ?>
                <img src="images/Portugal.png" width="25px" height="25px">
                <?php } ?>
                <?php if(isset($topicID[0]['tES_id']) && !empty($topicID[0]['tES_id'])){ ?>
                <img src="images/es.png" width="25px" height="25px">
                <?php } ?>
            </div>
            
        </div>
        <?php
            }
        ?>
        <!--
        <div class="col-xs-12 col-sm-6 col-md-4 box-content">
            <div class="inner-box background">
                <h3 data-placement="top" title="Edit Topic"><a>Motivational</a></h3>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4 box-content">
            <div class="inner-box background">
                <h3 data-placement="top" title="Edit Topic"><a>Inspirational</a></h3>
            </div>
        </div> -->
    </div>
</div>

<div class="container">
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li>
                <a href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li>
                <a href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

<script src="js/multiimages.js"></script>

<script>
    var changePlaceholder=function(el){
        var imgType = $(el).prop('files')[0].type;
        if(imgType.split('/')[0] == 'image'){
            // Name of file and placeholder
            var file = el.files[0].name;
            var dflt = $(el).attr("placeholder");
            if($(el).val()!=""){
                $(el).next().text(file);
            } else {
                $(el).next().text(dflt);
            }
        } else {
            document.getElementById("image").value = "";
            $(el).next().text("Oops! that's not an image!");
        }
    }
    
    var closeUpdate=function(){
    $('#update-form').hide(500);
}
var openUpdate=function(topID,resRel){
    var topic = find_by('topics_es','topicID',topID);
    $('#quote-form').hide(500);
    document.getElementById('image-box2').innerHTML="";
    topic.done(function(data){
        if(Object.keys(data[0][0]).length > 1){
            document.getElementById('update').setAttribute("onclick","updateTopic(this,"+data[0][0].topicID+","+resRel+")");
            $('#update-form').show(500);
            $('#topic-up').val(data[0][0].topicName);
            $('#keywords-up').val(data[0][0].keywords);
            $('#topic-up').focus();
            var topicRel = find_by('topics','tES_id',topID);
            topicRel.done(function(data2){
                var topicImages = find_by('topicsImages','tID',data2[0][0].id);
                topicImages.done(function(response){
                    for(var i in response[0]){
                        imagesToUpdate(response[0][i].img_url,response[0][i].id);
                    }
                });
            });
        }
    });
}

String.prototype.allReplace = function(obj) {
        var retStr = this;
        for (var x in obj) {
            retStr = retStr.replace(new RegExp(x, 'g'), obj[x]);
        }
        return retStr;
    }

    var updateTopic = function(el,topID,resRel){
        $(el).attr('disabled','disabled');
        el.innerHTML = "Updating";
        var topic = $('#topic-up').val(),
            keywords = $('#keywords-up').val(),
            imagesToUpdate = $("input[name='imagesUpdate[]']").map(function(){return $(this).prop('files')[0];}).get(),
            images = $("input[name='images[]']").map(function(){return $(this).prop('files')[0];}).get(), // NEW IMAGES
            arr = {};
        if(topic && topic != ''){
            arr['topicName'] = topic;
            var seo = topic.allReplace({'á': 'a','ã':'a','à':'a','â':'a','ç':'c', 'é': 'e','ê':'e','í':'i','ó':'o','õ':'o','ô':'o','ü':'u','ú':'u','ñ':'n',"'":'','"':""});
            arr['seo_url'] = seo.split(' ').join('-').toLowerCase();
        }
        else
            console.log('Error topic');
        if(keywords && keywords != '')
            arr['keywords'] = keywords;
        else
            console.log('Error keyword');
        if(arr['topicName'] != '' && arr['keywords'] != ''){
            var token = generateToken();
            token.done(function(generatedToken){
                var update_topic = update('topics_es',arr,'topicID',topID,generatedToken);
                update_topic.done(function(data){
                    //NEW STUFF
                    var logArr={};
                    logArr['log']=' has edited a Topic in Spanish. Topic ID: <a class="idREL" onclick="topicsTranslation('+resRel+')">'+resRel+'</a>';
                    var log=insertLog('dashboard_logs',logArr,'logs');
                    log.done(function(res2){
                        console.log(res2);
                    });
                    console.log(data);
                    if(Object.keys(imagesToUpdate).length > 0){ // Images to be updated
                        var imagesToUpdateID = $("input[name='imageID[]']").map(function(){if($(this).prev().val()!='') return $(this).val();}).get();
                        var arr3={};
                        var count = 0;
                        for(var i in imagesToUpdate){
                            var imageUpload = imgur_upload(imagesToUpdate[i]);
                            console.log('Uploading Image');
                            imageUpload.done(function(img){
                                var url = img.data.link;
                                arr3['img_url'] = url.replace('http','https');
                                var token2 = generateToken();
                                token2.done(function(generatedToken2){
                                    var update_image = update('topicsImages',arr3,'id',imagesToUpdateID[count],generatedToken2);
                                    update_image.done(function(updated_img){
                                        console.log(updated_img);
                                    });
                                });
                            });
                            //console.log(imagesToUpdate[i]+" and ID: "+ imagesToUpdateID[i]+"\n");
                        }
                    }
                    if(Object.keys(images).length > 0){ // There's a new image
                        var topicRel = find_by('topics','tES_id',topID);
                        topicRel.done(function(data2){
                            var arr3={};
                            arr3['tID']=data2[0][0].id;
                            for(var i in images){
                                 var image = imgur_upload(images[i]);
                                image.done(function(img){
                                    var url = img.data.link;
                                    arr3['img_url']=url.replace('http','https');
                                    var token3 = generateToken();
                                    token3.done(function(generatedToken3){
                                         var insertImages = insert('topicsImages',arr3,generatedToken3);
                                        insertImages.done(function(data2){
                                            console.log(data2);
                                        });
                                    });
                                });
                            }
                        });
                    }
                    if(Object.keys(imagesToUpdate).length == 0 && Object.keys(images).length == 0){
                        setTimeout(function() {
                            topics('TTopic Actualizado correctamente',document.getElementById('topic-es'));
                        }, 2000);
                    } else{
                        setTimeout(function() {
                            topics('Topic Actualizado correctamente',document.getElementById('topic-es'));
                        }, 2000);
                    }
                });
            });
        }
    }
function imagesToUpdate(src,id){
    var x = document.createElement("INPUT"); //file
    var hidden = document.createElement("INPUT"); //file
    var image = document.createElement("IMG");
    var i_Tag = document.createElement("I");
    var span = document.createElement("SPAN");
    var col = document.createElement("DIV");
    
    // div
    col.setAttribute("class", "form-group col-xs-12 col-sm-6 col-md-3 img-container");
    
    // Input file attributes
    x.setAttribute("type", "file");
    x.setAttribute("name", "imagesUpdate[]");
    x.setAttribute("class", "form-control img-file");
    x.setAttribute("aria-describedby","Image");
    x.setAttribute("accept","image/*");
    x.setAttribute("onchange","preview(this);changePlaceholder(this)");
    
    // Hidden Input
    hidden.setAttribute("type", "hidden");
    hidden.setAttribute("name", "imageID[]");
    hidden.setAttribute("value", id);    
    // Image
    image.setAttribute('src',src);
    image.setAttribute('class','img-responsive');
    
    // Span
    span.setAttribute('class','up-label');
    span.innerHTML='Upload an image';
    
    // I TAG
    i_Tag.setAttribute('class','ion-close-circled close');
    i_Tag.setAttribute('onclick','deleteField(this;deleteImage('+id+'))');
    
    // Append elements to Col
    col.appendChild(i_Tag);
    col.appendChild(image);
    col.appendChild(x);
    col.appendChild(hidden);
    col.appendChild(span);
    
    document.getElementById('image-box2').appendChild(col);
}
    
    var save = function(el) {
        $(el).attr('disabled','disabled');
        el.innerHTML = "Guardando";
        var topic = $('#topic').val(),
            keywords = $('#keywords').val(),
            images = $("input[name='images[]']").map(function(){return $(this).prop('files')[0];}).get(),
            arr = {};
        if(topic && topic != ''){
            arr['topicName'] = topic;
            var seo = topic.allReplace({'á': 'a','ã':'a','à':'a','â':'a','ç':'c', 'é': 'e','ê':'e','í':'i','ó':'o','õ':'o','ô':'o','ü':'u','ú':'u','ñ':'n',"'":'','"':""});
            arr['seo_url'] = seo.split(' ').join('-').toLowerCase();
        }
        else
            console.log('Error topic');
        if(keywords && keywords != '')
            arr['keywords'] = keywords;
        else
            console.log('Error keyword');
        if(arr['topicName'] != '' && arr['keywords'] != ''){
            var token = generateToken();
            token.done(function(generatedToken){
                var insert_topic = insert('topics_es',arr,generatedToken);
                insert_topic.done(function(data){
                    var lastTopic = limit('topics_es','topicID','topicID',1);
                    lastTopic.done(function(dataID){
                        var arr2={};
                        arr2['tES_id']=dataID[0][0].topicID;
                        var token2 = generateToken();
                        token2.done(function(generatedToken2){
                            var topicRelation = insert('topics',arr2,generatedToken2);
                            topicRelation.done(function(){
                                console.log('Topic Created!');
                                if(Object.keys(images).length > 0){
                                    var topicRelID = limit('topics','id','id',1); // GET LAST TOPICS ID
                                    topicRelID.done(function(relID){
                                        var arr3={};
                                        console.log(relID[0][0].id);
                                        arr3['tID']=relID[0][0].id;
                                        for(var i in images){
                                            var image = imgur_upload(images[i]);
                                            image.done(function(img){
                                                var url = img.data.link;
                                                arr3['img_url']=url.replace('http','https');
                                                var token3 = generateToken();
                                                token3.done(function(generatedToken3){
                                                    var insertImages = insert('topicsImages',arr3,generatedToken3);
                                                    insertImages.done(function(){
                                                        $(el).removeAttr('disabled');
                                                        el.innerHTML = "Guardada!";
                                                        console.log('Done!');
                                                        setTimeout(function() {
                                                            topicsES('Topic Saved correctly',document.getElementById('topic-es'));
                                                        }, 2000);
                                                    });
                                                });
                                            });
                                        }
                                    });
                                } else{
                                    $(el).removeAttr('disabled');
                                    el.innerHTML = "Guardada!";
                                    console.log('Done!');
                                    setTimeout(function() {
                                        topicsES('Topic Saved correctly',document.getElementById('topic-es'));
                                    }, 2000);
                                }
                            });
                        });
                    });
                });
            });
        } else {
            console.log('Error');
        }
    }
    
    var checkAvailability = function(){
        
    }
</script>