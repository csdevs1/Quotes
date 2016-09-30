<?php
    require_once('../Classes/AppController.php');
    $obj = new AppController();
    $topics = $obj->all('topics_es');
?>

<div class="portlet-heading">
    <h3 class="portlet-title text-dark text-uppercase">
        Tema
    </h3>
    <div class="clearfix"></div>
    <div class="col-lg-12 text-dark"><span id="add-quote" onclick="openWindow(this)"><span class="glyphicon glyphicon-edit"></span> Agregar un nuevo tema</span></div>
</div>

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
                        <button type="button" class="btn btn-warning" onclick="addTextBox()"><span class="glyphicon glyphicon-plus"></span> Agregar nueva imagen</button>
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


<div class="container">
    <div class="row">
        <?php
            foreach($topics as $key=>$val){
                $topicID = $obj->find_by('topics','tES_id',$topics[$key]['topicID']);
                $images = $obj->find_by('topicsImages','tID',$topicID[0]['id']);
        ?>
        <div class="col-xs-12 col-sm-6 col-md-4 box-content">
            <div class="inner-box background" style="background-image:url('<?php echo $images[0]['img_url'] ?>');">
                <h3 data-placement="top" title="Edit Topic"><a><?php echo $topics[$key]['topicName'] ?></a></h3>
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
    
    var save = function(el) {
        $(el).attr('disabled','disabled');
        el.innerHTML = "Guardando";
        var author = $('#topic').val(),
            keywords = $('#keywords').val(),
            images = $("input[name='images[]']").map(function(){return $(this).prop('files')[0];}).get(),
            arr = {};
        if(author && author != '')
            arr['topicName'] = author;
        else
            console.log('Error topic');
        if(keywords && keywords != '')
            arr['keywords'] = author;
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
                                                            topics('Topic Saved correctly',document.getElementById('topic-es'));
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
                                        topics('Topic Saved correctly',document.getElementById('topic-es'));
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