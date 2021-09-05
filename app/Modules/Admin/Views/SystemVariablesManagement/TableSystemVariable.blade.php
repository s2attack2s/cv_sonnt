
<div class="table-result" id="table-result" >
    <div class="table-responsive">
        <table class="table table-striped table-bordered jambo_table">
            <thead>
                <tr>
                    <th class="text-center max-50">{{__('Edit')}}</th>
                    <th class="text-center col-text">{{__('Name')}}</th>
                    <th class="text-center col-text">{{__('Key')}}</th>
                    <th class="text-center col-text">{{__('Value')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $system_variable)
                    <tr>
                        <td class="text-center middle max-50">
                            <a href='{{route('EditSystemVariable', ['id' => $system_variable->id])}}'>
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                        </td>
                        <td class="col-text">{{$system_variable->name}}</td>
                        <td class="col-text">{{$system_variable->key}}</td>
                        <td class="col-text">{{$system_variable->value}}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
