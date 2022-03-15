<div class="flex">
	<header>
		<nav class="navbar navbar-expand-lg navbar-light bg-dark">
			<div class="container justify-content-between">
				<div class="logo flex-sm-grow-1 flex-md-grow-0">
					<a class="navbar-brand" href="{{url('admin/dashboard')}}"><img src="{{asset('assets/img/logo.jpg')}}" alt=""></a>
				</div>
					
					<div class="search-icon d-md-none padding-10px-lr margin-10px-lr"><i><img src="{{asset('assets/img/search-icon.png')}}"></i></div>
					<ul class="navbar-nav mx-auto">
						<li class="nav-item mx-3"><a href="{{url('admin/dashboard')}}" class="nav-link">Dashboard</a></li>
						<li class="nav-item mx-3"><a href="{{url('admin/manage-hotel')}}" class="nav-link">Manage Hotel</a></li>
						<li class="nav-item mx-3"><a href="{{url('admin/setting')}}" class="nav-link">Settings</a></li>
						<li class="nav-item mx-3"><a href="{{url('admin/manage-tutorial')}}" class="nav-link">Manage Tutorial</a></li>
						<li class="nav-item mx-3"><a href="{{url('admin/transaction-history')}}" class="nav-link">Transaction History</a></li>
					</ul>
					<ul class="navbar-nav ml-auto navbar-right">
						<li class="nav-item dropdown">
							<a class="nav-link text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="avatar rounded-pill overflow-hidden"> 
									@if (!empty(auth()->user()->profile_image))
									<img src="{{asset('file/admin/profile').'/'.auth()->user()->profile_image}}">
									@else
									<img src="{{asset('file/admin/profile/profile.png')}}">
									@endif
									
								</span>
							</a>
							
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item d-flex align-items-center" href="#" data-toggle="modal" data-target="#changePassword"><img src="{{asset('assets/img/icons/lock.svg')}}" class="mr-2"> Change Password</a>
								<a class="dropdown-item d-flex align-items-center" href="#" data-toggle="modal" data-target="#signout"><img src="{{asset('assets/img/icons/logout.svg')}}" class="mr-2">  Sign out</a>
							</div>
						</li>
					</ul>
			</div>
		</nav>
	</header>