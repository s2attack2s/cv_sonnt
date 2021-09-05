@extends('LayoutAdmin')

@section('title',  __('List of Locations'))

@section('css')
    <link rel="stylesheet" href="/css/admin/location-management/list-of-location.css" type="text/css" media="all"/>
@stop

@section('scripts')
    <script>
        var url = {
            listOfLocations: '{{route("ListOfLocations")}}'
        }
    </script>
    <script src="/js/admin/location-management/list-of-locations.js" type="text/javascript"></script>
@stop

@section('body')
<div class="row">
    <!-- start of weather widget -->

    <div class="col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>{{__('Locations')}}</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" id="div-table-location">
                @include('Admin::LocationsManagement.TableLocation')
            </div>
        </div>
    </div>
</div>
@stop
