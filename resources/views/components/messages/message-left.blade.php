<div class="d-flex mb-1">
    <div class="flex-shrink-0 avatar avatar-xs me-2">
        <img class="avatar-img rounded-circle" src="{{ $message->user->profile_picture ? asset($message->user->profile_picture) : '' }}" alt="">
    </div>
    <div class="flex-grow-1">
        <div class="w-100">
            <div class="d-flex flex-column align-items-start">
                <div class="bg-light text-secondary p-2 px-3 rounded-2"
                     data-bs-toggle="tooltip"
                     data-bs-placement="bottom"
                     data-bs-custom-class="custom-tooltip"
                     data-bs-title="{{\Carbon\Carbon::createFromDate($message->created_at)->format('d/m/y')}}">
                    {{$message->content}}
                </div>
            </div>
        </div>
    </div>
</div>
