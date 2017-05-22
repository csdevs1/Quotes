<?php
    session_start();
    
    require_once('../Classes/AppController.php');
    $obj = new AppController();
    //$quotes = $obj->all('quotes_en');

//PAGINATOR
if(empty($_POST['dataARR'])){
    require_once('../Classes/Paginator.php');
    $limit = (isset( $_GET['limit'])) ? $_GET['limit'] : 10;
    $page = (isset( $_POST['page'])) ? $_POST['page'] : 1;
    $links = (isset( $_POST['links'])) ? $_POST['links'] : 7;
    $Paginator  = new Paginator('quotes_en');
    $quotesARR = $Paginator->getData("quotes_en",'quoteID',$limit,$page);
    $quotes=$quotesARR->data;
}else{
    $quotes=$_POST['dataARR'];
}
?>
<!-- Load with Jquery Load function -->
<div class="portlet-heading">
    <h3 class="portlet-title text-dark text-uppercase">
        Quotes
    </h3>
    <div class="clearfix"></div>
   <?php if(isset($_SESSION['permission'][1]) && !empty($_SESSION['permission'][1]) && isset($_SESSION['lang']) && !empty($_SESSION['lang']) && $_SESSION['label']!='author' && $_SESSION['label']!='image'){
    if($_SESSION['lang']=='eng' || $_SESSION['lang']=='all'){ //Permission to insert ?>
        <div class="col-lg-12 text-dark"><span id="add-quote" onclick="openWindow(this);clearFields();setAuthor()"><span class="glyphicon glyphicon-edit"></span> Add a new quote</span></div>
    <?php } } ?>
</div>
<?php if(isset($_SESSION['permission'][1]) && !empty($_SESSION['permission'][1]) && isset($_SESSION['lang']) && !empty($_SESSION['lang']) && $_SESSION['label']!='author'){
    if($_SESSION['lang']=='eng' || $_SESSION['lang']=='all'){ //Permission to insert ?>
<div class="container quote-form" id="quote-form">
    <div class="row">
        <div class="col-xs-12 relative-container">
            <label onclick="closeWindow();clearFields()"><span class="glyphicon glyphicon-remove"></span> Hide</label>
        </div>
        <div class="col-xs-12">
            <span class="label label-info" style="font-size:1.3rem" id="match"></span>
            <span class="label label-warning" style="font-size:1.3rem" id="char-length"></span>
            <div id="textarea_feedback"></div>
            <textarea placeholder="Insert your quote..." maxlength="380" class="textarea" id="quote" oninput="match(this)" <?php if($_SESSION['label']=='image') echo 'disabled';?>></textarea>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="author" data-error="Field required" aria-describedby="author" placeholder="Enter Author..."  oninput="listSearch(this,'authorList','authors','author')" <?php if($_SESSION['label']=='image') echo 'disabled';?>>
                <?php if($_SESSION['label']!='image'){ ?>
                <div class="col-xs-12 search-list" id="authorList">
                    <ul class="list-unstyled">
                    </ul>
                </div>
                <?php } ?>
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-chatbubble-working"></i></span>
                <input type="text" class="form-control" id="topic" data-error="Field required" aria-describedby="topic" placeholder="Enter Topic" value="" <?php if($_SESSION['label']=='image') echo 'disabled';?>>
                <?php if($_SESSION['label']!='image'){?>
                <div class="col-xs-12 search-list" id="topicList">
                    <ul class="list-unstyled">
                    </ul>
                </div>
                <?php }?>
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-image"></i></span>                
                <input type="file" class="form-control image-file" id="image" aria-describedby="image" placeholder="Upload Image" accept="image/*">          
                <span class="up-label">Upload an image</span>
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <button type="button" class="btn btn-primary" onclick="save(this)" id="save">Save</button>
            </div>
        </div>
    </div>
</div>
<?php } } ?>

