<?php
    session_start();
    require_once('../Classes/AppController.php');
    $obj = new AppController();
    if(empty($_POST['dataARR'])){
        //$authors = $obj->custom('SELECT * FROM dashboardUsr_Authors_en INNER JOIN authors ON dashboardUsr_Authors_en.authorID=authors.authorID WHERE userID='.$_SESSION['id']);
        require_once('../Classes/Paginator.php');
        $limit = (isset( $_GET['limit'])) ? $_GET['limit'] : 12;
        $page = (isset( $_POST['page'])) ? $_POST['page'] : 1;
        $links = (isset( $_POST['links'])) ? $_POST['links'] : 7;    
        $Paginator  = new Paginator('dashboardUsr_Authors_en INNER JOIN authors ON dashboardUsr_Authors_en.authorID=authors.authorID WHERE userID='.$_SESSION['id']);
        $authorARR = $Paginator->getData('dashboardUsr_Authors_en INNER JOIN authors ON dashboardUsr_Authors_en.authorID=authors.authorID WHERE userID='.$_SESSION['id'],'authors.authorID',$limit,$page);
        $authors=$authorARR->data;
    }else{
        $authors=$_POST['dataARR'];
    }
    $professions = $obj->all('professions ORDER BY professionName ASC');
    $countries = array('Afghan', 'Albanian', 'Algerian', 'American', 'Andorran', 'Angolan', 'Antiguans', 'Argentinean', 'Armenian', 'Australian', 'Austrian', 'Azerbaijani', 'Bahamian', 'Bahraini', 'Bangladeshi', 'Barbadian', 'Barbudans', 'Batswana', 'Belarusian', 'Belgian', 'Belizean', 'Beninese', 'Bhutanese', 'Bolivian', 'Bosnian', 'Brazilian', 'British', 'Bruneian', 'Bulgarian', 'Burkinabe', 'Burmese', 'Burundian', 'Cambodian', 'Cameroonian', 'Canadian', 'Cape Verdean', 'Central African', 'Chadian', 'Chilean', 'Chinese', 'Colombian', 'Comoran', 'Congolese', 'Costa Rican', 'Croatian', 'Cuban', 'Cypriot', 'Czech', 'Danish', 'Djibouti', 'Dominican', 'Dutch', 'East Timorese', 'Ecuadorean', 'Egyptian', 'Emirian', 'Equatorial Guinean', 'Eritrean', 'Estonian', 'Ethiopian', 'Fijian', 'Filipino', 'Finnish', 'French', 'Gabonese', 'Gambian', 'Georgian', 'German', 'Ghanaian', 'Greek', 'Grenadian', 'Guatemalan', 'Guinea-Bissauan', 'Guinean', 'Guyanese', 'Haitian', 'Herzegovinian', 'Honduran', 'Hungarian', 'I-Kiribati', 'Icelander', 'Indian', 'Indonesian', 'Iranian', 'Iraqi', 'Irish', 'Israeli', 'Italian', 'Ivorian', 'Jamaican', 'Japanese', 'Jordanian', 'Kazakhstani', 'Kenyan', 'Kittian and Nevisian', 'Kuwaiti', 'Kyrgyz', 'Laotian', 'Latvian', 'Lebanese', 'Liberian', 'Libyan', 'Liechtensteiner', 'Lithuanian', 'Luxembourger', 'Macedonian', 'Malagasy', 'Malawian', 'Malaysian', 'Maldivan', 'Malian', 'Maltese', 'Marshallese', 'Mauritanian', 'Mauritian', 'Mexican', 'Micronesian', 'Moldovan', 'Monacan', 'Mongolian', 'Moroccan', 'Mosotho', 'Motswana', 'Mozambican', 'Namibian', 'Nauruan', 'Nepalese', 'New Zealander', 'Nicaraguan', 'Nigerian', 'Nigerien', 'North Korean', 'Northern Irish', 'Norwegian', 'Omani', 'Pakistani', 'Palauan', 'Panamanian', 'Papua New Guinean', 'Paraguayan', 'Peruvian', 'Polish', 'Portuguese', 'Puerto Rican', 'Qatari', 'Romanian', 'Russian', 'Rwandan', 'Saint Lucian', 'Salvadoran', 'Samoan', 'San Marinese', 'Sao Tomean', 'Saudi', 'Scottish', 'Senegalese', 'Serbian', 'Seychellois', 'Sierra Leonean', 'Singaporean', 'Slovakian', 'Slovenian', 'Solomon Islander', 'Somali', 'South African', 'South Korean', 'Spanish', 'Sri Lankan', 'Sudanese', 'Surinamer', 'Swazi', 'Swedish', 'Swiss', 'Syrian', 'Taiwanese', 'Tajik', 'Tanzanian', 'Thai', 'Togolese', 'Tongan', 'Trinidadian/Tobagonian', 'Tunisian', 'Turkish', 'Tuvaluan', 'Ugandan', 'Ukrainian', 'Uruguayan', 'Uzbekistani', 'Venezuelan', 'Vietnamese', 'Welsh', 'Yemenite', 'Zambian', 'Zimbabwean');

