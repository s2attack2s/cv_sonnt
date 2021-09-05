@extends('LayoutAdmin')

@section('title',  !$data ? __('Create Candidate') : __('Edit Candidate'))

@section('css')
    <link rel="stylesheet" href="/css/admin/candidate-management/candidate-detail.css" type="text/css" media="all"/>
@stop

@section('scripts')
    <script>
        var url = {
            listOfCandidates: '{{route("ListOfCandidates")}}',
            deleteCandidate:  '{{route("DeleteCandidates")}}',
            approveCandidate:  '{{route("ApproveCandidate")}}',
            rejectCandidate:  '{{route("RejectCandidate")}}'
        }
    </script>
    <script src="/js/admin/candidate-management/candidate-detail.js?v=1" type="text/javascript"></script>
@stop

@section('body')
<div class="row">

    <form class="form-horizontal input_mask" id="form-candidate" enctype="multipart/form-data" action="{{route('UpdateCandidate')}}" accept-charset="UTF-8" method="post">
        <input type="hidden" name="id" id="id" value="{{!isset($data) ? 0 : $data->id}}" />

        <div class="col-xs-12 col-sm-12 ">
            <div class="x_panel">

                @php
                    $lblCls = 'primary';
                switch ($data->status){
                     case 0:
                         $lblCls = 'primary';
                        break;
                    case 1:
                         $lblCls = 'success';
                        break;
                    case 2:
                         $lblCls = 'danger';
                        break;
                    default:
                        $lblCls = 'default';
                }
                @endphp
                <h2>Candidate Information <span class="label label-{{$lblCls}}">{{$status[$data->status]}}</span></h2>

                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="trans_text">{{__('Name')}}</label>
                                <input type="text" readonly class="form-control" name="name" id="name" value="{{isset($data)?$data->name:''}}" />

                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="trans_text">{{__('Phone')}}</label>
                                <input type="text" readonly class="form-control" name="name" id="name" value="{{isset($data)?$data->phone:''}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="trans_text">{{__('Email')}}</label>
                                <input type="text" readonly  class="form-control" name="name" id="name" value="{{isset($data)?$data->email:''}}" />
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="trans_text">{{__('Apply Job')}}</label>
                                <input type="text" readonly  class="form-control" name="name" id="name" value="{{isset($data)?$data->career_name:''}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <label for="trans_text">{{__('message.title')}}</label>
                            <textarea class="form-control" disabled rows="10">{{$data->message}}</textarea>
                        </div>
                    </div>
                    <div class="clearfix">&nbsp;</div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <p><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp; Applied Date <span style="color: blue">{{$data->created_at}}</span></p>

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
                            @if (isset($data->cv_file))
                            <button type="button" class="btn btn-primary"  onclick="window.location.href='{{$data->cv_file}}'" >
                                    <i class="fa fa-download" aria-hidden="true"></i> {{__('Download CV')}}
                            </button>
                            @endif
                            @if ($data->status != 1)
                            <button type="button" class="btn btn-success btn-approve" id="btn-approve-candidate" id="{{$data->id}}">

                                <i class="fa fa-check" aria-hidden="true"></i> {{__('Approve')}}

                            </button>
                            @endif
                            @if ($data->status != 2)
                                <button type="button" class="btn btn-warning btn-approve" id="btn-reject-candidate" id="{{$data->id}}">

                                    <i class="fa fa-check" aria-hidden="true"></i> {{__('Reject')}}

                                </button>
                            @endif
                            <button type="button" class="btn btn-danger btn-del" id="btn-delete-candidate" id-del="{{$data->id}}">

                                <i class="fa fa-trash" aria-hidden="true"></i> {{__('Delete')}}

                            </button>
                            <a class="btn btn-secondary right" href="{{route('ListOfCandidates')}}">Back to List Candidates</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop
