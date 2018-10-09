<?php

namespace App\Http\Controllers;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function Index()
    {
    	return view('pages.image');
    }
    public function Convert(request $request)
    {
    	$name= $request->image;
    	
    	$input = public_path('images').'/'.$request->image;
    	$output = public_path('output_image').'/'.$request->image;
    	$resize = ' -resize '.$request->width.'x'.$request->height;
    	$quality = ' -quality '.$request->rate;
    	$color = ' -colorspace '.$request->color;
    	$depth = ' -colorspace '.$request->depth;
    	$all = 'convert '.$input.$resize.$color.$depth.$quality.' '.$output;
    	//dd($all);
    	$process = new Process ($all);
    	$process->run();
    	$new_name = $request->image;

		// if($status)
		// {
		// 	return redirect(route('image.index'))->with('error', 'Gagal Convert Image');		
		// }
		if (!$process->isSuccessful()) {
		    throw new ProcessFailedException($process);
		}
		else{
			return response()->json([
		    'message'   => 'Image Upload Successfully',
		    'uploaded_image' => '<img src="/output_image/'.$new_name.'" class="img-thumbnail"/>',
		    'class_name'  => 'alert-success',
		    'image' => $new_name
		    ]);		
		} 
    }
    public function UploadImage(Request $request)
    {
	    // $validation = Validator::make($request->all(), [
	    // 	'select_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
	    // ]);
    	// dd('ok');

	    // if($validation->passes())
	    // {
		    $image = $request->file('select_file');
		    $new_name = $image->getClientOriginalName();
		    $image->move(public_path('images'), $new_name);
		    return response()->json([
		    'message'   => 'Image Upload Successfully',
		    'uploaded_image' => '<img src="/images/'.$new_name.'" class="img-thumbnail"/>',
		    'class_name'  => 'alert-success',
		    'image' => $new_name
		    ]);
	    // }
	    // else
	    // {
		   //  return response()->json([
		   //  'message'   => $validation->errors()->all(),
		   //  'uploaded_image' => '',
		   //  'class_name'  => 'alert-danger'
		   //  ]);
	    // }
    }
}
