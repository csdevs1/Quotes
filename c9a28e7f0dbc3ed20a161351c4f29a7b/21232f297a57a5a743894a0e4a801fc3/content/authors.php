<?php
    session_start();
    require_once('../Classes/AppController.php');
    $obj = new AppController();
    $authors = $obj->all('authors');
    $professions = $obj->all('professions ORDER BY professionName ASC');
    $countries = array('Afghan', 'Albanian', 'Algerian', 'American', 'Andorran', 'Angolan', 'Antiguans', 'Argentinean', 'Armenian', 'Australian', 'Austrian', 'Azerbaijani', 'Bahamian', 'Bahraini', 'Bangladeshi', 'Barbadian', 'Barbudans', 'Batswana', 'Belarusian', 'Belgian', 'Belizean', 'Beninese', 'Bhutanese', 'Bolivian', 'Bosnian', 'Brazilian', 'British', 'Bruneian', 'Bulgarian', 'Burkinabe', 'Burmese', 'Burundian', 'Cambodian', 'Cameroonian', 'Canadian', 'Cape Verdean', 'Central African', 'Chadian', 'Chilean', 'Chinese', 'Colombian', 'Comoran', 'Congolese', 'Costa Rican', 'Croatian', 'Cuban', 'Cypriot', 'Czech', 'Danish', 'Djibouti', 'Dominican', 'Dutch', 'East Timorese', 'Ecuadorean', 'Egyptian', 'Emirian', 'Equatorial Guinean', 'Eritrean', 'Estonian', 'Ethiopian', 'Fijian', 'Filipino', 'Finnish', 'French', 'Gabonese', 'Gambian', 'Georgian', 'German', 'Ghanaian', 'Greek', 'Grenadian', 'Guatemalan', 'Guinea-Bissauan', 'Guinean', 'Guyanese', 'Haitian', 'Herzegovinian', 'Honduran', 'Hungarian', 'I-Kiribati', 'Icelander', 'Indian', 'Indonesian', 'Iranian', 'Iraqi', 'Irish', 'Israeli', 'Italian', 'Ivorian', 'Jamaican', 'Japanese', 'Jordanian', 'Kazakhstani', 'Kenyan', 'Kittian and Nevisian', 'Kuwaiti', 'Kyrgyz', 'Laotian', 'Latvian', 'Lebanese', 'Liberian', 'Libyan', 'Liechtensteiner', 'Lithuanian', 'Luxembourger', 'Macedonian', 'Malagasy', 'Malawian', 'Malaysian', 'Maldivan', 'Malian', 'Maltese', 'Marshallese', 'Mauritanian', 'Mauritian', 'Mexican', 'Micronesian', 'Moldovan', 'Monacan', 'Mongolian', 'Moroccan', 'Mosotho', 'Motswana', 'Mozambican', 'Namibian', 'Nauruan', 'Nepalese', 'New Zealander', 'Nicaraguan', 'Nigerian', 'Nigerien', 'North Korean', 'Northern Irish', 'Norwegian', 'Omani', 'Pakistani', 'Palauan', 'Panamanian', 'Papua New Guinean', 'Paraguayan', 'Peruvian', 'Polish', 'Portuguese', 'Puerto Rican', 'Qatari', 'Romanian', 'Russian', 'Rwandan', 'Saint Lucian', 'Salvadoran', 'Samoan', 'San Marinese', 'Sao Tomean', 'Saudi', 'Scottish', 'Senegalese', 'Serbian', 'Seychellois', 'Sierra Leonean', 'Singaporean', 'Slovakian', 'Slovenian', 'Solomon Islander', 'Somali', 'South African', 'South Korean', 'Spanish', 'Sri Lankan', 'Sudanese', 'Surinamer', 'Swazi', 'Swedish', 'Swiss', 'Syrian', 'Taiwanese', 'Tajik', 'Tanzanian', 'Thai', 'Togolese', 'Tongan', 'Trinidadian/Tobagonian', 'Tunisian', 'Turkish', 'Tuvaluan', 'Ugandan', 'Ukrainian', 'Uruguayan', 'Uzbekistani', 'Venezuelan', 'Vietnamese', 'Welsh', 'Yemenite', 'Zambian', 'Zimbabwean');

?>

