@extends('admin.layouts.admin_master_after_login')

@section('content')
<div class="wrapper full bg-ldark"> 
	<div class="container">
		<h3 class="text-light font-600 border-bottom border-xlight pb-4 mb-4">Manage Tutorial</h3>
		<form action="{{ url('admin/manage-tutorial/add') }}"  method="POST" enctype="multipart/form-data">
			@csrf
			<div class="text-light size-14 mb-3">Screen 1</div>
			<input type="hidden" name="screen[]" value="1">
			<input type="hidden" name="id[]" value="{{ isset($tutorial_1) ? $tutorial_1->id : '' }}">
			<input type="hidden" name="oldFile[]" value="{{ isset($tutorial_1) ?  $tutorial_1->file : '' }}">
			
			<div class="row mx-0 mb-3">
				<div class="upload-drag md">
					<img src="{{asset('assets/img/icons/upload.svg')}}" height="38">
					<label class="btn mt-2 mb-0">Upload Photo, Video</label>
					<input type="file" name="file[]" accept="image/*,video/*" id="upload_file" onchange="getImagePreview(event,'preview')">
				</div>
				<div class="image-md rounded-12 mx-3 position-relative" id="preview">
					
					@if (isset($tutorial_1) && !empty($tutorial_1->file))
						@if($tutorial_1->mimeType == 'video')
							<video  controls class="img "> 
								<source src="{{asset('file/admin/tutorial').'/'.$tutorial_1->file }}" type="video/mp4">
								<source src="{{asset('file/admin/tutorial').'/'.$tutorial_1->file }}" type="video/ogg">
								Your browser does not support this video.
							</video>
						@else							
							<img src="{{asset('file/admin/tutorial').'/'.$tutorial_1->file }}" class="img">
						@endif
						<div class="delete-circle bottom" role="button"> <a href="javascript:void(0)" onclick="myFunction({{$tutorial_1->id}})"> <img src="{{asset('assets/img/icons/trash.svg')}}" height="15"> </a></div>

					@else
						<img src="{{asset('assets/img/dummy.jpg')}}" class="img">
					@endif
				</div>
				<textarea name="caption[]" class="col form-control bg-dark-2  text-white border-0 rounded-12 py-3 resize-none" placeholder="Caption">{!! isset($tutorial_1) ? $tutorial_1->caption : ''!!}</textarea>
			</div>
			<div class="text-light size-14 mb-3">Screen 2</div>
			<input type="hidden" name="screen[]" value="2">
			<input type="hidden" name="id[]" value="{{ isset($tutorial_2) ? $tutorial_2->id :'' }}">
			<input type="hidden" name="oldFile[]" value="{{isset($tutorial_2) ? $tutorial_2->file : ''}}">
			<div class="row mx-0 mb-3">
				<div class="upload-drag md">
					<img src="{{asset('assets/img/icons/upload.svg')}}" height="38">
					<label class="btn mt-2 mb-0">Upload Photo, Video</label>
					<input type="file" name="file[]" accept="image/*,video/*" id="upload_file" onchange="getImagePreview(event,'preview1')">
				</div>
				
				<div class="image-md rounded-12 mx-3 position-relative" id="preview1">
					@if (isset($tutorial_2) && !empty($tutorial_2->file))
						@if($tutorial_2->mimeType == 'video')
							<video  controls class="img"> 
								<source src="{{asset('file/admin/tutorial').'/'.$tutorial_2->file }}" type="video/mp4">
								<source src="{{asset('file/admin/tutorial').'/'.$tutorial_2->file }}" type="video/ogg">
								Your browser does not support this video.
							</video>
						@else
							<img src="{{asset('file/admin/tutorial').'/'.$tutorial_2->file }}" class="img">
						@endif
						<div class="delete-circle bottom" role="button"><a href="javascript:void(0)" onclick="myFunction({{$tutorial_2->id}})"> <img src="{{asset('assets/img/icons/trash.svg')}}" height="15"></a></div>

					@else
						<img src="{{asset('assets/img/dummy.jpg')}}" class="img">
					@endif
				</div>
				<textarea name="caption[]" class="col form-control bg-dark-2 border-0 text-white rounded-12 py-3 resize-none" placeholder="Caption">{!! isset($tutorial_2) ? $tutorial_2->caption : ''!!}</textarea>
			</div>
			<div class="row">
				<div class="col-sm-12 mt-4 mb-4 pb-2">
					<button class="btn btn-gradient btn-lg w-175" id="addbutton" type="button" data-toggle="modal" data-target="#deactivateModal">Upload</button>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="modal fade" id="deactivateModal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content bg-black rounded-20">
<div class="modal-body text-center py-5">
<h3 class="text-white px-4 font-300">Are you sure you want to upload?</h3>
<div class="text-center mt-5">
	<button type="button" class="btn btn-secondary border-0 rounded-15 btn-lg w-150 py-3 mx-3" data-dismiss="modal">No</button>
	<button type="button" onclick="updatePop()" class="btn btn-gradient border-0 rounded-15 btn-lg w-150 py-3 mx-3">Yes</button>
</div>
</div>
</div>
</div>
</div>
<div class="modal fade" id="deleteModal1" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-black rounded-20">
	<form  action="{{url('admin/manage-tutorial/delete')}}" method="post">
            @csrf
			<input type="hidden" name="id" id="delete_id">
      <div class="modal-body text-center py-5">
        <h3 class="text-white px-4 font-300">Are you sure you want to Delete?</h3>
		<div class="text-center mt-5">
			<button type="button" class="btn btn-secondary border-0 rounded-15 btn-lg w-150 py-3 mx-3" data-dismiss="modal">No</button>
		
         <button type="submit"  class="btn btn-gradient border-0 rounded-15 btn-lg w-150 py-3 mx-3">Yes</button>
		</div>
      </div>
    </form>
    </div>
  </div>
</div> 
@endsection

<script>
	function getImagePreview(event,priviewid)
	{	
		var files = event.target.files;
		var fileName = files[0].type;	
		var image=URL.createObjectURL(event.target.files[0]);
		var imagediv= document.getElementById(priviewid);
		if(fileName.includes("image")== true){			
			var newimg=document.createElement('img');					
		}else{
			var newimg=document.createElement('video');	
			newimg.autoplay = false;
			newimg.controls = true;
			newimg.muted = false;	
		}
		
		newimg.classList.add('img');
		imagediv.innerHTML='';
		newimg.src=image;
		imagediv.appendChild(newimg);
	}
	
	function updatePop() {
		$('#addbutton').attr('type', 'submit');
		$('#addbutton').trigger('click');
	}

	function myFunction(id){
        $('#delete_id').val(id);
        $('#deleteModal1').modal('show');
    }
	  
</script>
