<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Title -->
    <title>@yield('title'){{ Setting::get('site_title', 'Tranxit') }}</title>

    <link rel="shortcut icon" type="image/png" href="{{ Setting::get('site_icon') }}">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{asset('main/vendor/bootstrap4/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/themify-icons/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/animate.css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/jscrollpane/jquery.jscrollpane.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/waves/waves.min.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/switchery/dist/switchery.min.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/DataTables/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/DataTables/Responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/DataTables/Buttons/css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/DataTables/Buttons/css/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css">
    <link rel="stylesheet" href="{{ asset('main/vendor/dropify/dist/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('main/assets/css/core.css') }}">

    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <style type="text/css">
        .rating-outer span,
        .rating-symbol-background {
            color: #ffe000!important;
        }
        .rating-outer span,
        .rating-symbol-foreground {
            color: #ffe000!important;
        }
    </style>
    @yield('styles')
</head>
<body class="fixed-sidebar fixed-header content-appear skin-default">

    <div class="wrapper">
        <div class="preloader"></div>
        <div class="site-overlay"></div>

        @include('account.include.nav')

        @include('account.include.header')

        <div class="site-content">

            @include('common.notify')

            @yield('content')

            @include('account.include.footer')

        </div>
    </div>

    <!-- Vendor JS -->
    <script type="text/javascript" src="{{asset('main/vendor/jquery/jquery-1.12.3.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('main/vendor/tether/js/tether.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('main/vendor/bootstrap4/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('main/vendor/detectmobilebrowser/detectmobilebrowser.js')}}"></script>
    <script type="text/javascript" src="{{asset('main/vendor/jscrollpane/jquery.mousewheel.js')}}"></script>
    <script type="text/javascript" src="{{asset('main/vendor/jscrollpane/mwheelIntent.js')}}"></script>
    <script type="text/javascript" src="{{asset('main/vendor/jscrollpane/jquery.jscrollpane.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('main/vendor/jquery-fullscreen-plugin/jquery.fullscreen')}}-min.js"></script>
    <script type="text/javascript" src="{{asset('main/vendor/waves/waves.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('main/vendor/DataTables/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('main/vendor/DataTables/js/dataTables.bootstrap4.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('main/vendor/DataTables/Responsive/js/dataTables.responsi')}}ve.min.js"></script>
    <script type="text/javascript" src="{{asset('main/vendor/DataTables/Responsive/js/responsive.bootstra')}}p4.min.js"></script>
    <script type="text/javascript" src="{{asset('main/vendor/DataTables/Buttons/js/dataTables.buttons')}}.min.js"></script>
    <script type="text/javascript" src="{{asset('main/vendor/DataTables/Buttons/js/buttons.bootstrap4')}}.min.js"></script>
    <script type="text/javascript" src="{{asset('main/vendor/DataTables/JSZip/jszip.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('main/vendor/DataTables/pdfmake/build/pdfmake.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('main/vendor/DataTables/pdfmake/build/vfs_fonts.js')}}"></script>
    <script type="text/javascript" src="{{asset('main/vendor/DataTables/Buttons/js/buttons.html5.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('main/vendor/DataTables/Buttons/js/buttons.print.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('main/vendor/DataTables/Buttons/js/buttons.colVis.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('main/vendor/switchery/dist/switchery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('main/vendor/dropify/dist/js/dropify.min.js')}}"></script>

    <!-- Neptune JS -->
    <script type="text/javascript" src="{{asset('main/assets/js/app.js')}}"></script>
    <script type="text/javascript" src="{{asset('main/assets/js/demo.js')}}"></script>
    <script type="text/javascript" src="{{asset('main/assets/js/tables-datatable.js')}}"></script>
    <script type="text/javascript" src="{{asset('main/assets/js/forms-upload.js')}}"></script>


    @yield('scripts')

    <script type="text/javascript" src="{{asset('asset/js/rating.js')}}"></script>    
    <script type="text/javascript">
        $('.rating').rating();
    </script>
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