@extends('layouts.main')

@section('title')
    Multimedia Converter
@endsection

@section('custom-css')
<style type="text/css">
	input[type="file"] {
	    display: none;
	}
</style>
@endsection

@section('contents')
			
<div class="row">
	<div class="col-xl-4">
		<div class="block block-themed">
            <div class="block-header bg-elegance">
                <h3 class="block-title">Upload Video</h3>
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
    			<label id="bb" class="btn btn-primary my-0 col-8"><span id="uploaded_name">Enter Video File</span>
				<input type="file" name="select_file" id="select_file" />
				</label>
		        <input type="submit" name="upload" id="upload" class="btn btn-primary" value="Upload">
			</div>
		</form>

    <span id="uploaded_video"></span>
		<span id="message"></span>
		<span id="output_video"></span>
    <span id="message2"></span>

	</div>

    <div class="col-xl-8">
        <!-- Bootstrap Contact -->
        <div class="block block-themed">
            <div class="block-header bg-elegance">
                <h3 class="block-title">Video Converter</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                        <i class="si si-refresh"></i>
                    </button>
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                </div>
            </div>
            <div class="block-content">
                <form id="convert_form" action="{{ route('video.convert') }}" method="post">
                	{{ csrf_field() }}
                    <div class="form-group row">
                    	<div class="col-12">
                            <label for="contact1-firstname">Video Format</label>
                            <select class="form-control" id="video_format" name="video_format" size="1">
                                <option value="mp4">MP4</option>
                                <option value="avi">AVI</option>
                                <option value="webm">WEBM</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="height">Height</label>
                            <input type="text" class="form-control" id="height" name="height" placeholder="Enter height..">
                        </div>
                        <div class="col-6">
                            <label for="width">Width</label>
                            <input type="text" class="form-control" id="width" name="width" placeholder="Enter width..">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="bitrate">Bitrate</label>
                            <select class="form-control" id="bitrate" name="bitrate" size="1">
                                <option disabled selected value><b>Choose bitrate</b></option>
                                <option value="56">56k</option>
                                <option value="96">96k</option>
                                <option value="128">128k</option>
                                <option value="160">160k</option>
                                <option value="192">192k</option>
                                <option value="320">320k</option>
                            </select>
                        </div>

                        <div class="col-6">
                            <label class="col-12" for="channel">Audio Channel</label>
                            <select class="form-control" id="channel" name="channel" size="1">
                                <option disabled selected value><b>Choose audio channel</b></option>
                                <option value="1">Mono</option>
                                <option value="2">Stereo</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12" for="framerate">Framerate</label>
                        <div class="col-12">
                            <select class="form-control" id="framerate" name="framerate" size="1">
                                <option disabled selected value><b>Choose framerate</b></option>
                                <option value="25">25</option>
                                <option value="30">30</option>
                                <option value="60">60</option>
                            </select>
                        </div>
                    </div>
                    <input id="video_name" name="video" type="hidden" value="">
                    <div class="form-group row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-danger bg-elegance col-12">
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
   url:"{{ route('video.uploads') }}",
   method:"POST",
   data:new FormData(this),
   dataType:'JSON',
   contentType: false,
   cache: false,
   processData: false,
       beforeSend:function(){
     $('#uploaded_video').html("<label class='text-success'>video Uploading...</label>");
    },  
   success:function(data)
   {
    $('#message').css('display', 'block');
    $('#message').html(data.message);
    $('#message').addClass(data.class_name);
    $('#uploaded_video').html(data.uploaded_video);
    document.getElementById('video_name').value = data.video;
    $('#uploaded_name').html(data.video);
   }
  })
 });

  $('#convert_form').on('submit', function(event){
  event.preventDefault();
  $.ajax({
   url:"{{ route('video.convert') }}",
   method:"POST",
   data:new FormData(this),
   dataType:'JSON',
   contentType: false,
   cache: false,
   processData: false,
       beforeSend:function(){
     $('#output_video').html("<label class='text-success'>Converting...</label>");
    },  
   success:function(data)
   {
   	console.log(data);
    $('#message2').css('display', 'block');
    $('#message2').html(data.message);
    $('#message2').addClass(data.class_name);
    $('#output_video').html(data.uploaded_video);
    document.getElementById('video_name').value = data.video;
    $('#output_name').html(data.video);
   }
  })
 });

});
</script>


@endsection