@extends('LayoutAdmin')

@section('title',  !$data ? __('Create Career') : __('Edit Career'))

@section('css')
    <link rel="stylesheet" href="/css/admin/career-management/career-detail.css" type="text/css" media="all"/>
@stop

@section('scripts')
    <script>
        var url = {
            deleteCareer:  '{{route("DeleteCareers")}}',
            createCareer:  '{{route("CreateCareer")}}',
            editCareer:    '{{route("EditCareer", ["id" => 0])}}'
        }
    </script>
    <script src="/js/admin/career-management/career-detail.js?v=3" type="text/javascript"></script>
@stop

@section('body')
<div class="row">
    <form class="form-horizontal input_mask" id="form-career" enctype="multipart/form-data" action="{{!$data ? route('InsertCareer') : route('UpdateCareer')}}" accept-charset="UTF-8" method="post">
        <input type="hidden" name="id" id="id" value="{{!isset($data) ? 0 : $data->id}}" />
        <div class="col-xs-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('Career')}}</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <select class="form-control cmb-trans" name="lang_id" id="trans_lang">
                                @foreach($languages as $key => $lang)
                                    <option value="{{$key}}" {{request('language_id')==$key ? 'selected':''}}>{{$lang}}</option>
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
                                <label for="trans_text">{{__('Job Type')}}</label>
                                <select class="form-control" name="job_type_id" id="job_type">
                                    @foreach($job_types as $key => $value)
                                        <option value="{{$key}}" {{ isset($data) && $key==$data->job_type_id ? 'selected':''}}>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 col-xs-6">
                            <div class="form-group">
                                <label for="trans_text">{{__('Start Date')}}</label>
                                <input type="date" required class="form-control" name="start_at" id="start_at" value="{{isset($data)?substr($data->start_at, 0, 10):''}}" />
                            </div>
                        </div>
                        <div class="col-6 col-xs-6">
                            <div class="form-group">
                                <label for="trans_text">{{__('End Date')}}</label>
                                <input type="date" class="form-control" name="finish_at" id="finish_date" value="{{isset($data)?substr($data->finish_at, 0, 10):''}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="trans_text">{{__('Contact Address')}}</label>
                        <div class="col-xs-12">
                            <div class="row form-group">
                                <textarea  class="form-control ckeditor" style="min-width: 100%" id="contact" name="contact">{{isset($data)?$data->contact:''}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-xs-12">
                            <div class="form-group div-upload-img">
                                <label for="trans_img">{{__('Image')}} (160px x 160px) <span class="text-required">*</span></label>
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
                        <label for="trans_text">{{__('Short Description')}}</label>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <textarea  class="form-control ckeditor" style="min-width: 100%" id="short_desc" name="short_desc">{{isset($data)?$data->short_desc:''}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="trans_text">{{__('Detail')}}</label>
                        <div class="col-xs-12">
                            <div class="row form-group">
                                <textarea  class="form-control" style="min-width: 100%" id="detail" name="detail" cols="800" rows="10">{{isset($data)?$data->detail:''}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="trans_text">{{__('Skill Required')}}</label>
                        <div class="col-xs-12">
                            <div class="row form-group">
                                <textarea  class="form-control ckeditor" style="min-width: 100%" id="skill_required" name="skill_required">{{isset($data)?$data->skill_required:''}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="trans_text">{{__('Priority')}}</label>
                        <div class="col-xs-12">
                            <div class="row form-group">
                                <textarea class="form-control ckeditor" style="min-width: 100%" id="priority" name="priority" >{{isset($data)?$data->priority:''}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="trans_text">{{__('Benefit')}}</label>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <textarea class="form-control ckeditor" style="min-width: 100%" id="benefit" name="benefit">{{isset($data)?$data->benefit:''}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6  col-xs-6">
                            <label for="location">{{__('Salary')}}</label>
                            <input type="text" class="form-control" name="salary" id="salary" value="{{isset($data)?$data->salary:''}}" />
                        </div>
                        <div class="col-6  col-xs-6">
                            <label for="location">{{__('Quantity')}}</label>
                            <input type="text" class="form-control" name="quantity" id="quantity" value="{{isset($data)?$data->quantity:''}}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6  col-xs-6">
                            <label for="location">{{__('Location')}}</label>
                            <select class="form-control" name="location_id" id="location">
                                @foreach($locations as $key => $value)
                                    <option value="{{$key}}" {{isset($data) && $data->location_id==$key ? 'selected':''}}>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-xs-6">
                            <label for="language">{{__('Language')}}</label>
                            <select class="form-control" name="language_id" id="language_id">
                                @foreach($languages as $key => $lang)
                                    <option value="{{$key}}" {{isset($data) && $data->language_id==$key ? 'selected':''}}>{{$lang}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="clearfix">&nbsp;</div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="status" class="lbl-status">{{__('Status')}}</label>
                                <select class="form-control" name="status" id="status">
                                    @foreach($statuses as $key => $val)
                                        <option value="{{$key}}" {{isset($data) && $data->status==$key ? 'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>

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
                            <input type="button" class="btn btn-primary" id="btn-save-career" value="{{__('Save')}}" />
                            <a class="btn btn-secondary" href="{{route('ListOfCareers')}}">{{__('Cancel')}}</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop
