<?php
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
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-university"></i></span>
                <input type="text" class="form-control" id="profession" data-error="Field required" aria-describedby="profession" placeholder="Enter Author's profession..." >
                
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


<div class="container">
    <div class="row" id="row">
        
        <?php
            foreach($authors as $key=>$val){
                if(!empty($authors[$key]['authorName']) || !empty($authors[$key]['sourceURL']) || !empty($authors[$key]['birth']) || !empty($authors[$key]['profession']) || !empty($authors[$key]['nationality']) || !empty($authors[$key]['seo_url'])){
        ?>
        <div class="col-xs-12 col-sm-6 col-md-4 box-content data">
            <div class="inner-box background" style="background-image:url('<?php echo $authors[$key]['authorImage']; ?>');">
                <h3 data-placement="top" title="Edit Topic" onclick="openUpdate(<?php echo $authors[$key]['authorID']; ?>)"><a><?php echo $authors[$key]['authorName']; ?></a></h3>
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
                $('#profession').val(data[0][0].profession);
                $('#profile').val(data[0][0].bio);
                $('#url').val(data[0][0].sourceURL);
                $('#country option[value='+data[0][0].nationality+']').prop('selected', true);
                $('#author').focus();
            }
        });
    }
    
    
    var updateAuthor = function(el, quotID){
        $(el).attr('disabled','disabled');
        el.innerHTML = "Updating";
        var author = $('#author').val(),
            birth=$('#bdate').val(),
            country=$('#country').val(),
            profession=$('#profession').val(),
            bio=$('#profile').val(),
            url=$('#url').val(),
            arr = {};
        if(author && author != ''){
            arr['authorName'] = author;
            var seo = author.replace(/["']/g, "");
            seo = seo.replace(/["-]/g, "");
            arr['seo_url'] = seo.split(' ').join('-').toLowerCase();
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
        if($('#profession').val()!='')
            arr['profession'] = profession;
        else
            console.log('Error profession');
        if($('#profile').val()!='')
            arr['bio'] = bio;
        else
            console.log('Error profile');
        if($('#url').val()!='')
            arr['sourceURL'] = url;
        else
            console.log('Error Source');
        if($('#image').val()!=''){
            if(arr['authorName'] != '' && arr['birth'] != '' && arr['country'] != '' && arr['profession'] != '' && arr['bio'] != ''){
                var token = generateToken();
                token.done(function(generatedToken){
                    var image = imgur_upload($('#image').prop('files')[0]);
                    image.done(function(response){
                        var url = response.data.link;
                        arr['authorImage'] = url.replace('http','https');
                        var update_author = update('authors',arr,'authorID',quotID,generatedToken);
                        update_author.done(function(data){
                            $(el).removeAttr('disabled');
                            el.innerHTML = "Updated!";
                            setTimeout(function() {
                                completedAuthors(document.getElementById('author-completed'));
                            }, 200);
                        });
                    });
                });
            }
        }else if(arr['authorName'] != '' && arr['birth'] != '' && arr['country'] != '' && arr['profession'] != '' && arr['bio'] != ''){
            var token = generateToken();
            token.done(function(generatedToken){
                var update_author = update('authors',arr,'authorID',quotID,generatedToken);
                update_author.done(function(data){
                    $(el).removeAttr('disabled');
                    el.innerHTML = "Updated!";
                    setTimeout(function() {
                        completedAuthors(document.getElementById('author-completed'));
                    }, 200);
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
</script>