<div class="portlet-heading">
    <h3 class="portlet-title text-dark text-uppercase">
        Authors
    </h3>
    <div class="clearfix"></div>
    <?php if(isset($_SESSION['permission'][1]) && !empty($_SESSION['permission'][1]) && isset($_SESSION['lang']) && !empty($_SESSION['lang']) && $_SESSION['label'] !='image'){
    if($_SESSION['lang']=='eng' || $_SESSION['lang']=='all'){ //Permission to insert ?>
<?php //if(isset($_SESSION['label']) && !empty($_SESSION['label']) && $_SESSION['label'] =='root' || $_SESSION['label'] =='author'){ //Permission to insert ?>
    <div class="col-lg-12 text-dark"><span id="add-quote" onclick="openWindow(this);clearFields()"><span class="glyphicon glyphicon-edit"></span> Add a new author</span></div>
<?php //} ?>
    <?php }} ?>
</div>
<?php if(isset($_SESSION['permission'][1]) && !empty($_SESSION['permission'][1]) && isset($_SESSION['lang']) && !empty($_SESSION['lang']) && $_SESSION['label'] !='image'){
    if($_SESSION['lang']=='eng' || $_SESSION['lang']=='all'){ //Permission to insert ?>
<?php //if(isset($_SESSION['label']) && !empty($_SESSION['label']) && $_SESSION['label'] =='root' || $_SESSION['label'] =='author'){ //Permission to insert ?>
<div class="container quote-form" id="quote-form">
    <div class="row">
        <div class="col-xs-12 relative-container">
            <label onclick="closeWindow();clearFields()"><span class="glyphicon glyphicon-remove"></span> Hide</label>
        </div>
        <div class="form-group col-xs-12">
		<span class="error">Author alreay exist</span>
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="author" data-error="Field required" aria-describedby="author" placeholder="Enter Author's name..."  oninput="checkAvailability(this)">
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-happy"></i></span>
                <input type="text" class="form-control" id="bdate" data-error="Field required" aria-describedby="birthday" placeholder="Birth">
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-sad"></i></span>
                <input type="text" class="form-control" id="pdate" data-error="Field required" aria-describedby="died" placeholder="Died">
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-earth"></i></span>
                <select class="form-control" id="country" required>
                    <option value="">-- SELECT NATIONALITY --</option>
                    <?php
                        for($i=0;$i<count($countries);$i++){
                    ?>
                        <option value="<?php echo $countries[$i]; ?>"><?php echo $countries[$i]; ?></option>
                    <?php
                        }
                    ?>
                </select>
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-6">
                        <button type="button" class="btn btn-warning" onclick="addProfession()"><span class="glyphicon glyphicon-plus"></span> Add a profession</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group col-xs-12" id="professions-list">
            <div class="input-group col-xs-12 col-sm-4 col-md-3">
                <span class="input-group-addon"><i class="ion-university"></i></span>
                <!--<input type="text" class="form-control" id="profession" data-error="Field required" aria-describedby="profession" placeholder="Enter Author's profession..." >-->
                <select class="form-control" name="professions[]" required>
                    <option value="">-- Profession --</option>
                    <?php
                        foreach($professions as $key=>$val){
                    ?>
                        <option value="<?php echo $professions[$key]['professionID']; ?>"><?php echo $professions[$key]['professionName']; ?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group col-xs-12">
            <textarea placeholder="Brief Description About the author..." maxlength="500" class="textarea" id="profile"></textarea>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-university"></i></span>
                <input type="text" class="form-control" id="url" data-error="Field required" aria-describedby="url" placeholder="Source (URL)..." >
                
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
<?php //} ?>
<?php }} ?>

<div class="container">
    <div class="row" id="row">
        
        <?php
            foreach($authors as $key=>$val){
        ?>
        <div class="col-xs-12 col-sm-6 col-md-4 box-content data">
		<?php if(isset($_SESSION['permission'][2]) && !empty($_SESSION['permission'][2]) && isset($_SESSION['lang']) && !empty($_SESSION['lang'])){if($_SESSION['lang']=='eng' || $_SESSION['lang']=='all'){ ?>
            <i class="ion-close-circled close" onclick='deleteThis(this,"<?php echo $authors[$key]['authorID']; ?>","<?php $remove[] = "'";$remove[] = '"'; echo str_replace($remove, "", $authors[$key]['authorName']); ?>")'></i>
            <?php } } ?>
            <div class="inner-box background" style="background-image:url('<?php echo $authors[$key]['authorImage']; ?>');">
                <h3 data-placement="top" title="Edit Topic" <?php if(isset($_SESSION['permission'][1]) && !empty($_SESSION['permission'][1]) && isset($_SESSION['lang']) && !empty($_SESSION['lang']) && $_SESSION['label'] !='image'){if($_SESSION['lang']=='eng' || $_SESSION['lang']=='all'){ ?>onclick="openUpdate(<?php echo $authors[$key]['authorID']; ?>)"<?php } } ?>><a><?php echo $authors[$key]['authorName']; ?></a></h3>
            </div>
        </div>        
        <?php
            }
        ?>
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
                <span class="input-group-addon page-go"><input type="submit" id="goto" class="btn btn-primary" value="Go"></span>
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

<!--<button class="btn btn-primary" onclick="publish()">Submit all Authors to Facebook</button> -->
<script src="js/pagination.js?<?php echo time(); ?>"></script>
<script>
    var addProfession=function(){
        var professions=order_by('professions','professionName','ASC');
        professions.done(function(response){
            var arr=[];
            for(var i in response[0]){
                arr[i]='<option value="'+response[0][i].professionID+'">'+response[0][i].professionName+'</option>';
            }
            $('#professions-list').append('<div class="input-group col-xs-12 col-sm-4 col-md-3"><span class="input-group-addon"><i class="ion-university"></i></span><select class="form-control" name="professions[]" required><option value="">-- Profession --</option>'+arr.join()+'</select></div>');
        });
    }

    /*Pagination*/
    var count = <?php echo count($authors); ?>;
    $(function () {
        load = function() {
            window.tp = new Pagination('#tablePaging', {
                itemsCount: count,
                onPageSizeChange: function (ps) {
                    //console.log('changed to ' + ps);
                },
                onPageChange: function (paging) {
                    //custom paging logic here
                    //console.log(paging);
                    var start = paging.pageSize * (paging.currentPage - 1),
                        end = start + paging.pageSize,
                        $rows = $('#row').find('.data');
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
                        $rows = $('#row').find('.data');
                    $rows.hide();
                    for (var i = start; i < end; i++) {
                        $rows.eq(i).show();
                    }
                }
            });
        }
    }

    /*Pagination*/

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
    
    var clearFields=function(){
        $('#author').val('');
        $('#bdate').val('');
        $('#pdate').val('');
        $('#profession').val('');
        $('#profile').val('');
        $('#url').val('');
        $('#country option[value=""]').prop('selected', true);
    }
    
    var openUpdate = function(authID){
        var author = find_by('authors','authorID',authID);
        $('#save').attr('onclick','updateAuthor(this,'+authID+')');
        document.getElementById('save').innerHTML="Update";
        author.done(function(data){
            if(Object.keys(data[0][0]).length > 1){
                $('#quote-form').show(500);
                $('#author').val(data[0][0].authorName);
                $('#bdate').val(data[0][0].birth);
                $('#pdate').val(data[0][0].died);
                $('#profile').val(data[0][0].bio);
                $('#url').val(data[0][0].sourceURL);
                $('#country option[value='+data[0][0].nationality+']').prop('selected', true);
                $('#author').focus();
                var professionAuthor=find_by('authorProfession','authorID',authID);
                professionAuthor.done(function(response){
                    document.getElementById('professions-list').innerHTML='';
                    for(var i in response[0]){
                        var professions=find_by('professions','professionID',response[0][i].professionID);
                        professions.done(function(response2){
                            var allProfessions=all('professions');
                            allProfessions.done(function(response3){
                                var arr=[];
                                for(var i2 in response3[0]){
                                    if(response3[0][i2].professionName==response2[0][0].professionName)
                                        arr[i2]='<option value="'+response3[0][i2].professionID+'" selected>'+response3[0][i2].professionName+'</option>';
                                    else
                                        arr[i2]='<option value="'+response3[0][i2].professionID+'">'+response3[0][i2].professionName+'</option>';
                                }
                                $('#professions-list').append('<div class="input-group col-xs-12 col-sm-4 col-md-3"><span class="input-group-addon"><i class="ion-university"></i></span><select class="form-control" name="professions[]" required><option value="">-- Profession --</option>'+arr.join()+'</select></div>');
                            });
                        });
                    }
                });
            }
        });
    }
    
    var updateAuthor = function(el, quotID){
        $(el).attr('disabled','disabled');
        el.innerHTML = "Updating";
        var author = $('#author').val(),
            birth=$('#bdate').val(),
            country=$('#country').val(),
            profession = $("select[name='professions[]']").map(function(){if($(this).val()!='') return $(this).val();}).get(),
            bio=$('#profile').val(),
            url=$('#url').val(),
            arr = {},
            arr2 = {};
        if(author && author != ''){
            arr['authorName'] = author;
		var seo = author.replace(/["']/g, "");
            seo = seo.replace(/["-]/g, "");
            arr['seo_url'] = seo.split(' ').join('-').toLowerCase();
            console.log(arr['seo_url']);
        }
        else
            console.log('Error author');
        if($('#bdate').val()!='')
            arr['birth'] = birth;
        else
            console.log('Error Birthday');
        if($('#pdate').val()!='')
            arr['died'] = $('#pdate').val();
        if($('#country').val()!='')
            arr['nationality'] = country;
        else
            console.log('Error Country');
        if($('#profile').val()!='')
            arr['bio'] = bio;
        else
            console.log('Error profile');
        if($('#url').val()!='')
            arr['sourceURL'] = url;
        else
            console.log('Error Source');
        if($('#image').val()!=''){
            if(arr['authorName'] != '' && arr['birth'] != '' && arr['country'] != '' && arr['bio'] != ''){
                var token = generateToken();
                token.done(function(generatedToken){
                    var image = imgur_upload($('#image').prop('files')[0]);
                    image.done(function(response){
                        var url = response.data.link;
                        arr['authorImage'] = url.replace('http','https');
                        var update_author = update('authors',arr,'authorID',quotID,generatedToken);
                        update_author.done(function(data){
                            if(profession.legnth > 0){
                                arr2['authorID']=quotID;
                                var token2 = generateToken();
                                token2.done(function(generatedToken2){
                                    var deleteRel = delete_function('authorProfession','authorID',quotID,generatedToken2);
                                    deleteRel.done(function(deleted){
                                        for(var i in profession){
                                            arr2['professionID']=profession[i];
                                            var token3 = generateToken();
                                            token3.done(function(generatedToken3){
                                                var authorProfession = insert('authorProfession',arr2,generatedToken3);
                                                authorProfession.done(function(response2){
                                                    //NEW STUFF
                                                    var logArr={};
                                                    logArr['log']=' has edited an Author in English. Author ID: <a class="idREL" onclick="authorsTranslation('+quotID+')">'+quotID+'</a>';
                                                    var log=insertLog('dashboard_logs',logArr,'logs');
                                                    log.done(function(res2){
                                                        console.log(res2);
                                                    });
                                                    //NEW STUFF
                                                    
                                                    $(el).removeAttr('disabled');
                                                    el.innerHTML = "Updated!";
                                                    setTimeout(function() {
                                                        clearFields();
                                                        closeWindow();
                                                    }, 200);
                                                });
                                            });
                                        }
                                    });
                                });
                            }else{
                                console.log(data);
                                $(el).removeAttr('disabled');
                                el.innerHTML = "Updated!";
                                setTimeout(function() {
                                    clearFields();
                                    closeWindow();
                                }, 200);
                            }
                        });
                    });
                });
            }
        }else if(arr['authorName'] != '' && arr['birth'] != '' && arr['country'] != '' && arr['bio'] != ''){
            var token = generateToken();
            token.done(function(generatedToken){
                var update_author = update('authors',arr,'authorID',quotID,generatedToken);
                update_author.done(function(data){
                    //NEW STUFF
                    var logArr={};
                    logArr['log']=' has edited an Author in English. Author ID: <a class="idREL" onclick="authorsTranslation('+quotID+')">'+quotID+'</a>';
                    var log=insertLog('dashboard_logs',logArr,'logs');
                    log.done(function(res2){
                        console.log(res2);
                    });
                    //NEW STUFF
                    if(profession.length > 0){
                        arr2['authorID']=quotID;
                        var token2 = generateToken();
                        token2.done(function(generatedToken2){
                            var deleteRel = delete_function('authorProfession','authorID',quotID,generatedToken2);
                            deleteRel.done(function(deleted){
                                console.log(deleted);
                                for(var i in profession){
                                    arr2['professionID']=profession[i];
                                    var token3 = generateToken();
                                    token3.done(function(generatedToken3){
                                        var authorProfession = insert('authorProfession',arr2,generatedToken3);
                                        authorProfession.done(function(response2){
                                            $(el).removeAttr('disabled');
                                            el.innerHTML = "Updated!";
                                            setTimeout(function() {
                                                clearFields();
                                                closeWindow();
                                            }, 200);
                                        });
                                    });
                                }
                            });
                        });
                    }else{
                        console.log(data);
                        $(el).removeAttr('disabled');
                        el.innerHTML = "Updated!";
                        setTimeout(function() {
                            clearFields();
                            closeWindow();
                        }, 200);
                    }
                });
            });
        }
    }

// FB API INIT
	window.fbAsyncInit = function() {
                FB.init({
                  appId      : '186483935126603',
                  xfbml      : true,
                  version    : 'v2.8'
                });
              };
            (function(d, s, id){
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
            function postToPage(param) {
                var page_id = '864112963723491';
		var path = '/'+param.split(' ').join('-');
                FB.api('/' + page_id, {fields: 'access_token'}, function(resp) {
                    FB.api('/' + page_id + '/feed',
                           'post',
                           { message:'Find the best quotes from '+param+' at PortalQuote...',link:'https://portalquote.com/author/quotes'+path+'/1',access_token:
                            'EAACpmyy1pEsBAOwhT8zJq5nT24Aet6joultEPRc4J6XvYqZCOleZCEU27jegDP8wyMBQCh8Y64s4TlnSvZABESiUFG2ilU9gVVKolNygNX3ebqDqrPw6nuJ3JBEmzns5EjToYEcCZBQqeWBrZBZCrGItZCppdZA8AN8PTp8ZCAr1ibwTOZChtBLVo7' }
                           ,function(response) {
                        console.log(response);
                    });
                });
            }

	var publish=function(){
		var authors=$('.inner-box h3 a').map(function(){return $(this).text();}).get();
		var i=11;
		var interval = setInterval(function() {
		    postToPage(authors[i]);
		    if(i==21){
		        clearInterval(interval);
			console.log('Done!');
			}
		    i++;
		}, 3*60000);
	    }
    
    var save = function(el){
        var author = $('#author').val(),
            birth=$('#bdate').val(),
            country=$('#country').val(),
            profession = $("select[name='professions[]']").map(function(){if($(this).val()!='') return $(this).val();}).get(),
            bio=$('#profile').val(),
            url=$('#url').val(),
            arr = {},
            arr2 = {};
        console.log(profession.length);
       if(author && author != ''){
            if($('.error').css('display')=='inline-block'){
                alert('Author Exist');
            }else{
                arr['authorName'] = author;
                var seo = author.replace(/["']/g, "");
                seo = seo.replace(/["-]/g, "");
                arr['seo_url'] = seo.split(' ').join('-').toLowerCase();
                console.log(arr['seo_url']);
            }
        }
        else
            console.log('Error author');
        if($('#bdate').val()!='')
            arr['birth'] = birth;
        else
            console.log('Error Birthday');
        if($('#pdate').val()!='')
            arr['died'] = $('#pdate').val();
        if($('#country').val()!='')
            arr['nationality'] = country;
        else
            console.log('Error Country');
        if($('#profile').val()!='')
            arr['bio'] = bio;
        else
            console.log('Error profile');
        if($('#url').val()!='')
            arr['sourceURL'] = url;
        else
            console.log('Error Source');
        if($('#image').val()!=''){
            if(arr['authorName'] != '' && arr['birth'] != '' && arr['country'] != '' && arr['bio'] != ''){
                var token = generateToken();
                token.done(function(generatedToken){
                    $(el).attr('disabled','disabled');
                    el.innerHTML = "Saving";
                    var image = imgur_upload($('#image').prop('files')[0]);
                    image.done(function(response){
                        var url = response.data.link;
                        arr['authorImage'] = url.replace('http','https');
                        var insert_author = insert('authors',arr,generatedToken);
                        insert_author.done(function(data){
                            console.log(data);
                            var last_author = limit('authors','authorID','authorID',1);
                            last_author.done(function(last){
                                console.log(last);
                                arr2['authorID']=last[0][0].authorID;
                                
                                //NEW STUFF
                                var logArr={},relArr={};
                                 relArr['authorID']=last[0][0].authorID;
                                var token3 = generateToken();
                                token3.done(function(generatedToke3){
                                    var userAuthorRel=insertLog('dashboardUsr_Authors_en',relArr,'relation');
                                    userAuthorRel.done(function(res){
                                        console.log(res);
                                        logArr['log']=' has inserted a new Author in English. Author ID: <a class="idREL" onclick="authorsTranslation('+relArr['authorID']+')">'+relArr['authorID']+'</a>';
                                        var log=insertLog('dashboard_logs',logArr,'logs');
                                        log.done(function(res2){
                                            console.log(res2);
                                        });
                                    });
                                });
                                //NEW STUFF
                                
                                for(var i in profession){
                                    arr2['professionID']=profession[i];
                                    var token2 = generateToken();
                                    token2.done(function(generatedToken2){
                                        var authorProfession = insert('authorProfession',arr2,generatedToken2);
                                        authorProfession.done(function(response2){
                                            $(el).removeAttr('disabled');
                                            el.innerHTML = "Saved!";
                                            console.log(response2);
                                            postToPage(author);
                                        });
                                    });
                                }
                                setTimeout(function() {
                                    authors('Author Saved correctly',document.getElementById('author-menu'));
                                }, 2000);
                            });
                        });
                    });
                });
            }
        }else if(arr['authorName'] != '' && arr['birth'] != '' && arr['country'] != '' && arr['bio'] != ''){
            var token = generateToken();
            token.done(function(generatedToken){
                $(el).attr('disabled','disabled');
                el.innerHTML = "Saving";
                var insert_author = insert('authors',arr,generatedToken);
                insert_author.done(function(data){
                    console.log(data);
                    var last_author = limit('authors','authorID','authorID',1);
                    last_author.done(function(last){
                        console.log(last);
                        arr2['authorID']=last[0][0].authorID;
                        
                        //NEW STUFF
                        var logArr={},relArr={};
                        relArr['authorID']=last[0][0].authorID;
                        var token3 = generateToken();
                        token3.done(function(generatedToke3){
                            var userAuthorRel=insertLog('dashboardUsr_Authors_en',relArr,'relation');
                            userAuthorRel.done(function(res){
                                console.log(res);
                                logArr['log']=' has inserted a new Author in English. Author ID: <a class="idREL" onclick="authorsTranslation('+relArr['authorID']+')">'+relArr['authorID']+'</a>';
                                var log=insertLog('dashboard_logs',logArr,'logs');
                                log.done(function(res2){
                                    console.log(res2);
                                });
                            });
                        });
                        //NEW STUFF
                        
                        for(var i in profession){
                            arr2['professionID']=profession[i];
                            var token2 = generateToken();
                            token2.done(function(generatedToken2){
                                var authorProfession = insert('authorProfession',arr2,generatedToken2);
                                authorProfession.done(function(response2){
                                    $(el).removeAttr('disabled');
                                    el.innerHTML = "Saved!";
                                    console.log(response2);
                                    postToPage(author);
                                });
                            });
                        }
                        setTimeout(function() {
                            authors('Author Saved correctly',document.getElementById('author-menu'));
                        }, 2000);
                    });
                });
            });
        }
    }
    
    var checkAvailability = function(el){
        var checked=find_by('authors','authorName',el.value);
        checked.done(function(response){
            console.log(response);
            if(Object.keys(response[0]).length > 0){
                $('.error').css('display','inline-block');
            } else{
                $('.error').css('display','none');
            }
        });
    }

	function deleteThis(el,id,name){
        swal({title: "Are you sure?",text: "You're about to delete "+name+"!",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){
            var token = generateToken();
            token.done(function(generatedToken){
                var deleted = delete_function('authors','authorID',id,generatedToken);
                deleted.done(function(response){
                    swal("Deleted!", name+" has been deleted.", "success");
			el.parentNode.parentNode.removeChild(el.parentNode);
                });
            });     
        });
    }
</script>