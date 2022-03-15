
@extends('admin.layouts.admin_master_befor_login')
		@section('content')
		<div class="login full">
			<div class="login-box float-right padding-eight-lr justify-content-start">
				<div class="login-inner pt-5 mt-4">
					<div class="welcome text-white margin-eight-tb text-center">
						<div class="size-28 font-700 mb-3">Forgot Password?</div>
						<p class="font-300 mb-5">Enter The Registered Email Address</p>
					</div>
					<form action="" method="post">
						@csrf
						<div class="form-inner px-1 pt-2">
							<div class="form-group">
								<label class="text-white size-14 font-300 mb-1">Email</label>
								<input type="text" name="email" placeholder="" class="form-control border border-gray bg-transparent rounded-12 font-300">
							
							</div>
							<div class="text-center mt-5 pt-3">
								<button type="submit" class="btn btn-gradient btn-lg min btn-block rounded-12 h-50">Request OTP</button>
							</div>
							<div class="text-center mt-5"><a href="{{url('admin/login')}}" class="text-white">
                                Login</a></div>
						</div>
					</form>
				</div>
			</div>
		</div>
		@endsection