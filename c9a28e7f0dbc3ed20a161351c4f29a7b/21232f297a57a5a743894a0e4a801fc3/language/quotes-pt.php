<?php
   session_start();
    require_once('../Classes/AppController.php');
    $obj = new AppController();
    $quotes = $obj->all('quotes_pt');
?>

<!-- Load with Jquery Load function -->
<div class="portlet-heading">
    <h3 class="portlet-title text-dark text-uppercase">
        Suas Citações
    </h3>
    <div class="clearfix"></div>
    <?php if(isset($_SESSION['label']) && !empty($_SESSION['label']) && $_SESSION['label'] =='root'){ //Permission to insert ?>
        <div class="col-lg-12 text-dark"><span id="add-quote" onclick="openWindow(this);clearFields()"><span class="glyphicon glyphicon-edit"></span> Adicionar uma nova cotação</span></div>
    <?php } ?>
</div>
<?php if(isset($_SESSION['permission'][1]) && !empty($_SESSION['permission'][1]) && isset($_SESSION['lang']) && !empty($_SESSION['lang']) && $_SESSION['label']!='author'){
    if($_SESSION['lang']=='pt' || $_SESSION['lang']=='all'){ //Permission to insert    ?>
<div class="container quote-form" id="quote-form">
    <div class="row">
        <div class="col-xs-12 relative-container">
            <label onclick="closeWindow();clearFields()"><span class="glyphicon glyphicon-remove"></span> Ocultar</label>
        </div>
        <div class="col-xs-12">
            <textarea placeholder="Digite sua frase..." maxlength="500" class="textarea" id="quote" <?php if($_SESSION['label']=='image') echo 'disabled';?>></textarea>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="author" data-error="Field required" aria-describedby="author" placeholder="Digite autor..."  oninput="listSearch(this,'authorList','authors','author')" <?php if($_SESSION['label']=='image') echo 'disabled';?>>
                
                <div class="col-xs-12 search-list" id="authorList">
                    <ul class="list-unstyled">
                    </ul>
                </div>
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-chatbubble-working"></i></span>
                <input type="text" class="form-control" id="topic" data-error="Field required" aria-describedby="topic" placeholder="Digite tópico..." value="" <?php if($_SESSION['label']=='image') echo 'disabled';?>>
                
                <div class="col-xs-12 search-list" id="topicList">
                    <ul class="list-unstyled">
                    </ul>
                </div>
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-image"></i></span>                
                <input type="file" class="form-control image-file" id="image" aria-describedby="image" placeholder="Adicionar uma imagem...<" accept="image/*">          
                <span class="up-label">Adicionar uma imagem...</span>
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <button type="button" class="btn btn-primary" onclick="save(this)" id="save">Salvar</button>
            </div>
        </div>
    </div>
</div>
<?php } } ?>
<div id="portlet1" class="panel-collapse collapse in">
    <div class="portlet-body">
        <section role="contentinfo">
            <div class="container">
                <div class="row">
                    <div class="masonry-container">
                        
                        <?php
                            foreach($quotes as $key=>$val){
                                $translations = $obj->find_by('quotes','pt_id',$quotes[$key]['quoteID']);
                        ?>
                        <div class="col-xs-12 col-sm-6 col-md-4 item quote data">
                            <div class="pad">
                                <?php if($_SESSION['label']!='author'){ ?><div class="circle-ref" onclick="quotesTranslation(<?php echo $translations[0]['id']; ?>)"><?php echo $translations[0]['id']; ?></div><?php } ?>
                                <?php if(isset($quotes[$key]['quoteImage']) && !empty($quotes[$key]['quoteImage'])){ ?>
                                    <img class="img-responsive" src="../../images/quotes/<?php echo $quotes[$key]['quoteImage']; ?>" alt="image description">
                                <?php } ?>
                                <blockquote><?php echo $quotes[$key]['quote']; ?> <span>- <?php echo $quotes[$key]['author']; ?></span></blockquote>
                                <div class="col-xs-8 col-md-8">
                                    Lang: 
                                    <?php if(isset($translations[0]['en_id']) && !empty($translations[0]['en_id'])){ ?>
                                        <img src="images/eng.png" width="25px" height="25px">
                                    <?php } ?>
                                    <?php if(isset($translations[0]['pt_id']) && !empty($translations[0]['pt_id'])){ ?>
                                        <img src="images/Portugal.png" width="25px" height="25px">
                                    <?php } ?>
                                    <?php if(isset($translations[0]['es_id']) && !empty($translations[0]['es_id'])){ ?>
                                        <img src="images/es.png" width="25px" height="25px">
                                    <?php } ?>
                                </div>
                                <?php if(isset($_SESSION['permission'][1]) && !empty($_SESSION['permission'][1]) && isset($_SESSION['lang']) && !empty($_SESSION['lang']) && $_SESSION['label']!='author'){
                                        if($_SESSION['lang']=='pt' || $_SESSION['lang']=='all'){ //Permission to insert    ?>
                                <div class="col-xs-4 col-md-4"><p><a class="like" onclick="openUpdate(<?php echo $quotes[$key]['quoteID'] ?>,<?php echo $translations[0]['id']; ?>);">Editar</a></p></div>
                                <?php } } ?>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<div class="container">
    <div class="paging-container col-xs-12" id="tablePaging">
    </div>
    <div class="col-xs-12 ">
        <div class="col-xs-12">
            <label for="pageN">Go to page:</label>
        </div>
        <div class="form-group col-xs-6">
            <div class="input-group">
                <input type="text" name="pageN" id="pageN" class="form-control" placeholder="Go to page...">
                <span class="input-group-addon page-go"><input type="submit" id="goto" class="btn btn-primary" value="Go" onclick="goToPage()"></span>
            </div>
        </div>
    </div>
    
    <!--<nav aria-label="Page navigation">
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
    </nav>-->
</div>
<script src="js/pagination.js?<?php echo time(); ?>"></script>
<!-- Load with Jquery Load function -->
<script src="assets/tagsinput/jquery.tagsinput.min.js"></script>
<script type="text/javascript">
    /*Pagination*/
    var count = <?php echo count($quotes); ?>;
    $(function () {
        load = function() {
            window.tp = new Pagination('#tablePaging', {
                itemsCount: count,
                //currentPage:3, Get this variable to 
                onPageSizeChange: function (ps) {
                    //console.log('changed to ' + ps);
                },
                onPageChange: function (paging) {
                    //custom paging logic here
                    //console.log(paging);
                    var start = paging.pageSize * (paging.currentPage - 1),
                        end = start + paging.pageSize,
                        $rows = $('.masonry-container').find('.data');
                    $rows.hide();
                    for (var i = start; i < end; i++) {
                        $rows.eq(i).show();
                    }
                }
            });
        }
        load();
    });
    
    var goToPage=function(){
        var nPage=$('#pageN').val();
        if(nPage>0){
            window.tp = new Pagination('#tablePaging', {
                itemsCount: count,
                currentPage:nPage,
                onPageSizeChange: function (ps) {
                    //console.log('changed to ' + ps);
                },
                onPageChange: function (paging) {
                    //custom paging logic here
                    //console.log(paging);
                    var start = paging.pageSize * (paging.currentPage - 1),
                        end = start + paging.pageSize,
                        $rows = $('.masonry-container').find('.data');
                    $rows.hide();
                    for (var i = start; i < end; i++) {
                        $rows.eq(i).show();
                    }
                }
            });
        }
    }

    $(document).ready(function() {
        var container = $('.masonry-container');
        container.masonry({
            columnWidth: '.item',
            itemSelector: '.item'
        });
    });

    $(document).ready(function($) {
        // Tags Input
        $('#topic').tagsInput({width:'auto'});
        $('.search-list').hide();
        document.getElementById('topic_tag').setAttribute('oninput','listSearch(this,"topicList","topics_pt","topic")');
        
       $('#topic_tag').bind("enterKey",function(e){
           console.log('Pressed Enter');
       });
        $('#topic_tag').keyup(function(e){
            if(e.keyCode == 13){
                detectWord();
                $('#topicList').slideUp();
            }
        });
        
    });
	var clearFields=function(){
        $('#author').val('');
        $('#quote').val('');
        $('.tag').remove();
    }
    
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
            $(this).next().text("Oops! Isso não é uma imagem!");
        }
    });
    
    var openUpdate = function(quotID,resRel){
        $('.tag').remove();
        $('#topic').val('');
        var quote = find_by('quotes_pt','quoteID',quotID);
        $('#save').attr('onclick','updateQuote(this,'+quotID+','+resRel+')');
        document.getElementById('save').innerHTML="Update";
        quote.done(function(data){
            if(Object.keys(data[0][0]).length > 1){
                $('#quote-form').show(500);
                $('#quote').val(data[0][0].quote);
                $('#author').val(data[0][0].author);
                var getTopics = find_by('quotesTopicPT','quoteID',quotID);
                getTopics.done(function(rel){
                    for(var i in rel[0]){
                        var topic = find_by('topics_pt','topicID',rel[0][i].topicID);
                        topic.done(function(response){
                            var val = document.getElementById('topic').value;
                            if(document.getElementById('topic').value!=""){
                                $('#topic').addTag(response[0][0].topicName);
                                <?php if($_SESSION['label']=='image'){ ?>
                                    $('.tag a').remove();
                                <?php } ?>
                            }else{
                                $('#topic').addTag(response[0][0].topicName);
                                <?php if($_SESSION['label']=='image'){ ?>
                                    $('.tag a').remove();
                                <?php } ?>
                            }
                        });
                    }
                });
            }
        });
    }
    
    var updateQuote = function(el, quotID,resRel){
        el.innerHTML = "Updating...";
        var quote = $('#quote').val(),
            author = $('#author').val(),
            topics = $('#topic').val();
        if(!quote || quote==''){
            console.log('Error quote');
            $(el).removeAttr('disabled');
            el.innerHTML = "Update";
        }else if(!author || author==''){
            console.log('Error author');
            $(el).removeAttr('disabled');
            el.innerHTML = "Update";
        }else if(!topics || topics==''){
            console.log('Error topic');
            $(el).removeAttr('disabled');
            el.innerHTML = "Update";
        }else{
            var arr = {};
            arr['quote']=quote;
            arr['author']=author;
            if($('#image').val() && $('#image').val() !=''){
                var image=$('#image').prop('files')[0];
            }
            var token = generateToken();
            token.done(function(generatedToken){
                var quoteUpdate = update('quotes_pt',arr,'quoteID',quotID,generatedToken,image);
                quoteUpdate.done(function(data){
                    //NEW STUFF
                    var logArr={};
                    logArr['log']=' has edited a Quote in Portuguese. Quote ID: <a class="idREL" onclick="quotesTranslation('+resRel+')">'+resRel+'</a>';
                    var log=insertLog('dashboard_logs',logArr,'logs');
                    log.done(function(res2){
                        console.log(res2);
                    });
                    console.log(data);
                    var token2 = generateToken();
                    token2.done(function(generatedToken2){
                        var deleteRel = delete_function('quotesTopicPT','quoteID',quotID,generatedToken2);
                        deleteRel.done(function(delResponse){
                            console.log(delResponse);
                            var arr2={};
                            arr2['quoteID']=quotID;
                            var topic = topics.split(',');
                            for(var i in topic){
                                var topicSearch = find_by('topics_pt','topicName',topic[i]);
                                topicSearch.done(function(topicId){
                                    var token3 = generateToken();
                                    token3.done(function(generatedToken3){
                                        arr2['topicID']=topicId[0][0].topicID;
                                        var topicQuote = insert('quotesTopicPT',arr2,generatedToken3);
                                        topicQuote.done(function(data2){
                                            console.log(data2);
                                            $(el).removeAttr('disabled');
                                            el.innerHTML = "Update!";
                                            setTimeout(function() {
                                                portuguese('Quote saved successfully!',document.getElementById('pt'));
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
    
    var save = function(el){
        $(el).attr('disabled','disabled');
        //el.innerHTML = "Saving...";
        var quote = $('#quote').val(),
            author = $('#author').val(),
            topics = $('#topic').val();
        if(!quote || quote==''){
            console.log('Error quote');
            $(el).removeAttr('disabled');
            //el.innerHTML = "Save";
        }else if(!author || author==''){
            console.log('Error author');
            $(el).removeAttr('disabled');
            //el.innerHTML = "Save";
        }else if(!topics || topics==''){
            console.log('Error topic');
            $(el).removeAttr('disabled');
            //el.innerHTML = "Save";
        }else{
            var arr = {};
            arr['quote']=quote;
            arr['author']=author;
            if($('#image').val() && $('#image').val() !=''){
                var image=$('#image').prop('files')[0];
            }
            var token1 = generateToken();
            token1.done(function(generatedToken1){
                var newQuote = insert('quotes_pt',arr,generatedToken1,image);
                newQuote.done(function(response){
                    if(response){
                        var lastQuote = limit('quotes_pt','quoteID','quoteID',1);
                        lastQuote.done(function(dataID){
                            var arr2={},
                                arr3={},
                                logArr={},relArr={};
                            arr2['quoteID']=dataID[0][0].quoteID;
                            arr3['pt_id']=dataID[0][0].quoteID;
                            relArr['quoteID']=dataID[0][0].quoteID;
                            var token2 = generateToken();
                            token2.done(function(generatedToken2){
                                var quoteRelation = insert('quotes',arr3,generatedToken2);
                                quoteRelation.done(function(re){
                                    console.log('Rel: '+ re);
                                    //NEW STUFF
                                    var userQuoteRel=insertLog('dashboardUsr_Quote_pt',relArr,'relation');
                                    userQuoteRel.done(function(res){
                                        console.log(res);
                                        var lastRel=find_by('quotes','es_id',dataID[0][0].quoteID);
                                        lastRel.done(function(resRel){
                                            logArr['log']=' has inserted a new Quote in Portuguese. Quote ID: <a class="idREL" onclick="quotesTranslation('+resRel[0][0].id+')">'+resRel[0][0].id+'</a>';
                                            var log=insertLog('dashboard_logs',logArr,'logs');
                                            log.done(function(res2){
                                                console.log(res2);
                                            });
                                        });
                                    });
                                });
                            });
                            var topic = topics.split(',');
                            for(var i in topic){
                                var topicSearch = find_by('topics_pt','topicName',topic[i]);
                                topicSearch.done(function(topicId){
                                    var token3 = generateToken();
                                    token3.done(function(generatedToken3){
                                        arr2['topicID']=topicId[0][0].topicID;
                                        var topicQuote = insert('quotesTopicPT',arr2,generatedToken3);
                                        topicQuote.done(function(data){
                                            var topicQuote = insert('quotesTopicPT',arr2,generatedToken3);
                                            $(el).removeAttr('disabled');
                                            el.innerHTML = "Salvou!";
                                            setTimeout(function() {
                                                portuguese('Frase salvas com sucesso!',document.getElementById('pt'));
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
    
    var listSearch = function(el,id,table,row){
        if(el.value=="" || el.value=="add a tag"){
            $('#'+id).slideUp();
        }else {
            if($(el).is(':focus'))
                $('.search-list').not('#'+id).slideUp();
            $('#'+id).slideDown();
            var pattern = $(el).val()+'%';
            if(row=='topic')
                var arr = {'topicName':'topicName'};
            else
                var arr = {'authorName':'authorName'};
            var search = like(table,arr,pattern);
            search.done(function(response){
                if(Object.keys(response[0]).length != 0){
                    $('#'+id+' ul').html('');
                    for(var i in response[0]){
                        if(row==='topic')
                            $('#'+id+' ul').append('<li  onclick="selectTag(this,\''+row+'\',\'csv\')">'+response[0][i].topicName+'</li>');
                        else
                            $('#'+id+' ul').append('<li  onclick="selectTag(this,\''+row+'\')">'+response[0][i].authorName+'</li>');
                    }
                } else
                    $('#'+id+' ul').html('<li>Não encontrado!</li>');
            });
        }
    }
    
    function detectWord(){
        var incorrecTag = $('.tag').last().children('span').html().split('&');
        var topicSearch = find_by('topics_es','topicName',incorrecTag[0]);
        topicSearch.done(function(response){
            if(Object.keys(response[0]).length == 0)
                $('.tag').last().children('a').click();
        });
    }
    
    var selectTag=function(el,inp,format=""){
        var elVal = el.innerHTML;
        if(format=="csv"){
            var val = document.getElementById(inp).value.split(',');
            val[val.length-1] = elVal;
            document.getElementById(inp).value = val.join(',');
            detectWord();
            var incorrecTag = $('.tag').last().children('span').html().split('&');
            $(el).parent().parent().slideUp();
        }
        else{
            document.getElementById(inp).value = elVal;
            $(el).parent().parent().slideUp();
        }
    }
</script>

<?php if($_SESSION['label']=='image'){ ?>
<script>
    $(document).ready(function(){
        $('#topic_tag').attr('disabled','disabled');
    });
</script>
<?php } ?>