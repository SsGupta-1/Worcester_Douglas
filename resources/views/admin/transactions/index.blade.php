@extends('admin.layouts.admin_master_after_login')

@section('content')
<div class="wrapper full bg-ldark">
	<div class="container">
		<div class="border-bottom border-xlight pb-4 mb-4 d-flex align-items-center">
			<h3 class="text-light font-600 my-0 py-0">Transaction History</h3>
			<div class="d-inline-flex ml-auto">
				<form  id="CsvformSubmit" class="d-flex" method="POST" action="{{url('admin/transaction-history/download')}}">
					@csrf
					<div>
						<select name="priceType" class="form-control h-45 selectpicker default arrow" id="select_duration">
						    <option value="0" selected>All</option>
							<option value="1">Weekly</option>
							<option value="2">Monthly</option>
							<option value="3">Annually</option>
						</select>
					</div> 
				</form>	
				<div class="px-3"><input class="form-control gray rounded-10 border-0 text-white h-45" id="search" type="search" placeholder="Search"></div>
				
				<button type="button" onclick="submitform();" class="btn bg-green border-0 text-white rounded-10 px-4 h-45 d-inline-flex align-items-center">
					<img src="{{asset('assets/img/icons/download-w.svg')}}" height="20" class="mr-2"> Export
				</button>
				
			</div>
		</div>
		<div class="row pt-4">
			<div class="col-sm-12">
				<div class="table-responsive dataTableSearch" >
					<table class="table theme-default table-borderless" id="insert_data">
						<thead>
							<tr>
								<th class="py-3">Hotel Name</th>
								<th class="py-3">Date</th>
								<th class="py-3">Time</th>
								<th class="py-3">Transaction ID</th>
								<th class="py-3">Amount</th>
							</tr>
						</thead>
						<tbody >
							@foreach ($subscription  as $value)
								<tr>
									<td>{{$value->hotel_name}}</td>
									<td>{{date('d-m-Y', strtotime($value->created_at))}}</td>
									<td>{{date('H:i:s A', strtotime($value->created_at))}}</td>
									<td>{{$value->transection_id}}</td>
									<td>{{!empty($value->amount) ? '$'.$value->amount : ''}}</td>
								</tr>
							@endforeach 	
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
	<script>
		$(document).ready(function() {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$('#select_duration').on('change',function(){
				list();

			});
			$(window).on('load', function(){
				list();

			});
			$('#search').focusout(function() {
				list();
		    });
						
		});

		function list(){
			var value = $('#select_duration').val();
				$.ajax({
					url: "{{url('admin/transaction-history/list')}}",
					type: 'POST',
					data:{value:value},
					success:function(response) {
						$("#insert_data tbody").html(response);
					}
					
				});
		}

		

		function submitform(){
		 $('#CsvformSubmit').submit();	 
			 		
		};



			
	</script>

@endsection

