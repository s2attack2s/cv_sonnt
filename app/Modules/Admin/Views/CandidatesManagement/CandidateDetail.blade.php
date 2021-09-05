@extends('LayoutAdmin')

@section('title',  !$data ? __('Create Candidate') : __('Edit Candidate'))

@section('css')
    <link rel="stylesheet" href="/css/admin/candidate-management/candidate-detail.css" type="text/css" media="all"/>
@stop

@section('scripts')
    <script>
        var url = {
            deleteCandidate:  '{{route("DeleteCandidates")}}',
            createCandidate:  '{{route("CreateCandidate")}}',
            editCandidate:    '{{route("EditCandidate", ["id" => 0])}}',
            approveCandidate:    '{{route("ApproveCandidate", ["id" => 0])}}'
        }
    </script>
    <script src="/js/admin/candidate-management/candidate-detail.js?v=3" type="text/javascript"></script>
@stop

@section('body')
<div class="row">
    <form class="form-horizontal input_mask" id="form-candidate" enctype="multipart/form-data" action="{{!$data ? route('InsertCandidate') : route('UpdateCandidate')}}" accept-charset="UTF-8" method="post">
        <input type="hidden" name="id" id="id" value="{{!isset($data) ? 0 : $data->id}}" />
        <div class="col-xs-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('Candidate')}}</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <select class="form-control cmb-trans" name="lang_id" id="trans_lang">
                                @foreach($languages as $key => $lang)
                                    <option value="{{$key}}">{{$lang}}</option>
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


                    <div class="row mb-1">
                        <div class="col-xs-12">
                            <div class="form-group div-upload-img">
                                <label for="trans_img">{{__('Logo')}} (160px x 160px) <span class="text-required">*</span></label>
                                <div class="div-review-img">

                                    <img class="img-preview" src="{{isset($data)?$data->logo:''}}" style="max-width: 250px;" />
                                    <input class="img-size" type="hidden" min-of-width="160px" min-rate="1.7" max-rate="1.8">
                                </div>
                                <div class="input-group">
                                    <input class="form-control filename" name="img" id="image" readonly="readonly" value="{{isset($data)?substr($data->logo, 15):''}}" />
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


{{--                    <div class="row">--}}
{{--                        <div class="col-xs-12">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="status_chk" class="lbl-status">{{__('Status')}}</label>--}}
{{--                                <div class="custom-checkbox">--}}
{{--                                    <input type="checkbox" id="status_chk" @if($data && $data->status)checked="checked"@endif value="1">--}}
{{--                                </div>--}}

{{--                                <input type="hidden" id="status" name="status"  {{!empty($data->status) ? 1 : 0}} value="0">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

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
                            <input type="button" class="btn btn-primary" id="btn-save-candidate" value="{{__('Save')}}" />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop
