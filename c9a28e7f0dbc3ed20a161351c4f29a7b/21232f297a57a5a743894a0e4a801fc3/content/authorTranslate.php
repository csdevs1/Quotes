<?php
    session_start();
    require_once('../Classes/AppController.php');
    $obj = new AppController();
    $author=$obj->find_by('authors','authorID',$_POST['id']);
    $professions_en=$obj->all('professions ORDER BY professionName ASC');
    $professions_es=$obj->all('professions_es ORDER BY professionName ASC');

    $professionsRel = $obj->find_by('authorProfession','authorID',$_POST['id']); //Profession an Author is
    $count=0;
//AUTHOR'S PROFESSIONS IN EN
    $professionEN=array();
    foreach($professionsRel as $key=>$val){
        $professionEN[$count]=$obj->find_by('professions','professionID',$professionsRel[$key]['professionID']); // get authors profession in spanish
        $count++;
    }
$count=0;
//AUTHOR'S PROFESSIONS IN SPANISH
    $professionES=array();
    foreach($professionsRel as $key=>$val){
        $professionES[$count]=$obj->find_by('professions_es','pID',$professionsRel[$key]['professionID']); // get authors profession in spanish
        $count++;
    }

    $next=$obj->custom("SELECT authorID FROM authors WHERE authorID > ".$_POST['id']." ORDER BY authorID ASC LIMIT 1"); //TO SELECT NEXT SET OF QUOTES
    $previous=$obj->custom("SELECT authorID FROM authors WHERE authorID < ".$_POST['id']." ORDER BY authorID DESC LIMIT 1"); //TO SELECT PREVIOUS SET OF QUOTES

// SPANISH
$authorES=$obj->find_by('authors_es','aID',$_POST['id']);

$countries = array('Afghan', 'Albanian', 'Algerian', 'American', 'Andorran', 'Angolan', 'Antiguans', 'Argentinean', 'Armenian', 'Australian', 'Austrian', 'Azerbaijani', 'Bahamian', 'Bahraini', 'Bangladeshi', 'Barbadian', 'Barbudans', 'Batswana', 'Belarusian', 'Belgian', 'Belizean', 'Beninese', 'Bhutanese', 'Bolivian', 'Bosnian', 'Brazilian', 'British', 'Bruneian', 'Bulgarian', 'Burkinabe', 'Burmese', 'Burundian', 'Cambodian', 'Cameroonian', 'Canadian', 'Cape Verdean', 'Central African', 'Chadian', 'Chilean', 'Chinese', 'Colombian', 'Comoran', 'Congolese', 'Costa Rican', 'Croatian', 'Cuban', 'Cypriot', 'Czech', 'Danish', 'Djibouti', 'Dominican', 'Dutch', 'East Timorese', 'Ecuadorean', 'Egyptian', 'Emirian', 'Equatorial Guinean', 'Eritrean', 'Estonian', 'Ethiopian', 'Fijian', 'Filipino', 'Finnish', 'French', 'Gabonese', 'Gambian', 'Georgian', 'German', 'Ghanaian', 'Greek', 'Grenadian', 'Guatemalan', 'Guinea-Bissauan', 'Guinean', 'Guyanese', 'Haitian', 'Herzegovinian', 'Honduran', 'Hungarian', 'I-Kiribati', 'Icelander', 'Indian', 'Indonesian', 'Iranian', 'Iraqi', 'Irish', 'Israeli', 'Italian', 'Ivorian', 'Jamaican', 'Japanese', 'Jordanian', 'Kazakhstani', 'Kenyan', 'Kittian and Nevisian', 'Kuwaiti', 'Kyrgyz', 'Laotian', 'Latvian', 'Lebanese', 'Liberian', 'Libyan', 'Liechtensteiner', 'Lithuanian', 'Luxembourger', 'Macedonian', 'Malagasy', 'Malawian', 'Malaysian', 'Maldivan', 'Malian', 'Maltese', 'Marshallese', 'Mauritanian', 'Mauritian', 'Mexican', 'Micronesian', 'Moldovan', 'Monacan', 'Mongolian', 'Moroccan', 'Mosotho', 'Motswana', 'Mozambican', 'Namibian', 'Nauruan', 'Nepalese', 'New Zealander', 'Nicaraguan', 'Nigerian', 'Nigerien', 'North Korean', 'Northern Irish', 'Norwegian', 'Omani', 'Pakistani', 'Palauan', 'Panamanian', 'Papua New Guinean', 'Paraguayan', 'Peruvian', 'Polish', 'Portuguese', 'Puerto Rican', 'Qatari', 'Romanian', 'Russian', 'Rwandan', 'Saint Lucian', 'Salvadoran', 'Samoan', 'San Marinese', 'Sao Tomean', 'Saudi', 'Scottish', 'Senegalese', 'Serbian', 'Seychellois', 'Sierra Leonean', 'Singaporean', 'Slovakian', 'Slovenian', 'Solomon Islander', 'Somali', 'South African', 'South Korean', 'Spanish', 'Sri Lankan', 'Sudanese', 'Surinamer', 'Swazi', 'Swedish', 'Swiss', 'Syrian', 'Taiwanese', 'Tajik', 'Tanzanian', 'Thai', 'Togolese', 'Tongan', 'Trinidadian/Tobagonian', 'Tunisian', 'Turkish', 'Tuvaluan', 'Ugandan', 'Ukrainian', 'Uruguayan', 'Uzbekistani', 'Venezuelan', 'Vietnamese', 'Welsh', 'Yemenite', 'Zambian', 'Zimbabwean');

