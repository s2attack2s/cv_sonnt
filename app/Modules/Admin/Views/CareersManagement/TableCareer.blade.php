@include('LayoutAdmin.PageInfo', [
    'per_page' => $data['per_page'],
    'total' => $data['total'],
    'from' => $data['from'],
    'to' => $data['to']
])
<div class="table-result" id="table-result" link-del='{{route("DeleteCareers")}}'>
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
                    <th class="text-center col-img">{{__('Image')}}</th>
                    <th class="text-center col-text">{{__('Name')}}</th>
                    <th class="text-center col-text">{{__('Status')}}</th>
                    <th class="text-center">{{__('Location')}}</th>
                    <th class="text-center">{{__('Lang')}}</th>
                    <th class="text-center max-50">{{__('Delete')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['data'] as $key => $career)
                    <tr>
                        <td class="text-center middle col-checkbox max-50">
                            <div class="custom-checkbox">
                                <input type="checkbox" class="check-item check-delete" name="check-remove" id-del="{{$career->id}}">
                            </div>
                        </td>
                        <td class="text-center middle max-50">
                            <a href='{{route('EditCareer', ['id' => $career->id])}}'>
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                        </td>
                        <td class="text-center col-img">
                            <img src="{{$career->image}}" alt="{{$career->name}}" height="80" />
                        </td>
                        <td class="col-text">{{$career->name}}</td>
                        <td class="text-center middle max-50 col-show">
                            <span class="label label-default">{{$statuses[$career->status]}}</span>
{{--                            <div class="custom-checkbox">--}}
{{--                                <input type="checkbox" class="check-show"  name="check-status" @if($career->status)checked="checked"@endif id-career="{{$career->id}}">--}}
{{--                            </div>--}}
                        </td>
                        <td class="text-center middle max-50 col-show">
                            {{$career->location_name}}
                        </td>
                        <td class="text-center middle max-50 col-show">
                            {{isset($career->language_id)?$languages[$career->language_id]:''}}
                        </td>

                        <td class="text-center middle max-50">
                            <button type="button" class="btn btn-xs btn-danger btn-delete" id-del="{{$career->id}}">
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
        <button type="button" class="btn btn-danger btn-delete-selected">{{__('Delete Selected')}}</button>
    </div>
</div>
<input type="hidden" id="total_pages" name="total_pages" value="{{$data['last_page']}}" />
