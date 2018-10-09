<?php

namespace App\Http\Controllers;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function Index()
    {
    	return view('pages.video');
    }
    public function Convert(request $request)
    {

    	$input = public_path('videos').'/'.$request->image;
    	$output = public_path('output_video').'/'.$request->image;
    	$resize = '-resize '.$request->width.'x'.$request->height;
    	$all = 'convert '.$input.' '.$resize.' '.$output;
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
		    'message'   => 'Video Upload Successfully',
		    'uploaded_video' => '<img src="/output_video/'.$new_name.'" class="img-thumbnail"/>',
		    'class_name'  => 'alert-success',
		    'video' => $new_name
		    ]);		
		} 
    }
    public function UploadVideo(Request $request)
    {
	    $video = $request->file('select_file');
	    $new_name = rand() . '.' . $video->getClientOriginalExtension();
	    $video->move(public_path('videos'), $new_name);
	    return response()->json([
	    'message'   => 'video Upload Successfully',
	    'uploaded_video' => '<video width="100%" controls>
							  <source src="/videos/'.$new_name.'" type="video/mp4">
							  <source src="/videos/'.$new_name.'" type="video/ogg">
							  Your browser does not support the video tag.
							</video>',
	    'class_name'  => 'alert-success',
	    'video' => $new_name
	    ]);

    }
}
