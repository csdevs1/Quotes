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
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-image"></i></span>                
                <input type="file" class="form-control" id="image" aria-describedby="image" placeholder="Sube una imagen" accept="image/*">          
                <span class="up-label">Sube una imagen</span>
            </div>
        </div>
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
        ?>
        <div class="col-xs-12 col-sm-6 col-md-4 box-content">
            <div class="inner-box background" style="background-image:url('<?php echo $topics[$key]['topicImage'] ?>');">
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

<script>
    $("#image").on("change", function(){
        var imgType = $(this).prop('files')[0].type;
        if(imgType.split('/')[0] == 'image'){
            // Name of file and placeholder
            var file = this.files[0].name;
            var dflt = $(this).attr("placeholder");
            if($(this).val()!=""){
                $(this).next().text(file);
            } else {
                $(this).next().text(dflt);
            }
        } else {
            document.getElementById("image").value = "";
            $(this).next().text("Oops! Eso no es una imagen!");
        }
    });
    
    var save = function(el) {
        $(el).attr('disabled','disabled');
        el.innerHTML = "Guardando";
        var author = $('#topic').val(),
            keywords = $('#keywords').val(),
            arr = {};
        if(author && author != '')
            arr['topicName'] = author;
        else
            console.log('Error topic');
        if(keywords && keywords != '')
            arr['keywords'] = author;
        else
            console.log('Error keyword');
        if($('#image').val()!=''){
            if(arr['topicName'] != '' && arr['keywords'] != ''){
                var token = generateToken();
                token.done(function(generatedToken){
                    var image = imgur_upload($('#image').prop('files')[0]);
                    image.done(function(response){
                        var url = response.data.link;
                        arr['topicImage'] = url.replace('http','https');
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
                                        $(el).removeAttr('disabled');
                                        el.innerHTML = "Guardado!";
                                        setTimeout(function() {
                                            topics('Topic Saved correctly',document.getElementById('topic-es'));
                                        }, 2000);
                                    });
                                });
                            });
                        });
                    });
                });
            }
        }else if(arr['topicName'] != '' && arr['keywords'] != ''){
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
                                $(el).removeAttr('disabled');
                                el.innerHTML = "Guardado!";
                                setTimeout(function() {
                                    topics('Tema guardado correctamente',document.getElementById('topic-es'));
                                }, 2000);
                            });
                        });
                    });
                });
            });
        }
    }
    
    var checkAvailability = function(){
        
    }
</script>