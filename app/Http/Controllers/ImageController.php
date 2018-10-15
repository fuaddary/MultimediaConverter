<?php

namespace App\Http\Controllers;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Http\Request;
use Validator;

class ImageController extends Controller
{
    public function Index()
    {
    	return view('pages.image');
    }
    public function Convert(request $request)
    {
    	$milliseconds = round(microtime(true) * 1000); //get time in ms

    	$name= $request->image;
    	
    	$input = public_path('images').'/'.$request->image;
		$info = pathinfo($input);
	
		// get the filename without the extension
		$image_name =  basename($input,'.'.$info['extension']);
		$new_name = $image_name.'.'.$request->image_format;

    	$output = public_path('output_image').'/'.$new_name;

    	$resize = ' -resize '.$request->width.'x'.$request->height;
    	$quality = ' -quality '.$request->rate;
    	$color = ' -colorspace '.$request->color;
    	$depth = ' -depth '.$request->depth;

    	// return response()->json([
    	// 	'uploaded_image' => '<p'.$input.$resize.$color.$depth.$quality.' '.$output.'/>'
    	// ]);

    	$all = 'convert '.$input.$resize.$color.$depth.$quality.' '.$output;
    	//dd($all);

    	$process = new Process ($all);
    	$process->run();

    	$millisecondsend = round(microtime(true) * 1000); //get time in ms after process convert
		$hasil = (float)$millisecondsend - $milliseconds; //difference beetween get time in ms before process and git time in ms after process convert


	    $info = "exiv2 ".$output;
	    $process2 = new Process($info);
		$process2->run();
		$output = $process2->getOutput();
		$target = "File size";
		$pos = strpos($output, $target);
		$final = substr($output, $pos);

		if (!$process->isSuccessful()) {
		    $error = new ProcessFailedException($process);
		    return response()->json([
			    'message'   => 'Image failed to convert'.$error.'.',
			    'uploaded_image' => '',
			    'class_name'  => 'alert-danger',
			    'image' => $new_name
		    ]);		
		}
		else{
			return response()->json([
		    'message'   => 'Image converted Successfully in '.$hasil.' miliseconds <br>'.$final,
		    'uploaded_image' => '<img src="/output_image/'.$new_name.'" class="img-thumbnail"/>',
		    'class_name'  => 'alert-success',
		    'image' => $new_name
		    ]);	
		} 
    }
    public function UploadImage(Request $request)
    {
	    $validation = Validator::make($request->all(), [
	    	'select_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:10096'
	    ]);


	    if($validation->passes())
	    {
		    $image = $request->file('select_file');
		    $new_name = $image->getClientOriginalName();
		    $image->move(public_path('images'), $new_name);
		    $input = public_path('images').'/'.$new_name;

		    $info = "exiv2 ".$input;
		    $process2 = new Process($info);
			$process2->run();
			$output = $process2->getOutput();
			$target = "File size";
			$pos = strpos($output, $target);
			$final = substr($output, $pos);

		    return response()->json([
		    'message'   => 'Image Upload Successfully <br> '.$final,
		    'uploaded_image' => '<img src="/images/'.$new_name.'" class="img-thumbnail"/>',
		    'class_name'  => 'alert-success',
		    'image' => $new_name
		    ]);
	    }
	    else
	    {
		    return response()->json([
		    'message'   => $validation->errors()->all(),
		    'uploaded_image' => '',
		    'class_name'  => 'alert-danger'
		    ]);
	    }
    }
}
