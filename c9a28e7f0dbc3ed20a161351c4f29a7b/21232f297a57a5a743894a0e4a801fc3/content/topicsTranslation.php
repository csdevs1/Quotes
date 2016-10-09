<?php
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

?>

<!-- Load with Jquery Load function -->

<div class="portlet-heading">
    <h3 class="portlet-title text-dark text-uppercase">
        Topic
    </h3>
    <div class="clearfix"></div>
</div>

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
                <button type="button" class="btn btn-primary" onclick="save(this,'en',<?php echo $_POST['id']; ?>)">Save</button>
            </div>
        </div>
    </div>
</div>

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
                <button type="button" class="btn btn-primary" onclick="save(this,'es',<?php echo $_POST['id']; ?>)">Guardar</button>
            </div>
        </div>
    </div>
</div>

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
                <button type="button" class="btn btn-primary" onclick="save(this,'pt',<?php echo $_POST['id']; ?>)">Salvar</button>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <?php if(isset($translations[0]['tEN_id']) && !empty($translations[0]['tEN_id'])){ ?>
        <div class="row">
            <h1>English</h1>
            <?php
                foreach($topicID as $key=>$val){
                    $images = $obj->find_by('topicsImages','tID',$_POST['id']);
            ?>
            <div class="col-xs-12 col-sm-6 col-md-4 box-content">
                <div class="inner-box background" style="background-image:url('<?php echo $images[0]['img_url'] ?>');">
                    <h3 data-placement="top" title="Edit Topic"><a><?php echo $topicID[$key]['topicName'] ?></a></h3>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    <?php
        } else{
    ?>
        <div class="row">
            <div class="col-lg-12 text-dark"><span class="addquote" onclick="openForm(this,'eng')"><span class="glyphicon glyphicon-edit"></span> Add a new topic</span></div>
        </div>
    <?php
        }
    ?>
    <!-- SPA -->
    <?php if(isset($translations[0]['tES_id']) && !empty($translations[0]['tES_id'])){ ?>
        <div class="row">
            <h1>Español</h1>
            <?php
                foreach($topicIDES as $key=>$val){
                    $images = $obj->find_by('topicsImages','tID',$_POST['id']);
            ?>
            <div class="col-xs-12 col-sm-6 col-md-4 box-content">
                <div class="inner-box background" style="background-image:url('<?php echo $images[0]['img_url'] ?>');">
                    <h3 data-placement="top" title="Edit Topic"><a><?php echo $topicIDES[$key]['topicName'] ?></a></h3>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    <?php
        } else{
    ?>
        <div class="row">
            <div class="col-lg-12 text-dark"><span class="addquote" onclick="openForm(this,'es')"><span class="glyphicon glyphicon-edit"></span> Agregar tema</span></div>
        </div>
    <?php
        }
    ?>
    <!-- PT -->
    <?php if(isset($translations[0]['tPT_id']) && !empty($translations[0]['tPT_id'])){ ?>
        <div class="row">
            <h1>Português</h1>
            <?php
                foreach($topicIDPT as $key=>$val){
                    $images = $obj->find_by('topicsImages','tID',$_POST['id']);
            ?>
            <div class="col-xs-12 col-sm-6 col-md-4 box-content">
                <div class="inner-box background" style="background-image:url('<?php echo $images[0]['img_url'] ?>');">
                    <h3 data-placement="top" title="Edit Topic"><a><?php echo $topicIDPT[$key]['topicName'] ?></a></h3>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    <?php
        } else{
    ?>
        <div class="row">
            <div class="col-lg-12 text-dark"><span class="addquote" onclick="openForm(this,'pt')"><span class="glyphicon glyphicon-edit"></span> Adicionar novo tópico</span></div>
        </div>
    <?php
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
    var openForm=function(el,lang){
        $('#t-'+lang).show(500);
        $('.addquote').hide(100);
    }
    
    var save = function(el,lang,relationID){        
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