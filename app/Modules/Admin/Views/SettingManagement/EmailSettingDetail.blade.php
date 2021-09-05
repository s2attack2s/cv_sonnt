@extends('LayoutAdmin')

@section('title', __('Edit Emaill Setting'))

@section('css')
<link rel="stylesheet" href="/css/admin/setting-management/email-setting-detail.css" type="text/css" media="all" />
@stop

@section('scripts')
<script>
    var url = {
        editEmailSetting: '{{route("EditEmailSetting")}}'
    }
</script>
<script src="/js/admin/setting-management/email-setting-detail.js" type="text/javascript"></script>
@stop

@section('body')
<div class="row">
    <form class="form-horizontal input_mask" id="form-emailsetting" action="{{route('UpdateEmailSetting')}}" accept-charset="UTF-8" method="post">
        <div class="col-xs-12 col-main-lang">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('Email setting information')}}</h2>
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
                                <label for="text">{{__('Mailer')}}</label>
                                <input type="hidden" name="id" id="id" value="{{$data['vi']->id}}" />
                                <input type="hidden" name="vi[lang]" id="lang" value="vi" />
                                <input type="text" class="form-control" name="vi[mailer]" id="mailer" value="{{$data['vi']->mailer}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Mail host')}}</label>
                                <input type="text" class="form-control" name="vi[mail_host]" id="mail_host" value="{{$data['vi']->mail_host}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Mail port')}}</label>
                                <input type="text" class="form-control" name="vi[mail_port]" id="mail_port" value="{{$data['vi']->mail_port}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Mail smtp auth')}}</label>
                                <input type="text" class="form-control" name="vi[mail_smtp_auth]" id="mail_smtp_auth" value="{{$data['vi']->mail_smtp_auth}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Mail user')}}</label>
                                <input type="text" class="form-control" name="vi[mail_user]" id="mail_user" value="{{$data['vi']->mail_user}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <label for="text">{{__('Mail password')}}</label>
                                <input type="password" class="form-control" name="vi[mail_password]" id="mail_password" value="<?php echo base64_decode($data['vi']->mail_password); ?>" />
                                <span class="input-group-btn btn-show-mail_password">
                                    <button type="button" class="btn btn-primary" id="btn-show-mail_password">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Mail from')}}</label>
                                <input type="text" class="form-control" name="vi[mail_from]" id="mail_from" value="{{$data['vi']->mail_from}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Mail received')}}</label>
                                <input type="text" class="form-control" name="vi[mail_received]" id="mail_received" value="{{$data['vi']->mail_received}}" />
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
                        <input type="button" class="btn btn-primary" id="btn-save-emailsetting" value="{{__('Save')}}" />
                    </div>
                </div>
            </div>
            @include('LayoutAdmin.UpdateInfo', [
            'created_by' => $data['vi']->created_by,
            'created_at' => $data['vi']->created_at,
            'updated_by' => $data['vi']->updated_by,
            'updated_at' => $data['vi']->updated_at
            ])
        </div>
    </div>
</div>
@stop