?>

<div class="portlet-heading">
    <h3 class="portlet-title text-dark text-uppercase">
        Your Authors
    </h3>
    <div class="clearfix"></div>
</div>
<?php if(isset($_SESSION['permission'][0]) && !empty($_SESSION['permission'][0])||(isset($_SESSION['permission'][1]) && !empty($_SESSION['permission'][1])) && isset($_SESSION['lang']) && !empty($_SESSION['lang']) && $_SESSION['label'] !='image'){
    if($_SESSION['lang']=='eng' || $_SESSION['lang']=='all'){ //Permission to insert ?>
<?php //if(isset($_SESSION['label']) && !empty($_SESSION['label']) && $_SESSION['label'] =='root' || $_SESSION['label'] =='author'){ //Permission to insert ?>
<div class="container quote-form" id="quote-form">
    <div class="row">
        <div class="col-xs-12 relative-container">
            <label onclick="closeWindow();clearFields()"><span class="glyphicon glyphicon-remove"></span> Hide</label>
        </div>
        <div class="form-group col-xs-12">
		<span class="error">Author already exists</span>
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="author" data-error="Field required" aria-describedby="author" placeholder="Enter Author's name..."  oninput="checkAvailability(this)">
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-happy"></i></span>
                <input type="text" class="form-control" id="bdate" data-error="Field required" aria-describedby="birthday" placeholder="Birth (Format: YYYY-MM-DD)">
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-sad"></i></span>
                <input type="text" class="form-control" id="pdate" data-error="Field required" aria-describedby="died" placeholder="Died (Format: YYY-MMM-DDD)">
                
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
                <button type="button" class="btn btn-primary" id="save">Save</button>
            </div>
        </div>
    </div>
</div>
<?php //} ?>
<?php }} ?>

<div class="container">
    <div class="row" id="row" style="display:inline;">        
        <?php
            foreach($authors as $key=>$val){
        ?>
        
        <div class="col-xs-6 col-sm-4 col-lg-3 author-container">
            <div class="profile background" style="background-image:url('https://portalquote.com/images/author-images/<?php echo $authors[$key]['authorImage']; ?>');"></div>
            <span><?php echo $authors[$key]['authorName']; ?></span>
            <ul style="overflow:hidden;text-align: center;margin-left:auto;margin-right: auto;">
                <?php if(isset($_SESSION['permission'][1]) && !empty($_SESSION['permission'][1]) && ($_SESSION['lang']=='eng' || $_SESSION['lang']=='all') || $_SESSION['label']=='root'){ ?><li onclick="openUpdate(<?php echo $authors[$key]['authorID']; ?>)">Edit | </li><?php } ?>
                <?php if(isset($_SESSION['permission'][2]) && !empty($_SESSION['permission'][2]) || $_SESSION['label']=='root'){ ?><li onclick='deleteThis(this,"<?php echo $authors[$key]['authorID']; ?>","<?php $remove[] = "'";$remove[] = '"'; echo str_replace($remove, "", $authors[$key]['authorName']); ?>")'>Delete | </li><?php } ?>
                <?php if($_SESSION['label'] !='image'){ ?><li onclick="authorsTranslation(<?php echo $authors[$key]['authorID']; ?>)">Translate</li><?php } ?>
            </ul>
            <p><a href="https://portalquote.com/author/quotes/<?php echo $authors[$key]['seo_url']; ?>/1" target="_blank">View Page</a></p>
        </div>
        <?php
            }
        ?>
    </div>
</div>

