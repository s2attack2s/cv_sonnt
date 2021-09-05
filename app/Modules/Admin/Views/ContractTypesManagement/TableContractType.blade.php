
<div class="table-result" id="table-result" >
    <div class="table-responsive">
        <table class="table table-striped table-bordered jambo_table">
            <thead>
                <tr>
                    <th class="text-center max-50">{{__('Edit')}}</th>
                    <th class="text-center col-text">{{__('Image')}}</th>
                    <th class="text-center col-text">{{__('Title')}}</th>
                    <th class="text-center col-text">{{__('Language')}}</th>
                    <th class="text-center max-70">{{__('View Detail')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $contract_type)
                    <tr>
                        <td class="text-center middle max-50">
                            <a href='{{route('EditContractType', ['id' => $contract_type->id])}}'>
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                        </td>
                        <td class="col-text">
                            <img src="{{$contract_type->image}}" alt="{{$contract_type->title}}" height="80" />
                        </td>
                        <td class="col-text">{{$contract_type->title}}</td>
                        <td class="col-text">{{$languages[$contract_type->language_id]}}</td>
                        <td class="col-text"><a href="{{route('ListOfContractTypeDetails', ['id'=> $contract_type->id])}}" > View Detail</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
