@extends('LayoutAdmin')

@section('title',  !$data ? __('Create news') : __('Edit news'))

@section('css')
    <link rel="stylesheet" href="/css/admin/news-management/news-detail.css" type="text/css" media="all"/>
@stop

@section('scripts')
    <script>
        var url = {
            deleteNews:  '{{route("DeleteNews")}}',
            createNews:  '{{route("CreateNews")}}',
            editNews:    '{{route("EditNews", ["id" => 0])}}'
        }
    </script>
    <script src="/js/admin/news-management/news-detail.js?v=3" type="text/javascript"></script>
@stop

@section('body')
<div class="row">
    <form class="form-horizontal input_mask" id="form-news" enctype="multipart/form-data" action="{{!$data ? route('InsertNews') : route('UpdateNews')}}" accept-charset="UTF-8" method="post">
        <input type="hidden" name="id" id="id" value="{{!isset($data) ? 0 : $data->id}}" />
        <div class="col-xs-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('news.title')}}</h2>
                    <ul class="nav navbar-right panel_toolbox">
{{--                        <li>--}}
{{--                            <select class="form-control cmb-trans" name="lang_id" id="trans_lang">--}}
{{--                                @foreach($languages as $key => $lang)--}}
{{--                                    <option value="{{$key}}" {{$data->language_id==$key ? 'selected':''}}>{{$lang}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </li>--}}
                        <li>
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="trans_text">{{__('Language')}}</label>
                            <select class="form-control cmb-trans" name="language_id" {{isset($data) ? 'disabled':''}} id="lang">
                                @foreach($languages as $key => $lang)
                                    <option value="{{$key}}" {{isset($data) && $data->language_id==$key ? 'selected':''}}>{{$lang}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_text">{{__('Title')}}</label>
                                <input type="text" class="form-control" name="title" id="title" value="{{isset($data)?$data->title:''}}" />
                            </div>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-xs-12">
                            <div class="form-group div-upload-img">
                                <label for="trans_img">{{__('Image')}} (423px x 423px) <span class="text-required">*</span></label>
                                <div class="div-review-img">

                                    <img class="img-preview" src="{{isset($data)?$data->thumbnail:''}}" style="max-width: 250px;" />
                                    <input class="img-size" type="hidden" min-of-width="423px" min-rate="1.7" max-rate="1.8">
                                </div>
                                <div class="input-group">
                                    <input class="form-control filename" name="img" id="image" readonly="readonly" value="{{isset($data)?basename($data->thumbnail):''}}" />
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
                        <label for="trans_text">{{__('Content')}}</label>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <textarea class="form-control ckeditor" style="min-width: 100%" rows="10" id="content" name="content">{{isset($data)?$data->content:''}}</textarea>
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
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_text">{{__('Published Date')}}</label>
                                <input type="date" class="form-control" name="published_date" id="published_date" value="{{isset($data)?$data->published_date:''}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="published_chk" @if($data && $data->is_published)checked="checked"@endif value="1">
                                </div>
                                <label for="published_chk" class="lbl-show">{{__('Published')}}</label>
                                <input type="hidden" id="published" name="is_published" {{!empty($data->is_published) ? 1 : 0}} value="1">
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
                            <input type="button" class="btn btn-primary" id="btn-save-news" value="{{__('Save')}}" />
                            <a class="btn btn-secondary" href="{{route('ListOfNews')}}">{{__('Cancel')}}</a>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop