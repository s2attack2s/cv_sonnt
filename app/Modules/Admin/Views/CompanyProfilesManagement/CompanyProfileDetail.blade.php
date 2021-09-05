@extends('LayoutAdmin')

@section('title',  !$data ? __('Create CompanyProfile') : __('Edit CompanyProfile'))


@section('scripts')
    <script>
        var url = {
            editCompanyProfile:    '{{route("EditCompanyProfile", ["id" => 0])}}'
        }
    </script>
    <script src="/js/admin/company-profile-management/company-profile-detail.js?v=3" type="text/javascript"></script>
@stop

@section('body')
<div class="row">
    <form class="form-horizontal input_mask" id="form-company-profile" enctype="multipart/form-data" action="{{route('UpdateCompanyProfile')}}" accept-charset="UTF-8" method="post">
        <input type="hidden" name="id" id="id" value="{{!isset($data) ? 0 : $data->id}}" />
        <div class="col-xs-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">


                </div>
                <div class="x_content">
                    <h2>{{__('Company Profile')}}</h2>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_text">{{__('Company Name')}}</label>
                                <input type="text" required class="form-control" name="company_name" id="company_name" value="{{isset($data)?$data->company_name:''}}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_text">{{__('Founded')}}</label>
                                <input type="text" required class="form-control" name="founded" id="address" value="{{isset($data)?$data->founded:''}}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_text">{{__('Tel')}}</label>
                                <input type="text" required class="form-control" name="tel" id="tel" value="{{isset($data)?$data->tel:''}}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_text">{{__('Capital')}}</label>
                                <input type="text" required class="form-control" name="capital" id="capital" value="{{isset($data)?$data->capital:''}}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_text">{{__('Main Bank')}}</label>
                                <input type="text" required class="form-control" name="main_bank" id="main_bank" value="{{isset($data)?$data->main_bank:''}}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="trans_text">{{__('CEO Name')}}</label>
                                <input type="text" required class="form-control" name="ceo_name" id="ceo_name" value="{{isset($data)?$data->ceo_name:''}}" />
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
                            <input type="button" class="btn btn-primary" id="btn-save-company-profile" value="{{__('Save')}}" />
                            <a class="btn btn-secondary" href="{{route('ListOfCompanyProfile')}}">{{__('Cancel')}}</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop
