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
            <div class="block-header bg-corporate">
                <h3 class="block-title">Upload Image</h3>
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
    			<label id="bb" class="btn btn-primary my-0 col-8"> Enter Your File
				<input type="file" name="select_file" id="select_file" />
				</label>
		        <input type="submit" name="upload" id="upload" class="btn btn-primary" value="Upload">
			</div>
		</form>

		<span id="uploaded_image"></span>

	</div>

    <div class="col-xl-8">
        <!-- Bootstrap Contact -->
        <div class="block block-themed">
            <div class="block-header bg-corporate">
                <h3 class="block-title">Image Converter</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                        <i class="si si-refresh"></i>
                    </button>
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                </div>
            </div>
            <div class="block-content">
                <form action="{{ route('image.convert') }}" method="post" onsubmit="return false;">
                    <div class="form-group row">
                    	<div class="col-12">
                            <label for="contact1-firstname">Image Format</label>
                            <select class="form-control" id="image_format" name="image_format" size="1">
					            <option value="jpg">.jpg</option>
					            <option value="bmp">.bmp</option>
					            <option value="tiff">.tiff</option>
				                <option value="png">.png</option>
				                <option value="ppm">.ppm</option>
				                <option value="apng">.apng</option>
				                <option value="dpx">.dpx</option>
				                <option value="pam">.pam</option>
				                <option value="pbm">.pbm</option>
				                <option value="pcx">.pcx</option>
				                <option value="pgm">.pgm</option>
				                <option value="xbm">.xbm</option>
				                <option value="xface">.xface</option>
				                <option value="xwd">.xwd</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="contact1-firstname">Height</label>
                            <input type="text" class="form-control" id="contact1-firstname" name="contact1-firstname" placeholder="Enter your firstname..">
                        </div>
                        <div class="col-6">
                            <label for="contact1-lastname">Width</label>
                            <input type="text" class="form-control" id="contact1-lastname" name="contact1-lastname" placeholder="Enter your lastname..">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="contact1-firstname">Depth</label>
                            <input type="text" class="form-control" id="contact1-firstname" name="contact1-firstname" placeholder="Enter your firstname..">
                        </div>
                        <div class="col-6">
                            <label for="contact1-lastname">Conversion Rate</label>
                            <input type="text" class="form-control" id="contact1-lastname" name="contact1-lastname" placeholder="Enter your lastname..">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12" for="contact1-subject">Colorspace</label>
                        <div class="col-12">
                            <select class="form-control" id="contact1-subject" name="contact1-subject" size="1">
                                <option value="rgb">RGB</option>
                                <option value="grayscale">Grayscale</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary bg-corporate col-12">
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
   url:"{{ route('image.uploads') }}",
   method:"POST",
   data:new FormData(this),
   dataType:'JSON',
   contentType: false,
   cache: false,
   processData: false,
       beforeSend:function(){
     $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");
    },  
   success:function(data)
   {
   	$('#uploaded_image').html(data);
    $('#message').css('display', 'block');
    $('#message').html(data.message);
    $('#message').addClass(data.class_name);
    $('#uploaded_image').html(data.uploaded_image);

   }
  })
 });

});
</script>


@endsection