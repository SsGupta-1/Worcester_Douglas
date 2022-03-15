@include('admin.includes.head')
@include('admin.includes.header')

{{-- <div class="wrapper full bg-ldark"> --}}
    @yield('content')
{{-- </div> --}}
@jquery
@toastr_js
@toastr_render
@include('admin.includes.footer')


@yield('script')