<div id="portlet1" class="panel-collapse collapse in">    
    <div class="portlet-body">
        <section role="contentinfo">
            <div class="">
                <div class="row">
                    <div class="masonry-container">
                        
                        <?php
                            foreach($quotes as $key=>$val){
                                $translations = $obj->find_by('quotes','en_id',$quotes[$key]['quoteID']);
                        ?>
                        <div class="col-xs-12 col-sm-6 col-md-4 item quote data">
                            <div class="pad clearfix">
                                <?php if($_SESSION['label']!='author'){ ?><div class="circle-ref" onclick="quotesTranslation(<?php echo $translations[0]['id']; ?>)"><?php echo $translations[0]['id']; ?></div><?php } ?>
                                <?php if(isset($quotes[$key]['tinyImg']) && !empty($quotes[$key]['tinyImg'])){ ?>
                                    <img class="img-responsive" src="https://portalquote.com/images/quotes/<?php echo $quotes[$key]['tinyImg']; ?>" alt="image description">
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
                                        if($_SESSION['lang']=='eng' || $_SESSION['lang']=='all'){ //Permission to insert    ?>
                                        <div class="col-xs-4 col-md-4"><p><a class="like" onclick="openUpdate(<?php echo $quotes[$key]['quoteID']; ?>,<?php echo $translations[0]['id']; ?>);">Edit</a></p></div>
                                <?php } } ?>
                                <?php if(isset($quotes[$key]['tinyImg']) && !empty($quotes[$key]['tinyImg']) && $_SESSION['label']=='root'){ ?>
                                       
                                <div class="col-xs-12">
                                    <?php if($quotes[$key]['active_img']==0){ ?><a class="btn btn-success activate-img shuffle-img" data-qtid="<?php echo $quotes[$key]['quoteID']; ?>">Activate Image</a><?php } ?>
                                    <?php if($quotes[$key]['active_img']!=0){ ?><a class="text-muted btn btn-warning deactivate-img shuffle-img" data-qtid="<?php echo $quotes[$key]['quoteID']; ?>">Deactivate Image</a><?php } ?>
                                </div>
                                <?php } ?>
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
<?php if(empty($_POST['dataARR'])){ ?>
<div class="container">
    <nav aria-label="Page navigation">
        <?php echo $Paginator->createLinks($links, 'pagination pagination-sm','quotes'); ?> 
    </nav>
</div>

<div class="container">
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
</div>
<?php } ?>
<script src="js/pagination.js?<?php echo time(); ?>"></script>
<!-- Load with Jquery Load function -->
<script src="assets/tagsinput/jquery.tagsinput.min.js"></script>
<script>
    if($('#search1').length)
        $('#search1').attr('id','search');
    
    //Activate or deactivate image_type_to_extension
    $('.shuffle-img').click(function(){
        var el=this;
        var quoteID=$(this).attr('data-qtid');
        arr = {};
        if($(el).hasClass('activate-img')){
            var token = generateToken();
            token.done(function(generatedToken){
                arr['active_img'] = 1;
                var activate = update('quotes_en',arr,'quoteID',quoteID,generatedToken);
                activate.done(function(data){
                    console.log(data);
                    $(el).removeClass('activate-img');
                    $(el).addClass('dectivate-img');
                    $(el).removeClass('btn-success');
                    $(el).addClass('btn-warning');
                    $(el).text('Deactivate Image');
                });
            });
        } else{
            var token = generateToken();
            token.done(function(generatedToken){
                arr['active_img'] = 0;
                var deactivate = update('quotes_en',arr,'quoteID',quoteID,generatedToken);
                deactivate.done(function(data){
                    console.log(data);
                    $(el).removeClass('deactivate-img');
                    $(el).addClass('activate-img');
                    $(el).removeClass('btn-warning');
                    $(el).addClass('btn-success');
                    $(el).text('Activate Image');
                });
            });
        }
    });
    /*Pagination*/
    /*
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
    });*/
    
    var goToPage=function(){
        var nPage=$('#pageN').val();
        english(document.getElementById('eng'),nPage);
        /*var nPage=$('#pageN').val();
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
        }*/
    }
    $(document).ready(function() {        
        /*var container = $('.masonry-container');
        container.masonry({
            columnWidth: '.item',
            itemSelector: '.item'
        });*/
        var $container = $('.masonry-container');
        $container.imagesLoaded( function() {
        $container.masonry({
            columnWidth: '.item',
            itemSelector: '.item'
        });
    }); 
        var text_max = 380;
        $('#textarea_feedback').html('('+text_max + ' characters remaining)');
        $('#quote').keyup(function() {
            var text_length = $('#quote').val().length;
            var text_remaining = text_max - text_length;
            $('#textarea_feedback').html('('+text_remaining + ' characters remaining)');
        });
    });
    
    var idleTime = 0;
    
    $(document).ready(function($) {        
        // Tags Input
        $('#topic').tagsInput({width:'auto'});
        $('.search-list').hide();
        document.getElementById('topic_tag').setAttribute('oninput','listSearch(this,"topicList","topics_en","topic")');
        
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
    function timerIncrement() {
        idleTime = idleTime + 1;
        if (idleTime > 10) { // 10 minutes
            signout();
        }
    }
    
    var clearFields=function(){
        $('#author').val('');
        $('#quote').val('');
        $('.tag').remove();
    }
    
    var setAuthor=function(){
        if(localStorage.getItem("authorName")!=null)
            $('#author').val(localStorage.getItem("authorName"));
        else
            $('#author').val('');
    }
    
    function resizeImage(imgObj){
        var canvas = document.createElement('canvas');
        var canvasContext = canvas.getContext('2d');
        canvas.width = 700;
        canvas.height = 400;
        canvasContext.drawImage(imgObj, 0, 0,700,400);
        return canvas.toDataURL('image/jpeg');
    }
    var $imgToUpload;
    $("#image").on("change", function(){
        var imgType = $(this).prop('files')[0].type,
            imageUrl = URL.createObjectURL($(this).prop('files')[0]),
            myImage = new Image();;
        if(imgType.split('/')[0] == 'image'){
            // Name of file and placeholder
            var file = this.files[0].name;
            var dflt = $(this).attr("placeholder");
            if($(this).val()!=""){
                $(this).next().text(file);
                myImage.src = imageUrl;
                myImage.onload = function () {
                    $imgToUpload=resizeImage(myImage);
                }                
            } else {
                $(this).next().text(dflt);
            }
        } else {
            document.getElementById("image").value = "";
            $(this).next().text("Oops! that's not an image!");
        }
    });
    
    var openUpdate = function(quotID,resRel){
        $('.tag').remove();
        $('#topic').val('');
        var quote = find_by('quotes_en','quoteID',quotID);
        $('#save').attr('onclick','updateQuote(this,'+quotID+','+resRel+')');
        document.getElementById('save').innerHTML="Update";
        quote.done(function(data){
            if(Object.keys(data[0][0]).length > 1){
                $('#quote-form').show(500);
                $('#quote').val(data[0][0].quote);
                $('#author').val(data[0][0].author);
                var getTopics = find_by('quotesTopicEN','quoteID',quotID);
                getTopics.done(function(rel){
                    for(var i in rel[0]){
                        var topic = find_by('topics_en','topicID',rel[0][i].topicID);
                        topic.done(function(response){
                            console.log(response);
                            if(response){
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
                            }
                        });
                    }
                });
            }
        });
    }
    
    function dataURLtoFile(dataurl, filename) {
        var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
            bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
        while(n--){
            u8arr[n] = bstr.charCodeAt(n);
        }
        return new File([u8arr], filename, {type:mime});
    }
    
    var updateQuote = function(el, quotID,resRel){
        el.innerHTML = "Updating...";
        var quote = $('#quote').val(),
            author = $('#author').val(),
            topics = $('#topic').val(),
            errors=[];
        if(!quote || quote==''){
            errors.push('Quotes cannot be blank!');
        }
        if(!author || author==''){
            errors.push('Author field cannot be blank!');
        }else{
            var authorExist=find_by('authors','authorName',author);
            authorExist.done(function(authorResponse){
                if(authorResponse[0].length<1)
                    errors.push('Author is not in our database!');
            });
        }
        if(!topics || topics==''){
            errors.push('Topics field cannot be blank!');
        }
        if(errors.length<1){            
            var arr = {};
            arr['quote']=quote;
            arr['author']=author;
            if($('#image').val() && $('#image').val() !=''){
                var originalImg=$('#image').prop('files')[0];
                var image = dataURLtoFile($imgToUpload,'file.jpg');
            }
            var token = generateToken();
            token.done(function(generatedToken){
                $(el).attr('disabled','disabled');
                if($('#image').val() && $('#image').val() !=''){
                    var upimg=imgur_upload(originalImg);
                    upimg.done(function(rImg){
                        var url=rImg.data.link.replace('http','https');
                        arr['quoteImage']=url;
                        var quoteUpdate = update('quotes_en',arr,'quoteID',quotID,generatedToken,image);
                        quoteUpdate.done(function(data){
		//NEW STUFF
                    var logArr={};
                    logArr['log']=' has edited a Quote in English. Quote ID: <a class="idREL" onclick="quotesTranslation('+resRel+')">'+resRel+'</a>';
                    var log=insertLog('dashboard_logs',logArr,'logs');
                    log.done(function(res2){
                        console.log(res2);
                    });

                    console.log(data);
                    var token2 = generateToken();
                    token2.done(function(generatedToken2){
                        var deleteRel = delete_function('quotesTopicEN','quoteID',quotID,generatedToken2);
                        deleteRel.done(function(delResponse){
                            console.log(delResponse);
                            var arr2={};
                            arr2['quoteID']=quotID;
                            var topic = topics.split(',');
                            for(var i in topic){
                                var topicSearch = find_by('topics_en','topicName',topic[i]);
                                topicSearch.done(function(topicId){
                                    var token3 = generateToken();
                                    token3.done(function(generatedToken3){
                                        arr2['topicID']=topicId[0][0].topicID;
                                        var topicQuote = insert('quotesTopicEN',arr2,generatedToken3);
                                        topicQuote.done(function(data2){
                                            console.log(data2);
                                            /*setTimeout(function() {
                                                english(document.getElementById('eng'),1);
                                            }, 1000);*/
                                        });
                                    });
                                });
                            }
                            setTimeout(function() {
                                english(document.getElementById('eng'),1);
                            }, 1000);
                        });
                    });
                });
                    });
                }else{
                    var quoteUpdate = update('quotes_en',arr,'quoteID',quotID,generatedToken,image);
                        quoteUpdate.done(function(data){
		//NEW STUFF
                    var logArr={};
                    logArr['log']=' has edited a Quote in English. Quote ID: <a class="idREL" onclick="quotesTranslation('+resRel+')">'+resRel+'</a>';
                    var log=insertLog('dashboard_logs',logArr,'logs');
                    log.done(function(res2){
                        console.log(res2);
                    });

                    console.log(data);
                    var token2 = generateToken();
                    token2.done(function(generatedToken2){
                        var deleteRel = delete_function('quotesTopicEN','quoteID',quotID,generatedToken2);
                        deleteRel.done(function(delResponse){
                            console.log(delResponse);
                            var arr2={};
                            arr2['quoteID']=quotID;
                            var topic = topics.split(',');
                            for(var i in topic){
                                var topicSearch = find_by('topics_en','topicName',topic[i]);
                                topicSearch.done(function(topicId){
                                    var token3 = generateToken();
                                    token3.done(function(generatedToken3){
                                        arr2['topicID']=topicId[0][0].topicID;
                                        var topicQuote = insert('quotesTopicEN',arr2,generatedToken3);
                                        topicQuote.done(function(data2){
                                            console.log(data2);
                                            /*setTimeout(function() {
                                                english(document.getElementById('eng'),1);
                                            }, 1000);*/
                                        });
                                    });
                                });
                            }
                            setTimeout(function() {
                                english(document.getElementById('eng'),1);
                            }, 1000);
                        });
                    });
                });
                }
            });
        }else{
            var error='';
            for(var e in errors)
                error+='-'+errors[e]+'\n';
            alert(error);
        }
    }
    
    var save = function(el){
        var quote = $('#quote').val(),
            author = $('#author').val(),
            topics = $('#topic').val(),
            errors=[];
        localStorage.setItem("authorName", author);
        if(!quote || quote==''){
            errors.push('Quotes cannot be blank!');
        }
        if(!author || author==''){
            errors.push('Author field cannot be blank!');
        }else{
            var authorExist=find_by('authors','authorName',author);
            authorExist.done(function(authorResponse){
                if(authorResponse[0].length<1)
                    errors.push('Author is not in our database!');
            });
        }
        if(errors.length<1){
            var arr = {};
            arr['quote']=quote;
            arr['author']=author;
            if($('#image').val() && $('#image').val() !=''){
                var originalImg=$('#image').prop('files')[0];
                var image = dataURLtoFile($imgToUpload,'file.jpg');
            }
            var token1 = generateToken();
            token1.done(function(generatedToken1){
                $(el).attr('disabled','disabled');
                if($('#image').val() && $('#image').val() !=''){
                    var upimg=imgur_upload(originalImg);
                    upimg.done(function(rImg){
                        var url=rImg.data.link.replace('http','https');
                        arr['quoteImage']=url;
                        var newQuote = insert('quotes_en',arr,generatedToken1,image);
                        newQuote.done(function(response){
                        if(response){
                            var lastQuote = limit('quotes_en','quoteID','quoteID',1);
                            lastQuote.done(function(dataID){
                                var arr2={},
                                    arr3={},
                                    logArr={},relArr={};
                                arr2['quoteID']=dataID[0][0].quoteID;
                                arr3['en_id']=dataID[0][0].quoteID;
                                relArr['quoteID']=dataID[0][0].quoteID;
                                var token2 = generateToken();
                                token2.done(function(generatedToken2){
                                    var quoteRelation = insert('quotes',arr3,generatedToken2);
                                    quoteRelation.done(function(re){
                                        console.log('Rel: '+ re);
                                        //NEW STUFF
                                        var userQuoteRel=insertLog('dashboardUsr_Quote_en',relArr,'relation');
                                        userQuoteRel.done(function(res){
                                            console.log(res);
                                            var lastRel=find_by('quotes','en_id',dataID[0][0].quoteID);
                                            lastRel.done(function(resRel){
                                                logArr['log']=' has inserted a new Quote in English. Quote ID: <a class="idREL" onclick="quotesTranslation('+resRel[0][0].id+')">'+resRel[0][0].id+'</a>';
                                                var log=insertLog('dashboard_logs',logArr,'logs');
                                                log.done(function(res2){
                                                    console.log(res2);
                                                });
                                            });
                                        });
                                    });
                                });
                                if(topics!=''){
                                    var topic = topics.split(',');
                                    for(var i in topic){
                                        var topicSearch = find_by('topics_en','topicName',topic[i]);
                                        topicSearch.done(function(topicId){
                                            var token3 = generateToken();
                                            token3.done(function(generatedToken3){
                                                arr2['topicID']=topicId[0][0].topicID;
                                                var topicQuote = insert('quotesTopicEN',arr2,generatedToken3);
                                                topicQuote.done(function(data){
                                                    el.innerHTML = "Saved!";
                                                   /* 
                                                    setTimeout(function() {
                                                        english(document.getElementById('eng'),1);
                                                    }, 2000);*/

                                                });
                                            });
                                        });
                                    }
                                }
                                setTimeout(function() {
                                    english(document.getElementById('eng'),1);
                                }, 2000);
                            });
                        }
                        });
                    });
                } else{
                    var newQuote = insert('quotes_en',arr,generatedToken1,image);
                    newQuote.done(function(response){
                        if(response){
                            var lastQuote = limit('quotes_en','quoteID','quoteID',1);
                            lastQuote.done(function(dataID){
                                var arr2={},
                                    arr3={},
                                    logArr={},relArr={};
                                arr2['quoteID']=dataID[0][0].quoteID;
                                arr3['en_id']=dataID[0][0].quoteID;
                                relArr['quoteID']=dataID[0][0].quoteID;
                                var token2 = generateToken();
                                token2.done(function(generatedToken2){
                                    var quoteRelation = insert('quotes',arr3,generatedToken2);
                                    quoteRelation.done(function(re){
                                        console.log('Rel: '+ re);
                                        //NEW STUFF
                                        var userQuoteRel=insertLog('dashboardUsr_Quote_en',relArr,'relation');
                                        userQuoteRel.done(function(res){
                                            console.log(res);
                                            var lastRel=find_by('quotes','en_id',dataID[0][0].quoteID);
                                            lastRel.done(function(resRel){
                                                logArr['log']=' has inserted a new Quote in English. Quote ID: <a class="idREL" onclick="quotesTranslation('+resRel[0][0].id+')">'+resRel[0][0].id+'</a>';
                                                var log=insertLog('dashboard_logs',logArr,'logs');
                                                log.done(function(res2){
                                                    console.log(res2);
                                                });
                                            });
                                        });
                                    });
                                });
                                if(topics!=''){
                                    var topic = topics.split(',');
                                    for(var i in topic){
                                        var topicSearch = find_by('topics_en','topicName',topic[i]);
                                        topicSearch.done(function(topicId){
                                            var token3 = generateToken();
                                            token3.done(function(generatedToken3){
                                                arr2['topicID']=topicId[0][0].topicID;
                                                var topicQuote = insert('quotesTopicEN',arr2,generatedToken3);
                                                topicQuote.done(function(data){
                                                    el.innerHTML = "Saved!";
                                                   /* 
                                                    setTimeout(function() {
                                                        english(document.getElementById('eng'),1);
                                                    }, 2000);*/

                                                });
                                            });
                                        });
                                    }
                                }
                                setTimeout(function() {
                                    english(document.getElementById('eng'),1);
                                }, 2000);
                            });
                        }
                    });
                }
            });
        }else{
            var error='';
            for(var e in errors)
                error+='-'+errors[e]+'\n';
            alert(error);
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
                    $('#'+id+' ul').html('<li>Not found!</li>');
            });
        }
    }
    
    function detectWord(){
        var incorrecTag = $('.tag').last().children('span').html().split('&');
        var topicSearch = find_by('topics_en','topicName',incorrecTag[0]);
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
    
    function match(el){
        var text=$(el).val();
        var matching=search('quotes_en','quote',text,'en_id','match');
        matching.done(function(response){
            if(response['percent']>=40){
                var percent=response['percent'],
                    relID=response['relID'];
                document.getElementById('match').innerHTML="This quote is similar to [<a onclick='quotesTranslation("+relID+")'>Quote ID: "+relID+"</a>] by "+percent+"%";
            }else{
                document.getElementById('match').innerHTML="";
            }
        });
        
        if(el.value.length>=380)
            document.getElementById('char-length').innerHTML="You've reached the maximum length of characters, check the quote to make sure it's completed!";
        else
            document.getElementById('char-length').innerHTML="";
    }
    
    //Search Quotes
    /*document.getElementById('search').oninput=function(){
        var text=this.value;
        var searching=search('quotes_en','quote',text,'quoteID','search');
        searching.done(function(data){
            english('#eng',1,data);
        });
    }*/
    
    var searchFunction=function(){
        var op=$('input[name=optradio]:checked').val(),
            text=document.getElementById('search').value;
        if(text!=''){
            $('#quotes-area').css('visibility','hidden');
            $('.portlet .loader').css('display','block');
            var searching=search('quotes_en','quote',text,'quoteID','search',op);
            searching.done(function(data){
                setTimeout(function() {
                    $('.portlet .loader').css('display','none');
                    $('#quotes-area').css('visibility','visible');
                    english(document.getElementById('eng'),1,data);
                }, 2000);
            });
        }else{
            english(document.getElementById('eng'),1);
        }
    }
    /*document.getElementById("search").addEventListener("keyup", function(event) {
        event.preventDefault();
        if(event.keyCode == 13){
            searchFunction();
        }
    });*/
    
</script>

<?php if($_SESSION['label']=='image'){ ?>
<script>
    $(document).ready(function(){
        $('#topic_tag').attr('disabled','disabled');
    });
</script>
<?php } ?>