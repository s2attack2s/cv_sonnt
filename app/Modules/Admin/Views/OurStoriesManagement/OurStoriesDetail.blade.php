@extends('LayoutAdmin')

@section('title',  $data['mode'] == 'I' ? __('Create Our Stories') : __('Edit Our Stories'))

@section('css')
@stop

@section('scripts')
    <script>
        var url = {
            deleteOurStories:  '{{route("DeleteOurStories")}}',
            createOurStories:  '{{route("CreateOurStories")}}',
            editOurStories:    '{{route("EditOurStories", ["id" => 0])}}'
        }
        var mode = '{{$data['mode']}}';
    </script>
    <script src="/js/admin/our-stories-management/stories-detail.js?v=3" type="text/javascript"></script>
@stop

@section('body')
<div class="row">
    <form class="form-horizontal input_mask" id="form-our-stories" enctype="multipart/form-data" action="{{$data['mode'] == 'I' ? route('InsertOurStories') : route('UpdateOurStories')}}" accept-charset="UTF-8" method="post">
        <div class="col-xs-12 col-sm-6 col-main-lang">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('Our Stories information')}}</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <button type="button" class="btn btn-primary" id="btn-no-trans">{{__('No translate')}}</button>
                            <button type="button" class="btn btn-primary hidden" id="btn-trans">{{__('Translate')}}</button>
                            <input type="hidden" id="trans-status" name="will_trans" value="1"/>
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
                                <label for="title">{{__('Title')}}</label>
                                <input type="hidden" name="id" id="id" value="{{$data['mode'] == 'I' ? 0 : $data['vi']->id}}" />
                                <input type="hidden" name="vi[lang]" id="lang" value="vi" />
                                <input type="text" class="form-control" name="vi[title]" id="title" value="{{$data['mode'] == 'I' ? '' : $data['vi']->title}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Description')}}</label>
                                <input type="hidden" name="description" id="description" value="{{$data['mode'] == 'I' ? 0 : $data['vi']->description}}" />
                                <input type="hidden" name="vi[lang]" id="lang" value="vi" />
                                <input type="text" class="form-control" name="vi[description]" id="title" value="{{$data['mode'] == 'I' ? '' : $data['vi']->description}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="link">URL</label>
                                <input type="text" class="form-control" name="vi[url]" id="url" value="{{$data['mode'] == 'I' ? '' : $data['vi']->url}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group div-upload-img">
                                <label for="logo">{{__('Logo')}} (1920 x 1080px) <span class="text-required">*</span></label>
                                <div class="div-review-img">
                                    <img class="img-preview" src="{{$data['mode'] == 'I' ? '' : $data['vi']->logo}}" style="max-width: 250px;" />
                                    <input class="img-size" type="hidden" min-of-width="1920" min-rate="1.7" max-rate="1.8">
                                </div>
                                <div class="input-group">
                                    <input class="form-control filename" name="vi[image]" id="image" readonly="readonly" value="{{$data['mode'] == 'I' ? '' : $data['vi']->logo}}" />
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary">
                                            <i class="fa fa-upload" aria-hidden="true"></i>
                                        </button>
                                        <input type="file" class="file fileImg" name="vi[logo]" id="logo" />
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="show_chk" @if($data['mode'] == 'I' ||  $data['vi']->show)checked="checked"@endif value="1">
                                </div>
                                <label for="show_chk" class="lbl-show">{{__('Show')}}</label>
                                <input type="hidden" id="show" name="vi[show]" {{$data['mode'] == 'I' || $data['vi']->show ? 1 : 0}} value="1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-trans">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('Translate content')}}</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <select class="form-control cmb-trans" name="trans[lang]" id="trans_lang">
                                @foreach($languages as $key => $langCode)
                                    <option value="{{$langCode->code}}">{{$langCode->name}}</option>
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
                                <label for="trans_title">{{__('Title')}}</label>
                                <input type="text" class="form-control" name="trans[title]" id="trans_title" value="{{$data['mode'] == 'I' ? '' : $data['trans']->title}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_description">{{__('Description')}}</label>
                                <input type="text"class="form-control" name="trans[description]" id="trans_description" value="{{$data['mode'] == 'I' ? '' : $data['trans']->description}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_url">URL</label>
                                <input type="text" class="form-control" name="trans[url]" id="trans_url" value="{{$data['mode'] == 'I' ? '' : $data['trans']->url}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-xs-12">
                            <div class="form-group div-upload-img">
                                <label for="trans_logo">{{__('logo')}} (1920 x 1080px) <span class="text-required">*</span></label>
                                <div class="div-review-img">
                                    <img class="img-preview" src="{{$data['mode'] == 'I' ? '' : $data['trans']->logo}}" style="max-width: 250px;" />
                                    <input class="img-size" type="hidden" min-of-width="1920" min-rate="1.7" max-rate="1.8">
                                </div>
                                <div class="input-group">
                                    <input class="form-control filename" name="trans[image]" id="trans_image" readonly="readonly" value="{{$data['mode'] == 'I' ? '' : $data['trans']->logo}}" />
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary">
                                            <i class="fa fa-upload" aria-hidden="true"></i>
                                        </button>
                                        <input type="file" class="file fileImg" name="trans[logo]" id="trans_logo" />
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
                            <input type="button" class="btn btn-primary" id="btn-save-stories" value="{{__('Save')}}" />
                            @if ($data['mode'] != 'I')
                                <input type="button" class="btn btn-danger" id="btn-delete-stories" value="{{__('Delete')}}" />
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
