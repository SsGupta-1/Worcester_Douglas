

{{-- @include('admin.includes.head')
	<style>footer {display: none}</style>
	<div class="flex"> --}}
		@extends('admin.layouts.admin_master_befor_login')
		@section('content')
		<div class="login full">
			<div class="login-box float-right justify-content-start">
				<div class="login-inner pt-5 mt-4 flex-fill padding-eight-lr mx-5">
					<div class="px-4">
						<div class="welcome text-white margin-eight-tb text-center">
							<div class="size-28 font-700 mb-3">Forgot Password?</div>
							<p class="font-300 mb-5">Enter OTP Sent To Email Address {{ Session::get('session_email') }}</p>
						</div>
						<form action="" method="POST">
							@csrf
							<div class="form-inner px-1 pt-2">
								<div class="form-group row otp-input">
									<input type="text" name="otp[]" class="form-control border border-gray rounded-12 px-1 text-center size-22 col mx-2">
									<input type="text" name="otp[]" class="form-control border border-gray rounded-12 px-1 text-center size-22 col mx-2">
									<input type="text" name="otp[]" class="form-control border border-gray rounded-12 px-1 text-center size-22 col mx-2">
									<input type="text" name="otp[]" class="form-control border border-gray rounded-12 px-1 text-center size-22 col mx-2">
									<input type="text" name="otp[]" class="form-control border border-gray rounded-12 px-1 text-center size-22 col mx-2">
									<input type="text" name="otp[]" class="form-control border border-gray rounded-12 px-1 text-center size-22 col mx-2">
                                    <input type="hidden" name="email" id="email" value="{{ Session::get('session_email') }}">
									@error('otp')
                                    <div style="color: red">{{ $message }}</div>
                                	@enderror
								</div>
								<div class="text-center mt-5 pt-3">
									<button type="submit" class="btn btn-gradient btn-lg min btn-block rounded-12 h-50">Verify OTP</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="footer">OTP Not Received? <a href="{{ url('admin/resend-otp') }}" class="text-success ml-1">Resend OTP</a></div>
			</div>
		</div>
		@endsection
	{{-- </div> --}}
    {{-- @include('admin.includes.footer') --}}