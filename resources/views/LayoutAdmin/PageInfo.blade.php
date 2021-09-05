<div class="page-info">
    <div class="div-page-size">
        <span>{{__('Number of record')}}</span>
        <select class="page-size" id="page-size">
            <option value="10" @if($per_page == 10)selected="selected"@endif>10</option>
            <option value="25" @if($per_page == 25)selected="selected"@endif>25</option>
            <option value="50" @if($per_page == 50)selected="selected"@endif>50</option>
            <option value="100"@if($per_page == 100)selected="selected"@endif>100</option>
        </select>
    </div>
    <div class="showing-row">
        @if ($total == 0)
            <span>{{__('No data to display')}}</span>
        @else
            <span>
                {{__('Showing from :from to :to of :total result', [
                    'from' =>  $from,
                    'to' => $to,
                    'total' => $total
                ])}}
            </span>
        @endif
    </div>
</div>
