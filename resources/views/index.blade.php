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
    <form action="{{action('clarifaiController@visual_search')}}" method="post">
        {{csrf_field()}}
        <div class="form-group">
            <label for="exampleInputEmail1">Image URL</label>
            <input type="text" name="imageurl" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Provide your Image URL">
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

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>
$("#exampleInputEmail1").change(function(){
    console.log($(this).val());

    $(".img_parent").html("<img src='"+ $(this).val()+"' alt='' style='height:400px'>");
})
</script>
</body>
</html>