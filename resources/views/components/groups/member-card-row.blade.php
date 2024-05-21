<!-- Connections Item -->
<div class="d-md-flex align-items-center mb-4">
    <!-- Avatar -->
    <div class="avatar me-3 mb-3 mb-md-0">
        <a href="{{ route('profiles.show', $otherUser->id) }}">
            <img class="avatar-img rounded-circle" src="{{ asset($otherUser->picture) }}" alt="">
        </a>
    </div>
    <!-- Info -->
    <div class="w-100">
        <div class="d-sm-flex align-items-start">
            <h6 class="mb-0"><a href="{{ route('profiles.show', $otherUser->id) }}">{{ $otherUser->name }} </a></h6>
        </div>
        <!-- Connections START -->
        <ul class="avatar-group mt-1 list-unstyled align-items-sm-center">
            <li class="small">
                Member for {{ Carbon\Carbon::parse($otherUser->pivot->created_at)->timezone('Europe/London')->longAbsoluteDiffForHumans() }}
            </li>
        </ul>
        <!-- Connections END -->
    </div>
    <!-- Button -->
    <form action="{{ route('follows.store') }}" method="post" class="follow-form ms-md-auto d-flex mb-auto">
        @csrf
        <input type="hidden" name="followee_id" value="{{$otherUser->id}}">
        <input type="hidden" name="follower_id" value="{{$user->id}}">
        @if($otherUser->followed_by_current_user)
            <input class="delete_method" type="hidden" name="_method" value="DELETE">
        @endif

        @if($otherUser->id != $user->id)
            @if($otherUser->followed_by_current_user)
                <button type="submit" class="btn btn-sm btn-danger-soft follow-button">
                    Unfollow
                </button>
            @else
                <button type="submit" class="btn btn-sm btn-success-soft follow-button">
                    Follow
                </button>
            @endif
        @endif

    </form>
</div>
<!-- Connections Item -->

