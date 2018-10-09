@extends('layouts.main')

@section('title')
    Multimedia Converter
@endsection

@section('custom-css')
<style type="text/css">
	input[type="file"] {
	    display: none;
	}

  audio{
    width: 100%;
  }
</style>
@endsection

@section('contents')
			
<div class="row">
	<div class="col-xl-4">
		<div class="block block-themed">
            <div class="block-header bg-danger">
                <h3 class="block-title">Upload audio</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                        <i class="si si-refresh"></i>
                    </button>
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                </div>
            </div>
        </div>

	
		<form method="post" id="upload_form" enctype="multipart/form-data">
			{{ csrf_field() }}
    		<div class="form-group" align="center">
    			<label id="bb" class="btn btn-primary my-0 col-8"><span id="uploaded_name">Enter audio File</span>
				<input type="file" name="select_file" id="select_file" />
				</label>
		        <input type="submit" name="upload" id="upload" class="btn btn-primary" value="Upload">
			</div>
		</form>

		<span id="uploaded_audio"></span>
		<span id="output_audio"></span>

	</div>

    <div class="col-xl-8">
        <!-- Bootstrap Contact -->
        <div class="block block-themed">
            <div class="block-header bg-danger">
                <h3 class="block-title">Audio Converter</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                        <i class="si si-refresh"></i>
                    </button>
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                </div>
            </div>
            <div class="block-content">
                <form id="convert_form" action="{{ route('audio.convert') }}" method="post">
                	{{ csrf_field() }}
                    <div class="form-group row">
                    	<div class="col-12">
                            <label for="contact1-firstname">Audio Format</label>
                            <select class="form-control" id="audio_format" name="audio_format" size="1">
                                <option value="mp3" >mp3</option>
                                <option value="flac" >flac</option>
                                <option value="ac3" >ac3</option>
                                <option value="aiff" >aiff</option>
                                <option value="ogg"  >ogg</option> 
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label for="bitrate">Bitrate</label>
                            <select class="form-control" id="bitrate" name="bitrate" size="1">
                                <option disabled selected value><b>Choose Bitrate</b></option>
                                <option value="56">56k</option>
                                <option value="96">96k</option>
                                <option value="128">128k</option>
                                <option value="160">160k</option>
                                <option value="192">192k</option>
                                <option value="320">320k</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label for="Sample">Sample Rate</label>
                            <select class="form-control" id="Sample" name="Sample" size="1">
                                <option selected value><b>Choose Sample Rate</b></option>
                                <option value="8000" >8000</option>
                                <option value="11025" >11025</option>
                                <option value="16000" >16000</option>
                                <option value="22050" >22050</option>
                                <option value="32000" >32000</option>
                                <option value="37800" >37800</option>
                                <option value="44056" >44056</option>
                                <option value="44100" >44100</option>
                            </select>
                        </div>
                    </div>                    
                    <div class="form-group row">
                        <label class="col-12" for="channel">Audio Channel</label>
                        <div class="col-12">
                            <select class="form-control" id="channel" name="channel" size="1">
                                <option disabled selected value><b>Choose audio channel</b></option>
                                <option value="mono">Mono</option>
                                <option value="stereo">Stereo</option>
                            </select>
                        </div>
                    </div>
                    <input id="audio_name" name="audio" type="hidden" value="">
                    <div class="form-group row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-danger bg-danger col-12">
                                <i class="fa fa-recycle mr-5"></i> Convert Now !
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END Bootstrap Contact -->
    </div>

</div>
                    
@endsection

@section('custom-js')

<script>
$(document).ready(function(){

 $('#upload_form').on('submit', function(event){
  event.preventDefault();
  $.ajax({
   url:"{{ route('audio.uploads') }}",
   method:"POST",
   data:new FormData(this),
   dataType:'JSON',
   contentType: false,
   cache: false,
   processData: false,
       beforeSend:function(){
     $('#uploaded_audio').html("<label class='text-success'>audio Uploading...</label>");
    },  
   success:function(data)
   {
    $('#message').css('display', 'block');
    $('#message').html(data.message);
    $('#message').addClass(data.class_name);
    $('#uploaded_audio').html(data.uploaded_audio);
    document.getElementById('audio_name').value = data.audio;
    $('#uploaded_name').html(data.audio);
   }
  })
 });

  $('#convert_form').on('submit', function(event){
  event.preventDefault();
  $.ajax({
   url:"{{ route('audio.convert') }}",
   method:"POST",
   data:new FormData(this),
   dataType:'JSON',
   contentType: false,
   cache: false,
   processData: false,
       beforeSend:function(){
     $('#output_audio').html("<label class='text-success'>Converting...</label>");
    },  
   success:function(data)
   {
   	console.log(data);
    $('#message2').css('display', 'block');
    $('#message2').html(data.message);
    $('#message2').addClass(data.class_name);
    $('#output_audio').html(data.uploaded_audio);
    document.getElementById('audio_name').value = data.audio;
    $('#output_name').html(data.audio);
   }
  })
 });

});
</script>


@endsection