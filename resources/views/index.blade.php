<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clarifai POC</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="container">
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

    <form action="{{action('clarifaiController@imgUpload')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        
        <div class="form-group">
            <input type="hidden" id="image_data" name="image_data">
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

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>
$("#exampleInputEmail1").change(function(){
    console.log($(this).val());

    $(".img_parent").html("<img src='"+ $(this).val()+"' alt='' style='height:400px'>");
})

function fileChange(){
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
    
        $("#image_data").val(response);

    });
}
</script>
</body>
</html>