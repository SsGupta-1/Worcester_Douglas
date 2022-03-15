@extends('admin.layouts.main')

@section('content')
<div class="wrapper full bg-ldark"> 
	<div class="container">
		<div class="border-bottom mb-4 d-flex justify-content-between">
		<h3 class="text-light font-600 mb-0">Manage Hotel</h3>
		<div class="manage-hotel-wrap mb-3">
				<input class="form-control gray rounded-10 border-0 text-white h-45" id="search" type="search" placeholder="Search">
			</div>
	</div>
		<div class="row pt-4">
			<div class="col-sm-12">
				<div class="table-responsive dataTableSearch">
					<table class="table theme-default table-borderless dataTable" id="searchData">
						<thead>
							<tr>
								<th class="py-3">Hotel Name</th>
								<th class="py-3">Contacts</th>
								<th class="py-3">Billing Contacts</th>
								<th width="23%" class="py-3">Address</th>
								<th class="py-3">Status</th>
								<th class="py-3 text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($details as $data)
							<tr>
								<td>{{$data->hotel_name}}</td>
								<td>{{$data->mobile}}</td>
								<td>{{$data->email}}</td>
								<td>{{strlen($data->address) > 58 ? substr($data->address,0,58)."..." : $data->address}}</td>
								<td>
									@if($data->is_active == 1)
									<span class="badge bg-green px-3 py-2 w-80">Active</span>
									@else 
									<span class="badge bg-red px-3 py-2 w-80">InActive</span>
									@endif
									</td>
								<td>
									<div class="action text-center">
										<a href="{{url('admin/manage-hotel/view',$data->id)}}" class="mx-2">
											<img src="{{asset('assets/img/icons/eye.svg')}}" alt="view" height="15">
										</a>
										<a href="javascript:void(0)" onclick="myFunction({{$data->id}})">
										<img src="{{asset('assets/img/icons/trash.svg')}}" alt="delete" height="20">
										</a>
									</div>
								</td>
							</tr>	
							@endforeach							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-black rounded-20">
	<form  action="{{url('admin/manage-hotel/delete')}}" method="post">
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

@section('script')
 <script>
	 function myFunction(id){
        $('#delete_id').val(id);
        $('#deleteModal').modal('show');
    }
	  


 </script>

 <style>
	 .manage-hotel-wrap input {
	width: 300px;
}
.manage-hotel-wrap {
	display: flex;
	justify-content: end;
}
 </style>

@endsection


