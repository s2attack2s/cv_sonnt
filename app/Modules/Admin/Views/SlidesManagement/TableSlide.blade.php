@include('LayoutAdmin.PageInfo', [
    'per_page' => $data['per_page'],
    'total' => $data['total'],
    'from' => $data['from'],
    'to' => $data['to']
])
<div class="table-result" id="table-result" link-del='{{route("DeleteSlides")}}'>
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
                    <th class="text-center col-text">{{__('Title')}}</th>
                    <th class="text-center col-link">{{__('Link')}}</th>
                    <th class="text-center max-50 col-show">{{__('Show')}}</th>
                    <th class="text-center max-50">{{__('Del')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['data'] as $key => $slide)
                    <tr>
                        <td class="text-center middle col-checkbox max-50">
                            <div class="custom-checkbox">
                                <input type="checkbox" class="check-item check-delete" name="check-remove" id-del="{{$slide->id}}">
                            </div>
                        </td>
                        <td class="text-center middle max-50">
                            <a href='{{route('EditSlide', ['id' => $slide->id])}}'>
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                        </td>
                        <td class="text-center col-img">
                            <img src="{{$slide->img}}" alt="{{$slide->text}}" height="80" />
                        </td>
                        <td class="col-text">{{$slide->text}}</td>
                        <td class="col-link">
                            <a href="{{$slide->link}}" target="_blank">{{$slide->link}}</a>
                        </td>
                        <td class="text-center middle max-50 col-show">
                            <div class="custom-checkbox">
                                <input type="checkbox" class="check-show" name="check-show" @if($slide->show)checked="checked"@endif id-slide="{{$slide->id}}">
                            </div>
                        </td>
                        <td class="text-center middle max-50">
                            <button type="button" class="btn btn-xs btn-danger btn-delete" id-del="{{$slide->id}}">
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
