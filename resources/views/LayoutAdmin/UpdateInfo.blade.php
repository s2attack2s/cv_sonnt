<div class="row created_info">
    <div class="col-sm-12">
        <p><b>{{__('Created by')}}</b>: <i>{{$created_by}}</i> - {{date('H:i:s d/m/Y', strtotime($created_at))}}</p>
        @if ($updated_by != null && $updated_by != '' && $updated_at != null)
            <p><b>{{__('Updated by')}}</b>: <i>{{$updated_by}}</i> - {{date('H:i:s d/m/Y', strtotime($updated_at))}}</p>
        @endif
    </div>
</div>
