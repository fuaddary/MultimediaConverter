<?php

namespace App\Http\Controllers;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Http\Request;
use Validator;

class AudioController extends Controller
{
    public function Index()
    {
    	return view('pages.audio');
    }
    public function Convert(request $request)
    {
    	$milliseconds = round(microtime(true) * 1000); //get time in ms

    	$name= $request->audio;
    	
    	$input = public_path('audios').'/'.$request->audio;
		$info = pathinfo($input);
	
		// get the filename without the extension
		$audio_name =  basename($input,'.'.$info['extension']);
		$new_name = $audio_name.'.'.$request->audio_format;

    	$output = public_path('output_audio').'/'.$new_name;

    	$bitrate = ($request->bitrate ? " -ab ".$request->bitrate : ""); //if user use bitrate to convert the audio
		$sample_rate = ($request->sample ? " -ar ".$request->sample : ""); //if user use sample_rate to convert the audio
		$channel = ($request->channel ? " -ac ".$request->channel : ""); //if user use channel (mono or stereo) to convert the audio

		$all = "ffmpeg -i ".$input.$bitrate." ".$sample_rate." ".$channel." -y ".$output;

    	$process = new Process ($all);
    	$process->run();

    	$millisecondsend = round(microtime(true) * 1000); //get time in ms after process convert
		$hasil = (float)$millisecondsend - $milliseconds; //difference beetween get time in ms before process and git time in ms after process convert

		// if($status)
		// {
		// 	return redirect(route('audio.index'))->with('error', 'Gagal Convert audio');		
		// }
		if (!$process->isSuccessful()) {
		    $error = new ProcessFailedException($process);
		    return response()->json([
			    'message'   => 'audio failed to convert :'.$error.'.',
			    'uploaded_audio' => '',
			    'class_name'  => 'alert-danger',
			    'audio' => $new_name
		    ]);		
		}
		else{
			return response()->json([
		    'message'   => 'audio converted Successfully in '.$hasil.' miliseconds',
		    'uploaded_audio' => '<audio width="100%" controls>
							  <source src="/output_audio/'.$new_name.'" type="audio/mp3">
							  <source src="/output_audio/'.$new_name.'" type="audio/ogg">

							  Your browser does not support the audio tag.
							</audio>
							<a href="/output_audio/'.$new_name.'"> Download Output</a>
							',
		    'class_name'  => 'alert-success',
		    'audio' => $new_name
		    ]);		
		} 
    }
    public function Uploadaudio(Request $request)
    {
	    $validation = Validator::make($request->all(), [
	    	'select_file' => 'required|max:10096'
	    ]);


	    if($validation->passes())
	    {
		    $audio = $request->file('select_file');
		    $new_name = $audio->getClientOriginalName();
		    $audio->move(public_path('audios'), $new_name);
		    return response()->json([
		    'message'   => 'audio Upload Successfully',
		    'uploaded_audio' => '<audio width="100%" controls>
							  <source src="/audios/'.$new_name.'" type="audio/mp3">
							  <source src="/audios/'.$new_name.'" type="audio/ogg">
							  Your browser does not support the audio tag.
							</audio>',
		    'class_name'  => 'alert-success',
		    'audio' => $new_name
		    ]);
	    }
	    else
	    {
		    return response()->json([
		    'message'   => $validation->errors()->all(),
		    'uploaded_audio' => '',
		    'class_name'  => 'alert-danger'
		    ]);
	    }
    }
}
