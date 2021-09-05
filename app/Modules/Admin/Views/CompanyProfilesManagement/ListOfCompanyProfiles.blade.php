@extends('LayoutAdmin')

@section('title',  __('List of CompanyProfiles'))

@section('css')
    <link rel="stylesheet" href="/css/admin/company-profile-management/list-of-company-profile.css" type="text/css" media="all"/>
@stop

@section('scripts')
    <script>
        var url = {
            listOfCompanyProfiles: '{{route("ListOfCompanyProfile")}}'
        }
    </script>
    <script src="/js/admin/company-profile-management/list-of-company-profiles.js" type="text/javascript"></script>
@stop

@section('body')
<div class="row">
    <!-- start of weather widget -->

    <div class="col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>{{__('Company Profile')}}</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" id="div-table-company-profile">
                @include('Admin::CompanyProfilesManagement.TableCompanyProfile')
            </div>
        </div>
    </div>
</div>
@stop