$countries_es=array("Afganistán", "Akrotiri", "Albania", "Alemania", "Andorra", "Angola", "Anguila", "Antártida", "Antigua y Barbuda", "Antillas Neerlandesas", "Arabia Saudí", "Arctic Ocean", "Argelia", "Argentina", "Armenia", "Aruba", "Ashmore andCartier Islands", "Atlantic Ocean", "Australia", "Austria", "Azerbaiyán", "Bahamas", "Bahráin", "Bangladesh", "Barbados", "Bélgica", "Belice", "Benín", "Bermudas", "Bielorrusia", "Birmania Myanmar", "Bolivia", "Bosnia y Hercegovina", "Botsuana", "Brasil", "Brunéi", "Bulgaria", "Burkina Faso", "Burundi", "Bután", "Cabo Verde", "Camboya", "Camerún", "Canadá", "Chad", "Chile", "China", "Chipre", "Clipperton Island", "Colombia", "Comoras", "Congo", "Coral Sea Islands", "Corea del Norte", "Corea del Sur", "Costa de Marfil", "Costa Rica", "Croacia", "Cuba", "Dhekelia", "Dinamarca", "Dominica", "Ecuador", "Egipto", "El Salvador", "El Vaticano", "Emiratos Árabes Unidos", "Eritrea", "Eslovaquia", "Eslovenia", "España", "Estados Unidos", "Estonia", "Etiopía", "Filipinas", "Finlandia", "Fiyi", "Francia", "Gabón", "Gambia", "Gaza Strip", "Georgia", "Ghana", "Gibraltar", "Granada", "Grecia", "Groenlandia", "Guam", "Guatemala", "Guernsey", "Guinea", "Guinea Ecuatorial", "Guinea-Bissau", "Guyana", "Haití", "Honduras", "Hong Kong", "Hungría", "India", "Indian Ocean", "Indonesia", "Irán", "Iraq", "Irlanda", "Isla Bouvet", "Isla Christmas", "Isla Norfolk", "Islandia", "Islas Caimán", "Islas Cocos", "Islas Cook", "Islas Feroe", "Islas Georgia del Sur y Sandwich del Sur", "Islas Heard y McDonald", "Islas Malvinas", "Islas Marianas del Norte", "IslasMarshall", "Islas Pitcairn", "Islas Salomón", "Islas Turcas y Caicos", "Islas Vírgenes Americanas", "Islas Vírgenes Británicas", "Israel", "Italia", "Jamaica", "Jan Mayen", "Japón", "Jersey", "Jordania", "Kazajistán", "Kenia", "Kirguizistán", "Kiribati", "Kuwait", "Laos", "Lesoto", "Letonia", "Líbano", "Liberia", "Libia", "Liechtenstein", "Lituania", "Luxemburgo", "Macao", "Macedonia", "Madagascar", "Malasia", "Malaui", "Maldivas", "Malí", "Malta", "Man, Isle of", "Marruecos", "Mauricio", "Mauritania", "Mayotte", "México", "Micronesia", "Moldavia", "Mónaco", "Mongolia", "Montserrat", "Mozambique", "Namibia", "Nauru", "Navassa Island", "Nepal", "Nicaragua", "Níger", "Nigeria", "Niue", "Noruega", "Nueva Caledonia", "Nueva Zelanda", "Omán", "Pacific Ocean", "Países Bajos", "Pakistán", "Palaos", "Panamá", "Papúa-Nueva Guinea", "Paracel Islands", "Paraguay", "Perú", "Polinesia Francesa", "Polonia", "Portugal", "Puerto Rico", "Qatar", "Reino Unido", "República Centroafricana", "República Checa", "República Democrática del Congo", "República Dominicana", "Ruanda", "Rumania", "Rusia", "Sáhara Occidental", "Samoa", "Samoa Americana", "San Cristóbal y Nieves", "San Marino", "San Pedro y Miquelón", "San Vicente y las Granadinas", "Santa Helena", "Santa Lucía", "Santo Tomé y Príncipe", "Senegal", "Seychelles", "Sierra Leona", "Singapur", "Siria", "Somalia", "Southern Ocean", "Spratly Islands", "Sri Lanka", "Suazilandia", "Sudáfrica", "Sudán", "Suecia", "Suiza", "Surinam", "Svalbard y Jan Mayen", "Tailandia", "Taiwán", "Tanzania", "Tayikistán", "TerritorioBritánicodel Océano Indico", "Territorios Australes Franceses", "Timor Oriental", "Togo", "Tokelau", "Tonga", "Trinidad y Tobago", "Túnez", "Turkmenistán", "Turquía", "Tuvalu", "Ucrania", "Uganda", "Unión Europea", "Uruguay", "Uzbekistán", "Vanuatu", "Venezuela", "Vietnam", "Wake Island", "Wallis y Futuna", "West Bank", "World", "Yemen", "Yibuti", "Zambia", "Zimbabue");


