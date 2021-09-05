@extends('LayoutAdmin')

@section('title',  $data['mode'] == 'I' ? __('Create slide') : __('Edit slide'))

@section('css')
    <link rel="stylesheet" href="/css/admin/slides-management/slide-detail.css" type="text/css" media="all"/>
@stop

@section('scripts')
    <script>
        var url = {
            deleteSlide:  '{{route("DeleteSlides")}}',
            createSlide:  '{{route("CreateSlide")}}',
            editSlide:    '{{route("EditSlide", ["id" => 0])}}'
        }
        var mode = '{{$data['mode']}}';
    </script>
    <script src="/js/admin/slides-management/slide-detail.js?v=3" type="text/javascript"></script>
@stop

@section('body')
<div class="row">
    <form class="form-horizontal input_mask" id="form-slide" enctype="multipart/form-data" action="{{$data['mode'] == 'I' ? route('InsertSlide') : route('UpdateSlide')}}" accept-charset="UTF-8" method="post">
        <div class="col-xs-12 col-sm-6 col-main-lang">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('Slide information')}}</h2>
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
                                <label for="text">{{__('Title')}}</label>
                                <input type="hidden" name="id" id="id" value="{{$data['mode'] == 'I' ? 0 : $data['vi']->id}}" />
                                <input type="hidden" name="vi[lang]" id="lang" value="vi" />
                                <input type="text" class="form-control" name="vi[text]" id="text" value="{{$data['mode'] == 'I' ? '' : $data['vi']->text}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="link">Link</label>
                                <input type="text" class="form-control" name="vi[link]" id="link" value="{{$data['mode'] == 'I' ? '' : $data['vi']->link}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group div-upload-img">
                                <label for="img">{{__('Image')}} (1920 x 1080px) <span class="text-required">*</span></label>
                                <div class="div-review-img">
                                    <img class="img-preview" src="{{$data['mode'] == 'I' ? '' : $data['vi']->img}}" style="max-width: 250px;" />
                                    <input class="img-size" type="hidden" min-of-width="1920" min-rate="1.7" max-rate="1.8">
                                </div>
                                <div class="input-group">
                                    <input class="form-control filename" name="vi[image]" id="image" readonly="readonly" value="{{$data['mode'] == 'I' ? '' : $data['vi']->img}}" />
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary">
                                            <i class="fa fa-upload" aria-hidden="true"></i>
                                        </button>
                                        <input type="file" class="file fileImg" name="vi[img]" id="img" />
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
                                <label for="trans_text">{{__('Title')}}</label>
                                <input type="text" class="form-control" name="trans[text]" id="trans_text" value="{{$data['mode'] == 'I' ? '' : $data['trans']->text}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_link">Link</label>
                                <input type="text" class="form-control" name="trans[link]" id="trans_link" value="{{$data['mode'] == 'I' ? '' : $data['trans']->link}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-xs-12">
                            <div class="form-group div-upload-img">
                                <label for="trans_img">{{__('Image')}} (1920 x 1080px) <span class="text-required">*</span></label>
                                <div class="div-review-img">
                                    <img class="img-preview" src="{{$data['mode'] == 'I' ? '' : $data['trans']->img}}" style="max-width: 250px;" />
                                    <input class="img-size" type="hidden" min-of-width="1920" min-rate="1.7" max-rate="1.8">
                                </div>
                                <div class="input-group">
                                    <input class="form-control filename" name="trans[image]" id="trans_image" readonly="readonly" value="{{$data['mode'] == 'I' ? '' : $data['trans']->img}}" />
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary">
                                            <i class="fa fa-upload" aria-hidden="true"></i>
                                        </button>
                                        <input type="file" class="file fileImg" name="trans[img]" id="trans_img" />
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
                            <input type="button" class="btn btn-primary" id="btn-save-slide" value="{{__('Save')}}" />
                            @if ($data['mode'] != 'I')
                                <input type="button" class="btn btn-danger" id="btn-delete-slide" value="{{__('Delete')}}" />
                            @endif
                        </div>
                    </div>
                </div>
                @if ($data['mode'] != 'I')
                    @include('LayoutAdmin.UpdateInfo', [
                        'created_by' => $data['vi']->created_by,
                        'created_at' => $data['vi']->created_at,
                        'updated_by' => $data['vi']->updated_by,
                        'updated_at' => $data['vi']->updated_at
                    ])
                @endif
            </div>
        </div>
    </div>
</div>
@stop
