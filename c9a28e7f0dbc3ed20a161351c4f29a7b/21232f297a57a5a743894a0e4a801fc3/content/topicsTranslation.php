<?php
    session_start();
    require_once('../Classes/AppController.php');
    $obj = new AppController();
    $translations = $obj->find_by('topics','id',$_POST['id']);
    if(isset($translations[0]['tEN_id']) && !empty($translations[0]['tEN_id'])){
        $topicID = $obj->find_by('topics_en','topicID',$translations[0]['tEN_id']);
    }
    if(isset($translations[0]['tES_id']) && !empty($translations[0]['tES_id'])){
        $topicIDES = $obj->find_by('topics_es','topicID',$translations[0]['tES_id']);
    }
    if(isset($translations[0]['tPT_id']) && !empty($translations[0]['tPT_id'])){
        $topicIDPT = $obj->find_by('topics_pt','topicID',$translations[0]['tPT_id']);
    }

$next=$obj->custom("SELECT id FROM topics WHERE id > ".$_POST['id']." ORDER BY id ASC LIMIT 1"); //TO SELECT NEXT SET OF QUOTES
$previous=$obj->custom("SELECT id FROM topics WHERE id < ".$_POST['id']." ORDER BY id DESC LIMIT 1"); //TO SELECT PREVIOUS SET OF QUOTES
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
                            <li <?php if(empty($previous[0]['id'])) echo 'class="disabled"'; ?>><a <?php if(!empty($previous[0]['id'])){?>onclick="topicsTranslation(<?php echo $previous[0]['id']; ?>)"<?php } ?>><span class="glyphicon glyphicon-arrow-left"></span> Previous</a></a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li <?php if(empty($next[0]['id'])) echo 'class="disabled"'; ?>><a <?php if(!empty($next[0]['id'])){?>onclick="topicsTranslation(<?php echo $next[0]['id']; ?>)"<?php } ?>><span class="glyphicon glyphicon-arrow-right"></span> Next</a></li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        </div>
    </div>
</div>

<div class="portlet-heading">
    <h3 class="portlet-title text-dark text-uppercase">
        Topic
    </h3>
    <div class="clearfix"></div>
</div>
<!-- ENGLISH -->
<?php if(isset($_SESSION['permission'][0]) && !empty($_SESSION['permission'][0]) && isset($_SESSION['lang']) && !empty($_SESSION['lang'])){ //Permission to insert
                 if($_SESSION['lang']=='eng' || $_SESSION['lang']=='all'){ ?>
<div class="container quote-form" id="t-eng">
    <div class="row">
        <div class="col-xs-12 relative-container">
            <label onclick="closeForm()"><span class="glyphicon glyphicon-remove"></span> Hide</label>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="tp-en" data-error="Field required" aria-describedby="topic" placeholder="Enter Topic..."  oninput="checkAvailability(this)">
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="keywords-en" data-error="Field required" aria-describedby="topic" placeholder="Keywords separated by coma...">
                
            </div>
        </div>        
        <div class="form-group col-xs-12">
            <div class="input-group">
                <button type="button" class="btn btn-primary" onclick="save(this,'en',<?php echo $_POST['id']; ?>,'English')" id="save-en">Save</button>
            </div>
        </div>
    </div>
</div>
<?php } } ?>
<!-- SPANISH -->
<?php if(isset($_SESSION['permission'][0]) && !empty($_SESSION['permission'][0]) && isset($_SESSION['lang']) && !empty($_SESSION['lang'])){ //Permission to insert
                 if($_SESSION['lang']=='es' || $_SESSION['lang']=='all'){ ?>
<div class="container quote-form" id="t-es">
    <div class="row">
        <div class="col-xs-12 relative-container">
            <label onclick="closeForm()"><span class="glyphicon glyphicon-remove"></span> Ocultar</label>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="tp-es" data-error="Field required" aria-describedby="topic" placeholder="Ingresa tema..."  oninput="checkAvailability(this)">
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="keywords-es" data-error="Field required" aria-describedby="topic" placeholder="Keywords separados por coma...">
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <button type="button" class="btn btn-primary" onclick="save(this,'es',<?php echo $_POST['id']; ?>,'Spanish')" id="save-es">Guardar</button>
            </div>
        </div>
    </div>
</div>
<?php } } ?>
<!-- PORTUGUESE -->
<?php if(isset($_SESSION['permission'][0]) && !empty($_SESSION['permission'][0]) && isset($_SESSION['lang']) && !empty($_SESSION['lang'])){ //Permission to insert
                 if($_SESSION['lang']=='pt' || $_SESSION['lang']=='all'){ ?>
<div class="container quote-form" id="t-pt">
    <div class="row">
        <div class="col-xs-12 relative-container">
            <label onclick="closeForm()"><span class="glyphicon glyphicon-remove"></span> Ocultar</label>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="tp-pt" data-error="Field required" aria-describedby="topic" placeholder="Digite tópico..."  oninput="checkAvailability(this)">
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="keywords-pt" data-error="Field required" aria-describedby="topic" placeholder="Keywords separados por vírgulas...">
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <button type="button" class="btn btn-primary" onclick="save(this,'pt',<?php echo $_POST['id']; ?>,'Portuguese')" id="save-pt">Salvar</button>
            </div>
        </div>
    </div>
</div>
<?php } } ?>


