<?php
    require_once('../Classes/AppController.php');
    $obj = new AppController();
    $quotes = $obj->all('quotes_en');
?>

<!-- Load with Jquery Load function -->
<div class="portlet-heading">
    <h3 class="portlet-title text-dark text-uppercase">
        Your quotes
    </h3>
    <div class="clearfix"></div>
    <div class="col-lg-12 text-dark"><span id="add-quote" onclick="openWindow(this)"><span class="glyphicon glyphicon-edit"></span> Add a new quote</span></div>
</div>
<div class="container quote-form" id="quote-form">
    <div class="row">
        <div class="col-xs-12 relative-container">
            <label onclick="closeWindow()"><span class="glyphicon glyphicon-remove"></span> Hide</label>
        </div>
        <div class="col-xs-12">
            <textarea placeholder="Insert your quote..." maxlength="255" class="textarea" id="quote"></textarea>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="author" data-error="Field required" aria-describedby="author" placeholder="Enter Author..."  oninput="listSearch(this,'authorList','authors','author')">
                
                <div class="col-xs-12 search-list" id="authorList">
                    <ul class="list-unstyled">
                    </ul>
                </div>
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-chatbubble-working"></i></span>
                <input type="text" class="form-control" id="topic" data-error="Field required" aria-describedby="topic" placeholder="Enter Topic" value="">
                
                <div class="col-xs-12 search-list" id="topicList">
                    <ul class="list-unstyled">
                    </ul>
                </div>
                
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

<div id="portlet1" class="panel-collapse collapse in">
    <div class="portlet-body">
        <section role="contentinfo">
            <div class="container">
                <div class="row">
                    <div class="masonry-container">
                        
                        <?php
                            foreach($quotes as $key=>$val){
                                $translations = $obj->find_by('quotes','en_id',$quotes[$key]['quoteID']);
                        ?>
                        <div class="col-xs-12 col-sm-6 col-md-4 item quote">
                            <div class="pad">
                                <div class="circle-ref" onclick="quotesTranslation(<?php echo $translations[0]['id']; ?>)"><?php echo $translations[0]['id']; ?></div>
                                <?php if(isset($quotes[$key]['quoteImage']) && !empty($quotes[$key]['quoteImage'])){ ?>
                                    <img class="img-responsive" src="<?php echo $quotes[$key]['quoteImage']; ?>" alt="image description">
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
                                <div class="col-xs-4 col-md-4"><p><a class="like" onclick="openUpdate(<?php echo $quotes[$key]['quoteID'] ?>);">Edit</a></p></div>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                        <!--
                        <div class="col-xs-12 col-sm-6 col-md-4 item quote">
                            <div class="pad">
                                <img class="img-responsive" src="../../images/3.jpg" alt="image description">
                                <blockquote>Contrary to popular belief, Lorem Ipsum is not simply random text. <span>- Albert Einstein</span></blockquote>
                                <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="mycustomurl" data-title="THE TITLE"></div>
                                <div class="col-xs-4 col-md-4"><p><a class="like" onclick="return myFunction(this)">Edit</a></p></div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 item quote">
                            <div class="pad">
                                <blockquote>It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock. <span>- Albert Einstein</span></blockquote>
                                <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="mycustomurl" data-title="THE TITLE"></div>
                                <div class="col-xs-4 col-md-4"><p><a class="like" onclick="return myFunction(this)">Edit</a></p></div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 item quote">
                            <div class="pad">
                                <img class="img-responsive" src="../../images/1.jpg" alt="image description">
                                <blockquote>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC. <span>- Albert Einstein</span></blockquote>
                                <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="mycustomurl" data-title="THE TITLE"></div>
                                <div class="col-xs-4 col-md-4"><p><a class="like" onclick="return myFunction(this)">Edit</a></p></div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 item quote">
                            <div class="pad">
                                <img class="img-responsive" src="../../images/2.jpg" alt="image description">
                                <blockquote>Contrary to popular belief, Lorem Ipsum is not simply random text. <span>- Albert Einstein</span></blockquote>
                                <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="mycustomurl" data-title="THE TITLE"></div>
                                <div class="col-xs-4 col-md-4"><p><a class="like" onclick="return myFunction(this)">Edit</a></p></div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 item quote">
                            <div class="pad">
                                <blockquote>It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock. <span>- Albert Einstein</span></blockquote>
                                <div class="addthis_sharing_toolbox col-xs-8 col-md-8" data-url="mycustomurl" data-title="THE TITLE"></div>
                                <div class="col-xs-4 col-md-4"><p><a class="like" onclick="return myFunction(this)">Edit</a></p></div>
                            </div>
                        </div>
                        -->
                    </div>
                </div>
            </div>
        </section>
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
<!-- Load with Jquery Load function -->
<script src="assets/tagsinput/jquery.tagsinput.min.js"></script>
<script type="text/javascript">
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
    
    var openUpdate = function(quotID){
        var quote = find_by('quotes_en','quoteID',quotID);
        $('#save').attr('onclick','update(this)');
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
                            var val = document.getElementById('topic').value;
                            if(document.getElementById('topic').value!=""){
                                $('#topic').addTag(response[0][0].topicName);
                            }else{
                                $('#topic').addTag(response[0][0].topicName);
                            }
                            console.log($('#topic').val());
                        });
                    }
                });
            }
        });
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
            $(this).next().text("Oops! that's not an image!");
        }
    });
    
    var save = function(el){
        $(el).attr('disabled','disabled');
        el.innerHTML = "Saving...";
        var quote = $('#quote').val(),
            author = $('#author').val(),
            topics = $('#topic').val();
        if(!quote || quote==''){
            console.log('Error quote');
            $(el).removeAttr('disabled');
            el.innerHTML = "Save";
        }else if(!author || author==''){
            console.log('Error author');
            $(el).removeAttr('disabled');
            el.innerHTML = "Save";
        }else if(!topics || topics==''){
            console.log('Error topic');
            $(el).removeAttr('disabled');
            el.innerHTML = "Save";
        }else{
            var arr = {};
            arr['quote']=quote;
            arr['author']=author;
            if($('#image').val() && $('#image').val() !=''){
                var image=$('#image').prop('files')[0];
            }
            var token1 = generateToken();
            token1.done(function(generatedToken1){
                var newQuote = insert('quotes_en',arr,generatedToken1,image);
                newQuote.done(function(response){
                    if(response){
                        var lastQuote = limit('quotes_en','quoteID','quoteID',1);
                        lastQuote.done(function(dataID){
                            var arr2={},
                                arr3={};
                            arr2['quoteID']=dataID[0][0].quoteID;
                            arr3['en_id']=dataID[0][0].quoteID;
                            var token2 = generateToken();
                            token2.done(function(generatedToken2){
                                var quoteRelation = insert('quotes',arr3,generatedToken2);
                                quoteRelation.done(function(re){
                                    console.log('Rel: '+ re);
                                });
                            });
                            var topic = topics.split(',');
                            for(var i in topic){
                                var topicSearch = find_by('topics_en','topicName',topic[i]);
                                topicSearch.done(function(topicId){
                                    var token3 = generateToken();
                                    token3.done(function(generatedToken3){
                                        arr2['topicID']=topicId[0][0].topicID;
                                        var topicQuote = insert('quotesTopicEN',arr2,generatedToken3);
                                        topicQuote.done(function(data){
                                            $(el).removeAttr('disabled');
                                            el.innerHTML = "Saved!";
                                            setTimeout(function() {
                                                english('Quote saved successfully!',document.getElementById('eng'));
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
</script>