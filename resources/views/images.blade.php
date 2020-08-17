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
    
    <div class="row text-center">
    
        <div class="col-sm text-center" >
        <h6>Searched Image</h6>
        <br>    
            <img src="{{$search_img}}" alt="" class="img-thumbnail rounded" style="height: 350px;">
        </div>
    </div>

    <br>
    <br>
    <br>
    
    <div class="row text-center">
    
        <div class="col-sm">
        <h6>Matching Results.</h6>
        <br>    

            @foreach($images as $img)
                <!-- <a href=""> -->
                    <img src="{{asset('images/'.$img)}}" alt="" class="img-thumbnail rounded float-left" style="margin: 10px;height: 200px;padding: 10px;">
                <!-- </a> -->
            @endforeach
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>

</script>
</body>
</html>