<div class="container">
    <?php if(isset($translations[0]['tEN_id']) && !empty($translations[0]['tEN_id'])){ ?>
        <div class="row">
            <h1>English</h1>
            <?php $images = $obj->find_by('topicsImages','tID',$_POST['id']); ?>
            <div class="col-xs-12 col-sm-6 col-md-4 box-content">
                <div class="inner-box background" style="background-image:url('<?php echo $images[0]['img_url'] ?>');">
                    <h3 data-placement="top" title="Edit Topic" <?php if(isset($_SESSION['permission'][1]) && !empty($_SESSION['permission'][1]) && isset($_SESSION['lang']) && !empty($_SESSION['lang'])){if($_SESSION['lang']=='en' || $_SESSION['lang']=='all'){ ?>onclick="openUpdate(<?php echo $topicID[0]['topicID'] ?>,<?php echo $_POST['id']; ?>,'eng')"<?php } } ?>><a><?php echo $topicID[0]['topicName'] ?></a></h3>
                </div>
            </div>
        </div>
    <?php
        } else{
             if(isset($_SESSION['permission'][0]) && !empty($_SESSION['permission'][0]) && isset($_SESSION['lang']) && !empty($_SESSION['lang'])){ //Permission to insert
                 if($_SESSION['lang']=='eng' || $_SESSION['lang']=='all'){
    ?>
        <div class="row">
            <div class="col-lg-12 text-dark"><span class="addquote" onclick="openForm(this,'eng')"><span class="glyphicon glyphicon-edit"></span> Add a new topic</span></div>
        </div>
    <?php
                 }
             }
        }
    ?>
    <!-- SPA -->
    <?php if(isset($translations[0]['tES_id']) && !empty($translations[0]['tES_id'])){ ?>
        <div class="row">
            <h1>Español</h1>
            <?php $images = $obj->find_by('topicsImages','tID',$_POST['id']); ?>
            <div class="col-xs-12 col-sm-6 col-md-4 box-content">
                <div class="inner-box background" style="background-image:url('<?php echo $images[0]['img_url'] ?>');">
                    <h3 data-placement="top" title="Edit Topic" <?php if(isset($_SESSION['permission'][1]) && !empty($_SESSION['permission'][1]) && isset($_SESSION['lang']) && !empty($_SESSION['lang'])){if($_SESSION['lang']=='es' || $_SESSION['lang']=='all'){ ?>onclick="openUpdate(<?php echo $topicIDES[0]['topicID'] ?>,<?php echo $_POST['id']; ?>,'es')"<?php } } ?>><a><?php echo $topicIDES[0]['topicName'] ?></a></h3>
                </div>
            </div>
        </div>
    <?php
        } else{
            if(isset($_SESSION['permission'][0]) && !empty($_SESSION['permission'][0]) && isset($_SESSION['lang']) && !empty($_SESSION['lang'])){ //Permission to insert
                 if($_SESSION['lang']=='es' || $_SESSION['lang']=='all'){
    ?>
        <div class="row">
            <div class="col-lg-12 text-dark"><span class="addquote" onclick="openForm(this,'es')"><span class="glyphicon glyphicon-edit"></span> Agregar tema</span></div>
        </div>
    <?php
                }
             }
        }
    ?>
    <!-- PT -->
    <?php if(isset($translations[0]['tPT_id']) && !empty($translations[0]['tPT_id'])){ ?>
        <div class="row">
            <h1>Português</h1>
            <?php $images = $obj->find_by('topicsImages','tID',$_POST['id']); ?>
            <div class="col-xs-12 col-sm-6 col-md-4 box-content">
                <div class="inner-box background" style="background-image:url('<?php echo $images[0]['img_url'] ?>');">
                    <h3 data-placement="top" title="Edit Topic" <?php if(isset($_SESSION['permission'][1]) && !empty($_SESSION['permission'][1]) && isset($_SESSION['lang']) && !empty($_SESSION['lang'])){if($_SESSION['lang']=='pt' || $_SESSION['lang']=='all'){ ?>onclick="openUpdate(<?php echo $topicIDPT[0]['topicID'] ?>,<?php echo $_POST['id']; ?>,'pt')"<?php } } ?>><a><?php echo $topicIDPT[0]['topicName'] ?></a></h3>
                </div>
            </div>
        </div>
    <?php
        } else{
             if(isset($_SESSION['permission'][0]) && !empty($_SESSION['permission'][0]) && isset($_SESSION['lang']) && !empty($_SESSION['lang'])){ //Permission to insert
                 if($_SESSION['lang']=='pt' || $_SESSION['lang']=='all'){
    ?>
        <div class="row">
            <div class="col-lg-12 text-dark"><span class="addquote" onclick="openForm(this,'pt')"><span class="glyphicon glyphicon-edit"></span> Adicionar novo tópico</span></div>
        </div>
    <?php
                 }
             }
        }
    ?>
</div>

<!-- Load with Jquery Load function -->
<script>
    $(document).ready(function(){
        $('.quote-form').hide();
    });
    var closeForm=function(){
        $('.quote-form').hide(500);
        $('.addquote').show();
    }
    var openForm=function(el,lang,language){
        $('#t-'+lang).show(500);
        $('.addquote').hide(100);
        $('.quote-form').not('#t-'+lang).hide();
    }
    
    var closeUpdate=function(){
        $('#update-form').hide(500);
    }
    var openUpdate=function(topID,resRel,lan){
        $('.quote-form').not('#t-'+lan).hide();
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
        var topic = find_by('topics_'+lang,'topicID',topID);
        //document.getElementById('image-box2').innerHTML="";
        topic.done(function(data){
            if(Object.keys(data[0][0]).length > 1){
                document.getElementById('save-'+lang).setAttribute("onclick","updateTopic(this,'"+lang+"','"+language+"',"+data[0][0].topicID+","+resRel+")");
                $('#t-'+lan).show(500);
                $('#tp-'+lang).val(data[0][0].topicName);
                $('#keywords-'+lang).val(data[0][0].keywords);
                $('#tp-'+lang).focus();
                /*var topicRel = find_by('topics','t'+lang.toUpperCase()+'_id',topID);
                topicRel.done(function(data2){
                    var topicImages = find_by('topicsImages','tID',data2[0][0].id);
                    topicImages.done(function(response){
                        for(var i in response[0]){
                            imagesToUpdate(response[0][i].img_url,response[0][i].id);
                        }
                    });
                });*/
            }
        });
    }
    
    var updateTopic = function(el,lang,language,topID,resRel){
        var topic = $('#tp-'+lang).val(),
            keywords = $('#keywords-'+lang).val(),
            arr = {};
        if(topic && topic != ''){
            arr['topicName'] = topic;
            var seo = topic.replace(/["']/g, "");
            arr['seo_url'] = seo.split(' ').join('-').toLowerCase();
        }
        else
            console.log('Error topic');
        if(keywords && keywords != '')
            arr['keywords'] = keywords;
        else
            console.log('Error keyword');
        if(arr['topicName'] != '' && arr['keywords'] != ''){
            $(el).attr('disabled','disabled');
            var token = generateToken();
            token.done(function(generatedToken){
                var update_topic = update('topics_'+lang,arr,'topicID',topID,generatedToken);
                update_topic.done(function(data){
                    //NEW STUFF
                    var logArr={};
                    logArr['log']=' has edited a Topic in '+language+'. Topic ID: <a class="idREL" onclick="topicsTranslation('+resRel+')">'+resRel+'</a>';
                    var log=insertLog('dashboard_logs',logArr,'logs');
                    log.done(function(res2){
                        console.log(res2);
                        topicsTranslation(resRel);
                    });
                });
            });
        }
    }
    
    var save = function(el,lang,relationID,language){
        $(el).attr('disabled','disabled');
        var topic = $('#tp-'+lang).val(),
            keywords = $('#keywords-'+lang).val(),
            arr = {};
        if(topic && topic != '')
            arr['topicName'] = topic;
        if(keywords && keywords != '')
            arr['keywords'] = keywords;
        if(Object.keys(arr).length > 1){
            var token = generateToken();
            token.done(function(generatedToken){
                var table = 'topics_'+lang;
                var insert_topic = insert(table,arr,generatedToken);
                insert_topic.done(function(response){                    
                    var lastTopic = limit(table,'topicID','topicID',1);
                    lastTopic.done(function(data){
                        //NEW STUFF
                        var logArr={},relArr={};
                        relArr['topicID']=data[0][0].topicID;
                        var topicQuoteRel=insertLog('dashboardUsr_Topic_'+lang,relArr,'relation');
                        topicQuoteRel.done(function(res){
                            console.log(res);
                            logArr['log']=' has translated a Topic in '+language+'. Topic ID: <a class="idREL" onclick="topicsTranslation('+relationID+')">'+relationID+'</a>';
                            var log=insertLog('dashboard_logs',logArr,'logs');
                            log.done(function(res2){
                                console.log(res2);
                            });
                        });
                        
                        var arr2={},
                            uppercaseLang = lang.toUpperCase();
                        arr2['t'+uppercaseLang+'_id']=data[0][0].topicID;
                        var token2 = generateToken();
                        token2.done(function(generatedToken2){
                            var updateRelation = update('topics',arr2,'id',relationID,generatedToken2);
                            updateRelation.done(function(updated){
                                topicsTranslation(relationID);
                            });
                        });
                    });
                });
            });
        } else{
            $(el).removeAttr('disabled');
            console.log('Error!');
        }
    }
</script>