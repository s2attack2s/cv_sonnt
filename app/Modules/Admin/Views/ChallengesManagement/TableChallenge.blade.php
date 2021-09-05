@include('LayoutAdmin.PageInfo', [
    'per_page' => $data['per_page'],
    'total' => $data['total'],
    'from' => $data['from'],
    'to' => $data['to']
])
<div class="table-result" id="table-result" link-del='{{route("DeleteChallenges")}}'>
    <div class="table-responsive">
        <table class="table table-striped table-bordered jambo_table">
            <thead>
                <tr>
                    <th class="text-center col-checkbox max-50">
                        <div class="custom-checkbox">
                            <input type="checkbox" id="check-all" class="check-all">
                        </div>
                    </th>
                    <th class="text-center col-text">{{__('Full Name')}}</th>
                    <th class="text-center col-text">{{__('Email')}}</th>
                    <th class="text-center col-text">{{__('Phone Number')}}</th>
                    <th class="text-center col-text">{{__('Company Name')}}</th>
                    <th class="text-center col-text">{{__('Bussiness Industry')}}</th>
                    <th class="text-center col-text">{{__('Bussiness Idea')}}</th>
                    <th class="text-center col-text">{{__('Status')}}</th>
                    <th class="text-center max-50">{{__('Del')}}</th>

                </tr>
            </thead>
            <tbody>
                @foreach($data['data'] as $key => $challenge)
                    <tr>
                        <td class="text-center middle col-checkbox max-50">
                            <div class="custom-checkbox">
                                <input type="checkbox" class="check-item check-delete" name="check-remove" id-del="{{$challenge->id}}">
                            </div>
                        </td>
                        <td class="text-center col-text">{{$challenge->fullname}}</td>
                        <td class="text-center col-text">{{$challenge->email}}</td>
                        <td class="text-center col-text">{{$challenge->phone}}</td>
                        <td class="text-center col-text">{{$challenge->company}}</td>
                        <td class="text-center col-text">{{$challenge->industry}}</td>
                        <td class="text-center col-text">{{$challenge->content}}</td>
                        <td class="text-center col-text">
                            <select name="status" id="" class="select-status">
                                @foreach($combobox as $item)
                                    <option value="{{$item->id}}" @if($item->id == $challenge->status)selected="selected" @endif id-challenge="{{$challenge->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        
                        <td class="text-center middle max-50">
                            <button type="button" class="btn btn-xs btn-danger btn-delete-challenges" id-del="{{$challenge->id}}">
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
        <button type="button" class="btn btn-danger btn-delete-selected-challenges">{{__('Delete seleted')}}</button>
    </div>
</div>
<input type="hidden" id="total_pages" name="total_pages" value="{{$data['last_page']}}" />
