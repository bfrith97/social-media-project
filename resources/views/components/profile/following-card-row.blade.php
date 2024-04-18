<!-- Connections Item -->
<div class="d-md-flex align-items-center mb-4">
    <!-- Avatar -->
    <div class="avatar me-3 mb-3 mb-md-0">
        <a href="{{ route('profiles.show', $user->id) }}">
            <img class="avatar-img rounded-circle" src="assets/images/avatar/05.jpg" alt="">
        </a>
    </div>
    <!-- Info -->
    <div class="w-100">
        <div class="d-sm-flex align-items-start">
            <h6 class="mb-0"><a href="{{ route('profiles.show', $user->id) }}">{{ $user->name }} </a></h6>
            <p class="small ms-sm-2 mb-0">{{ $user->role }}</p>
        </div>
        <!-- Connections START -->
        <ul class="avatar-group mt-1 list-unstyled align-items-sm-center">
            <li class="small">
                Following
                for {{ Carbon\Carbon::parse($user->pivot->created_at)->timezone('Europe/London')->longAbsoluteDiffForHumans() }}
            </li>
        </ul>
        <!-- Connections END -->
    </div>
    <!-- Button -->
    <div class="ms-md-auto d-flex mb-auto">
        @if($profile->id === $self->id)
            <button class="btn btn-danger-soft btn-sm mb-0 me-2"> Unfollow</button>
        @endif
        <button class="btn btn-primary-soft btn-sm mb-0"> Message</button>
    </div>
</div>
<!-- Connections Item -->

