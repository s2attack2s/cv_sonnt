
<div class="table-result" id="table-result" >
    <div class="table-responsive">
        <table class="table table-striped table-bordered jambo_table">
            <thead>
                <tr>
                    <th class="text-center max-50">{{__('Edit')}}</th>
                    <th class="text-center col-text">{{__('Image')}}</th>
                    <th class="text-center col-text">{{__('Title')}}</th>
                    <th class="text-center col-text">{{__('Language')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $delivery_model)
                    <tr>
                        <td class="text-center middle max-50">
                            <a href='{{route('EditDeliveryModel', ['id' => $delivery_model->id])}}'>
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                        </td>
                        <td class="col-text">
                            <img src="{{$delivery_model->image}}" alt="{{$delivery_model->title}}" height="80" />
                        </td>
                        <td class="col-text">{{$delivery_model->title}}</td>
                        <td class="col-text">{{$languages[$delivery_model->language_id]}}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
