@extends('LayoutAdmin')

@section('title',  __('List of ContractTypes'))

@section('scripts')
    <script>
        var url = {
            listOfContractTypeDetails: '{{route("ListOfContractTypeDetails", ['id' => $data['info']->id])}}'
        }
    </script>

@stop

@section('body')
<div class="row">
    <!-- start of weather widget -->

    <div class="col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>{{__('ContractTypeDetails')}}</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" id="div-table-delivery_model">
                <div class="row">
                    <div class="col-6">
                        <p><strong>Contact Type:</strong> {{$data['info']->title}}</p>
                        <p><strong>Language:</strong>  {{$languages[$data['info']->language_id]}}</p>
                    </div>
                </div>
                @include('Admin::ContractTypesManagement.TableContractTypeDetail')
                <div class="clearfix">&nbsp;</div>
                <div class="row">
                    <div class="col-12">
                        <a class="btn btn-secondary" href="{{route('ListOfContractTypes')}}">{{__('Back To List Contract Type')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
