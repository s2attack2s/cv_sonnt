
<div class="table-result" id="table-result" >
    <div class="table-responsive">
        <table class="table table-striped table-bordered jambo_table">
            <thead>
                <tr>
                    <th class="text-center max-50">{{__('Edit')}}</th>
                    <th class="text-center col-text">{{__('Name')}}</th>
                    <th class="text-center col-text">{{__('Fix Price')}}</th>
                    <th class="text-center col-text">{{__('Time Material')}}</th>
                    <th class="text-center col-text">{{__('Dedicated Team')}}</th>
                </tr>
            </thead>
            <tbody>

                @foreach($data['detail'] as $key => $contract_type)
                    <tr>
                        <td class="text-center middle max-50">
                            <a href='{{route('EditContractTypeDetail', ['id' => $contract_type->id])}}'>
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                        </td>

                        <td class="col-text">{{$contract_type->item_name}}</td>
                        <td class="col-text">{{$contract_type->fix_price}}</td>
                        <td class="col-text">{{$contract_type->time_materials}}</td>
                        <td class="col-text">{{$contract_type->dedicated_team}}</td>


                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
