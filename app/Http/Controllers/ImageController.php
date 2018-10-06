<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function Index()
    {
    	return view('pages.image');
    }
    public function Convert()
    {
    	
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
		    $new_name = rand() . '.' . $image->getClientOriginalExtension();
		    $image->move(public_path('images'), $new_name);
		    return response()->json([
		    'message'   => 'Image Upload Successfully',
		    'uploaded_image' => '<img src="/images/'.$new_name.'" class="img-thumbnail"/>',
		    'class_name'  => 'alert-success'
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
