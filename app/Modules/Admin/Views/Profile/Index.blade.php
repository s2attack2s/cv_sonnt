@extends('LayoutAdmin')

@section('title', __('Edit Profile'))

@section('css')
<link rel="stylesheet" href="/css/admin/profile/profile-detail.css" type="text/css" media="all" />
@stop

@section('scripts')
<script>
var url = {
    Profile: '{{route("Profile")}}'
}
</script>
<script src="/js/admin/profile/profile.js" type="text/javascript"></script>
@stop

@section('body')
<div class="row">
    <form class="form-horizontal input_mask" id="form-profile" enctype="multipart/form-data"
        action="{{route('UpdateProfile')}}" accept-charset="UTF-8" method="post">
        <div class="col-xs-12 col-sm-12 col-main-lang">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('Profile information')}}</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('User Name')}}</label>
                                <input type="hidden" name="id" id="id" value="{{$data['query']->id}}" />
                                <input type="text" name="username" class="form-control"
                                    value="{{$data['query']->username}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{$data['query']->name}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    value="{{$data['query']->address}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{$data['query']->email}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="number" class="form-control" id="phone" name="phone"
                                    value="{{$data['query']->phone}}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <input type="button" class="btn btn-primary" id="btn-save-profile" value="{{__('Save')}}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <form class="form-horizontal input_mask" id="form-password" enctype="multipart/form-data" action="{{route('UpdatePassword')}}" accept-charset="UTF-8" method="post">
        <div class="col-xs-12 col-sm-12 col-main">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('chage password')}}</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="password">{{__('Old Password')}}</label>
                                <input name="old_password" id="old_password" type="password" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="password">{{__('New Password')}}</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="password">{{__('Confirm Password')}}</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <input type="button" class="btn btn-primary" id="btn-password" value="{{__('Save')}}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop