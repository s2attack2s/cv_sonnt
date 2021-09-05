@extends('LayoutAdmin')

@section('title',  !$data ? __('Create Client') : __('Edit Client'))

@section('css')
    <link rel="stylesheet" href="/css/admin/client-management/client-detail.css" type="text/css" media="all"/>
@stop

@section('scripts')
    <script>
        var url = {
            deleteClient:  '{{route("DeleteClients")}}',
            createClient:  '{{route("CreateClient")}}',
            editClient:    '{{route("EditClient", ["id" => 0])}}'
        }
    </script>
    <script src="/js/admin/client-management/client-detail.js?v=3" type="text/javascript"></script>
@stop

@section('body')
<div class="row">
    <form class="form-horizontal input_mask" id="form-client" enctype="multipart/form-data" action="{{!$data ? route('InsertClient') : route('UpdateClient')}}" accept-charset="UTF-8" method="post">
        <input type="hidden" name="id" id="id" value="{{!isset($data) ? 0 : $data->id}}" />
        <div class="col-xs-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('Client')}}</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <select class="form-control cmb-trans" name="lang_id" id="trans_lang">
                                @foreach($languages as $key => $lang)
                                    <option value="{{$key}}" {{isset($data) && $data->language_id==$key ? 'selected':''}}>{{$lang}}</option>
                                @endforeach
                            </select>
                        </li>
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
                                <label for="trans_text">{{__('Name')}}</label>
                                <input type="text" required class="form-control" name="name" id="name" value="{{isset($data)?$data->name:''}}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_text">{{__('Website')}}</label>
                                <input type="text" required class="form-control" name="website" id="website" value="{{isset($data)?$data->website:''}}" />
                            </div>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-xs-12">
                            <div class="form-group div-upload-img">
                                <label for="trans_img">{{__('Logo')}} (260px x 260px) <span class="text-required">*</span></label>
                                <div class="div-review-img">

                                    <img class="img-preview" src="{{isset($data)?$data->logo:''}}" style="max-width: 250px;" />
                                    <input class="img-size" type="hidden" min-of-width="260px" min-rate="1.7" max-rate="1.8">
                                </div>
                                <div class="input-group">
                                    <input class="form-control filename" name="img" id="image" readonly="readonly" value="{{isset($data)?basename($data->logo):''}}" />
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary">
                                            <i class="fa fa-upload" aria-hidden="true"></i>
                                        </button>
                                        <input type="file" class="file fileImg" name="image" id="image" />
                                    </span>
                                </div>
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
                            <input type="button" class="btn btn-primary" id="btn-save-client" value="{{__('Save')}}" />
                            <a class="btn btn-secondary" href="{{route('ListOfClients')}}">{{__('Cancel')}}</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop
