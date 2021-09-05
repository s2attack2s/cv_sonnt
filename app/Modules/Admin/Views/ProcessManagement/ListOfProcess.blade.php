@extends('LayoutAdmin')

@section('title',  __('List of Process'))

@section('css')
    <link rel="stylesheet" href="/css/admin/process-management/list-of-process.css" type="text/css" media="all"/>
@stop

@section('scripts')
    <script>
        var url = {
            listOfProcess: '{{route("ListOfProcess")}}',
            updateStatus: '{{route("UpdateStatusOfProcess")}}'
        }
    </script>
    <script src="/js/admin/process-management/list-of-process.js" type="text/javascript"></script>
@stop

@section('body')
<div class="row">
    <!-- start of weather widget -->
    <div class="col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>{{__('Search Condition')}}</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" id="condition-search">
                <form class="form-horizontal input_mask" id="form-search" action="" accept-charset="UTF-8" method="get">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="search">{{__('Title')}}</label>
                                <input class="form-control" name="search" id="search" value="{{$condition['search'] ?? ''}}" placeholder="{{__('Input value to search')}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="button" class="btn btn-primary" id="btn-search" link-search="{{route("ListOfProcess")}}">{{__('Search')}}</button>
                        </div>
                        <input type="hidden" name="current_page" id="current_page" value="{{$data['current_page']}}" />
                        <input type="hidden" name="per_page" id="per_page" value="{{$data['per_page']}}" />
                    </div>                   
                </form>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>{{__('List of process')}}</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" id="div-table-slides">
                @include('Admin::ProcessManagement.TableProcess')
            </div>
        </div>
    </div>
</div>
@stop