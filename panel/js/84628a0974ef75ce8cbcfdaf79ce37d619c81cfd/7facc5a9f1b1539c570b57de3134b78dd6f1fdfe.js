//CHANGE BANNER AND PROFILE PICTURE

var toImgur = function(file){
    var formData = new FormData();
    formData.append("image", file);
    return $.ajax({
        url: "https://api.imgur.com/3/image",
        type: "POST",
        datatype: "json",
        headers: {
            "Authorization": "Client-ID 4571ccbf369395f",
            Accept: 'application/json'
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

var updateImg = function(col,val){
    var formData = new FormData();
    formData.append("col", col);
    formData.append("val", val);
    formData.append("action", 'update');
    return $.ajax({
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType:  false,
        data: formData,
        url: '/c9dcc9a0e463aca2d9575c58a5e23fb9b12d9fa2/4a72dc8ceda3f3885da0aba3a857aa19abcef5bc',
        async:false
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

function crop(el,attr) {
      var $cropper = el,
          $dataX = $("#dataX"),
          $dataY = $("#dataY"),
          $dataHeight = $("#dataHeight"),
          $dataWidth = $("#dataWidth"),
          $dataRotate = $("#dataRotate"),
          console = window.console || {log:$.noop},
          cropper;

      $cropper.cropper("setCropBoxData", { width: "1024", height: "300" },{
       // aspectRatio: 16 / 9,
        data: {
          x: 420,
          y: 50,
          width: 300,
          height: 300,
        },
        //preview: ".preview",

        // autoCrop: false,
        // dragCrop: false,
        // modal: false,
        // moveable: false,
        // resizeable: false,
        // scalable: false,

        // maxWidth: 480,
        // maxHeight: 270,
        // minWidth: 160,
        // minHeight: 90,

        done: function(data) {
          $dataX.val(data.x);
          $dataY.val(data.y);
          $dataHeight.val(data.height);
          $dataWidth.val(data.width);
          $dataRotate.val(data.rotate);
        },
        build: function(e) {
          console.log(e.type);
        },
        built: function(e) {
          console.log(e.type);
        },
        dragstart: function(e) {
          console.log(e.type);
        },
        dragmove: function(e) {
          console.log(e.type);
        },
        dragend: function(e) {
          console.log(e.type);
        }
      });

      cropper = $cropper.data("cropper");

      $cropper.on({
        "build.cropper": function(e) {
          console.log(e.type);
          // e.preventDefault();
        },
        "built.cropper": function(e) {
          console.log(e.type);
          // e.preventDefault();
        },
        "dragstart.cropper": function(e) {
          console.log(e.type);
          // e.preventDefault();
        },
        "dragmove.cropper": function(e) {
          console.log(e.type);
          // e.preventDefault();
        },
        "dragend.cropper": function(e) {
          console.log(e.type);
          // e.preventDefault();
        }
      });
    
      $("#get_img").click(function() {
          var croppedImg = $cropper.cropper('getCroppedCanvas',{width:300,height:300});
          $('.cropped-image').attr('src',croppedImg.toDataURL('image/jpeg'));
          var file = dataURLtoFile(croppedImg.toDataURL('image/jpeg'),'file.jpg');
          swal({
              title: "Update image",
              text: "Are you sure you want to change set this image?",
              type: "info",
              showCancelButton: true,
              closeOnConfirm: false,
              showLoaderOnConfirm: true
          },
               function(isConfirm){
              if (isConfirm) {
                  var uplImg=toImgur(file);
                  uplImg.done(function(response){
                      var url=response.data.link.replace('http','https');
                      console.log(url);
                      var update=updateImg(attr,url);
                      update.done(function(data){
                          if(data){
                              document.getElementById('picture').style.backgroundImage = "url('"+croppedImg.toDataURL('image/jpeg')+"')";
                              $('.img-circle ').css('background-image','url('+croppedImg.toDataURL('image/jpeg')+')');
                              swal("Image updated correctly!");
                              $('#imgChange').modal('hide');
                          }else{
                              swal("Error", "There's been an error, try again later!", "error");
                          }
                      });
                  });
              } else {
                  //swal("Cancelled", "Your imaginary file is safe :)", "error");
              }
          });
      });
    $("#get_img_banner").click(function() {
          var croppedImg = $cropper.cropper('getCroppedCanvas',{width:1024,height:300});
          $('.cropped-image').attr('src',croppedImg.toDataURL('image/jpeg'));
          var file = dataURLtoFile(croppedImg.toDataURL('image/jpeg'),'file.jpg');
          swal({
              title: "Update image",
              text: "Are you sure you want to change set this image?",
              type: "info",
              showCancelButton: true,
              closeOnConfirm: false,
              showLoaderOnConfirm: true
          },
               function(isConfirm){
              if (isConfirm) {
                  var uplImg=toImgur(file);
                  uplImg.done(function(response){
                      var url=response.data.link.replace('http','https');
                      console.log(url);
                      var update=updateImg(attr,url);
                      update.done(function(data){
                          if(data){
                              document.getElementById('banner-pic').style.backgroundImage = "url('"+croppedImg.toDataURL('image/jpeg')+"')";
                              //$('.img-circle ').css('background-image','url('+croppedImg.toDataURL('image/jpeg')+')');
                              swal("Image updated correctly!");
                              $('#bannerChange').modal('hide');
                          }else{
                              swal("Error", "There's been an error, try again later!", "error");
                          }
                      });
                  });
              } else {
                  //swal("Cancelled", "Your imaginary file is safe :)", "error");
              }
          });
      });
}



function uploadToCrop(el,attr,cropperClass,preview){
  var imageUrl = URL.createObjectURL(el.files[0]),
      myImage = new Image();
    document.getElementById(preview).src=imageUrl;
    $('.'+cropperClass).cropper('destroy');
    crop($('.'+cropperClass),attr);
}

$(".default-profile").click(function(){
    var url=this.src;
    swal({
              title: "Update image",
              text: "Are you sure you want to set this image?",
              type: "info",
              showCancelButton: true,
              closeOnConfirm: false
          },
               function(isConfirm){
              if (isConfirm) {
                      var update=updateImg('picture',url);
                      update.done(function(data){
                          if(data){
                              document.getElementById('picture').style.backgroundImage = "url('"+url+"')";
                              $('.img-circle ').css('background-image','url('+url+')');
                              swal("Image updated correctly!");
                              $('#imgChange').modal('hide');
                          }else{
                              swal("Error", "There's been an error, try again later!", "error");
                          }
                      });
              } else {
                  //swal("Cancelled", "Your imaginary file is safe :)", "error");
              }
          });
});

$(".default-banner").click(function(){
    var url=this.src;
    swal({
              title: "Update image",
              text: "Are you sure you want to set this image?",
              type: "info",
              showCancelButton: true,
              closeOnConfirm: false
          },
               function(isConfirm){
              if (isConfirm) {
                      var update=updateImg('banner',url);
                      update.done(function(data){
                          if(data){
                              document.getElementById('banner-pic').style.backgroundImage = "url('"+url+"')";
                              swal("Image updated correctly!");
                              $('#bannerChange').modal('hide');
                          }else{
                              swal("Error", "There's been an error, try again later!", "error");
                          }
                      });
              } else {
                  //swal("Cancelled", "Your imaginary file is safe :)", "error");
              }
          });
});