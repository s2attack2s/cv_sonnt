@include('LayoutAdmin.PageInfo', [
'per_page' => $data['per_page'],
'total' => $data['total'],
'from' => $data['from'],
'to' => $data['to']
])
<div class="table-result" id="table-result" link-del='{{route("DeleteUsers")}}'>
    <div class="table-responsive">
        <table class="table table-striped table-bordered jambo_table">
            <thead>
                <tr>
                    <th class="text-center col-checkbox max-50">
                        <div class="custom-checkbox">
                            <input type="checkbox" id="check-all" class="check-all">
                        </div>
                    </th>
                    <th class="text-center max-50">{{__('Edit')}}</th>
                    <th class="text-center col-username">{{__('Username')}}</th>
                    <th class="text-center col-name">{{__('Name')}}</th>
                    <th class="text-center col-address">{{__('Address')}}</th>
                    <th class="text-center col-email">{{__('Email')}}</th>
                    <th class="text-center col-phone">{{__('Phone')}}</th>
                    <th class="text-center col-password">{{__('Reset Password')}}</th>
                    <th class="text-center max-50">{{__('Del')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['data'] as $key => $user)
                <tr>
                    <td class="text-center middle col-checkbox max-50">
                        <div class="custom-checkbox">
                            <input type="checkbox" class="check-item check-delete" name="check-remove" id-del="{{$user->id}}">
                        </div>
                    </td>
                    <td class="text-center middle max-50">
                        <a href='{{route('EditUser', ['id' => $user->id])}}'>
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>
                    </td>
                    <td class="col-text">
                        <a href="{{$user->username}}" target="_blank">{{$user->username}}</a>
                    </td>
                    <td class="col-text">{{$user->name}}</td>
                    <td class="col-text">{{$user->address}}</td>
                    <td class="col-text">{{$user->email}}</td>
                    <td class="col-text">{{$user->phone}}</td>
                    <td class="col-text  text-center">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">Reset</button>
                        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Reset Passwod</h3>
        </button>
      </div>
                                    <div class="modal-body">
                                        <h4>Do you want to reset your password?</h4>
                                        <form action="{{ route('ResetPassword') }}" id="form-reset" method="post" class="resign_form">
                                            @csrf
                                            <div class="form-group">
                                                <input type="hidden" name="id" class="form-control" value="{{$user->id}}">
                                                <input type="hidden" name="username" class="form-control" value="{{$user->username}}">
                                                <input type="hidden" name="password" class="form-control" value="{{$user->password}}">
                                                <input type="hidden" name="email" class="form-control" value="{{$user->email}}">
                                                <input type="hidden" name="name" class="form-control" value="{{$user->name}}">
                                                <input type="hidden" name="address" class="form-control" value="{{$user->address}}">
                                                <input type="hidden" name="phone" class="form-control" value="{{$user->phone}}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                                                <button type="button" class="btn btn-primary" id="btn-reset-password">{{__('Submit')}}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="text-center middle max-50">
                        <button type="button" class="btn btn-xs btn-danger btn-delete" id-del="{{$user->id}}">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-xs-12 pl-0 pr-0">
        <div class="div-pagination">
            <ul class="pagination"></ul>
        </div>
    </div>
    <div class="col-xs-12 pl-0 pr-0">
        <button type="button" class="btn btn-danger btn-delete-selected">{{__('Delete seleted')}}</button>
    </div>
</div>
<input type="hidden" id="total_pages" name="total_pages" value="{{$data['last_page']}}" />