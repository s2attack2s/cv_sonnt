@extends('LayoutAdmin')

@section('title',  __('List of Careers'))

@section('css')
    <link rel="stylesheet" href="/css/admin/career-management/list-of-career.css" type="text/css" media="all"/>
@stop

@section('scripts')
    <script>
        var url = {
            listOfCareers: '{{route("ListOfCareers")}}',
            updateStatus: '{{route("UpdateStatusOfCareers")}}'
        }
    </script>
    <script src="/js/admin/career-management/list-of-careers.js" type="text/javascript"></script>
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
                        <div class="col-6 col-lg-6 col-md-6">
                            <label for="search">{{__('Language')}}</label>
                            <select class="form-control " name="language_id" id="language_id">
                                <option value="">{{__('All Languages')}}</option>
                                @foreach($languages as $key => $lang)
                                    <option value="{{$key}}" {{$key==request('language_id')?'selected':''}}>{{$lang}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-lg-6 col-md-6">
                            <label for="search">{{__('Location')}}</label>
                            <select class="form-control " name="location_id" id="location_id">
                                <option value="">{{__('All Locations')}}</option>
                                @foreach($locations as $key => $val)
                                    <option value="{{$key}}" {{$key==request('location_id')?'selected':''}}>{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group col-12">
                                    <label for="search">{{__('Name')}}</label>
                                    <input class="form-control" name="search" id="search" value="{{$condition['search'] ?? ''}}" placeholder="{{__('Input value to search')}}" />
                           </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="button" class="btn btn-primary" id="btn-search" link-search="{{route("ListOfCareers")}}">{{__('Search')}}</button>
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
                <h2>{{__('List of careers')}}</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" id="div-table-career">
                @include('Admin::CareersManagement.TableCareer')
            </div>
        </div>
    </div>
</div>
@stop
