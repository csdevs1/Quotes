<?php
    session_start();
    require_once('../Classes/AppController.php');
    $obj = new AppController();
    $authors = $obj->all('authors');
    $countries = array('Afghan', 'Albanian', 'Algerian', 'American', 'Andorran', 'Angolan', 'Antiguans', 'Argentinean', 'Armenian', 'Australian', 'Austrian', 'Azerbaijani', 'Bahamian', 'Bahraini', 'Bangladeshi', 'Barbadian', 'Barbudans', 'Batswana', 'Belarusian', 'Belgian', 'Belizean', 'Beninese', 'Bhutanese', 'Bolivian', 'Bosnian', 'Brazilian', 'British', 'Bruneian', 'Bulgarian', 'Burkinabe', 'Burmese', 'Burundian', 'Cambodian', 'Cameroonian', 'Canadian', 'Cape Verdean', 'Central African', 'Chadian', 'Chilean', 'Chinese', 'Colombian', 'Comoran', 'Congolese', 'Costa Rican', 'Croatian', 'Cuban', 'Cypriot', 'Czech', 'Danish', 'Djibouti', 'Dominican', 'Dutch', 'East Timorese', 'Ecuadorean', 'Egyptian', 'Emirian', 'Equatorial Guinean', 'Eritrean', 'Estonian', 'Ethiopian', 'Fijian', 'Filipino', 'Finnish', 'French', 'Gabonese', 'Gambian', 'Georgian', 'German', 'Ghanaian', 'Greek', 'Grenadian', 'Guatemalan', 'Guinea-Bissauan', 'Guinean', 'Guyanese', 'Haitian', 'Herzegovinian', 'Honduran', 'Hungarian', 'I-Kiribati', 'Icelander', 'Indian', 'Indonesian', 'Iranian', 'Iraqi', 'Irish', 'Israeli', 'Italian', 'Ivorian', 'Jamaican', 'Japanese', 'Jordanian', 'Kazakhstani', 'Kenyan', 'Kittian and Nevisian', 'Kuwaiti', 'Kyrgyz', 'Laotian', 'Latvian', 'Lebanese', 'Liberian', 'Libyan', 'Liechtensteiner', 'Lithuanian', 'Luxembourger', 'Macedonian', 'Malagasy', 'Malawian', 'Malaysian', 'Maldivan', 'Malian', 'Maltese', 'Marshallese', 'Mauritanian', 'Mauritian', 'Mexican', 'Micronesian', 'Moldovan', 'Monacan', 'Mongolian', 'Moroccan', 'Mosotho', 'Motswana', 'Mozambican', 'Namibian', 'Nauruan', 'Nepalese', 'New Zealander', 'Nicaraguan', 'Nigerian', 'Nigerien', 'North Korean', 'Northern Irish', 'Norwegian', 'Omani', 'Pakistani', 'Palauan', 'Panamanian', 'Papua New Guinean', 'Paraguayan', 'Peruvian', 'Polish', 'Portuguese', 'Puerto Rican', 'Qatari', 'Romanian', 'Russian', 'Rwandan', 'Saint Lucian', 'Salvadoran', 'Samoan', 'San Marinese', 'Sao Tomean', 'Saudi', 'Scottish', 'Senegalese', 'Serbian', 'Seychellois', 'Sierra Leonean', 'Singaporean', 'Slovakian', 'Slovenian', 'Solomon Islander', 'Somali', 'South African', 'South Korean', 'Spanish', 'Sri Lankan', 'Sudanese', 'Surinamer', 'Swazi', 'Swedish', 'Swiss', 'Syrian', 'Taiwanese', 'Tajik', 'Tanzanian', 'Thai', 'Togolese', 'Tongan', 'Trinidadian/Tobagonian', 'Tunisian', 'Turkish', 'Tuvaluan', 'Ugandan', 'Ukrainian', 'Uruguayan', 'Uzbekistani', 'Venezuelan', 'Vietnamese', 'Welsh', 'Yemenite', 'Zambian', 'Zimbabwean');

?>
<style>
    .error{color: #ff4c4c;display: none;}
</style>
<div class="portlet-heading">
    <h3 class="portlet-title text-dark text-uppercase">
        Authors
    </h3>
    <div class="clearfix"></div>
</div>
<?php if(isset($_SESSION['permission'][1]) && !empty($_SESSION['permission'][1]) && isset($_SESSION['lang']) && !empty($_SESSION['lang']) && $_SESSION['label'] !='image'){if($_SESSION['lang']=='eng' || $_SESSION['lang']=='all'){ ?>
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
<?php }} ?>


<div class="container">
    <div class="row" id="row">
        
        <?php
            foreach($authors as $key=>$val){
                $professions=$obj->find_by('authorProfession','authorID',$authors[$key]['authorID']);
                if(!empty($authors[$key]['authorName']) && !empty($authors[$key]['sourceURL']) && !empty($authors[$key]['birth']) && count($professions)>0 && !empty($authors[$key]['nationality']) && !empty($authors[$key]['seo_url'])){
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
            }
        ?>
    </div>
</div>

<div class="container">
    <div class="paging-container row col-centered" id="tablePaging">
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

<!--<button class="btn btn-primary" onclick="publish()">Submit all Authors to Facebook</button>-->
<script src="js/pagination.js?<?php echo time(); ?>"></script>

<script>
    var addProfession=function(){
        var professions=all('professions');
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
                    console.log('changed to ' + ps);
                },
                onPageChange: function (paging) {
                    //custom paging logic here
                    console.log(paging);
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
                            //NEW STUFF
                            var logArr={};
                            logArr['log']=' has edited an Author in English. Author ID: <a class="idREL" onclick="authorsTranslation('+quotID+')">'+quotID+'</a>';
                            var log=insertLog('dashboard_logs',logArr,'logs');
                            log.done(function(res2){
                                console.log(res2);
                            });
                            //NEW STUFF
                            
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
    
    var checkAvailability = function(el){
        var checked=find_by('authors','authorName',el.value);
        checked.done(function(response){
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