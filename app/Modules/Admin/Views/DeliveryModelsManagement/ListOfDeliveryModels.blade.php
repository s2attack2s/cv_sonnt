@extends('LayoutAdmin')

@section('title',  __('List of DeliveryModels'))

@section('css')
    <link rel="stylesheet" href="/css/admin/delivery-modal-management/list-of-delivery-modal.css" type="text/css" media="all"/>
@stop

@section('scripts')
    <script>
        var url = {
            listOfDeliveryModels: '{{route("ListOfDeliveryModels")}}'
        }
    </script>

@stop

@section('body')
<div class="row">
    <!-- start of weather widget -->

    <div class="col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>{{__('DeliveryModels')}}</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" id="div-table-delivery_model">
                @include('Admin::DeliveryModelsManagement.TableDeliveryModel')
            </div>
        </div>
    </div>
</div>
@stop
