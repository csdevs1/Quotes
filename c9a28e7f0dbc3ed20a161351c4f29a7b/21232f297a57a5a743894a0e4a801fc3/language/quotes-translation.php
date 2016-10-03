<?php
    require_once('../Classes/AppController.php');
    $obj = new AppController();
    $translations = $obj->find_by('quotes','id',$_POST['id']);
    if(isset($translations[0]['en_id']) && !empty($translations[0]['en_id'])){
        $eng = $obj->find_by('quotes_en','quoteID',$translations[0]['en_id']);
        $author = $eng[0]['author'];
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
            <textarea placeholder="Insert your quote..." maxlength="255" class="textarea" id="q-en"></textarea>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="a-en" data-error="Field required" aria-describedby="author" placeholder="Enter Author..." value="<?php if(!empty($author)) echo $author; ?>" oninput="listSearch(this,'authorList','authors','author')">
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-chatbubble-working"></i></span>
                <input type="text" class="form-control" id="t-en" data-error="Field required" aria-describedby="topic" placeholder="Enter Topic" value="">
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-image"></i></span>                
                <input type="file" class="form-control" id="image-en" aria-describedby="image" placeholder="Upload Image" accept="image/*">          
                <span class="up-label">Upload an image</span>
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <button type="button" class="btn btn-primary" onclick="save(this,'en',<?php echo $_POST['id']; ?>)">Save</button>
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
            <textarea placeholder="Ingresa la frase..." maxlength="255" class="textarea" id="q-es"></textarea>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="a-es" data-error="Field required" aria-describedby="author" placeholder="Ingresa el autor..." value="<?php if(!empty($author)) echo $author; ?>"  oninput="listSearch(this,'authorList','authors','author')">
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-chatbubble-working"></i></span>
                <input type="text" class="form-control" id="t-es" data-error="Field required" aria-describedby="topic" placeholder="Ingresa tema" value="<?php if(!empty($arrES[0])) echo join(',', $arrES); ?>">                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-image"></i></span>                
                <input type="file" class="form-control" id="image-es" aria-describedby="image" placeholder="Subir imagen" accept="image/*">          
                <span class="up-label">Subir una imagen</span>
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <button type="button" class="btn btn-primary" onclick="save(this,'es',<?php echo $_POST['id']; ?>)">Guardar</button>
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
            <textarea placeholder="Digite sua frase..." maxlength="255" class="textarea" id="q-pt"></textarea>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="a-pt" data-error="Field required" aria-describedby="author" placeholder="Digite autor..." value="<?php if(!empty($author)) echo $author; ?>"  oninput="listSearch(this,'authorList','authors','author')">                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-chatbubble-working"></i></span>
                <input type="text" class="form-control" id="t-pt" data-error="Field required" aria-describedby="topic" placeholder="Digite tópico..." value="<?php if(!empty($arrPT)) echo join(',', $arrPT); ?>">                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-image"></i></span>                
                <input type="file" class="form-control" id="image-pt" aria-describedby="image" placeholder="Adicionar uma imagem..." accept="image/*">          
                <span class="up-label">Adicionar uma imagem...</span>
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <button type="button" class="btn btn-primary" onclick="save(this,'pt',<?php echo $_POST['id']; ?>)">Salvar</button>
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
                        <div class="col-lg-12 text-dark"><span class="addquote"  onclick="openForm(this,'eng')"><span class="glyphicon glyphicon-edit"></span> Add translation in english</span></div>
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
                                $pt = $obj->find_by('quotes_pt','quoteID',$translations[0]['pt_id']);
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
        $('#t-en').tagsInput({width:'auto'});
        $('#t-es').tagsInput({width:'auto'});
        $('#t-pt').tagsInput({width:'auto'});
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
    
    var save = function(el, lang, relationID){
        $(el).attr('disabled','disabled');
        var quote = $('#q-'+lang).val(),
            author = $('#a-'+lang).val(),
            topics = $('#t-'+lang).val();
        if(!quote || quote==''){
            console.log('Error quote');
            $(el).removeAttr('disabled');
        }else if(!author || author==''){
            console.log('Error author');
            $(el).removeAttr('disabled');
        }else if(!topics || topics==''){
            console.log('Error topic');
            $(el).removeAttr('disabled');
        }else{
            var arr = {};
            arr['quote']=quote;
            arr['author']=author;
            if($('#image-'+lang).val() && $('#image-'+lang).val() !=''){
                var image=$('#image-'+lang).prop('files')[0];
            }
            var token1 = generateToken();
            token1.done(function(generatedToken1){
                var table = 'quotes_'+lang;
                var newQuote = insert(table,arr,generatedToken1,image);
                newQuote.done(function(response){
                    if(response){
                        var lastQuote = limit(table,'quoteID','quoteID',1);
                        lastQuote.done(function(dataID){
                            var arr2={},
                                arr3={};
                            arr2['quoteID']=dataID[0][0].quoteID;
                            arr3[lang+'_id']=dataID[0][0].quoteID;
                            var token2 = generateToken();
                            token2.done(function(generatedToken2){
                                var quoteRelation = update('quotes',arr3,relationID,generatedToken2);
                                quoteRelation.done(function(re){
                                    console.log('Rel: '+ re);
                                });
                            });
                            var topic = topics.split(',');
                            for(var i in topic){
                                var topicTable = 'topics_'+lang;
                                var topicSearch = find_by(topicTable,'topicName',topic[i]);
                                topicSearch.done(function(topicId){
                                    var token3 = generateToken();
                                    token3.done(function(generatedToken3){
                                        arr2['topicID']=topicId[0][0].topicID;
                                        var relTable = 'quotesTopic'+lang.toUpperCase();
                                        var topicQuote = insert(relTable,arr2,generatedToken3);
                                        topicQuote.done(function(data){
                                            setTimeout(function() {
                                                quotesTranslation(relationID);
                                            }, 2000);
                                        });
                                    });
                                });
                            }
                        });
                    }
                });
            });
        }
    }
</script>