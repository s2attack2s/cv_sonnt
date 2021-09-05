@extends('LayoutAdmin')

@section('title',  !$data ? __('Create Contact') : __('Edit Contact'))

@section('css')
    <link rel="stylesheet" href="/css/admin/contact-management/contact-detail.css" type="text/css" media="all"/>
@stop

@section('scripts')
    <script>
        var url = {
            deleteContact:  '{{route("DeleteContacts")}}',
            resolveContact:  '{{route("ResolveContact")}}',
            closeContact:  '{{route("CloseContact")}}',
            listOfContacts: '{{route('ListOfContacts')}}'
        }
    </script>
    <script src="/js/admin/contact-management/contact-detail.js?v=3" type="text/javascript"></script>
@stop

@section('body')
<div class="row">
    <form class="form-horizontal input_mask">
        <input type="hidden" name="id" id="id" value="{{!isset($data) ? 0 : $data->id}}" />
        <div class="col-xs-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('Contact.title')}}</h2>
                    <ul class="nav navbar-right panel_toolbox">

                        <li>
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="trans_text">{{__('Full Name')}}</label>
                                <input type="text" disabled class="form-control" name="fullname" id="fullname" value="{{isset($data)?$data->fullname:''}}" />
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="trans_text">{{__('Email')}}</label>
                                <input type="text" disabled class="form-control" name="email" id="email" value="{{isset($data)?$data->email:''}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="trans_text">{{__('Phone')}}</label>
                                <input type="text" disabled class="form-control" name="phone" id="phone" value="{{isset($data)?$data->phone:''}}" />
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="trans_text">{{__('Reason')}}</label>
                                <input type="text" disabled class="form-control" name="reason" id="reason" value="{{isset($data)?$data->reason:''}}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="trans_text">{{__('Company')}}</label>
                                <input type="text" disabled class="form-control" name="company" id="company" value="{{isset($data)?$data->company:''}}" />
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="trans_text">{{__('Position')}}</label>
                                <input type="text" disabled class="form-control" name="position" id="position" value="{{isset($data)?$data->position:''}}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="trans_text">{{__('Service Interest')}}</label>
                                <input type="text" disabled class="form-control" name="service_interest" id="service_interest" value="{{isset($data)?$data->service_interest:''}}" />
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="trans_text">{{__('Date Created')}}</label>
                                <input type="text" disabled class="form-control" name="date_created" id="date_created" value="{{isset($data)?$data->created_at:''}}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <textarea disabled class="form-control">{{$data?$data->message:''}}</textarea>
                        </div>
                    </div>
                    <div class="clearfix">&nbsp;</div>
                    <div class="row">
                        @if (isset($data->attachment))
                            <div class="form-group">
                                <label for="trans_text">{{__('Attachment')}}</label> &nbsp;&nbsp;
                                <a href="#"   onclick="window.location.href='{{$data->attachment}}'" target="_blank" >
                                    <i class="fa fa-download" aria-hidden="true"></i> {{__('Download')}}
                                </a>
                            </div>
                        @endif

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

                            @if ($data->status != 2)
                                <button type="button" class="btn btn-success btn-resolved" id="btn-resolve-contact" id="{{$data->id}}">
                                    <i class="fa fa-check" aria-hidden="true"></i> {{__('Resolved')}}
                                </button>
                            @endif
                            @if ($data->status != 3)
                                <button type="button" class="btn btn-warning btn-close" id="btn-close-contact" id="{{$data->id}}">
                                    <i class="fa fa-check" aria-hidden="true"></i> {{__('Close')}}
                                </button>
                            @endif
                            <button type="button" class="btn btn-danger btn-del" id="btn-delete-contact" id-del="{{$data->id}}">
                                <i class="fa fa-trash" aria-hidden="true"></i> {{__('Delete')}}
                            </button>
                            <a class="btn btn-secondary right" href="{{route('ListOfContacts')}}">Back</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop
