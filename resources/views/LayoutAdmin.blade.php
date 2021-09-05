<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href= "/favicon.ico">

    <title>@yield('title') - TOPLoop.co</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="/assets/bootstrap-3.3.7/css/bootstrap.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/assets/font-awesome-4.7.0/css/font-awesome.min.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/assets/nprogress/css/nprogress.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/assets/iCheck/skins/flat/green.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/assets/colorbox/css/jquery.colorbox.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/css/common/admin.css" type="text/css" media="all"/>
    @yield('css')
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            @include('LayoutAdmin.Header')
            @include('LayoutAdmin.Sidebar')
            <!-- page content -->
            <div class="right_col" role="main">
                @yield('body')
            </div>
            <!-- /page content -->
            <!-- footer content -->
            <footer>
                <div class="custom-footer">
                    {{__('Copyright by')}} <a href="{{route('AdminDashboard')}}">©TOPLoop.co</a>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>
    <script>
        var lang = 'vi';
    </script>
    <script src="/assets/jquery/js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="/assets/bootstrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/assets/ckeditor/ckeditor.js" type="text/javascript"></script>
    <script src="/assets/nprogress/js/nprogress.js" type="text/javascript"></script>
    <script src="/assets/fastclick/js/fastclick.js" type="text/javascript"></script>
    <script src="/assets/pagination/js/pagination.js" type="text/javascript"></script>
    <script src="/js/common/jquery-form.js" type="text/javascript"></script>
    <script src="/js/common/jquery-cookie.js" type="text/javascript"></script>
    <script src="/assets/colorbox/js/jquery.colorbox.js" type="text/javascript"></script>
    <script src="/js/common/secure.js" type="text/javascript"></script>
    <script src="/js/common/common.js?v=1" type="text/javascript"></script>
    <script src="/js/common/message.js" type="text/javascript"></script>
    <script src="/js/common/notification.js" type="text/javascript"></script>
    <script src="/js/common/admin.js?v=1" type="text/javascript"></script>
    @yield('scripts')
</body>
</html>
