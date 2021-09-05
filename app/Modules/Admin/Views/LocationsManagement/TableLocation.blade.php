
<div class="table-result" id="table-result" >
    <div class="table-responsive">
        <table class="table table-striped table-bordered jambo_table">
            <thead>
                <tr>

                    <th class="text-center max-50">{{__('Edit')}}</th>
                    <th class="text-center col-img">{{__('Image')}}</th>
                    <th class="text-center col-text">{{__('Name')}}</th>
                    <th class="text-center">{{__('Language')}}</th>
                    <th class="text-center">{{__('Phone')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $location)
                    <tr>
                        <td class="text-center middle max-50">
                            <a href='{{route('EditLocation', ['id' => $location->id])}}'>
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                        </td>
                        <td class="text-center col-img">
                            <img src="{{$location->image}}" alt="{{$location->name}}" height="80" />
                        </td>
                        <td class="col-text">{{$location->name}}</td>
                        <td class="col-text text-center">{{$languages[$location->language_id]}}</td>
                        <td class="col-text">{{$location->phone}}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
