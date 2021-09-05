@extends('LayoutAdmin')

@section('title',  !$data ? __('Create DeliveryModel') : __('Edit DeliveryModel'))

@section('css')
    <link rel="stylesheet" href="/css/admin/delivery-model-management/delivery-model-detail.css" type="text/css" media="all"/>
@stop

@section('scripts')
    <script>
        var url = {
            editDeliveryModel:    '{{route("EditDeliveryModel", ["id" => 0])}}'
        }
    </script>
    <script src="/js/admin/delivery-model-management/delivery-model-detail.js?v=1" type="text/javascript"></script>
@stop

@section('body')
<div class="row">
    <form class="form-horizontal input_mask" id="form-delivery-model"  enctype="multipart/form-data" action="{{route('UpdateDeliveryModel')}}" accept-charset="UTF-8" method="post">
        <input type="hidden" name="id" id="id" value="{{!isset($data) ? 0 : $data->id}}" />
        <div class="col-xs-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    &nbsp;
                </div>
                <div class="x_content">
                    <h2>{{__('DeliveryModel')}}</h2>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_text">{{__('Title')}}</label>
                                <input type="text" required class="form-control" name="title" id="title" value="{{isset($data)?$data->title:''}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_text">{{__('Language')}}</label>
                                <select class="form-control cmb-trans" name="language_id" id="trans_lang">
                                    @foreach($languages as $key => $lang)
                                        <option value="{{$key}}" {{$data->language_id==$key ? 'selected':''}}>{{$lang}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-xs-12">
                            <div class="form-group div-upload-img">
                                <label for="trans_img">{{__('Logo')}} (201px x 201px) <span class="text-required">*</span></label>
                                <div class="div-review-img">

                                    <img class="img-preview" src="{{isset($data)?$data->image:''}}" style="max-width: 250px;" />
                                    <input class="img-size" type="hidden" min-of-width="201px" min-rate="1.7" max-rate="1.8">
                                </div>
                                <div class="input-group">
                                    <input class="form-control filename" name="img" id="image" readonly="readonly" value="{{isset($data)?basename($data->image):''}}" />
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
                                <label for="trans_text">{{__('Description')}}</label>
                                    <textarea name="desc" class="form-control" rows="10">{{$data->desc}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-xs-12">
                            <div class="form-group div-upload-img">
                                <label for="trans_img">{{__('Offshore Delivery Image')}} <span class="text-required">*</span></label>
                                <div class="div-review-img">

                                    <img class="img-preview" src="{{isset($data)?$data->offshore_delivery:''}}" style="max-width: 250px;" />
                                    <input class="img-size" type="hidden" min-of-width="160px" min-rate="1.7" max-rate="1.8">
                                </div>
                                <div class="input-group">
                                    <input class="form-control filename" name="offshore_delivery_img" id="offshore_delivery_image" readonly="readonly" value="{{isset($data)?basename($data->offshore_delivery):''}}" />
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary">
                                            <i class="fa fa-upload" aria-hidden="true"></i>
                                        </button>
                                        <input type="file" class="file fileImg" name="offshore_delivery_image" id="offshore_delivery_image" />
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-xs-12">
                            <div class="form-group div-upload-img">
                                <label for="trans_img">{{__('Onside Delivery Image')}} <span class="text-required">*</span></label>
                                <div class="div-review-img">

                                    <img class="img-preview" src="{{isset($data)?$data->onside_delivery:''}}" style="max-width: 250px;" />
                                    <input class="img-size" type="hidden" min-of-width="160px" min-rate="1.7" max-rate="1.8">
                                </div>
                                <div class="input-group">
                                    <input class="form-control filename" name="onside_delivery_img" id="onside_delivery_image" readonly="readonly" value="{{isset($data)?basename($data->onside_delivery):''}}" />
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary">
                                            <i class="fa fa-upload" aria-hidden="true"></i>
                                        </button>
                                        <input type="file" class="file fileImg" name="onside_delivery_image" id="onside_delivery_image" />
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-xs-12">
                            <div class="form-group div-upload-img">
                                <label for="trans_img">{{__('Hybrid Delivery Image')}} <span class="text-required">*</span></label>
                                <div class="div-review-img">
                                    <img class="img-preview" src="{{isset($data)?$data->hybrid_delivery:''}}" style="max-width: 250px;" />
                                    <input class="img-size" type="hidden" min-of-width="160px" min-rate="1.7" max-rate="1.8">
                                </div>
                                <div class="input-group">
                                    <input class="form-control filename" name="hybrid_delivery_img" id="hybrid_delivery_image" readonly="readonly" value="{{isset($data)?basename($data->hybrid_delivery):''}}" />
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary">
                                            <i class="fa fa-upload" aria-hidden="true"></i>
                                        </button>
                                        <input type="file" class="file fileImg" name="hybrid_delivery_image" id="hybrid_delivery_image" />
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
                            <input type="button" class="btn btn-primary" id="btn-save-delivery-model" value="{{__('Save')}}" />
                            <a class="btn btn-secondary" href="{{route('ListOfDeliveryModels')}}">{{__('Cancel')}}</a>
                         </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop
