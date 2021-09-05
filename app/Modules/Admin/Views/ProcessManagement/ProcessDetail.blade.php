@extends('LayoutAdmin')

@section('title',  $data['mode'] == 'I' ? __('Create Process') : __('Edit Process'))

@section('css')
    <link rel="stylesheet" href="/css/admin/process-management/process-detail.css" type="text/css" media="all"/>
@stop

@section('scripts')
     <script>
        var url = {
            deleteProcess:  '{{route("DeleteProcess")}}',
            editProcess:    '{{route("EditProcess", ["id" => 0])}}'
        }
        var mode = '{{$data['mode']}}';
    </script>
    <script src="/js/admin/process-management/process-detail.js" type="text/javascript"></script>
@stop

@section('body')
<div class="row">
    <form class="form-horizontal input_mask" id="form-process" action="{{$data['mode'] == 'I' ? route('InsertProcess') : route('UpdateProcess')}}" accept-charset="UTF-8" method="post">
        <div class="col-xs-12 col-sm-6 col-main-lang">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{__('Process information')}}</h2>
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
                                <input type="text" class="form-control" name="vi[title]" id="title" value="{{$data['mode'] == 'I' ? '' : $data['vi']->title}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Description')}}</label>
                                <input type="text" class="form-control" name="vi[description]" id="description" value="{{$data['mode'] == 'I' ? '' : $data['vi']->description}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Content')}}</label>
                                <input type="text" class="form-control" name="vi[content]" id="content" value="{{$data['mode'] == 'I' ? '' : $data['vi']->content}}" />
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
                                <input type="text" class="form-control" name="trans[title]" id="trans_title" value="{{$data['mode'] == 'I' ? '' : $data['trans']->title}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Description')}}</label>
                                <input type="text" class="form-control" name="trans[description]" id="trans_description" value="{{$data['mode'] == 'I' ? '' : $data['trans']->description}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Content')}}</label>
                                <input type="text" class="form-control" name="trans[content]" id="trans_content" value="{{$data['mode'] == 'I' ? '' : $data['trans']->content}}" />
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
                            <input type="button" class="btn btn-primary" id="btn-save-process" value="{{__('Save')}}" />
                            @if ($data['mode'] != 'I')
                                <input type="button" class="btn btn-danger" id="btn-delete-process" value="{{__('Delete')}}" />
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