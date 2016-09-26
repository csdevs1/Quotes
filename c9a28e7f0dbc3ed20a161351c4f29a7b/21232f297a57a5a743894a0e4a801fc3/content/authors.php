<?php
    require_once('../Classes/AppController.php');
    $obj = new AppController();
    $authors = $obj->all('authors');
?>

<div class="portlet-heading">
    <h3 class="portlet-title text-dark text-uppercase">
        Authors
    </h3>
    <div class="clearfix"></div>
    <div class="col-lg-12 text-dark"><span id="add-quote" onclick="openWindow(this)"><span class="glyphicon glyphicon-edit"></span> Add a new author</span></div>
</div>

<div class="container quote-form" id="quote-form">
    <div class="row">
        <div class="col-xs-12 relative-container">
            <label onclick="closeWindow()"><span class="glyphicon glyphicon-remove"></span> Hide</label>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="author" data-error="Field required" aria-describedby="author" placeholder="Enter Author..."  oninput="checkAvailability(this)">
                
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


<div class="container">
    <div class="row">
        
        <?php
            foreach($authors as $key=>$val){
        ?>
        <div class="col-xs-12 col-sm-6 col-md-4 box-content">
            <div class="inner-box background" style="background-image:url('<?php echo $authors[$key]['authorImage'] ?>');">
                <h3 data-placement="top" title="Edit Topic"><a><?php echo $authors[$key]['authorName'] ?></a></h3>
            </div>
        </div>        
        <?php
            }
        ?>
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
            $(this).next().text("Oops! that's not an image!");
        }
    });
    
    var save = function(el){
        $(el).attr('disabled','disabled');
        el.innerHTML = "Saving";
        var author = $('#author').val(),
            arr = {};
        if(author && author != '')
            arr['authorName'] = author;
        else
            console.log('Error author');
        if($('#image').val()!=''){
            if(arr['authorName'] != ''){
                var token = generateToken();
                token.done(function(generatedToken){
                    var image = imgur_upload($('#image').prop('files')[0]);
                    image.done(function(response){
                        var url = response.data.link;
                        arr['authorImage'] = url.replace('http','https');
                        var insert_author = insert('authors',arr,generatedToken);
                        insert_author.done(function(data){
                            $(el).removeAttr('disabled');
                            el.innerHTML = "Saved!";
                            setTimeout(function() {
                                authors('Author Saved correctly',document.getElementById('author-menu'));
                            }, 2000);
                        });
                    });
                });
            }
        }else if(arr['authorName'] != ''){
            var token = generateToken();
            token.done(function(generatedToken){
                var insert_author = insert('authors',arr,generatedToken);
                insert_author.done(function(data){
                    $(el).removeAttr('disabled');
                    el.innerHTML = "Saved!";
                    setTimeout(function() {
                        authors('Author Saved correctly',document.getElementById('author-menu'));
                    }, 2000);
                });
            });
        }
    }
    
    var checkAvailability = function(){
        
    }
</script>