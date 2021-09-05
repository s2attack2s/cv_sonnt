<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Important stuff for SEO, don't neglect. (And don't dupicate values across your site!) -->
    <title>@yield('title') - Nguyễn Trọng Sơn</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="">
    <meta property="og:description" content="" />
    <meta property="og:image" content="">
    <meta name="author" content="" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <!-- Don't forget to set your site up: http://google.com/webmasters -->
    <meta content="" property="fb:app_id">
    <meta content="" name="google-signin-client_id" />
    <meta name="google-site-verification" content="" />
    <meta name="Copyright" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/assets/bootstrap-4.5.0/css/bootstrap.min.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/assets/bootstrap-3.3.7/css/bootstrap.min.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/assets/bootstrap-3.3.7/css/bootstrap-theme.min.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/assets/slick/css/slick.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/assets/slick/css/slick-theme.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/css/common/common.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/assets/fontawesome-free-5.15.3-web/css/all.min.css" />
    @yield('css')
</head>

<body class="">
    @yield('body')

    <script src="/assets/jquery/js/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="/assets/bootstrap-4.5.0/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/assets/jquery/js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="/assets/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="/assets/bootstrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/js/common/jquery-form.js" type="text/javascript"></script>
    <script src="/js/common/jquery-cookie.js" type="text/javascript"></script>
    <script src="/assets/slick/js/slick.min.js" type="text/javascript"></script>
    <script src="/js/common/secure.js" type="text/javascript"></script>
    <script src="/js/common/common.js" type="text/javascript"></script>
    <script src="/js/common/message.js" type="text/javascript"></script>
    <script src="/js/common/notification.js" type="text/javascript"></script>
    @yield('scripts')

    <!-- Messenger Chat Plugin Code -->


   
</body>
</html>
