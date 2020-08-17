<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Clarifai\API\ClarifaiClient;
use Clarifai\DTOs\Inputs\ClarifaiURLImage;
use Clarifai\DTOs\Outputs\ClarifaiOutput;
use Clarifai\DTOs\Predictions\Concept;
use Clarifai\DTOs\Searches\SearchBy;
use Clarifai\DTOs\Searches\SearchInputsResult;
use Clarifai\DTOs\Models\ModelType;

class clarifaiController extends Controller
{

    public function index(){
        return view("index", ['name' => 'James']);
    }

    function imagecreatefromfile( $filename ) {
        // if (!file_exists($filename)) {
        //     throw new InvalidArgumentException('File "'.$filename.'" not found.');
        // }
        $var = strtolower( array_pop( explode('.', substr($filename, 0, strpos($filename, '?')))
    
    ));
        dd($var);

        switch ( $var ) {
            case 'jpeg':
            case 'jpg':
                return imagecreatefromjpeg($filename);
            break;
    
            case 'png':
                return imagecreatefrompng($filename);
            break;
    
            case 'gif':
                return imagecreatefromgif($filename);
            break;
    
            default:
                throw new InvalidArgumentException('File "'.$filename.'" is not valid jpg, png or gif image.');
            break;
        }
    }

    public function getCroppedBoxArray($imageurl, $data){

        $images = [];
        $image_size = getimagesize ($imageurl);
        $width = $image_size[0];
        $height = $image_size[1];

        foreach ($data as $key => $value) {

            $x_one = $width * $value["bounding_box"]->left_col;
            $x_two = $width * $value["bounding_box"]->right_col;
            $rect_width = $x_two - $x_one;

            $y_one = $height * $value["bounding_box"]->top_row;
            $y_two = $height * $value["bounding_box"]->bottom_row;
            $rect_height = $y_two - $y_one;

            $gd_image = imagecreatefromstring(file_get_contents($imageurl));

            $croppedImg = imagecrop($gd_image, ['x' => $x_one, 'y' => $y_one, 'width' => $rect_width, 'height' => $rect_height]);

            // header('Content-Type: image/png');
            // ob_start();
            imagepng($croppedImg,  public_path()."/images/".$value["product"].".png");

            // $imagedata = ob_get_clean();
            // dd();

            array_push($images, $value["product"].".png");
            
        }

        return $images;
    }

    public function apparelDetection(){
        
        $ch = curl_init();
        $imgurl = 'https://scontent.fdac31-1.fna.fbcdn.net/v/t1.0-9/117244889_3817065401643690_8295446081903188797_n.jpg?_nc_cat=111&_nc_sid=8024bb&_nc_ohc=UjJQB_0Zv7IAX-fFThz&_nc_ht=scontent.fdac31-1.fna&oh=c9ea50d23b395e20fabe1ec9fdc2f2cb&oe=5F5AEA56';

        $data = '
        {
            "inputs": [
              {
                "data": {
                  "image": {
                    "url": "'.$imgurl.'"
                  }
                }
              }
            ]
        }';

        curl_setopt($ch, CURLOPT_URL,"https://api.clarifai.com/v2/models/72c523807f93e18b431676fb9a58e6ad/outputs");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Key c37baaad5dce485abbabe363cf133a31',
            'Content-Type: application/json'
        ));
        // In real life you should use something like:
        // curl_setopt($ch, CURLOPT_POSTFIELDS, 
        //          http_build_query(array('postvar1' => 'value1')));

        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        // dd(json_decode($server_output));
        
        $response = json_decode($server_output);

        $regions = $response->outputs[0]->data->regions;
        $data = [];
        foreach($regions as $region){

            $bounding_box = $region->region_info->bounding_box;
            $product = [
                "bounding_box" => $bounding_box,
                "product" => $region->data->concepts[0]->name
            ];

            array_push($data, $product);

        }

        // dd($data);

        $imageBoundingBoX =  $this->getCroppedBoxArray($imgurl, $data);
        // dd($imageBoundingBoX);
        // foreach ($imageBoundingBoX as $key => $value) {
            
        //     print '<p><img src="data:image/png;base64,'.base64_encode($value).'" alt="image 1" width="96" height="48"/></p>';
        // }
        curl_close ($ch);

        return view("images", ['images' => $imageBoundingBoX, "search_img" => $imgurl]);
    }
    //
    public function testClarifai(){

        $imgURL = 'https://scontent.fdac31-1.fna.fbcdn.net/v/t1.0-9/117244889_3817065401643690_8295446081903188797_n.jpg?_nc_cat=111&_nc_sid=8024bb&_nc_ohc=UjJQB_0Zv7IAX-fFThz&_nc_ht=scontent.fdac31-1.fna&oh=c9ea50d23b395e20fabe1ec9fdc2f2cb&oe=5F5AEA56';
        $client = new ClarifaiClient('c37baaad5dce485abbabe363cf133a31');

        // $model = $client;
        // dd($model);
        // $input = new ClarifaiURLImage();

        // $response = $model->predict($input)
        // ->executeSync();

        // $outputs = $response->get();
        // print_r($outputs);
        // dd($response);
        // foreach ($outputs as $output) {
        //     /** @var ClarifaiURLImage $image */
        //     $image = $output->input();
        //     echo "Predicted concepts for image at url " . $image->url() . "\n";
            
        //     /** @var Concept $concept */
        //     foreach ($output->data() as $concept) {
        //         echo $concept->name() . ': ' . $concept->value() . "\n";
        //     }
        //     echo "\n";
        // }

  
        // print_r( gd_info());
        // dd( );

        $image_size = getimagesize ($imgURL);
        
        $width = $image_size[0];
        $height = $image_size[1];

    }


    public function visual_search(Request $request){


        $imageurl = $request->input('imageurl');

        // dd($imageurl);
        $client = new ClarifaiClient('c37baaad5dce485abbabe363cf133a31');


        $response = $client->searchInputs(
            SearchBy::urlImageVisually($imageurl))
        ->executeSync();

        if ($response->isSuccessful()) {
            // echo "Response is successful.\n";
        
            /** @var SearchInputsResult $result */
            $result = $response->get();
            // dd($result);
            // foreach ($result->searchHits() as $searchHit) {
            //     $result_array[] = $searchHit->input() $searchHit->
            // }
        } else {
            echo "Response is not successful. Reason: \n";
            echo $response->status()->description() . "\n";
            echo $response->status()->errorDetails() . "\n";
            echo "Status code: " . $response->status()->statusCode();
        }

        return view("products", ['result' => $result, 'search_img' => $imageurl]);
    }

}