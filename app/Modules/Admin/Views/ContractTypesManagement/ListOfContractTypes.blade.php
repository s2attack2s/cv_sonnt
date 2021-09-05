@extends('LayoutAdmin')

@section('title',  __('List of ContractTypes'))



@section('scripts')
    <script>
        var url = {
            listOfContractTypes: '{{route("ListOfContractTypes")}}'
        }
    </script>

@stop

@section('body')
<div class="row">
    <!-- start of weather widget -->

    <div class="col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>{{__('ContractTypes')}}</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" id="div-table-delivery_model">
                @include('Admin::ContractTypesManagement.TableContractType')
            </div>
        </div>
    </div>
</div>
@stop
