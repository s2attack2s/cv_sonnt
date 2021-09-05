@extends('LayoutAdmin')

@section('title',  !$data ? __('Create ContractType') : __('Edit ContractType'))

@section('css')
    <link rel="stylesheet" href="/css/admin/contract-type-management/contract-type-detail.css" type="text/css" media="all"/>
@stop

@section('scripts')
    <script>
        var url = {
            editContractType:    '{{route("EditContractType", ["id" => 0])}}'
        }
    </script>
    <script src="/js/admin/contract-type-management/contract-type-detail.js?v=1" type="text/javascript"></script>
@stop

@section('body')
<div class="row">
    <form class="form-horizontal input_mask" id="form-contract-type"  enctype="multipart/form-data" action="{{route('UpdateContractTypeDetail')}}" accept-charset="UTF-8" method="post">
        <input type="hidden" name="id" id="id" value="{{!isset($data) ? 0 : $data->id}}" />
        <div class="col-xs-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    &nbsp;
                </div>
                <div class="x_content">
                    <h2>{{__('Contract Type Detail')}}</h2>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_text">{{__('Title')}}</label>
                                <input type="text" required class="form-control" name="item_name" id="item_name" value="{{isset($data)?$data->item_name:''}}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_text">{{__('Fix Price')}}</label>
                                <input type="text" required class="form-control" name="fix_price" id="fix_price" value="{{isset($data)?$data->fix_price:''}}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_text">{{__('Time Material')}}</label>
                                <input type="text" required class="form-control" name="time_materials" id="time_materials" value="{{isset($data)?$data->time_materials:''}}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_text">{{__('Dedicated Team')}}</label>
                                <input type="text" required class="form-control" name="dedicated_team" id="dedicated_team" value="{{isset($data)?$data->dedicated_team:''}}" />
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
                            <a class="btn btn-secondary" href="{{route('ListOfContractTypeDetails', ['id' => $data->id])}}">{{__('Cancel')}}</a>
                         </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop
