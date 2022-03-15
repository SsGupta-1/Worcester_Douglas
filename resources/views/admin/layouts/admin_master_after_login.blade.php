@include('admin.includes.head')
@include('admin.includes.header')

    @yield('content')
    @jquery
@toastr_js
@toastr_render
@include('admin.includes.footer')

@yield('script')
