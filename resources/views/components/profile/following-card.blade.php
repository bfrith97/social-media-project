<div class="col-6">
    <!-- Friends item START -->
    <div class="card shadow-none text-center h-100">
        <!-- Card body -->
        <div class="card-body p-2 pb-0">
            <div class="avatar avatar-xl">
                <a href="{{ route('profiles.show', $following->id) }}"><img class="avatar-img rounded-circle" src="{{ asset($following->profile_picture) }}" alt=""></a>
            </div>
            <h6 class="card-title mb-1 mt-3"><a href="{{ route('profiles.show', $following->id) }}"> {{ $following->name }} </a></h6>
            <p class="mb-0 small lh-sm">{{ $following->role }}</p>
        </div>
        <!-- Card footer -->
        <div class="card-footer p-2 border-0">
            <button class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Send message">
                <i class="bi bi-chat-left-text"></i></button>
        </div>
    </div>
    <!-- Friends item END -->
</div>
