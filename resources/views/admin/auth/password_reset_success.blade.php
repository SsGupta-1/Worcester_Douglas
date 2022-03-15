
@extends('admin.layouts.admin_master_befor_login')
@section('content')
	
		<div class="login full">
			<div class="login-box float-right padding-eight-lr justify-content-start">
				<div class="login-inner pt-5 mt-4">
					<div class="welcome text-white margin-eight-tb text-center">
						<div class="size-28 font-700 mb-3">Password Updated!</div>
						<p class="font-300 mb-5"><div class="text-success ml-1">Your password have been changed successfully. Use your new password to login</div></p>
					</div>
                    
                    <div class="text-center mt-5"><a href="{{ url('admin') }}">Login</a></div></div>
					
				</div>
			</div>
		</div>
		@endsection