?>

<style>    .profile{
        width: 150px;
        height: 150px;
        box-shadow: 0 36px 64px -34px #222, 0 16px 14px -14px rgba(0, 0, 0, 0.6), 0 22px 18px -18px rgba(0, 0, 0, 0.4), 0 22px 38px -18px #222;
        margin-bottom: 10px;
        border-radius: 100%;
        margin-left: auto;
        margin-right: auto;
        background-image: url('<?php echo $author[0]['authorImage']; ?>');
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
    h1{text-align: center;}
    .button{background: none;outline: none;border: 0;background-size: contain;background-position: left;background-repeat: no-repeat;padding: 10px;font-weight: 900;color: #000;margin-bottom: 10px;text-shadow: -2px 1px 3px #fff;padding-left: 45px;}
    p{text-align: center;font-size: 1.5rem;}
</style>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <nav class="navbar">
                <div class="container-fluid">
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li <?php if(empty($previous[0]['authorID'])) echo 'class="disabled"'; ?>><a <?php if(!empty($previous[0]['authorID'])){?>onclick="authorsTranslation(<?php echo $previous[0]['authorID']; ?>)"<?php } ?>><span class="glyphicon glyphicon-arrow-left"></span> Previous</a></a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li <?php if(empty($next[0]['authorID'])) echo 'class="disabled"'; ?>><a <?php if(!empty($next[0]['authorID'])){?>onclick="authorsTranslation(<?php echo $next[0]['authorID']; ?>)"<?php } ?>><span class="glyphicon glyphicon-arrow-right"></span> Next</a></li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="profile"></div>
            <h1><?php echo $author[0]['authorName']; ?></h1>
            <p class="text-muted"><?php echo $author[0]['bio']; ?></p>
        </div>
    </div>
</div>

<!-- TO TRANSLATE IN ENG -->
<?php if(isset($_SESSION['permission'][1]) && !empty($_SESSION['permission'][1]) && isset($_SESSION['lang']) && !empty($_SESSION['lang']) && $_SESSION['label'] !='image'){
                    if($_SESSION['lang']=='en' || $_SESSION['lang']=='all'){
            ?>
<div class="container quote-form" id="author-en">
    <div class="row">
        <div class="col-xs-12 relative-container">
            <label onclick="closeForm();clearFields()"><span class="glyphicon glyphicon-remove"></span> Hide</label>
        </div>
        <div class="form-group col-xs-12">
		<span class="error">Author already exist</span>
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="a-en" data-error="Field required" aria-describedby="author" placeholder="Enter Author's Name..." value="<?php echo $author[0]['authorName']; ?>" disabled>
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-happy"></i></span>
                <input type="text" class="form-control" id="bdate-en" data-error="Field required" aria-describedby="birthday" placeholder="Birth" value="<?php echo $author[0]['birth']; ?>">
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-sad"></i></span>
                <input type="text" class="form-control" id="pdate-en" data-error="Field required" aria-describedby="died" placeholder="Died" value="<?php echo $author[0]['died']; ?>">
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-earth"></i></span>
                <select class="form-control" id="country-en" required>
                    <option value="">-- SELECT NATIONALY --</option>
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
       <!-- <div class="form-group col-xs-12">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-6">
                        <button type="button" class="btn btn-warning" onclick="addProfession()"><span class="glyphicon glyphicon-plus"></span> Add a profession</button>
                    </div>
                </div>
            </div>
        </div>-->
        <div class="form-group col-xs-12" id="professions-list-en">
            <div class="input-group col-xs-12 col-sm-4 col-md-3">
                <span class="input-group-addon"><i class="ion-university"></i></span>
                <!--<input type="text" class="form-control" id="profession" data-error="Field required" aria-describedby="profession" placeholder="Enter Author's profession..." >-->
                <?php foreach($professionEN as $key1=>$val1){ ?>
                    <select class="form-control" name="professions-en[]" required>
                        <option value="">-- Profession --</option>
                        <?php
                            foreach($professions_en as $key=>$val){
                        ?>
                            <option value="<?php echo $professions_en[$key]['professionID']; ?>" <?php if($professions_en[$key]['professionID']==$professionEN[$key1][0]['professionID']) echo 'selected'; ?>><?php echo $professions_en[$key]['professionName']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                <?php
                    }
                ?>
            </div>
        </div>
        <div class="form-group col-xs-12">
            <textarea placeholder="Brief Description About the author..." maxlength="500" class="textarea" id="profile-en"></textarea>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-university"></i></span>
                <input type="text" class="form-control" id="url-en" data-error="Field required" aria-describedby="url" placeholder="Source (URL)..." >
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <button type="button" class="btn btn-primary" onclick="update_author(this,'en',<?php echo $author[0]['authorID']; ?>)" id="save-en">Traducir</button>
            </div>
        </div>
    </div>
</div>
<?php } } ?>

<!-- TO TRANSLATE IN SPANISH -->
<?php if(isset($_SESSION['permission'][1]) && !empty($_SESSION['permission'][1]) && isset($_SESSION['lang']) && !empty($_SESSION['lang']) && $_SESSION['label'] !='image'){
                    if($_SESSION['lang']=='es' || $_SESSION['lang']=='all'){
            ?>
<div class="container quote-form" id="author-es">
    <div class="row">
        <div class="col-xs-12 relative-container">
            <label onclick="closeForm();clearFields()"><span class="glyphicon glyphicon-remove"></span> Cerrar</label>
        </div>
        <div class="form-group col-xs-12">
		<span class="error">Author alreay exist</span>
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input type="text" class="form-control" id="a-es" data-error="Field required" aria-describedby="author" placeholder="Ingresa el nombre del autor..." value="<?php echo $author[0]['authorName']; ?>" disabled>
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-happy"></i></span>
                <input type="text" class="form-control" id="bdate-es" data-error="Field required" aria-describedby="birthday" placeholder="Birth" value="<?php echo $author[0]['birth']; ?>" disabled>
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-sad"></i></span>
                <input type="text" class="form-control" id="pdate-es" data-error="Field required" aria-describedby="died" placeholder="Died" value="<?php echo $author[0]['died']; ?>" disabled>
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-earth"></i></span>
                <select class="form-control" id="country-es" required>
                    <option value="">-- SELECCIONA LA NACIONALIDAD --</option>
                    <?php
                        for($i=0;$i<count($countries_es);$i++){
                    ?>
                        <option value="<?php echo $countries_es[$i]; ?>"><?php echo $countries_es[$i]; ?></option>
                    <?php
                        }
                    ?>
                </select>
                
            </div>
        </div>
       <!-- <div class="form-group col-xs-12">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-6">
                        <button type="button" class="btn btn-warning" onclick="addProfession()"><span class="glyphicon glyphicon-plus"></span> Add a profession</button>
                    </div>
                </div>
            </div>
        </div>-->
        <div class="form-group col-xs-12" id="professions-list-es">
            <div class="input-group col-xs-12 col-sm-4 col-md-3">
                <span class="input-group-addon"><i class="ion-university"></i></span>
                <!--<input type="text" class="form-control" id="profession" data-error="Field required" aria-describedby="profession" placeholder="Enter Author's profession..." >-->
                <?php foreach($professionES as $key1=>$val1){ ?>
                    <select class="form-control" name="professions-es[]" required disabled>
                        <option value="">-- Profession --</option>
                        <?php
                            foreach($professions_es as $key=>$val){
                        ?>
                            <option value="<?php echo $professions_es[$key]['professionID']; ?>" <?php if($professions_es[$key]['professionID']==$professionES[$key1][0]['professionID']) echo 'selected'; ?>><?php echo $professions_es[$key]['professionName']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                <?php
                    }
                ?>
            </div>
        </div>
        <div class="form-group col-xs-12">
            <textarea placeholder="Breve descripcion acerca del autor..." maxlength="500" class="textarea" id="profile-es"></textarea>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="ion-university"></i></span>
                <input type="text" class="form-control" id="url-es" data-error="Field required" aria-describedby="url" placeholder="Source (URL)..." >
                
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <button type="button" class="btn btn-primary" onclick="save(this,'es',<?php echo $author[0]['authorID']; ?>)" id="save-es">Traducir</button>
            </div>
        </div>
    </div>
</div>
<?php } } ?>

<!-- ENGLISH OPTIONS -->
<div class="container">
    <div class="row">
        <div class="col-xs-12 addauthor">
            <?php if(isset($_SESSION['permission'][1]) && !empty($_SESSION['permission'][1]) && isset($_SESSION['lang']) && !empty($_SESSION['lang']) && $_SESSION['label'] !='image'){
                    if($_SESSION['lang']=='eng' || $_SESSION['lang']=='all'){
            ?>
                <button class="button" onclick="openUpdate(this,'en',<?php echo $_POST['id']; ?>)" style="background-image: url('images/eng.png');">Edit</button>
            <?php } }?>
        </div>
    </div>
</div>

<!-- SPANISH OPTIONS -->
<div class="container">
    <div class="row">
        <div class="col-xs-12 addauthor">
            <?php if(isset($_SESSION['permission'][1]) && !empty($_SESSION['permission'][1]) && isset($_SESSION['lang']) && !empty($_SESSION['lang']) && $_SESSION['label'] !='image'){
                    if($_SESSION['lang']=='es' || $_SESSION['lang']=='all'){
            ?>
            <?php if(empty($authorES)){ ?>
                <button class="button" onclick="openForm(this,'es')" style="background-image: url('images/es.png');">Traducir al Espanol</button>
            <?php }else{ ?>
                <button class="button" onclick="openUpdate(this,'es',<?php echo $_POST['id']; ?>)" style="background-image: url('images/es.png');">Editar</button>
            <?php } } }?>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        $('.quote-form').hide();
    });
    var closeForm=function(){
        $('.quote-form').hide(500);
        $('.addauthor').show();
    }
    var openForm=function(el,lang){
        $('#author-'+lang).show(500);
        $('.addauthor').hide(100);
        $('.quote-form').not('#author-'+lang).hide();
    }
    
    var openUpdate=function(el,lan,aID){
        lan=='en' ? lang='en':lang=lan;
        lan=='en' ? auProf='':auProf='_'+lang;
        lan=='en' ? idROW='authorID':idROW='aID';
        switch(lan){
            case 'es':
                language='Spanish';
                break;
            case 'pt':
                language='Portuguese';
                break;
            default:
                language='English';
        }
        var author = find_by('authors'+auProf,idROW,aID);
        document.getElementById('save-'+lang).innerHTML="Update";
        author.done(function(data){
            if(Object.keys(data[0][0]).length > 1){
                $('#author-'+lang).show(500);
                $('.addauthor').hide(100);
                $('.quote-form').not('#author-'+lang).hide();
                $('#save-'+lang).attr('onclick','update_author(this,"'+lang+'",'+aID+','+data[0][0].authorID+')');
                
                $('#profile-'+lang).val(data[0][0].bio);
                $('#url-'+lang).val(data[0][0].sourceURL);
                $('#country-'+lang+" option[value='"+data[0][0].nationality+"']").prop('selected', true);
                $('#a-'+lang).focus();
                var professionAuthor=find_by('authorProfession'+auProf,'authorID',data[0][0].authorID);
                professionAuthor.done(function(response){
                    console.log(response);
                    document.getElementById('professions-list-'+lang).innerHTML='';
                    for(var i in response[0]){
                        var professions=find_by('professions'+auProf,'professionID',response[0][i].professionID);
                        professions.done(function(response2){
                            var allProfessions=order_by('professions'+auProf,'professionName','ASC');
                            allProfessions.done(function(response3){
                                var arr=[];
                                for(var i2 in response3[0]){
                                    if(response3[0][i2].professionName==response2[0][0].professionName)
                                        arr[i2]='<option value="'+response3[0][i2].professionID+'" selected>'+response3[0][i2].professionName+'</option>';
                                    else
                                        arr[i2]='<option value="'+response3[0][i2].professionID+'">'+response3[0][i2].professionName+'</option>';
                                }
                                $('#professions-list-'+lang).append('<div class="input-group col-xs-12 col-sm-4 col-md-3"><span class="input-group-addon"><i class="ion-university"></i></span><select class="form-control" name="professions-'+lang+'[]" required><option value="">-- Profession --</option>'+arr.join()+'</select></div>');
                            });
                        });
                    }
                });
            }
        });
    }
    
    var save=function(el,lang,aID){
        var country=$('#country-'+lang).val(),
            profession = $("select[name='professions-"+lang+"[]']").map(function(){if($(this).val()!='') return $(this).val();}).get(),
            bio=$('#profile-'+lang).val(),
            url=$('#url-'+lang).val(),
            arr = {},
            arr2 = {};
        console.log(profession.length);
        if($('#country-'+lang).val()!='')
            arr['nationality'] = country;
        else
            console.log('Error Country');
        if($('#profile-'+lang).val()!='')
            arr['bio'] = bio;
        else
            console.log('Error profile');
        if($('#url-'+lang).val()!='')
            arr['sourceURL'] = url;
        else
            console.log('Error Source');
        if(arr['authorName'] != '' && arr['birth'] != '' && arr['country'] != '' && arr['bio'] != ''){
            arr['aID']=aID;
            var token = generateToken();
            token.done(function(generatedToken){
                $(el).attr('disabled','disabled');
                el.innerHTML = '<div class="la-ball-fall"><div></div><div></div><div></div></div>';
                var insert_author = insert('authors_'+lang,arr,generatedToken);
                insert_author.done(function(data){
                    console.log(data);
                    var last_author = limit('authors_'+lang,'authorID','authorID',1);
                    last_author.done(function(last){
                        console.log(last);
                        arr2['authorID']=last[0][0].authorID;
                        
                        //NEW STUFF
                        var logArr={},relArr={};
                        relArr['authorID']=last[0][0].authorID;
                        var token3 = generateToken();
                        token3.done(function(generatedToke3){
                            var userAuthorRel=insertLog('dashboardUsr_Authors_'+lang,relArr,'relation');
                            userAuthorRel.done(function(res){
                                console.log('xzc');
                                console.log(res);
                                logArr['log']=' has translated an Author to Spanish. Author ID: <a class="idREL" onclick="authorsTranslation('+aID+')">'+aID+'</a>';
                                var log=insertLog('dashboard_logs',logArr,'logs');
                                log.done(function(res2){
                                    console.log('vfdv');
                                    console.log(res2);
                                });
                            });
                        });
                        //NEW STUFF
                        
                        for(var i in profession){
                            arr2['professionID']=profession[i];
                            var token2 = generateToken();
                            token2.done(function(generatedToken2){
                                var authorProfession = insert('authorProfession_'+lang,arr2,generatedToken2);
                                authorProfession.done(function(response2){
                                    $(el).removeAttr('disabled');
                                    el.innerHTML = "Saved!";
                                    console.log(response2);
                                });
                            });
                        }
                        setTimeout(function() {
                            authorsTranslation(aID);
                        }, 2000);
                    });
                });
            });
        }
    }
    
    var update_author = function(el,lang,aID,thisID){
        $(el).attr('disabled','disabled');
        el.innerHTML = "Updating";
        var birth=$('#bdate-'+lang).val(),
            country=$('#country-'+lang).val(),
            profession = $("select[name='professions-"+lang+"[]']").map(function(){if($(this).val()!='') return $(this).val();}).get(),
            bio=$('#profile-'+lang).val(),
            url=$('#url-'+lang).val(),
            arr = {},
            arr2 = {};
        if($('#bdate-'+lang).val()!='')
            arr['birth'] = birth;
        else
            console.log('Error Birthday');
        if($('#pdate-'+lang).val()!='')
            arr['died'] = $('#pdate').val();
        if($('#country-'+lang).val()!='')
            arr['nationality'] = country;
        else
            console.log('Error Country');
        if($('#profile-'+lang).val()!='')
            arr['bio'] = bio;
        else
            console.log('Error profile');
        if($('#url-'+lang).val()!='')
            arr['sourceURL'] = url;
        else
            console.log('Error Source');
        /*if($('#image').val()!=''){
            if(arr['authorName'] != '' && arr['birth'] != '' && arr['country'] != '' && arr['bio'] != ''){
                var token = generateToken();
                token.done(function(generatedToken){
                    var image = imgur_upload($('#image').prop('files')[0]);
                    image.done(function(response){
                        var url = response.data.link;
                        arr['authorImage'] = url.replace('http','https');
                        var update_author = update('authors',arr,'authorID',aID,generatedToken);
                        update_author.done(function(data){
                            if(profession.legnth > 0){
                                arr2['authorID']=aID;
                                var token2 = generateToken();
                                token2.done(function(generatedToken2){
                                    var deleteRel = delete_function('authorProfession','authorID',aID,generatedToken2);
                                    deleteRel.done(function(deleted){
                                        for(var i in profession){
                                            arr2['professionID']=profession[i];
                                            var token3 = generateToken();
                                            token3.done(function(generatedToken3){
                                                var authorProfession = insert('authorProfession',arr2,generatedToken3);
                                                authorProfession.done(function(response2){
                                                    //NEW STUFF
                                                    var logArr={};
                                                    logArr['log']=' has edited an Author in English. Author ID: <a class="idREL" onclick="authorsTranslation('+aID+')">'+aID+'</a>';
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
        }else */if(arr['birth'] != '' && arr['country'] != '' && arr['bio'] != ''){
            var token = generateToken();
            token.done(function(generatedToken){
                lang=='en' ? x='':x='_'+lang;
                lang=='en' ? idROW='authorID':idROW='aID';
                var update_author = update('authors'+x,arr,idROW,aID,generatedToken);
                update_author.done(function(data){
                    //NEW STUFF
                    switch(lang){
                        case 'es':
                            language='Spanish';
                            break;
                        case 'pt':
                            language='Portuguese';
                            break;
                        default:
                            language='English';
                    }
                    
                    var logArr={};
                    logArr['log']=' has edited an Author in '+language+'. Author ID: <a class="idREL" onclick="authorsTranslation('+aID+')">'+aID+'</a>';
                    var log=insertLog('dashboard_logs',logArr,'logs');
                    log.done(function(res2){
                        //console.log(res2);
                    });
                    //NEW STUFF
                    if(profession.length > 0){
                        arr2['authorID']=thisID;
                        var token2 = generateToken();
                        token2.done(function(generatedToken2){
                            var deleteRel = delete_function('authorProfession'+x,'authorID',thisID,generatedToken2);
                            deleteRel.done(function(deleted){
                                console.log(deleted);
                                for(var i in profession){
                                    arr2['professionID']=profession[i];
                                    var token3 = generateToken();
                                    token3.done(function(generatedToken3){
                                        var authorProfession = insert('authorProfession'+x,arr2,generatedToken3);
                                        authorProfession.done(function(response2){
                                            $(el).removeAttr('disabled');
                                            el.innerHTML = "Updated!";
                                            console.log(response2);
                                        });
                                    });
                                }
                            });
                        });
                        authorsTranslation(aID);
                    }else{
                        $(el).removeAttr('disabled');
                        el.innerHTML = "Updated!";
                        setTimeout(function() {
                            authorsTranslation(aID);
                        }, 200);
                    }
                });
            });
        }
    }
</script>