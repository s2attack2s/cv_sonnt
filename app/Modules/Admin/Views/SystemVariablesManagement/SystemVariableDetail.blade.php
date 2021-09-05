@extends('LayoutAdmin')

@section('title',  !$data ? __('Create SystemVariable') : __('Edit SystemVariable'))

@section('css')
    <link rel="stylesheet" href="/css/admin/system-variable-management/system-variable-detail.css" type="text/css" media="all"/>
@stop

@section('scripts')
    <script>
        var url = {
            editSystemVariable:    '{{route("EditSystemVariable", ["id" => 0])}}'
        }
    </script>
    <script src="/js/admin/system-variable-management/system-variable-detail.js?v=3" type="text/javascript"></script>
@stop

@section('body')
<div class="row">
    <form class="form-horizontal input_mask" id="form-system-variable"  action="{{route('UpdateSystemVariable')}}" accept-charset="UTF-8" method="post">
        <input type="hidden" name="id" id="id" value="{{!isset($data) ? 0 : $data->id}}" />
        <div class="col-xs-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    &nbsp;
                </div>
                <div class="x_content">
                    <h2>{{__('SystemVariable')}}</h2>
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
                                <label for="trans_text">{{__('Key')}}</label>
                                <input type="text" readonly class="form-control" name="key" id="key" value="{{isset($data)?$data->key:''}}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_text">{{__('Value')}}</label>
{{--                                <input type="textarea" required class="form-control" name="value" id="value" value="{{isset($data)?$data->value:''}}" />--}}
                                    <textarea name="value" class="form-control" rows="10">{{$data->value}}</textarea>
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
                            <input type="button" class="btn btn-primary" id="btn-save-system-variable" value="{{__('Save')}}" />
                            <a class="btn btn-secondary" href="{{route('ListOfSystemVariables')}}">{{__('Cancel')}}</a>
                         </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop
