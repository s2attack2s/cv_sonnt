@extends('LayoutAdmin')

@section('title',  $data['mode'] == 'I' ? __('Create user') : __('Edit user'))

@section('css')
    <link rel="stylesheet" href="/css/admin/users-management/user-detail.css" type="text/css" media="all"/>
@stop

@section('scripts')
<script>
        var url = {
            deleteUser:  '{{route("DeleteUsers")}}',
            createUser:  '{{route("CreateUser")}}',
            editUser:    '{{route("EditUser", ["id" => 0])}}'
        }
        var mode = '{{$data['mode']}}';
    </script>
    <script src="/js/admin/users-management/user-detail.js?v=3" type="text/javascript"></script>
@stop

@section('body')
<div class="row">
    <form class="form-horizontal input_mask" id="form-user" action="{{$data['mode'] == 'I' ? route('InsertUser') : route('UpdateUser')}}" accept-charset="UTF-8" method="post">
        <div class="col-xs-12 col-sm-12">
            <div class="x_panel"> 
                    <h2>{{__('User information')}}</h2>        
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="text">{{__('Username')}}</label>
                                <input type="hidden" name="id" id="id" value="{{$data['mode'] == 'I' ? '0' : $data['query']->id}}" />
                                <input type="text" id="username" name="username" class="form-control" value="{{$data['mode'] == 'I' ? '' : $data['query']->username}}" />
                            </div>
                        </div>
                    </div>
                    @if ($data['mode'] == 'I')              
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" />
                                
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{$data['mode'] == 'I' ? '' : $data['query']->name}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                        <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{$data['mode'] == 'I' ? '' : $data['query']->address}}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                        <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{$data['mode'] == 'I' ? '' : $data['query']->email}}"  />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                        <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control number-only"  id="phone" name="phone" value="{{$data['mode'] == 'I' ? '' : $data['query']->phone}}" />
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
                            <input type="button" class="btn btn-primary" id="btn-save-user" value="{{__('Save')}}" />
                            @if ($data['mode'] != 'I')
                                <input type="button" class="btn btn-danger" id="btn-delete-user" value="{{__('Delete')}}" />
                             
                                <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">Reset</button>
                                <div class="col-text  text-center">
                        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="exampleModalLongTitle">Reset password</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h4>Do you want to reset your password?</h4>
                                        <form action="{{ route('ResetPassword') }}" id="form-reset" method="post" class="resign_form">
                                            @csrf
                                            <div class="form-group">
                                                <input type="hidden" name="id" class="form-control" value="{{$data['mode'] == 'I' ? '0' : $data['query']->id}}">
                                                <input type="hidden" name="username" class="form-control" value="{{$data['mode'] == 'I' ? '0' : $data['query']->username}}">
                                                <input type="hidden" name="password" class="form-control" value="{{$data['mode'] == 'I' ? '0' : $data['query']->password}}">
                                                <input type="hidden" name="email" class="form-control" value="{{$data['mode'] == 'I' ? '0' : $data['query']->email}}">
                                                <input type="hidden" name="name" class="form-control" value="{{$data['mode'] == 'I' ? '0' : $data['query']->name}}">
                                                <input type="hidden" name="address" class="form-control" value="{{$data['mode'] == 'I' ? '0' : $data['query']->address}}">
                                                <input type="hidden" name="phone" class="form-control" value="{{$data['mode'] == 'I' ? '0' : $data['query']->phone}}">
                                            </div>
                                            <div class="form-group">
                                                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" id="btn-reset-password" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                             </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
