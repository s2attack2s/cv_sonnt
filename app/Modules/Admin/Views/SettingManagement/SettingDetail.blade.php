@extends('LayoutAdmin')

@section('title', __('Edit setting'))

@section('css')
<link rel="stylesheet" href="/css/admin/setting-management/setting-detail.css" type="text/css" media="all" />
@stop

@section('scripts')
<script>
    var url = {
        editSetting: '{{route("EditSetting")}}'
    }
</script>
<script src="/js/admin/setting-management/setting-detail.js" type="text/javascript"></script>
@stop

@section('body')
<div class="row">
    <form class="form-horizontal input_mask" id="form-setting" enctype="multipart/form-data" action="{{route('UpdateSetting')}}" accept-charset="UTF-8" method="post">
        <div class="col-xs-12 col-sm-6 col-main-lang">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('Base setting information')}}</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <button type="button" class="btn btn-primary" id="btn-no-trans">{{__('No translate')}}</button>
                            <button type="button" class="btn btn-primary hidden" id="btn-trans">{{__('Translate')}}</button>
                            <input type="hidden" id="trans-status" name="will_trans" value="1" />
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
                                <label for="text">{{__('About us')}}</label>
                                <input type="text" class="form-control" name="vi[about_us]" id="about_us" value="{{$data['vi']->about_us}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Stories')}}</label>
                                <input type="text" class="form-control" name="vi[stories]" id="stories" value="{{$data['vi']->stories}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Process')}}</label>
                                <input type="text" class="form-control" name="vi[process]" id="process" value="{{$data['vi']->process}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group div-upload-img">
                                <label for="img">{{__('Image')}} (1920 x 1080px) <span class="text-required">*</span></label>
                                <div class="div-review-img">
                                    <img class="img-preview" src="{{$data['vi']->about_us_img}}" style="max-width: 250px;" />
                                    <input class="img-size" type="hidden" min-of-width="1920" min-rate="1.7" max-rate="1.8">
                                </div>
                                <div class="input-group">
                                    <input class="form-control filename" name="vi[image]" id="image" readonly="readonly" value="{{$data['vi']->about_us_img}}" />
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary">
                                            <i class="fa fa-upload" aria-hidden="true"></i>
                                        </button>
                                        <input type="file" class="file fileImg" name="vi[about_us_img]" id="about_us_img" />
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Description')}}</label>
                                <input type="text" class="form-control" name="vi[description]" id="description" value="{{$data['vi']->description}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Keyword')}}</label>
                                <input type="text" class="form-control" name="vi[keyword]" id="keyword" value="{{$data['vi']->keyword}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Author')}}</label>
                                <input type="text" class="form-control" name="vi[author]" id="author" value="{{$data['vi']->author}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Phone')}}</label>
                                <input type="text" class="form-control number-only required" name="vi[phone]" id="phone" value="{{$data['vi']->phone}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Address')}}</label>
                                <input type="text" class="form-control" name="vi[address]" id="address" value="{{$data['vi']->address}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Facebook')}}</label>
                                <input type="hidden" name="id" id="id" value="{{$data['vi']->id}}" />
                                <input type="hidden" name="vi[lang]" id="lang" value="vi" />
                                <input type="text" class="form-control" name="vi[facebook]" id="facebook" value="{{$data['vi']->facebook}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('LinkedIn')}}</label>
                                <input type="text" class="form-control" name="vi[linkedin]" id="linkedin" value="{{$data['vi']->linkedin}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Email')}}</label>
                                <input type="text" class="form-control" name="vi[email]" id="email" value="{{$data['vi']->email}}" />
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
                                <label for="text">{{__('About us')}}</label>
                                <input type="text" class="form-control" name="trans[about_us]" id="trans_about_us" value="{{$data['trans']->about_us}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Stories')}}</label>
                                <input type="text" class="form-control" name="trans[stories]" id="trans_stories" value="{{$data['trans']->stories}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Process')}}</label>
                                <input type="text" class="form-control" name="trans[process]" id="trans_process" value="{{$data['trans']->process}}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group div-upload-img">
                            <label for="trans_img">{{__('Image')}} (1920 x 1080px) <span class="text-required">*</span></label>
                            <div class="div-review-img">
                                <img class="img-preview" src="{{$data['trans']->about_us_img}}" style="max-width: 250px;" />
                                <input class="img-size" type="hidden" min-of-width="1920" min-rate="1.7" max-rate="1.8">
                            </div>
                            <div class="input-group">
                                <input class="form-control filename" name="trans[image]" id="trans_image" readonly="readonly" value="{{$data['trans']->about_us_img}}" />
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fa fa-upload" aria-hidden="true"></i>
                                    </button>
                                    <input type="file" class="file fileImg" name="trans[about_us_img]" id="trans_about_us_img" />
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Description')}}</label>
                                <input type="text" class="form-control" name="trans[description]" id="trans_description" value="{{$data['trans']->description}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Keyword')}}</label>
                                <input type="text" class="form-control" name="trans[keyword]" id="trans_keyword" value="{{$data['trans']->keyword}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Author')}}</label>
                                <input type="text" class="form-control" name="trans[author]" id="trans_author" value="{{$data['trans']->author}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Phone')}}</label>
                                <input type="text" class="form-control number-only required" name="trans[phone]" id="trans_phone" value="{{$data['trans']->phone}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Address')}}</label>
                                <input type="text" class="form-control" name="trans[address]" id="trans_address" value="{{$data['trans']->address}}" />
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
                        <input type="button" class="btn btn-primary" id="btn-save-setting" value="{{__('Save')}}" />
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
</div>
@stop