<?php
    require_once('../Classes/AppController.php');
    $obj = new AppController();
    $translations = $obj->find_by('quotes','id',$_POST['id']);
    if(isset($translations[0]['en_id']) && !empty($translations[0]['en_id'])){
        $eng = $obj->find_by('quotes_en','quoteID',$translations[0]['en_id']);
        $arrES = array();
        $arrPT = array();
        $topicRel = $obj->find_by('quotesTopicEN','quoteID',$eng[0]['quoteID']); // GET AN ARRAY WITH ALL THE TOPICS RELATED TO THIS QUOTE IN ENGLISH
        $count=0;
        
        foreach($topicRel as $key=>$val){ // LOOP THROUGH ALL THE ID AND THEN STORE THEM IN THE ARRAY
            $arrES[$count] = $obj->custom('SELECT topics_es.topicID,topics_es.topicName FROM topics_es INNER JOIN topics ON topics_es.topicID=topics.tES_id WHERE topics.tEN_id='.$val['topicID']); // USE join() FUNCTION
            $arrPT[$count] = $obj->custom('SELECT topics_pt.topicID,topics_pt.topicName FROM topics_pt INNER JOIN topics ON topics_pt.topicID=topics.tPT_id WHERE topics.tEN_id='.$val['topicID']); // USE join() FUNCTION
            $count++;
        }
        $count=0;
        if(!empty($arrES)){
            foreach($arrES as $key=>$val){// DELETE THIS LOOP AND USE ONLY JOIN LIKE BELOW
                $arrES[$count]=$val[0]['topicName']; // TOPIC'S NAME IN SPANISH
                $count++;
            }
        }
        
        $count=0;
        if(!empty($arrPT)){
            foreach($arrPT as $key=>$val){// DELETE THIS LOOP AND USE ONLY JOIN LIKE BELOW
                $arrPT[$count]=$val[0]['topicName']; // TOPIC'S NAME IN SPANISH
                $count++;
            }
        }
    }

?>

<!-- Load with Jquery Load function -->
<div class="portlet-heading">
    <h3 class="portlet-title text-dark text-uppercase">
        Translate
    </h3>
    <div class="clearfix"></div>
</div>
<div class="container quote-form" id="quote-eng">
    <div class="row">
        <div class="col-xs-12 relative-container">
            <label onclick="closeForm()"><span class="glyphicon glyphicon-remove"></span> Hide</label>
        </div>
        <div class="col-xs-12">
            <textarea placeholder="Insert your quote..." maxlength="255" class="textarea" id="quote"></textarea>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="author" data-error="Field required" aria-describedby="author" placeholder="Enter Author..."  oninput="listSearch(this,'authorList','authors','author')">
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-chatbubble-working"></i></span>
                <input type="text" class="form-control" id="topic-en" data-error="Field required" aria-describedby="topic" placeholder="Enter Topic" value="">
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-image"></i></span>                
                <input type="file" class="form-control" id="image" aria-describedby="image" placeholder="Upload Image" accept="image/*">          
                <span class="up-label">Upload an image</span>
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <button type="button" class="btn btn-primary" onclick="save(this)">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="container quote-form" id="quote-es">
    <div class="row">
        <div class="col-xs-12 relative-container">
            <label onclick="closeForm()"><span class="glyphicon glyphicon-remove"></span> Ocultar</label>
        </div>
        <div class="col-xs-12">
            <textarea placeholder="Ingresa la frase..." maxlength="255" class="textarea" id="quote"></textarea>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="author" data-error="Field required" aria-describedby="author" placeholder="Ingresa el autor..."  oninput="listSearch(this,'authorList','authors','author')">
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-chatbubble-working"></i></span>
                <input type="text" class="form-control" id="topic-es" data-error="Field required" aria-describedby="topic" placeholder="Ingresa tema" value="<?php if(!empty($arrES[0])) echo join(',', $arrES); ?>">                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-image"></i></span>                
                <input type="file" class="form-control" id="image" aria-describedby="image" placeholder="Subir imagen" accept="image/*">          
                <span class="up-label">Subir una imagen</span>
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <button type="button" class="btn btn-primary" onclick="save(this)">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="container quote-form" id="quote-pt">
    <div class="row">
        <div class="col-xs-12 relative-container">
            <label onclick="closeForm()"><span class="glyphicon glyphicon-remove"></span> Ocultar</label>
        </div>
        <div class="col-xs-12">
            <textarea placeholder="Digite sua frase..." maxlength="255" class="textarea" id="quote"></textarea>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="author" data-error="Field required" aria-describedby="author" placeholder="Digite autor..."  oninput="listSearch(this,'authorList','authors','author')">                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-chatbubble-working"></i></span>
                <input type="text" class="form-control" id="topic-port" data-error="Field required" aria-describedby="topic" placeholder="Digite tópico..." value="<?php if(!empty($arrPT)) echo join(',', $arrPT); ?>">                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-image"></i></span>                
                <input type="file" class="form-control" id="image" aria-describedby="image" placeholder="Adicionar uma imagem..." accept="image/*">          
                <span class="up-label">Adicionar uma imagem...</span>
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <button type="button" class="btn btn-primary" onclick="save(this)">Salvar</button>
            </div>
        </div>
    </div>
</div>

<div id="portlet1" class="panel-collapse collapse in">
    <div class="portlet-body">
        <section role="contentinfo">
            <div class="container">
                <div class="row">
                    <div class="masonry-container">
                        <!-- ENGLISH -->
                        <?php 
                            if(isset($translations[0]['en_id']) && !empty($translations[0]['en_id'])){
                                //$eng = $obj->find_by('quotes_en','quoteID',$translations[0]['en_id']);
                        ?>
                        <div class="col-xs-12 col-sm-6 col-md-4 item quote">
                            <div class="pad">
                                <?php if(isset($eng[0]['quoteImage']) && !empty($eng[0]['quoteImage'])){ ?>
                                    <img class="img-responsive" src="../../images/quotes/<?php echo $quotes[$key]['quoteImage']; ?>" alt="image description">
                                <?php } ?>
                                <blockquote><?php echo $eng[0]['quote']; ?> <span>- <?php echo $eng[0]['author']; ?></span></blockquote>
                                <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="mycustomurl" data-title="THE TITLE"></div>
                                <div class="col-xs-4 col-md-4"><p><a class="like" onclick="return myFunction(this)">Edit</a></p></div>
                            </div>
                        </div>
                        <?php
                            }else{
                        ?>
                        <div class="col-lg-12 text-dark"><span class="addquote"  onclick="openForm(this,eng)"><span class="glyphicon glyphicon-edit"></span> Add translation in english</span></div>
                        <?php
                            }
                        ?>
                        <!-- SPANISH -->
                        <?php 
                            if(isset($translations[0]['es_id']) && !empty($translations[0]['es_id'])){
                                $es = $obj->find_by('quotes_es','quoteID',$translations[0]['es_id']);
                        ?>
                        <div class="col-xs-12 col-sm-6 col-md-4 item quote">
                            <div class="pad">
                                <?php if(isset($es[0]['quoteImage']) && !empty($es[0]['quoteImage'])){ ?>
                                    <img class="img-responsive" src="../../images/quotes/<?php echo $es[$key]['quoteImage']; ?>" alt="image description">
                                <?php } ?>
                                <blockquote><?php echo $es[0]['quote']; ?> <span>- <?php echo $es[0]['author']; ?></span></blockquote>
                                <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="mycustomurl" data-title="THE TITLE"></div>
                                <div class="col-xs-4 col-md-4"><p><a class="like" onclick="return myFunction(this)">Edit</a></p></div>
                            </div>
                        </div>
                        <?php
                            }else{
                        ?>
                            <div class="col-lg-12 text-dark"><span class="addquote"  onclick="openForm(this,'es')"><span class="glyphicon glyphicon-edit"></span> Agregar traduccion en espa&ntilde;ol</span></div>
                        <?php
                            }
                        ?>
                        <!-- PORTUGUESE -->
                        <?php 
                            if(isset($translations[0]['pt_id']) && !empty($translations[0]['pt_id'])){
                                $pt = $obj->find_by('pt_id','quoteID',$translations[0]['pt_id']);
                        ?>
                        <div class="col-xs-12 col-sm-6 col-md-4 item quote">
                            <div class="pad">
                                <?php if(isset($pt[0]['quoteImage']) && !empty($pt[0]['quoteImage'])){ ?>
                                    <img class="img-responsive" src="../../images/quotes/<?php echo $pt[$key]['quoteImage']; ?>" alt="image description">
                                <?php } ?>
                                <blockquote><?php echo $pt[0]['quote']; ?> <span>- <?php echo $pt[0]['author']; ?></span></blockquote>
                                <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="mycustomurl" data-title="THE TITLE"></div>
                                <div class="col-xs-4 col-md-4"><p><a class="like" onclick="return myFunction(this)">Edit</a></p></div>
                            </div>
                        </div>
                        <?php
                            }else{
                        ?>
                            <div class="col-lg-12 text-dark"><span class="addquote" onclick="openForm(this,'pt')"><span class="glyphicon glyphicon-edit"></span> Adicionar uma tradução em português</span></div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- Load with Jquery Load function -->
<script src="assets/tagsinput/jquery.tagsinput.min.js"></script>
<script>
    $(document).ready(function(){
        $('#topic-en').tagsInput({width:'auto'});
        $('#topic-es').tagsInput({width:'auto'});
        $('#topic-port').tagsInput({width:'auto'});
        $('.quote-form').hide();
    });
    var closeForm=function(){
        $('.quote-form').hide(500);
        $('.addquote').show();
    }
    var openForm=function(el,lang){
        $('#quote-'+lang).show(500);
        $('.addquote').hide();
    }
</script>