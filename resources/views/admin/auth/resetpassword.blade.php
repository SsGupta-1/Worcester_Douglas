@extends('admin.layouts.admin_master_befor_login')
@section('content')
	
		<div class="login full">
			<div class="login-box float-right padding-eight-lr justify-content-start pt-5">
				<div class="login-inner mt-3">
					<div class="welcome text-white margin-eight-tb text-center">
						<div class="size-26 text-uppercase font-600 mb-3">Create New Password</div>
						<p class="font-300 mb-5">Please Enter NEw Password</p>
					</div>
					<form action="" method="POST" >
						@csrf
						<input type="hidden" name="email" id="email" value="{{Session::get('session_email')}}">
						<input type="hidden" name="user_id" id="user_id" value="{{Session::get('user_id')}}">
						<div class="form-inner px-1">
							<div class="form-group">
								<label class="text-white size-14 font-300 mb-1">Password</label>
								<div class="password-field">
									<input type="password" name="new_password" class="form-control border border-gray bg-transparent rounded-12 font-300">
									<i class="showPassword"></i>
								</div>
							</div>
							<div class="form-group">
								<label class="text-white size-14 font-300 mb-1">Confirm Password</label>
								<div class="password-field">
									<input type="password" name="confirm_password" class="form-control border border-gray bg-transparent rounded-12 font-300">
									<i class="showPassword"></i>
								</div>
							</div>
							<div class="text-center action margin-50px-top md-margin-20px-top">
								<button type="submit" class="btn btn-gradient btn-lg min btn-block rounded-12 h-50">Update Password</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		@endsection