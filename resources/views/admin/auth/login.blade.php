
@extends('admin.layouts.admin_master_befor_login')
    @section('content')
    <style>footer {display: none}</style>
    <div class="login full">
        <div class="login-box float-right padding-eight-lr">
            <div class="login-inner">
                <div class="welcome text-white margin-eight-tb text-center">
                    <div class="size-26 text-uppercase font-600 mb-3">Sign In</div>
                    <p class="font-300 mb-5">Welcome to Super Admin Panel</p>
                </div>

                <form action="{{ url('admin/login') }}" method="POST">
                    @csrf
                    <div class="form-inner px-1">
                        <div class="form-group">
                            <label class="text-white size-14 font-300 mb-1">Email</label>
                            <input type="text" placeholder="" name="email" value="{{ old('email') }}"
                                class="form-control text-white border border-gray bg-transparent rounded-12 font-300">
                           
                        </div>

                        <div class="form-group">
                            <label class="text-white size-14 font-300 mb-1">Password</label>
                            <div class="password-field">
                                <input type="password" name="password" value="{{ old('password') }}"
                                    class="form-control text-white border border-gray bg-transparent rounded-12 font-300">
                                <i class="showPassword"></i>
                                
                            </div>
                        </div>
                        <div class="text-center action margin-50px-top md-margin-20px-top">
                            <button type="submit" class="btn btn-gradient btn-lg min btn-block rounded-12 h-50">Sign
                                In</button>
                        </div>
                        <div class="text-center mt-5"><a href="{{url('admin/forgot-password')}}" class="text-white">Forgot
                                Password</a></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection
