<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href= "favicon.ico">

    <title>@yield('title') - Nguyễn Trọng Sơn</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="/assets/bootstrap-3.3.7/css/bootstrap.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/assets/font-awesome-4.7.0/css/font-awesome.min.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/assets/nprogress/css/nprogress.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/css/common/admin.css" type="text/css" media="all"/>
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <!-- page content -->
            <div class="col-md-12">
                <div class="col-middle">
                    <div class="text-center">
                        @yield('body')
                    </div>
                </div>
            </div>
            <!-- /page content -->
        </div>
    </div>
    <script src="/assets/jquery/js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="/assets/bootstrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>
