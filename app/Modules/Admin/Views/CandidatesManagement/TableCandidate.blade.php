@include('LayoutAdmin.PageInfo', [
    'per_page' => $data['per_page'],
    'total' => $data['total'],
    'from' => $data['from'],
    'to' => $data['to']
])
<div class="table-result" id="table-result" link-del='{{route("DeleteCandidates")}}'>
    <div class="table-responsive">
        <table class="table table-striped table-bordered jambo_table">
            <thead>
                <tr>
                    <th class="text-center col-checkbox max-50">
                        <div class="custom-checkbox">
                            <input type="checkbox" id="check-all" class="check-all">
                        </div>
                    </th>
                    <th class="text-center max-50">{{__('View')}}</th>
                    <th class="text-center col-img">{{__('Name')}}</th>
                    <th class="text-center col-text">{{__('Email')}}</th>
                    <th class="text-center">{{__('Phone')}}</th>
                    <th class="text-center">{{__('Job')}}</th>
                    <th class="text-center">{{__('Status')}}</th>
                    <th class="text-center max-100">{{__('CV')}}</th>
                    <th class="text-center max-50">{{__('Delete')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['data'] as $key => $candidate)
                    <tr>
                        <td class="text-center middle col-checkbox max-50">
                            <div class="custom-checkbox">
                                <input type="checkbox" class="check-item check-delete" name="check-remove" id-del="{{$candidate->id}}">
                            </div>
                        </td>
                        <td class="text-center middle max-50">
                            <a href='{{route('ViewCandidate', ['id' => $candidate->id])}}'>
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                        </td>
                        <td class="col-text">{{$candidate->name}}</td>
                        <td class="col-text">{{$candidate->email}}</td>
                        <td class="col-text">{{$candidate->phone}}</td>

                        <td align="center" class="col-text center">
                            <a href='{{route('EditCareer', ['id' => $candidate->career_id])}}'>
                                {{$candidate->career_name}}
                            </a>
                        </td>
                        <td class="col-text"><span class="label label-{{$candidate->status==1?'primary': ($candidate->status==2?'warning':'info')}}">{{$status[$candidate->status]}}</span></td>
                        <td align="center" class="col-text center max-50">
                            @if (isset($candidate->cv_file))
                            <a href="{{$candidate->cv_file}}" target="_blank"><i class="fa fa-download" aria-hidden="true"></i> CV</a>
                            @endif
                        </td>
                        <td class="text-center middle max-50">
                            <button type="button" class="btn btn-xs btn-danger btn-delete" id-del="{{$candidate->id}}">
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
