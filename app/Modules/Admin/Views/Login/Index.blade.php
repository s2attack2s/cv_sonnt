<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href= "/favicon.ico">

    <title>Admin login - TOPLoop.co</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="/assets/bootstrap-3.3.7/css/bootstrap.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/assets/font-awesome-4.7.0/css/font-awesome.min.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/assets/nprogress/css/nprogress.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/assets/iCheck/skins/flat/green.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/assets/colorbox/css/jquery.colorbox.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/css/common/admin.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/css/admin/login/login.css" type="text/css" media="all"/>
</head>

<body class="login">
    <div>
        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <form id="form-login" action="{{route('AdminCheckLogin')}}" method="post">
                        <div class="form-container">
                            <div class="box-select">
                                <h1>{{__('LOGIN')}}</h1>
                                <div class="row">
                                    <div class="col-xs-offset-1 col-xs-10 col-sm-12">
                                        <input type="text" name="username" id="username" class="form-control" placeholder="{{__('Username')}}" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-offset-1 col-xs-10 col-sm-12">
                                        <div class="input-group">
                                            <input type="password" name="password" id="password" class="form-control" placeholder="{{__('Password')}}" />
                                            <span class="input-group-btn btn-show-password">
                                                <button type="button" class="btn btn-primary" id="btn-show-password">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <input type="checkbox" id="remember" value="1" tabindex="3">
                                    <label for="remember">{{__('Remember login')}}</label>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12">
                                        <button type="button" id="btn-login" tabindex="4">{{__('Login')}}</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
    <script>
        var lang = 'vi';
    </script>
    <script src="/assets/jquery/js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="/assets/bootstrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/assets/nprogress/js/nprogress.js" type="text/javascript"></script>
    <script src="/assets/fastclick/js/fastclick.js" type="text/javascript"></script>
    <script src="/assets/pagination/js/pagination.js" type="text/javascript"></script>
    <script src="/js/common/jquery-form.js" type="text/javascript"></script>
    <script src="/js/common/jquery-cookie.js" type="text/javascript"></script>
    <script src="/assets/colorbox/js/jquery.colorbox.js" type="text/javascript"></script>
    <script src="/js/common/secure.js" type="text/javascript"></script>
    <script src="/js/common/common.js?v=2" type="text/javascript"></script>
    <script src="/js/common/message.js" type="text/javascript"></script>
    <script src="/js/common/notification.js" type="text/javascript"></script>
    <script src="/js/common/admin.js" type="text/javascript"></script>
    <script src="/js/admin/login/login.js" type="text/javascript"></script>
</body>
</html>
