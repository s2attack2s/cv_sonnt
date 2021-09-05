@extends('LayoutAdmin')

@section('title',  !$data ? __('Create Location') : __('Edit Location'))

@section('css')
    <link rel="stylesheet" href="/css/admin/location-management/location-detail.css" type="text/css" media="all"/>
@stop

@section('scripts')
    <script>
        var url = {
            editLocation:    '{{route("EditLocation", ["id" => 0])}}'
        }
    </script>
    <script src="/js/admin/location-management/location-detail.js?v=3" type="text/javascript"></script>
@stop

@section('body')
<div class="row">
    <form class="form-horizontal input_mask" id="form-location" enctype="multipart/form-data" action="{{!$data ? route('InsertLocation') : route('UpdateLocation')}}" accept-charset="UTF-8" method="post">
        <input type="hidden" name="id" id="id" value="{{!isset($data) ? 0 : $data->id}}" />
        <div class="col-xs-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('Location')}}</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>

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
                            <div class="form-group div-upload-img">
                                <label for="img">{{__('Image')}} (223px x 152px) <span class="text-required">*</span></label>
                                <div class="div-review-img">
                                    <img class="img-preview" src="{{$data->image}}" style="max-width: 250px;" />
                                    <input class="img-size" type="hidden" min-of-width="223" min-rate="1.7" max-rate="1.8">
                                </div>
                                <div class="input-group">
                                    <input class="form-control filename" name="image" id="image" readonly="readonly" value="{{basename($data->image)}}" />
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
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_text">{{__('Name')}}</label>
                                <input type="text" required class="form-control" name="name" id="name" value="{{isset($data)?$data->name:''}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-xs-12">
                            <div class="form-group">
                                <label for="trans_text">{{__('Language')}}</label>
                                <select class="form-control" disabled="true" name="language_id" id="language_id">
                                    @foreach($languages as $key => $lang)
                                        <option value="{{$key}}" {{isset($data) && $data->language_id==$key ? 'selected':''}}>{{$lang}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_text">{{__('Head Office')}}</label>
                                <input type="text" required class="form-control" name="head_office" id="head_office" value="{{isset($data)?$data->head_office:''}}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_text">{{__('Sale Office')}}</label>
                                <input type="text" required class="form-control" name="sales_office" id="sales_office" value="{{isset($data)?$data->sales_office:''}}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_text">{{__('Phone')}}</label>
                                <input type="text" required class="form-control" name="phone" id="phone" value="{{isset($data)?$data->phone:''}}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_text">{{__('Head Office Map')}}</label>
                                <textarea name="head_iframe" rows="6" class="form-control">{{isset($data)?$data->head_iframe:''}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_text">{{__('Sale Office Map')}}</label>
                                <textarea name="sales_iframe" rows="6" class="form-control">{{isset($data)?$data->sales_iframe:''}}</textarea>
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
                            <input type="button" class="btn btn-primary" id="btn-save-location" value="{{__('Save')}}" />
                            <a class="btn btn-secondary" href="{{route('ListOfLocations')}}">{{__('Cancel')}}</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop
