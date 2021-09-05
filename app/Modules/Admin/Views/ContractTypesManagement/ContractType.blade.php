@extends('LayoutAdmin')

@section('title',  !$data ? __('Create ContractType') : __('Edit ContractType'))


@section('scripts')
    <script>
        var url = {
            editContractType:    '{{route("EditContractType", ["id" => 0])}}'
        }
    </script>
    <script src="/js/admin/contract-type-management/contract-type.js?v=1" type="text/javascript"></script>
@stop

@section('body')
<div class="row">
    <form class="form-horizontal input_mask" id="form-contract-type"  enctype="multipart/form-data" action="{{route('UpdateContractType')}}" accept-charset="UTF-8" method="post">
        <input type="hidden" name="id" id="id" value="{{!isset($data) ? 0 : $data->id}}" />
        <div class="col-xs-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    &nbsp;
                </div>
                <div class="x_content">
                    <h2>{{__('ContractType')}}</h2>
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
                                <select class="form-control" readonly="true" disabled name="language_id" id="trans_lang">
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
                                <label for="trans_img">{{__('Logo')}} (160px x 160px) <span class="text-required">*</span></label>
                                <div class="div-review-img">

                                    <img class="img-preview" src="{{isset($data)?$data->image:''}}" style="max-width: 250px;" />
                                    <input class="img-size" type="hidden" min-of-width="160px" min-rate="1.7" max-rate="1.8">
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
                            <input type="button" class="btn btn-primary" id="btn-save-contract-type" value="{{__('Save')}}" />
                            <a class="btn btn-secondary" href="{{route('ListOfContractTypes')}}">{{__('Back To List')}}</a>
                         </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop
