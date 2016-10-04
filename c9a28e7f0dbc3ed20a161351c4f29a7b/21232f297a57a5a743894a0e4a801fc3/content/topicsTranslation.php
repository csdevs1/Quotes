<?php
    require_once('../Classes/AppController.php');
    $obj = new AppController();
    $translations = $obj->find_by('topics','id',$_POST['id']);
    if(isset($translations[0]['tEN_id']) && !empty($translations[0]['tEN_id'])){
        $topicID = $obj->find_by('topics_en','topicID',$translations[0]['tEN_id']);
    }
    if(isset($translations[0]['tES_id']) && !empty($translations[0]['tES_id'])){
        $topicID = $obj->find_by('topics_es','topicID',$translations[0]['tES_id']);
    }
    if(isset($translations[0]['tPT_id']) && !empty($translations[0]['tPT_id'])){
        $topicID = $obj->find_by('topics_pt','topicID',$translations[0]['tPT_id']);
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
                <input type="text" class="form-control" id="topic" data-error="Field required" aria-describedby="topic" placeholder="Enter Topic..."  oninput="checkAvailability(this)">
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="keywords" data-error="Field required" aria-describedby="topic" placeholder="Keywords separated by coma...">
                
            </div>
        </div>        
        <div class="form-group col-xs-12">
            <div class="input-group">
                <button type="button" class="btn btn-primary" onclick="save(this)">Save</button>
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
                <button type="button" class="btn btn-primary" onclick="save(this)">Guardar</button>
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
                <input type="text" class="form-control" id="topic" data-error="Field required" aria-describedby="topic" placeholder="Digite tópico..."  oninput="checkAvailability(this)">
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="keywords" data-error="Field required" aria-describedby="topic" placeholder="Keywords separados por vírgulas...">
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <button type="button" class="btn btn-primary" onclick="save(this)">Salvar</button>
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
    
    var save = function(){}
</script>