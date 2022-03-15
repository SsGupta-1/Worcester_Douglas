@extends('admin.layouts.admin_master_after_login')

@section('content')
<div class="wrapper full bg-ldark"> 
	<div class="container">
		<h3 class="text-light font-600 border-bottom border-xlight pb-4 mb-4">Price Settings</h3>
		<form action="{{ url('admin/setting/update') }}"  method="POST">
			@csrf
		<div class="row">
			<div class="col-sm-12 text-light size-14">Weekly</div>
			<input type="hidden" name="price_type[]" value="1">
			<div class="col-sm-4 my-3">
				<input type="hidden" name="weekId[]" value="{{$priceSettings[0]->id}}">
				<div class="p-3 bg-dark-2 rounded-15">
					<div class="d-flex text-nowrap price-box text-white">
						<div class="col flex-fill px-0">
							<label class="text-light size-14 position-rekative">Ranges</label>
							<div class="border box rounded-lg-left bg-lgray px-4 d-flex align-items-center size-14">{{$priceSettings[0]->rang}}</div>
							<input name="rangWeek[]" type="hidden" class="border form-control flex-fill bg-transparent rounded-lg-left size-14" value="{{$priceSettings[0]->rang}}" >
						</div>
						<div class="col flex-fill px-0">
							<label class="text-light size-14 mr-4 pr-2">Price Per Extension</label>
							<div class="d-flex box">
								<div class="bg-green px-3 size-22 font-600 text-white d-flex align-items-center">$</div>
								<input name="priceExtensionWeek[]" class="border form-control flex-fill bg-transparent text-white rounded-lg-right size-14" value="{{$priceSettings[0]->price_extension}}" onkeypress="return /[0-9\.]/i.test(event.key)" autocomplete="off">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-4 my-3">
				<div class="p-3 bg-dark-2 rounded-15">
					<div class="d-flex text-nowrap price-box text-white">
						<input type="hidden" name="weekId[]" value="{{$priceSettings[1]->id}}">
						<div class="col flex-fill px-0">
							<label class="text-light size-14 position-rekative">Ranges</label>
							<div class="border box rounded-lg-left bg-lgray px-4 d-flex align-items-center size-14">{{$priceSettings[1]->rang}}</div>
							<input name="rangWeek[]" type="hidden" class="border form-control flex-fill bg-transparent rounded-lg-left size-14" value="{{$priceSettings[1]->rang}}">
						</div>
						<div class="col flex-fill px-0">
							<label class="text-light size-14 mr-4 pr-2">Price Per Extension</label>
							<div class="d-flex box">
								<div class="bg-green px-3 size-22 font-600 text-white d-flex align-items-center">$</div>
								<input name="priceExtensionWeek[]" class="border form-control flex-fill bg-transparent text-white rounded-lg-right size-14" value="{{$priceSettings[1]->price_extension}}" onkeypress="return /[0-9\.]/i.test(event.key)" autocomplete="off">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-4 my-3">
				<div class="p-3 bg-dark-2 rounded-15">
					<div class="d-flex text-nowrap price-box text-white">
						<input type="hidden" name="weekId[]" value="{{$priceSettings[2]->id}}">
						<div class="col flex-fill px-0">
							<label class="text-light size-14 position-rekative">Ranges</label>
							<div class="border box rounded-lg-left bg-lgray px-4 d-flex align-items-center size-14">{{$priceSettings[2]->rang}}</div>
							<input name="rangWeek[]" type="hidden" class="border form-control flex-fill bg-transparent rounded-lg-left size-14" value="{{$priceSettings[2]->rang}}">
						</div>
						<div class="col flex-fill px-0">
							<label class="text-light size-14 mr-4 pr-2">Price Per Extension</label>
							<div class="d-flex box">
								<div class="bg-green px-3 size-22 font-600 text-white d-flex align-items-center">$</div>
								<input name="priceExtensionWeek[]" class="border form-control flex-fill bg-transparent text-white rounded-lg-right size-14" value="{{$priceSettings[2]->price_extension}}" onkeypress="return /[0-9\.]/i.test(event.key)" autocomplete="off">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 text-light size-14">Monthly</div>
			<input type="hidden" name="price_type[]" value="2">
			<div class="col-sm-4 my-3">
				<input type="hidden" name="monthId[]" value="{{$priceSettings[3]->id}}">
				<div class="p-3 bg-dark-2 rounded-15">
					<div class="d-flex text-nowrap price-box text-white">
						<div class="col flex-fill px-0">
							<label class="text-light size-14 position-rekative">Ranges</label>
							<div class="border box rounded-lg-left bg-lgray px-4 d-flex align-items-center size-14">{{$priceSettings[3]->rang}}</div>
							<input name="rangMonth[]" type="hidden" class="border form-control flex-fill bg-transparent rounded-lg-left size-14" value="{{$priceSettings[3]->rang}}">
						</div>
						<div class="col flex-fill px-0">
							<label class="text-light size-14 mr-4 pr-2">Price Per Extension</label>
							<div class="d-flex box">
								<div class="bg-green px-3 size-22 font-600 text-white d-flex align-items-center">$</div>
								<input name="priceExtensionMonth[]" class="border form-control flex-fill bg-transparent text-white rounded-lg-right size-14" value="{{$priceSettings[3]->price_extension}}" onkeypress="return /[0-9\.]/i.test(event.key)" autocomplete="off">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-4 my-3">
				<div class="p-3 bg-dark-2 rounded-15">
					<div class="d-flex text-nowrap price-box text-white">
						<input type="hidden" name="monthId[]" value="{{$priceSettings[4]->id}}">
						<div class="col flex-fill px-0">
							<label class="text-light size-14 position-rekative">Ranges</label>
							<div class="border box rounded-lg-left bg-lgray px-4 d-flex align-items-center size-14">{{$priceSettings[4]->rang}}</div>
							<input name="rangMonth[]" type="hidden" class="border form-control flex-fill bg-transparent rounded-lg-left size-14" value="{{$priceSettings[4]->rang}}" >
						</div>
						<div class="col flex-fill px-0">
							<label class="text-light size-14 mr-4 pr-2">Price Per Extension</label>
							<div class="d-flex box">
								<div class="bg-green px-3 size-22 font-600 text-white d-flex align-items-center">$</div>
								<input name="priceExtensionMonth[]" class="border form-control flex-fill bg-transparent text-white rounded-lg-right size-14" value="{{$priceSettings[4]->price_extension}}" onkeypress="return /[0-9\.]/i.test(event.key)" autocomplete="off">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-4 my-3">
				<div class="p-3 bg-dark-2 rounded-15">
					<div class="d-flex text-nowrap price-box text-white">
						<input type="hidden" name="monthId[]" value="{{$priceSettings[5]->id}}">
						<div class="col flex-fill px-0">
							<label class="text-light size-14 position-rekative">Ranges</label>
							<div class="border box rounded-lg-left bg-lgray px-4 d-flex align-items-center size-14">{{$priceSettings[5]->rang}}</div>
							<input name="rangMonth[]" type="hidden" class="border form-control flex-fill bg-transparent rounded-lg-left size-14" value="{{$priceSettings[5]->rang}}" >
						</div>
						<div class="col flex-fill px-0">
							<label class="text-light size-14 mr-4 pr-2">Price Per Extension</label>
							<div class="d-flex box">
								<div class="bg-green px-3 size-22 font-600 text-white d-flex align-items-center">$</div> 
								<input name="priceExtensionMonth[]" class="border form-control flex-fill bg-transparent text-white rounded-lg-right size-14" value="{{$priceSettings[5]->price_extension}}" onkeypress="return /[0-9\.]/i.test(event.key)" autocomplete="off">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 text-light size-14">Annually</div>
			<input type="hidden" name="price_type[]" value="3">
			<div class="col-sm-4 my-3">
				<div class="p-3 bg-dark-2 rounded-15">
					<div class="d-flex text-nowrap price-box text-white">
						<input type="hidden" name="annualId[]" value="{{$priceSettings[6]->id}}">
						<div class="col flex-fill px-0">
							<label class="text-light size-14 position-rekative">Ranges</label>
							<div class="border box rounded-lg-left bg-lgray px-4 d-flex align-items-center size-14">{{$priceSettings[6]->rang}}</div>
							<input name="rangAnnual[]" type="hidden" class="border form-control flex-fill bg-transparent rounded-lg-left size-14" value="{{$priceSettings[6]->rang}}">
						</div>
						<div class="col flex-fill px-0">
							<label class="text-light size-14 mr-4 pr-2">Price Per Extension</label>
							<div class="d-flex box">
								<div class="bg-green px-3 size-22 font-600 text-white d-flex align-items-center">$</div>
								<input name="priceExtensionAnnual[]" class="border form-control flex-fill bg-transparent text-white rounded-lg-right size-14" value="{{$priceSettings[6]->price_extension}}" onkeypress="return /[0-9\.]/i.test(event.key)" autocomplete="off">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-4 my-3">
				<div class="p-3 bg-dark-2 rounded-15">
					<div class="d-flex text-nowrap price-box text-white">
						<input type="hidden" name="annualId[]" value="{{$priceSettings[7]->id}}">
						<div class="col flex-fill px-0">
							<label class="text-light size-14 position-rekative">Ranges</label>
							<div class="border box rounded-lg-left bg-lgray px-4 d-flex align-items-center size-14">{{$priceSettings[7]->rang}}</div>
							<input name="rangAnnual[]" type="hidden" class="border form-control flex-fill bg-transparent rounded-lg-left size-14" value="{{$priceSettings[7]->rang}}">
						</div>
						<div class="col flex-fill px-0">
							<label class="text-light size-14 mr-4 pr-2">Price Per Extension</label>
							<div class="d-flex box">
								<div class="bg-green px-3 size-22 font-600 text-white d-flex align-items-center">$</div>
								<input name="priceExtensionAnnual[]" class="border form-control flex-fill bg-transparent text-white rounded-lg-right size-14" value="{{$priceSettings[7]->price_extension}}" onkeypress="return /[0-9\.]/i.test(event.key)" autocomplete="off">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-4 my-3">
				<div class="p-3 bg-dark-2 rounded-15">
					<div class="d-flex text-nowrap price-box text-white">
						<input type="hidden" name="annualId[]" value="{{$priceSettings[8]->id}}">
						<div class="col flex-fill px-0">
							<label class="text-light size-14 position-rekative">Ranges</label>
							<div class="border box rounded-lg-left bg-lgray px-4 d-flex align-items-center size-14">{{$priceSettings[8]->rang}}</div>
							<input name="rangAnnual[]" type="hidden" class="border form-control flex-fill bg-transparent rounded-lg-left size-14" value="{{$priceSettings[8]->rang}}">
						</div>
						<div class="col flex-fill px-0">
							<label class="text-light size-14 mr-4 pr-2">Price Per Extension</label>
							<div class="d-flex box">
								<div class="bg-green px-3 size-22 font-600 text-white d-flex align-items-center">$</div>
								<input name="priceExtensionAnnual[]" class="border form-control flex-fill bg-transparent text-white rounded-lg-right size-14" value="{{$priceSettings[8]->price_extension}}" onkeypress="return /[0-9\.]/i.test(event.key)" autocomplete="off">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 mt-4 mb-4 pb-2">
				<button class="btn btn-gradient btn-lg w-175" id="update_setting" type="button" data-toggle="modal" data-target="#deactivateModal">Update</button>
			</div>
		</div>
		</form>
	</div>
</div>
{{-- Modal --}}
<div class="modal fade" id="deactivateModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content bg-black rounded-20">
		<div class="modal-body text-center py-5">
		  <h3 class="text-white px-4 font-300">Are you sure you want to Update Price?</h3>
		  <div class="text-center mt-5">
			  <button type="button" class="btn btn-secondary border-0 rounded-15 btn-lg w-150 py-3 mx-3" data-dismiss="modal">No</button>
			  <button type="button" onclick="updatePop()" class="btn btn-gradient border-0 rounded-15 btn-lg w-150 py-3 mx-3">Yes</button>
		  </div>
		</div>
	  </div>
	</div>
</div>
@endsection


<script>
	function updatePop() {
		$('#update_setting').attr('type', 'submit');
		$('#update_setting').trigger('click');
	}
</script>