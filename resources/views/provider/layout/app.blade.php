<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ Setting::get('site_favicon', asset('favicon.ico')) }}" type="image/x-icon">
    <link rel="icon" href="{{ Setting::get('site_favicon', asset('favicon.ico')) }}" type="image/x-icon">

    <title>@yield('title'){{ Setting::get('site_title', 'Tranxit') }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ Setting::get('site_icon') }}"/>
    

    <!-- Styles -->
    <link href="{{ asset('asset/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('asset/css/slick.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('asset/css/slick-theme.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('asset/css/rating.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('asset/css/dashboard-style.css') }}" rel="stylesheet" type="text/css">
    @yield('styles')

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    
    <div id="wrapper">
        <div class="overlay" id="overlayer" data-toggle="offcanvas"></div>
        @include('provider.layout.partials.nav')
        <div id="page-content-wrapper">
            @include('provider.layout.partials.header')
            <div class="page-content">
                <div class="pro-dashboard">
                    @yield('content')
                </div>
                @include('provider.layout.partials.footer')
            </div>
        </div>
    </div>

    <div id="modal-incoming"></div>

    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('asset/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset/js/jquery.mousewheel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset/js/jquery-migrate-1.2.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset/js/slick.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset/js/rating.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset/js/dashboard-scripts.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.3.1/react.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.3.1/react-dom.js"></script>
    <script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>

    <script type="text/babel" src="{{ asset('asset/js/incoming.js') }}"></script>
    <script type="text/javascript">
        // $.incoming({
        //     'url': '{{ route('provider.incoming') }}',
        //     'modal': '#modal-incoming'
        // });
    </script>

    @yield('scripts')
    @if(Setting::get('demo_mode', 0) == 1)
        <!-- Start of LiveChat (www.livechatinc.com) code -->
        <script type="text/javascript">
            window.__lc = window.__lc || {};
            window.__lc.license = 8256261;
            (function() {
                var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
                lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
            })();
        </script>
        <!-- End of LiveChat code -->
    @endif

</body>
</html>