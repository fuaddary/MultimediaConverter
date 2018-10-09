<?php

namespace App\Http\Controllers;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Http\Request;

class audioController extends Controller
{
    public function Index()
    {
    	return view('pages.audio');
    }
    public function Convert(request $request)
    {
    	//dd($request);
    	//dd(public_path('output'));
    	$input = public_path('audios').'/'.$request->image;
    	$output = public_path('output_audio').'/'.$request->image;
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
		    'message'   => 'audio Upload Successfully',
		    'uploaded_audio' => '<img src="/output_audio/'.$new_name.'" class="img-thumbnail"/>',
		    'class_name'  => 'alert-success',
		    'audio' => $new_name
		    ]);		
		} 
    }
    public function Uploadaudio(Request $request)
    {
	    $audio = $request->file('select_file');
	    $new_name = rand() . '.' . $audio->getClientOriginalExtension();
	    $audio->move(public_path('audios'), $new_name);
	    return response()->json([
	    'message'   => 'audio Upload Successfully',
	    'uploaded_audio' => '<audio controls>
							  	<source src="audios/'.$new_name.'" type="audio/ogg">
							  	<source src="audios/'.$new_name.'" type="audio/mpeg">
								Your browser does not support the audio element.
							</audio>',
	    'class_name'  => 'alert-success',
	    'audio' => $new_name
	    ]);

    }
}
