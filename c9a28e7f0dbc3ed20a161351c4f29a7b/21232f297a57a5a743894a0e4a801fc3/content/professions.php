<?php
    session_start();
    require_once('../Classes/AppController.php');
    $obj = new AppController();
    $professions = $obj->all('professions ORDER BY professionName ASC');
    if(empty($_POST['dataARR'])){
        $professions = $obj->all('professions ORDER BY professionName ASC');
    }else{
        $professions=$_POST['dataARR'];
    }
?>

<div class="portlet-heading">
    <h3 class="portlet-title text-dark text-uppercase">
        Professions
    </h3>
    <div class="clearfix"></div>
    <?php if(isset($_SESSION['label']) && !empty($_SESSION['label']) && $_SESSION['label'] =='root'){ ?>
        <div class="col-lg-12 text-dark"><span id="add-quote" onclick="openWindow(this);clearFields()"><span class="glyphicon glyphicon-edit"></span> Add a new profession</span></div>
    <?php } ?>
</div>
<?php if(isset($_SESSION['label']) && !empty($_SESSION['label']) && $_SESSION['label'] =='root'){ ?>
<div class="container quote-form" id="quote-form">
    <div class="row">
        <div class="col-xs-12 relative-container">
            <label onclick="closeWindow();clearFields()"><span class="glyphicon glyphicon-remove"></span> Hide</label>
        </div>
        <div class="form-group col-xs-12">
		<span class="error">Profession already exists</span>
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-education"></i></span>
                <input type="text" class="form-control" id="profession" data-error="Field required" aria-describedby="author" placeholder="Enter profession..."  oninput="checkAvailability(this)">
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-education"></i></span>
                <input type="text" class="form-control" id="profession-es" data-error="Field required" aria-describedby="author" placeholder="Enter profession in spanish...">
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-education"></i></span>
                <input type="text" class="form-control" id="profession-pt" data-error="Field required" aria-describedby="author" placeholder="Enter profession in portuguese...">
            </div>
        </div>
        <div class="form-group col-xs-12">
            <div class="input-group">
                <button type="button" class="btn btn-primary" onclick="save(this)" id="save">Save</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<div class="container">
    <div class="row profession-list" id="row" style="display:inline;">
        <ul class="list-unstyled">
        <?php
            foreach($professions as $key=>$val){
        ?>
        
            <li class="data"><span class="glyphicon glyphicon-remove-sign" onclick="deleteThis(this,<?php echo $professions[$key]['professionID'].",'".$professions[$key]['professionName']."'"; ?>)"></span> <span onclick="openUpdate(<?php echo $professions[$key]['professionID']; ?>)"><?php echo $professions[$key]['professionName']; ?></span></li>
        <?php
            }
        ?>
        </ul>
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
</div>

<!--<button class="btn btn-primary" onclick="publish()">Submit all Authors to Facebook</button> -->
<script src="js/pagination.js?<?php echo time(); ?>"></script>
<script>
  /*  var count = <?php echo count($professions); ?>;
    
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
    }*/

    /*Pagination*/
    
    var clearFields=function(){
        $('#profession').val('');
    }
    
    var openUpdate = function(profID){
        var professions = find_by('professions','professionID',profID);
        professions.done(function(data){
            if(Object.keys(data[0][0]).length >= 1){
                $('html, body').animate({ scrollTop: 0 }, 'fast');
                $('#profession').focus();
                $('#save').attr('onclick','updateProfession(this,'+profID+')');
                document.getElementById('save').innerHTML="Update";                
                $('#quote-form').show(500);
                $('#profession').val(data[0][0].professionName);
                var professions_es = find_by('professions_es','pID',profID);
                var professions_pt = find_by('professions_pt','pID',profID);
                professions_es.done(function(rEs){
                    if(Object.keys(rEs[0][0]).length >= 1){
                        $('#profession-es').val(rEs[0][0].professionName);
                    }
                });
                professions_pt.done(function(rPT){
                    if(rPT[0].length >= 1){
                        $('#profession-pt').val(rPT[0][0].professionName);
                    }
                });
            }
        });
    }
    
    var updateProfession = function(el, professionID){
        var profession = $('#profession').val(),
            profession_es = $('#profession-es').val(),
            profession_pt = $('#profession-pt').val(),
            arr = {},
            arr_es = {},
            arr_pt = {},
            errors=[];
        if($('#profession').val()!='')
            arr['professionName'] = profession;
        else
            errors.push('Profession field cannot be blank!');
       if(errors.length < 1){
           $(el).attr('disabled','disabled');
           el.innerHTML = "Updating";
           var token = generateToken();
           token.done(function(generatedToken){
               var update_profession = update('professions',arr,'professionID',professionID,generatedToken);
               update_profession.done(function(data){
                   $(el).removeAttr('disabled');
                   el.innerHTML = "Updated!";
                   professionsLoad('#profession-op');
               });
               var p_es = find_by('professions_es','pID',professionID),
                   p_pt = find_by('professions_pt','pID',professionID);
                p_es.done(function(rEs){
                    if($('#profession-es').val()!='')
                        arr_es['professionName'] = profession_es;
                    if(Object.keys(rEs[0][0]).length >= 1){
                        var token2 = generateToken();
                        token2.done(function(generatedToken2){
                            var update_profession_es = update('professions_es',arr_es,'pID',professionID,generatedToken2);
                            update_profession_es.done(function(data1){
                                console.log('Bien!');
                            });
                        });
                    }else{
                        var token2 = generateToken();
                        token2.done(function(generatedToken2){
                            var insert_profession = insert('professions_es',arr_es,generatedToken2);
                            insert_profession.done(function(){});
                        });
                    }
                });
               p_pt.done(function(rPT){
                    if($('#profession-pt').val()!='')
                        arr_pt['professionName'] = profession_pt;
                    if(rPT[0].length >= 1){
                        var token3 = generateToken();
                        token3.done(function(generatedToken3){
                            var update_profession_pt = update('professions_pt',arr_pt,'pID',professionID,generatedToken3);
                            update_profession_pt.done(function(data1){
                                console.log('Good!');
                            });
                        });
                    }else{
                        var token3 = generateToken();
                        token3.done(function(generatedToken3){
                            arr_pt['pID'] = professionID;
                            var insert_profession_pt = insert('professions_pt',arr_pt,generatedToken3);
                            insert_profession_pt.done(function(r_pt){console.log(r_pt);});
                        });
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
    
    var save = function(el){
        var profession = $('#profession').val(),
            arr = {},
            arr_es = {},
            arr_pt = {},
            errors=[];
        if($('#profession').val()!='')
            arr['professionName'] = profession;
        else
            errors.push('Profession field cannot be blank!');
        if(errors.length < 1){
            var token = generateToken();
            token.done(function(generatedToken){
                $(el).attr('disabled','disabled');
                el.innerHTML = "Saving";
                var insert_profession = insert('professions',arr,generatedToken);
                insert_profession.done(function(data){
                    var professions = find_by('professions','professionName',profession);
                    professions.done(function(response){
                        if($('#profession-pt').val()!=''){
                            arr_pt['professionName'] = $('#profession-pt').val();
                            arr_pt['pID'] = response[0][0].professionID;
                            var token2 = generateToken();
                            token2.done(function(generatedToken2){
                                var insert_profession_pt = insert('professions_pt',arr_pt,generatedToken2);
                                insert_profession_pt.done(function(r_pt){console.log(r_pt);});
                            });
                        }
                        if($('#profession-es').val()!=''){
                            arr_es['professionName'] = $('#profession-es').val();
                            arr_es['pID'] = response[0][0].professionID;
                            var token3 = generateToken();
                            token3.done(function(generatedToken3){
                                var insert_profession_es = insert('professions_es',arr_es,generatedToken3);
                                insert_profession_es.done(function(r_es){console.log(r_es);});
                            });
                        }
                    });                    
                    $(el).removeAttr('disabled');
                    el.innerHTML = "Updated!";
                    professionsLoad('#profession-op');
                });
            });
        }else{
          var error='';
           for(var e in errors)
               error+='-'+errors[e]+'\n';
           alert(error);
       }
    }
    
    var checkAvailability = function(el){
        var checked=find_by('professions','professionName',el.value);
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
                var deleted = delete_function('professions','professionID',id,generatedToken);
                deleted.done(function(response){
                    swal("Deleted!", name+" has been deleted.", "success");
                    $(el).parent().remove();
                });
            });     
        });
    }
    
    document.onkeydown = function(e){
        if(e.keyCode == 13){
            var text=document.getElementById('search').value;
            if(text!=''){
                $('#quotes-area').css('visibility','hidden');
                $('.portlet .loader').css('display','block');
                var searching=search('professions','professionName',text,'professionID','search');
                searching.done(function(data){
                    setTimeout(function() {
                        $('.portlet .loader').css('display','none');
                        $('#quotes-area').css('visibility','visible');
                        professionsLoad('#profession-op',data);
                    }, 2000);
                });
            }else{
                professionsLoad('#profession-op');
            }
        }
    }
</script>