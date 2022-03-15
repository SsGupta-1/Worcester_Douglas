
@php
$Total_Active_Hotels = Activehotels();
$Total_Inactive_Hotels = Inactivehotels();
$Total_Revenues = RevenueAll();
@endphp

@extends('admin.layouts.admin_master_after_login')

@section('content')
<div class="container">
	<div class="border-bottom border-xlight pb-4 mb-4 d-flex align-items-center">
		<h3 class="text font-600 my-0 py-0">Dashboard</h3>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<div class="bg-secondary px-3 pt-4 pb-3 rounded-15">
				<div class="d-flex align-items-center mb-4 pb-3">
					<img src="{{asset('assets/img/icons/1.png')}}">
					<h3 class="text-white font-700 size-34 my-0 ml-3">{{$Total_Active_Hotels}}</h3>
				</div>
				<div class="text-white size-18">Total Active Hotels</div>
			</div>
		</div>
		
		<div class="col-sm-4">
			<div class="bg-secondary px-3 pt-4 pb-3 rounded-15">
				<div class="d-flex align-items-center mb-4 pb-3">
					<img src="{{asset('assets/img/icons/2.png')}}">
					<h3 class="text-white font-700 size-34 my-0 ml-3">{{$Total_Inactive_Hotels}}</h3>
				</div>
				<div class="text-white size-18"> Total Inactive Hotels</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="bg-secondary px-3 pt-4 pb-3 rounded-15">
				<div class="d-flex align-items-center mb-4 pb-3">
					<img src="{{asset('assets/img/icons/3.png')}}">
					<h3 class="text-white font-700 size-34 my-0 ml-3">${{$Total_Revenues}}</h3>
				</div>
				<div class="text-white size-18">Total Revenue</div>
			</div>
		</div>
	</div>
	<div class="row pt-4">
		<div class="col-sm-12">
			<div class="overflow-hidden rounded-15 bg-lgray">
				<div class="bg-secondary p-3 text-white">Hotels</div>
				<div class="my-3 pl-2">
					<canvas id="hotelsChart" height="75"></canvas>
				</div>
			</div>
		</div>
	</div>
	<div class="row pt-4">
		<div class="col-sm-12">
			<div class="overflow-hidden rounded-15 bg-lgray">
				<div class="bg-secondary p-3 text-white">Revenue</div>
				<div class="my-3 pl-2">
					<canvas id="revenueChart" height="75"></canvas>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	var mothName = @php echo json_encode($monthWiseHotels['month']) @endphp;
	var dataCount = @php echo json_encode($monthWiseHotels['dataCount']) @endphp;
	var monthlyRevenue = @php echo json_encode($monthWiseRevenue['monthlyRevenue']) @endphp;
</script> 
@endsection
