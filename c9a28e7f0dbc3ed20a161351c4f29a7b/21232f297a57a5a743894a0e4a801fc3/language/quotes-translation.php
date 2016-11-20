<?php
	session_start();
    require_once('../Classes/AppController.php');
    $obj = new AppController();
    $translations = $obj->find_by('quotes','id',$_POST['id']);
    if(isset($translations[0]['en_id']) && !empty($translations[0]['en_id'])){
        $eng = $obj->find_by('quotes_en','quoteID',$translations[0]['en_id']);
        $author = $eng[0]['author'];
        $arrES = array();
        $arrPT = array();
        $topics_en = array();
        $topicRel = $obj->find_by('quotesTopicEN','quoteID',$eng[0]['quoteID']); // GET AN ARRAY WITH ALL THE TOPICS RELATED TO THIS QUOTE IN ENGLISH
        $count=0;
        
        foreach($topicRel as $key=>$val){
            $topics_en[$count]=$obj->find_by('topics_en','topicID',$val['topicID']);
            $count++;
        }
        $count=0;
        foreach($topicRel as $key=>$val){ // LOOP THROUGH ALL THE ID AND THEN STORE THEM IN THE ARRAY
            $arrES[$count] = $obj->custom('SELECT topics_es.topicID,topics_es.topicName FROM topics_es INNER JOIN topics ON topics_es.topicID=topics.tES_id WHERE topics.tEN_id='.$val['topicID']); // USE join() FUNCTION
            $arrPT[$count] = $obj->custom('SELECT topics_pt.topicID,topics_pt.topicName FROM topics_pt INNER JOIN topics ON topics_pt.topicID=topics.tPT_id WHERE topics.tEN_id='.$val['topicID']); // USE join() FUNCTION
            $count++;
        }
        
        $count=0;
        if(!empty($topics_en)){
            foreach($topics_en as $key=>$val){// DELETE THIS LOOP AND USE ONLY JOIN LIKE BELOW
                $topics_en[$count]=$val[0]['topicName']; // TOPIC'S NAME IN SPANISH
                $count++;
            }
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
    }elseif(isset($translations[0]['es_id']) && !empty($translations[0]['es_id'])){
        $eng = $obj->find_by('quotes_es','quoteID',$translations[0]['es_id']);
        $author = $eng[0]['author'];
        $arrEN = array();
        $arrPT = array();
        $topics_es = array();
        $topicRel = $obj->find_by('quotesTopicES','quoteID',$eng[0]['quoteID']); // GET AN ARRAY WITH ALL THE TOPICS RELATED TO THIS QUOTE IN ENGLISH
        $count=0;
        
        foreach($topicRel as $key=>$val){
            $topics_es[$count]=$obj->find_by('topics_es','topicID',$val['topicID']);
            $count++;
        }
        $count=0;
        foreach($topicRel as $key=>$val){ // LOOP THROUGH ALL THE ID AND THEN STORE THEM IN THE ARRAY
            $arrEN[$count] = $obj->custom('SELECT topics_en.topicID,topics_en.topicName FROM topics_en INNER JOIN topics ON topics_en.topicID=topics.tEN_id WHERE topics.tES_id='.$val['topicID']); // USE join() FUNCTION
            $arrPT[$count] = $obj->custom('SELECT topics_pt.topicID,topics_pt.topicName FROM topics_pt INNER JOIN topics ON topics_pt.topicID=topics.tPT_id WHERE topics.tES_id='.$val['topicID']); // USE join() FUNCTION
            $count++;
        }
        $count=0;
        if(!empty($arrEN)){
            foreach($arrEN as $key=>$val){// DELETE THIS LOOP AND USE ONLY JOIN LIKE BELOW
                $arrEN[$count]=$val[0]['topicName']; // TOPIC'S NAME IN SPANISH
                $count++;
            }
        }
        
        $count=0;
        if(!empty($topics_sn)){
            foreach($topics_es as $key=>$val){// DELETE THIS LOOP AND USE ONLY JOIN LIKE BELOW
                $topics_es[$count]=$val[0]['topicName']; // TOPIC'S NAME IN SPANISH
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

$next=$obj->custom("SELECT id FROM quotes WHERE id > ".$_POST['id']." ORDER BY id ASC LIMIT 1"); //TO SELECT NEXT SET OF QUOTES
$previous=$obj->custom("SELECT id FROM quotes WHERE id < ".$_POST['id']." ORDER BY id DESC LIMIT 1"); //TO SELECT PREVIOUS SET OF QUOTES
?>

<!-- Load with Jquery Load function -->
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <nav class="navbar">
                <div class="container-fluid">
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li <?php if(empty($previous[0]['id'])) echo 'class="disabled"'; ?>><a <?php if(!empty($previous[0]['id'])){?>onclick="quotesTranslation(<?php echo $previous[0]['id']; ?>)"<?php } ?>><span class="glyphicon glyphicon-arrow-left"></span> Previous</a></a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li <?php if(empty($next[0]['id'])) echo 'class="disabled"'; ?>><a <?php if(!empty($next[0]['id'])){?>onclick="quotesTranslation(<?php echo $next[0]['id']; ?>)"<?php } ?>><span class="glyphicon glyphicon-arrow-right"></span> Next</a></li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        </div>
    </div>
</div>

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
                <input type="text" class="form-control" id="t-en" data-error="Field required" aria-describedby="topic" placeholder="Enter Topic" value="<?php if(!empty($topics_en[0])) echo join(',', $topics_en);elseif(!empty($arrEN[0])) echo join(',', $arrEN); ?>">
                <div class="col-xs-12 search-list" id="topicListEN">
                    <ul class="list-unstyled">
                    </ul>
                </div>
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-image"></i></span>
                <input type="file" class="form-control image-file" id="image-en" aria-describedby="image" placeholder="Upload Image" accept="image/*">
                <span class="up-label">Upload an image</span>
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <button type="button" class="btn btn-primary" onclick="save(this,'en','English',<?php echo $_POST['id']; ?>)" id="save-eng">Save</button>
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
                <input type="file" class="form-control image-file" id="image-es" aria-describedby="image" placeholder="Subir imagen" accept="image/*">          
                <span class="up-label">Subir una imagen</span>
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <button type="button" class="btn btn-primary" onclick="save(this,'es','Spanish',<?php echo $_POST['id']; ?>)" id="save-es">Guardar</button>
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
                <input type="file" class="form-control image-file" id="image-pt" aria-describedby="image" placeholder="Adicionar uma imagem..." accept="image/*">
                <span class="up-label">Adicionar uma imagem...</span>
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <button type="button" class="btn btn-primary" onclick="save(this,'pt','Portuguese',<?php echo $_POST['id']; ?>)" id="save-pt">Salvar</button>
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
                                    <img class="img-responsive" src="https://portalquote.com/images/quotes/<?php echo $eng[0]['quoteImage']; ?>" alt="image description">
                                <?php } ?>
                                <blockquote><?php echo $eng[0]['quote']; ?> <span>- <?php echo $eng[0]['author']; ?></span></blockquote>
                                <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="mycustomurl" data-title="THE TITLE"></div>
                                <?php if(isset($_SESSION['permission'][1]) && !empty($_SESSION['permission'][1]) && isset($_SESSION['lang']) && !empty($_SESSION['lang'])){ //Permission to insert
                                    if($_SESSION['lang']=='eng' || $_SESSION['lang']=='all'){?>
                                    <div class="col-xs-4 col-md-4"><p><a class="like" onclick="openUpdate(<?php echo $eng[0]['quoteID']; ?>,<?php echo $_POST['id']; ?>,'eng');">Edit</a></p></div>
                                <?php } } ?>
                            </div>
                        </div>
                        <?php
                            }else{
                                if(isset($_SESSION['permission'][0]) && !empty($_SESSION['permission'][0]) && isset($_SESSION['lang']) && !empty($_SESSION['lang'])){ //Permission to insert
                                    if($_SESSION['lang']=='eng' || $_SESSION['lang']=='all'){?>
                        <div class="col-lg-12 text-dark"><span class="addquote"  onclick="openForm(this,'eng')"><span class="glyphicon glyphicon-edit"></span> Add translation in english</span></div>
                        <?php
                                    }
                                }
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
                                    <img class="img-responsive" src="https://portalquote.com/images/quotes/<?php echo $es[0]['quoteImage']; ?>" alt="image description">
                                <?php } ?>
                                <blockquote><?php echo $es[0]['quote']; ?> <span>- <?php echo $es[0]['author']; ?></span></blockquote>
                                <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="mycustomurl" data-title="THE TITLE"></div>
				<?php if(isset($_SESSION['permission'][1]) && !empty($_SESSION['permission'][1]) && isset($_SESSION['lang']) && !empty($_SESSION['lang'])){ //Permission to insert
                                    if($_SESSION['lang']=='es' || $_SESSION['lang']=='all'){?>
                                <div class="col-xs-4 col-md-4"><p><a class="like" onclick="openUpdate(<?php echo $es[0]['quoteID']; ?>,<?php echo $_POST['id']; ?>,'es');">Edit</a></p></div>
                                <?php } } ?>
                            </div>
                        </div>
                        <?php
                            }else{
                                if(isset($_SESSION['permission'][0]) && !empty($_SESSION['permission'][0]) && isset($_SESSION['lang']) && !empty($_SESSION['lang'])){ //Permission to insert
                                    if($_SESSION['lang']=='es' || $_SESSION['lang']=='all'){ ?>
                            <div class="col-lg-12 text-dark"><span class="addquote"  onclick="openForm(this,'es')"><span class="glyphicon glyphicon-edit"></span> Agregar traduccion en espa&ntilde;ol</span></div>
                        <?php
                                    }
                                }
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
                                    <img class="img-responsive" src="https://portalquote.com/images/quotes/<?php echo $pt[0]['quoteImage']; ?>" alt="image description">
                                <?php } ?>
                                <blockquote><?php echo $pt[0]['quote']; ?> <span>- <?php echo $pt[0]['author']; ?></span></blockquote>
                                <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="mycustomurl" data-title="THE TITLE"></div>
			<?php if(isset($_SESSION['permission'][1]) && !empty($_SESSION['permission'][1]) && isset($_SESSION['lang']) && !empty($_SESSION['lang'])){ //Permission to insert
                                    if($_SESSION['lang']=='eng' || $_SESSION['lang']=='all'){?>
                                <div class="col-xs-4 col-md-4"><p><a class="like" onclick="openUpdate(<?php echo $pt[0]['quoteID']; ?>,<?php echo $_POST['id']; ?>,'pt');">Edit</a></p></div>
			<?php } } ?>
                            </div>
                        </div>
                        <?php
                            }else{
                                if(isset($_SESSION['permission'][0]) && !empty($_SESSION['permission'][0]) && isset($_SESSION['lang']) && !empty($_SESSION['lang'])){ //Permission to insert
                                    if($_SESSION['lang']=='pt' || $_SESSION['lang']=='all'){?>
                            <div class="col-lg-12 text-dark"><span class="addquote" onclick="openForm(this,'pt')"><span class="glyphicon glyphicon-edit"></span> Adicionar uma tradução em português</span></div>
                        <?php
                                    }
                                }
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
        
        $('.search-list').hide();
        document.getElementById('t-en_tag').setAttribute('oninput','listSearch(this,"topicListEN","topics_en","t-en","en")');
        document.getElementById('t-es_tag').setAttribute('oninput','listSearch(this,"topicListES","topics_es","t-es","es")');
        document.getElementById('t-pt_tag').setAttribute('oninput','listSearch(this,"topicListPT","topics_pt","t-pt","pt")');
       //eng 
       $('#t-en_tag').bind("enterKey",function(e){
           console.log('Pressed Enter');
       });
        $('#t-en_tag').keyup(function(e){
            if(e.keyCode == 13){
                detectWord();
                $('#topicListEN').slideUp();
            }
        });
        //es
       $('#t-es_tag').bind("enterKey",function(e){
           console.log('Pressed Enter');
       });
        $('#t-es_tag').keyup(function(e){
            if(e.keyCode == 13){
                detectWord();
                $('#topicListES').slideUp();
            }
        });
        //pt
       $('#t-pt_tag').bind("enterKey",function(e){
           console.log('Pressed Enter');
       });
        $('#t-pt_tag').keyup(function(e){
            if(e.keyCode == 13){
                detectWord();
                $('#topicListPT').slideUp();
            }
        });
    });
    
    var closeForm=function(){
        $('.quote-form').hide(500);
        $('.addquote').show();
    }
    var openForm=function(el,lang){
        $('#quote-'+lang).show(500);
        $('.quote-form').not('#quote-'+lang).hide();
        $('.addquote').hide();
    }
    
    var openUpdate = function(quotID,resRel,lan){
        $('.quote-form').not('#quote-'+lan).hide();
        var lang='',language='';
        lan=='eng' ? lang='en':lang=lan;
        switch(lan){
            case 'es':
                language='Spanish';
                break;
            case 'pt':
                language='Portuguese';
                break;
            default:
                language='English';
        }
        var quote = find_by('quotes_'+lang,'quoteID',quotID);
        $('#save-'+lan).attr('onclick','updateQuote(this,"'+lang+'","'+language+'",'+quotID+','+resRel+')');
        quote.done(function(data){
            if(Object.keys(data[0][0]).length > 1){
                $('#quote-'+lan).show(500);
                $('#q-'+lang).val(data[0][0].quote);
            }
        });
    }
    
    var updateQuote = function(el,lang,languague,quotID,resRel){
        var quote = $('#q-'+lang).val(),
            author = $('#a-'+lang).val(),
            topics = document.getElementById('t-'+lang).value;
        console.log(topics);
        if(!quote || quote==''){
            console.log('Error quote');
        }else if(!author || author==''){
            console.log('Error author');
        }else if(!topics || topics==''){
            console.log('Error topic');
        }else{
            $(el).attr('disabled','disabled');
            var arr = {};
            arr['quote']=quote;
            arr['author']=author;
            if($('#image').val() && $('#image').val() !=''){
                var image=$('#image').prop('files')[0];
            }
            console.log(arr);
            var token = generateToken();
            token.done(function(generatedToken){
                var quoteUpdate = update('quotes_'+lang,arr,'quoteID',quotID,generatedToken,image);
                quoteUpdate.done(function(data){
                    console.log(data);
		//NEW STUFF
                    var logArr={};
                    logArr['log']=' has edited a Quote in '+languague+'. Quote ID: <a class="idREL" onclick="quotesTranslation('+resRel+')">'+resRel+'</a>';
                    var log=insertLog('dashboard_logs',logArr,'logs');
                    log.done(function(res2){
                        console.log(res2);
                    });

                    console.log(data);
                    var token2 = generateToken();
                    token2.done(function(generatedToken2){
                        var deleteRel = delete_function('quotesTopic'+lang.toUpperCase(),'quoteID',quotID,generatedToken2);
                        deleteRel.done(function(delResponse){
                            console.log(delResponse);
                            var arr2={};
                            arr2['quoteID']=quotID;
                            var topic = topics.split(',');
                            for(var i in topic){
                                var topicSearch = find_by('topics_'+lang,'topicName',topic[i]);
                                topicSearch.done(function(topicId){
                                    var token3 = generateToken();
                                    token3.done(function(generatedToken3){
                                        arr2['topicID']=topicId[0][0].topicID;
                                        var topicQuote = insert('quotesTopic'+lang.toUpperCase(),arr2,generatedToken3);
                                        topicQuote.done(function(data2){
                                            console.log(data2);
                                            $(el).removeAttr('disabled');
                                            setTimeout(function() {
                                                quotesTranslation(resRel);
                                            }, 1000);
                                        });
                                    });
                                });
                            }
                        });
                    });
                });
            });
        }
    }
    
    var save = function(el, lang,languague, relationID){
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
                                arr3={},
                                logArr={},relArr={};
                            arr2['quoteID']=dataID[0][0].quoteID;
                            arr3[lang+'_id']=dataID[0][0].quoteID;
                            relArr['quoteID']=dataID[0][0].quoteID;
                            var token2 = generateToken();
                            token2.done(function(generatedToken2){
                                var quoteRelation = update('quotes',arr3,'id',relationID,generatedToken2);
                                quoteRelation.done(function(re){
                                    console.log('Rel: '+ re);
                                    //NEW STUFF
                                    var userQuoteRel=insertLog('dashboardUsr_Quote_'+lang,relArr,'relation');
                                    userQuoteRel.done(function(res){
                                        console.log(res);
                                        logArr['log']=' has translated a Quote in '+languague+'. Quote ID: <a class="idREL" onclick="quotesTranslation('+relationID+')">'+relationID+'</a>';
                                        var log=insertLog('dashboard_logs',logArr,'logs');
                                        log.done(function(res2){
                                            console.log(res2);
                                        });
                                    });
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
    
    var listSearch = function(el,id,table,row,lan){
        if(el.value=="" || el.value=="add a tag"){
            $('#'+id).slideUp();
        }else {
            if($(el).is(':focus'))
                $('.search-list').not('#'+id).slideUp();
            $('#'+id).slideDown();
            var pattern = $(el).val()+'%';
            if(row=='t-'+lan)
                var arr = {'topicName':'topicName'};
            else
                var arr = {'authorName':'authorName'};
            var search = like(table,arr,pattern);
            search.done(function(response){
                console.log(response);
                if(Object.keys(response[0]).length != 0){
                    $('#'+id+' ul').html('');
                    for(var i in response[0]){
                        if(row==='t-'+lan)
                            $('#'+id+' ul').append('<li  onclick="selectTag(this,\''+row+'\',\''+lan+'\',\'csv\')">'+response[0][i].topicName+'</li>');
                        else
                            $('#'+id+' ul').append('<li  onclick="selectTag(this,\''+row+'\',\''+lan+'\')">'+response[0][i].authorName+'</li>');
                    }
                } else
                    $('#'+id+' ul').html('<li>Not found!</li>');
            });
        }
    }
    
    function detectWord(lan){
        var incorrecTag = $('.tag').last().children('span').html().split('&');
        var topicSearch = find_by('topics_'+lan,'topicName',incorrecTag[0]);
        topicSearch.done(function(response){
            if(Object.keys(response[0]).length == 0)
                $('.tag').last().children('a').click();
        });
    }
    
    var selectTag=function(el,inp,lan,format=""){
        //detectWord(lan);
        var elVal = el.innerHTML;
        if(format=="csv"){
            $('.tag').remove();
            var val = document.getElementById(inp).value.split(',');
            val[val.length-1] = elVal;
            for(var i in val){
                $('#t-'+lan).addTag(val[i]);
            }
            document.getElementById(inp).value=val.join(',');
            $(el).parent().parent().slideUp();
        }
        else{
            document.getElementById(inp).value = elVal;
            $(el).parent().parent().slideUp();
        }
    }
</script>