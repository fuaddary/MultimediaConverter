<?php

namespace App\Http\Controllers;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Http\Request;
use Validator;

class videoController extends Controller
{
    public function Index()
    {
    	return view('pages.video');
    }
    public function Convert(request $request)
    {
    	$milliseconds = round(microtime(true) * 1000); //get time in ms

    	$name= $request->video;
    	
    	$input = public_path('videos').'/'.$request->video;
		$info = pathinfo($input);
	
		// get the filename without the extension
		$video_name =  basename($input,'.'.$info['extension']);
		$new_name = $video_name.'.'.$request->video_format;

    	$output = public_path('output_video').'/'.$new_name;

    	$height = $request->height;
    	$width = $request->width;
    	$bitrate = $request->bitrate;
    	$videoChannel = $request->channel;
    	$fileFormat = $request->formatVideo;
    	$frameRate = $request->framerate;

    	$all = "ffmpeg -i ". $input
	    		." -ac ". $videoChannel
	    		." -r ". $frameRate
	    		." -s ". $width. "x". $height 
	    		." -aspect ". $width .":". $height 
	    		." -b:v ". $bitrate ."k"
	    		." -bufsize ". $bitrate ."k"
	    		." -maxrate ". $bitrate ."k"
	    		// ." -sn -f ". $fileFormat 
	    		." -y ".$output;

    	$process = new Process ($all);
    	$process->run();

    	$millisecondsend = round(microtime(true) * 1000); //get time in ms after process convert
		$hasil = (float)$millisecondsend - $milliseconds; //difference beetween get time in ms before process and git time in ms after process convert

		if (!$process->isSuccessful()) {
		    $error = new ProcessFailedException($process);
		    return response()->json([
			    'message'   => 'video failed to convert :'.$error.'.',
			    'uploaded_video' => '',
			    'class_name'  => 'alert-danger',
			    'video' => $new_name
		    ]);		
		}
		else{
			return response()->json([
		    'message'   => 'video converted Successfully in '.$hasil.' miliseconds',
		    'uploaded_video' => '<video width="100%" controls>
							  <source src="/output_video/'.$new_name.'" type="video/mp3">
							  <source src="/output_video/'.$new_name.'" type="video/ogg">
							  Your browser does not support the video tag.
							</video>
							<a href="/output_video/'.$new_name.'"> Download Output</a>',
		    'class_name'  => 'alert-success',
		    'video' => $new_name
		    ]);		
		} 
    }
    public function Uploadvideo(Request $request)
    {
	    $validation = Validator::make($request->all(), [
	    	'select_file' => 'required|max:10096'
	    ]);


	    if($validation->passes())
	    {
		    $video = $request->file('select_file');
		    $new_name = $video->getClientOriginalName();
		    $video->move(public_path('videos'), $new_name);
		    return response()->json([
		    'message'   => 'video Upload Successfully',
		    'uploaded_video' => '<video width="100%" controls>
							  <source src="/videos/'.$new_name.'" type="video/mp3">
							  <source src="/videos/'.$new_name.'" type="video/ogg">
							  Your browser does not support the video tag.
							</video>',
		    'class_name'  => 'alert-success',
		    'video' => $new_name
		    ]);
	    }
	    else
	    {
		    return response()->json([
		    'message'   => $validation->errors()->all(),
		    'uploaded_video' => '',
		    'class_name'  => 'alert-danger'
		    ]);
	    }
    }
}
