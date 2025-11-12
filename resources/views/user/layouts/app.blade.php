<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@yield('meta_description', '')">
    <meta name="author" content="@yield('meta_author', '')">

    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'App') }}</title>

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    {{-- Vendor CSS --}}
    <link href="{{ asset('assets_dashboard/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    {{-- SB Admin 2 CSS --}}
    <link href="{{ asset('assets_dashboard/css/sb-admin-2.min.css') }}" rel="stylesheet">

    @stack('extra_css')
</head>
<body id="page-top">
    <div id="wrapper">
        {{-- Sidebar --}}
        @include('user.layouts.nav')

        {{-- Content Wrapper --}}
        <div id="content-wrapper" class="d-flex flex-column">

            {{-- Main Content --}}
            <div id="content">

                {{-- Topbar --}}
                @include('layouts.header')

                {{-- Page Content --}}
                <div class="container-fluid">
                    @yield('page_header')
                    @yield('content')
                </div>
            </div>

            {{-- Footer --}}
            @include('layouts.footer')

        </div>
    </div>

    {{-- Scroll to Top Button --}}
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    {{-- Logout Modal --}}
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form class="modal-content" method="POST" action="{{ route('logout') }}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Pilih "Logout" di bawah untuk mengakhiri sesi saat ini.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <button class="btn btn-primary" type="submit">Logout</button>
            </div>
        </form>
      </div>
    </div>

    {{-- Core JS --}}
    <script src="{{ asset('assets_dashboard/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets_dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets_dashboard/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    {{-- SB Admin 2 JS --}}
    <script src="{{ asset('assets_dashboard/js/sb-admin-2.min.js') }}"></script>

    {{-- Optional: Charts --}}
    @stack('vendor_js')
    @stack('extra_js')
</body>
</html>
