
<div class="table-result" id="table-result" >
    <div class="table-responsive">
        <table class="table table-striped table-bordered jambo_table">
            <thead>
                <tr>

                    <th class="text-center max-50">{{__('Edit')}}</th>
                    <th class="text-center col-text">{{__('Lang')}}</th>
                    <th class="text-center col-text">{{__('Company Name')}}</th>
                    <th class="text-center">{{__('Founded')}}</th>
                    <th class="text-center">{{__('Tel')}}</th>
                    <th class="text-center">{{__('Capital')}}</th>
                    <th class="text-center">{{__('Main Bank')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $company_profile)
                    <tr>

                        <td class="text-center middle max-50">
                            <a href='{{route('EditCompanyProfile', ['id' => $company_profile->id])}}'>
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                        </td>
                        <td class="col-text">{{$languages[$company_profile->language_id]}}</td>
                        <td class="col-text">{{$company_profile->company_name}}</td>
                        <td class="col-text">{{$company_profile->founded}}</td>
                        <td class="col-text">{{$company_profile->tel}}</td>
                        <td class="col-text">{{$company_profile->capital}}</td>
                        <td class="col-text">{{$company_profile->main_bank}}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