<?php if(empty($_POST['dataARR'])){ ?>
<div class="container">
    <nav aria-label="Page navigation">
        <?php echo $Paginator->createLinks($links, 'pagination pagination-sm','myAuthors'); ?> 
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

<!--<button class="btn btn-primary" onclick="publish()">Submit all Authors to Facebook</button> -->
<script src="js/pagination.js?<?php echo time(); ?>"></script>
<script>
    if($('#search').length)
        $('#search').attr('id','search1');
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
    var goToPage=function(){
        var nPage=$('#pageN').val();
        myAuthors(document.getElementById('my-author'),nPage);
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
        $('#professions-list').html('');
        $("#image").val('');
        $(".up-label").text('Upload an image');
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
                $('html, body').animate({ scrollTop: 0 }, 'fast');
                $('#author').val(data[0][0].authorName);
                if(data[0][0].birth!=''){
                    var birth=data[0][0].birth.split('-');
                    if(birth[0]!='0000' && birth[1]!='00' &&  birth[2]!='00')
                        $('#bdate').val(data[0][0].birth);   
                }
                if(data[0][0].died!='' && data[0][0].died!=null){
                    var death=data[0][0].died.split('-');
                    if(death[0]!='0000' && death[1]!='00' &&  death[2]!='00')
                        $('#pdate').val(data[0][0].died);
                }
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
    
    // Validates that the input string is a valid date formatted as "yy/mm/dd"
    function isValidDate(dateString){
        // First check for the pattern
        if(!/^\d{4}-\d{2}-\d{2}$/.test(dateString))
            return false;

        // Parse the date parts to integers
        var parts = dateString.split("-");
        var month = parseInt(parts[1], 10);
        var year = parseInt(parts[0], 10);
        var day = parseInt(parts[2], 10);
        // Check the ranges of month and year
        if(year < 1000 || year > 3000 || month == 0 || month > 12)
            return false;
        
        var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];
        // Adjust for leap years
        if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
            monthLength[1] = 29;
        // Check the range of the day
        return day > 0 && day <= monthLength[month - 1];
    }
    
   var updateAuthor = function(el, quotID){
        var author = $('#author').val(),
            birth=$('#bdate').val(),
            pdate=$('#pdate').val(),
            country=$('#country').val(),
            profession = $("select[name='professions[]']").map(function(){if($(this).val()!='') return $(this).val();}).get(),
            bio=$('#profile').val(),
            url=$('#url').val(),
            arr = {},
            arr2 = {},
            errors=[];
       if(author && author != ''){
            if($('.error').css('display')=='inline-block'){
                errors.push('Author already exists!');
            }else{
                arr['authorName'] = author;
                var seo = author.replace(/["']/g, "");
                seo = seo.replace(/["-]/g, "");
                seo = seo.replace(/[",]/g, "");
                seo = seo.replace(/["!]/g, "");
                seo = seo.replace(/[".]/g, "");
                seo = seo.replace(/\s/g,' ');
                arr['seo_url'] = seo.split(' ').join('-').toLowerCase();
            }
        }
        else
            errors.push('Author\'s name cannot be blank!');
        if($('#bdate').val()!=''){
            if(isValidDate(birth))
                arr['birth'] = birth;
            else
                errors.push('Error date format');
        }
        if($('#pdate').val()!=''){
            if(isValidDate(pdate))
                arr['died'] = pdate;
            else
                errors.push('Error date format');
        }else{
            arr['died'] = '0000-00-00';
        }
        if($('#country').val()!='')
            arr['nationality'] = country;
        else
            errors.push('Country cannot be blank!');
        if($('#profile').val()!='')
            arr['bio'] = bio;
        else
            errors.push('Author\'s description cannot be blank!');
        if($('#url').val()!='')
            arr['sourceURL'] = url;
        else
            errors.push('Source cannot be blank!');
       if($('#image').val()!=''){
           var imageSize=$('#image').prop('files')[0].size;
           if(imageSize<=100000)
               var image=$('#image').prop('files')[0];
           else
               errors.push('Image should be 100KB or less!');
       }else
           var image='';
       if(profession.length<1)
           errors.push("Author's profession not selected!");
       if(errors.length < 1){
           var token = generateToken();
           token.done(function(generatedToken){
		el.innerHTML = "Updating";
               $(el).attr('disabled','disabled');
               var update_author = update('authors',arr,'authorID',quotID,generatedToken,image);
               update_author.done(function(data){
                   //NEW STUFF
			console.log(data);
                   var logArr={};
                   logArr['log']=' has edited an Author in English. Author ID: <a class="idREL" onclick="authorsTranslation('+quotID+')">'+quotID+'</a>';
                   var log=insertLog('dashboard_logs',logArr,'logs');
                   log.done(function(res2){
                       //console.log(res2);
                   });
                   //NEW STUFF
                   if(profession.length > 0){
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
                                           $(el).removeAttr('disabled');
                                           el.innerHTML = "Update";
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
                       $(el).removeAttr('disabled');
                       el.innerHTML = "Update!";
                       setTimeout(function() {
                           clearFields();
                           closeWindow();
                       }, 200);
                   }
               });
           });
       }else{
           var error='';
           for(var e in errors)
               error+='-'+errors[e]+'\n';
           alert(error);
       }
   }

// FB API INIT
/*	window.fbAsyncInit = function() {
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
    }*/
    
    var save = function(el){
        var author = $('#author').val(),
            birth=$('#bdate').val(),
            country=$('#country').val(),
            profession = $("select[name='professions[]']").map(function(){if($(this).val()!='') return $(this).val();}).get(),
            bio=$('#profile').val(),
            url=$('#url').val(),
            arr = {},
            arr2 = {},
            errors=[];
       if(author && author != ''){
            if($('.error').css('display')=='inline-block'){
                errors.push('Author already exists!');
            }else{
                var seo = author.replace(/["']/g, "");
                seo = seo.replace(/["-]/g, "");
                seo = seo.replace(/[",]/g, "");
                seo = seo.replace(/["!]/g, "");
                seo = seo.replace(/[".]/g, "");
                seo = seo.replace(/\s/g,' ');
                arr['seo_url'] = seo.split(' ').join('-').toLowerCase();
            }
        }
        else
            errors.push('Author\'s name cannot be blank!');
        if($('#bdate').val()!=''){
            if(isValidDate(birth))
                arr['birth'] = birth;
            else
                errors.push('Error date format');
        }
        if($('#pdate').val()!=''){
            if(isValidDate(birth))
                arr['died'] = birth;
            else
                errors.push('Error date format');
        }
        if($('#country').val()!='')
            arr['nationality'] = country;
        else
            errors.push('Country cannot be blank!');
        if($('#profile').val()!='')
            arr['bio'] = bio;
        else
            errors.push('Author\'s description cannot be blank!');
        if($('#url').val()!='')
            arr['sourceURL'] = url;
        else
            errors.push('Source cannot be blank!');
        if(errors.length < 1){
            if(profession.length>=1){
                var token = generateToken();
                token.done(function(generatedToken){
                    if($('#image').val()!='')
                        var image=$('#image').prop('files')[0];
                    else
                        var image='';
                    $(el).attr('disabled','disabled');
                    el.innerHTML = "Saving";
                    var insert_author = insert('authors',arr,generatedToken,image);
                    insert_author.done(function(data){
                        console.log(data);
                        var last_author = limit('authors','authorID','authorID',1);
                        last_author.done(function(last){
                            arr2['authorID']=last[0][0].authorID;
                            //NEW STUFF
                            var logArr={},relArr={};
                            relArr['authorID']=last[0][0].authorID;
                            var token3 = generateToken();
                            token3.done(function(generatedToke3){
                                var userAuthorRel=insertLog('dashboardUsr_Authors_en',relArr,'relation');
                                userAuthorRel.done(function(res){
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
                                        postToPage(author);
                                    });
                                });
                            }
                            setTimeout(function() {
                                myAuthors(document.getElementById('my-author'));
                            }, 2000);
                        });
                    });
                });
            }else{
                errors.push("Author's profession not selected!");
            }
        }else{
            var error='';
            for(var e in errors)
                error+='-'+errors[e]+'\n';
            alert(error);
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
    
    var searchFunction=function(){
        var text=document.getElementById('search1').value;
        if(text!=''){
            $('#quotes-area').css('visibility','hidden');
            $('.portlet .loader').css('display','block');
            var searching=search('authors','authorName',text,'authorID','search');
            searching.done(function(data){
                setTimeout(function() {
                    $('.portlet .loader').css('display','none');
                    $('#quotes-area').css('visibility','visible');
                    authors('','#authors-eng',data);
                }, 2000);
            });
        }else{
            authors('','#authors-eng');
        }
    }
    document.getElementById("search1").addEventListener("keyup", function(event) {
        event.preventDefault();
        if(event.keyCode == 13){
            searchFunction();
        }
    });
</script>