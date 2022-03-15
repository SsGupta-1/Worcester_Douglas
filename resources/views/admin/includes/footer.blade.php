		<footer class="text-center">
			<div class="container">
				<p>&copy; 2022 Worcester Douglas Limited. &middot; <a href="#" class="text-white">Privacy</a> &middot; <a href="#" class="text-white">Terms</a></p>
			</div>
		</footer>  
		<div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content bg-black rounded-20">
			  <div class="modal-body py-5">
				<h3 class="text-white px-4 font-300 text-center">Change New Password</h3>
				<div class="print-error-msg" style="display:none">
					<ul style="color: red"></ul>
				</div>
				<form class="px-4 mx-2" id="changePasswordForm">
					<div class="form-group">
						<label class="text-light mb-1 d-block size-14">Old Password</label>
						<div class="password-field">
							<input type="password" name="current_password" id="current_password" class="form-control border border-gray bg-transparent rounded-12 font-300">
							<i class="showPassword"></i>
							<span style="color: red; display:none" id="msg_current_password">The old password field is required.</span>
						</div>
					</div>
					<div class="form-group">
						<label class="text-light mb-1 d-block size-14">New Password</label>
						<div class="password-field">
							<input type="password" name="new_password" id="new_password" class="form-control border border-gray bg-transparent rounded-12 font-300">
							<i class="showPassword"></i>
							<span style="color: red; display:none" id="msg_new_password">The new password field is required.</span>
						</div>
					</div>
					<div class="form-group">
						<label class="text-light mb-1 d-block size-14">Confirm Password</label>
						<div class="password-field">
							<input type="password" name="confirm_password" id="confirm_password" class="form-control border border-gray bg-transparent rounded-12 font-300">
							<i class="showPassword"></i>
							<span style="color: red; display:none" id="msg_confirm_password">The confirm password field is required.</span>
							<span style="color: red; display:none" id="msg_match">The new password and confirm password is mismatch!</span>
						</div>
					</div>
					<div class="text-center mt-4 row mx-n2 pt-1">
						<div class="col-6 px-2">
							<button type="button" class="btn btn-secondary border-0 rounded-15 btn-lg btn-block py-3" data-dismiss="modal">Back</button>
						</div>
						<div class="col-6 px-2">
							<button type="button" id="change_password" class="btn btn-gradient border-0 rounded-15 btn-lg btn-block py-3">Update Password</button>
						</div>
					</div>
				</form>
			  </div>
			</div>
		  </div>
		</div>
		<div class="modal fade" id="signout" tabindex="-1" role="dialog" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content bg-black rounded-20">
			  <div class="modal-body text-center py-5">
				<h3 class="text-white px-4 font-300">Are you sure you want to<br> Sign Out?</h3>
				<div class="text-center mt-5">
					<button type="button" class="btn btn-secondary border-0 rounded-15 btn-lg w-150 py-3 mx-3" data-dismiss="modal">No</button>
					<a href="{{url('admin/logout')}}" class="btn btn-gradient border-0 rounded-15 btn-lg w-150 py-3 mx-3">Yes</a>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	</div>
	
	<div id="mask"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="{{ asset('assets/js/moment-with-locales.js') }}"></script>
    	<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ asset('assets/js/selectize.min.js') }}"></script>
		<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
		<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.ui.touch.min.js') }}"></script>
		<script src="{{ asset('assets/js/chart.min.js') }}"></script>
		<script src="{{ asset('assets/js/datatables.min.js') }}"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
		<script src="{{ asset('assets/js/custom.js') }}"></script>
		
		<script>
			$(document).ready(function() {
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				$(document).on("click","#change_password",function() {

					$("#msg_current_password,#msg_new_password,#msg_confirm_password,#msg_match").css("display", "none");
					if($('#current_password').val().trim() == ''){
						$("#msg_current_password").css("display", "block");
						return false;
					}
					if($('#new_password').val().trim() == ''){
						$("#msg_new_password").css("display", "block");
						return false;
					}
					if($('#confirm_password').val().trim() == ''){
						$("#msg_confirm_password").css("display", "block");
						return false;
					}
					if($('#new_password').val().trim() != $('#confirm_password').val().trim()){
						$("#msg_match").css("display", "block");
						return false;
					}
					event.preventDefault();
					var data=$("#changePasswordForm").serializeArray();
					$.ajax({
						url: "{{url('admin/update-password')}}",
						type: 'POST',
						data:data,
						success:function(response) {
							if (response.status == 400) {
								printErrorMsg(response.message)
								return false;
								// $('#otp_validation').html('<span class="" id=""><i style="color: red">' + response.message + ' </i></span>');
							}
							if (response.status == 200) {
								
								$("#changePasswordForm")[0].reset();
								$('#changePassword').modal('hide');
								//window.location.reload();
								window.location.href = "{{url('admin/login')}}";
							}
							
						},
						error:function() {
							alert("Errors");
						}
					});

				});
				function printErrorMsg (msg) {
					$(".print-error-msg").find("ul").html('');
					$(".print-error-msg").css('display','block');
					$.each( msg, function( key, value ) {
						$(".print-error-msg").find("ul").append('<li>'+value+'</li>');
					});

				}
				
			});

			
		</script>
		
  </body>
</html>
