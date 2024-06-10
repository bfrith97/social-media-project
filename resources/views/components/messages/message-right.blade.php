<div class="d-flex justify-content-end text-end mb-1">
    <div class="w-100">
        <div class="d-flex flex-column align-items-end">
            <div class="bg-primary text-white p-2 px-3 rounded-2"
                 data-bs-toggle="tooltip"
                 data-bs-placement="bottom"
                 data-bs-custom-class="custom-tooltip"
                 data-bs-title="{{\Carbon\Carbon::createFromDate($message->created_at)->format('d/m/y H:i:s')}}">{{$message->content}}
            </div>
            <div class="small my-1"></div>
        </div>
    </div>
</div>
