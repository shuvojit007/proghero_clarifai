<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clarifai POC</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
/* Center the loader */
#loader {
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 150px;
  height: 150px;
  margin: -75px 0 0 -75px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Add animation to "page content" */
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
}

@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:1 }
}

@keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:1 }
}


</style>
</head>
<body>
<div id="loader" style="display:none"></div>

<div class="container" id="main_form" style="display:block">
    <br>
    <br>
    <br>
    <br>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <label for="exampleInputEmail1">Upload Image</label>
    <input type="file" id="input_img" onchange="fileChange()" accept="image/*">

    <form action="{{action('clarifaiController@imgUpload')}}" method="post" id="form_img" enctype="multipart/form-data">
        {{csrf_field()}}
        
        <div class="form-group">
            
            <input type="hidden" id="image_url" name="imageurl">
            <!-- <input type="text" name="imageurl" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Provide your Image URL"> -->
            <!-- <input type="file" name="input_img" id="product_img"> -->
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>

    </form>

    <br>
    <br>
    <br>
    <div class="img_parent">
        <!-- <h6>Your Image will appear here</h6> -->
        
    </div>
</div>

<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>
$("#exampleInputEmail1").change(function(){
    console.log($(this).val());

    $(".img_parent").html("<img src='"+ $(this).val()+"' alt='' style='height:400px'>");
})

function fileChange(){
    document.getElementById("loader").style.display = "block";
    document.getElementById("main_form").style.display = "none";

    var file = document.getElementById('input_img');
    var form = new FormData();
    form.append("image", file.files[0])

    var settings = {
        "url": "https://api.imgbb.com/1/upload?key=28f24262f25a666786758692a7ff70a0",
        "method": "POST",
        "timeout": 0,
        "processData": false,
        "mimeType": "multipart/form-data",
        "contentType": false,
        "data": form
    };


    $.ajax(settings).done(function (response) {
        console.log(response);
        var jx = JSON.parse(response);
        console.log(jx.data.url);

        $("#image_url").val(response);
        $("#form_img").submit()
    });


}
</script>
</body>
</html>