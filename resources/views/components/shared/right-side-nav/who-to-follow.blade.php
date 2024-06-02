<!-- Card follow START -->
<div class="col-sm-6 col-lg-12">
    <div class="card">
        <!-- Card header START -->
        <div class="card-header pb-0 border-0">
            <h5 class="card-title mb-0">Who to follow</h5>
        </div>
        <!-- Card header END -->
        <!-- Card body START -->
        <div class="card-body">
            <!-- Connection item START -->
            @foreach($usersToFollow as $userToFollow)
                <form action="{{route('follows.store')}}" method="post" class="follow-form">
                    @csrf
                    <input type="hidden" name="followee_id" value="{{$userToFollow->id}}">
                    <input type="hidden" name="follower_id" value="{{$user->id}}">
                    @if($userToFollow->followed_by_current_user)
                        <input class="delete_method" type="hidden" name="_method" value="DELETE">
                    @endif

                    <div class="hstack gap-2 mb-3">
                        <!-- Avatar -->
                        <div class="avatar">
                            <a href="{{ route('profiles.show', $userToFollow->id) }}"><img class="avatar-img rounded-circle" src="{{ asset($userToFollow->profile_picture) }}" alt="Image of {{$userToFollow->name}}"></a>
                        </div>
                        <!-- Title -->
                        <div class="overflow-hidden">
                            <a class="h6 mb-0" href="{{ route('profiles.show', $userToFollow->id) }}"> {{ $userToFollow->name }} </a>
                            <p class="mb-0 small text-truncate">{{ $userToFollow->role }}</p>
                        </div>
                        <!-- Button -->
                        <button type="submit" class="btn btn-primary-soft rounded-circle icon-md ms-auto follow-button">
                            <i class="fa-solid fa-plus"> </i></button>
                    </div>
                </form>
            @endforeach

            <!-- Connection item END -->
            <!-- Connection item END -->

            <!-- View more button -->
            <div class="d-grid mt-3">
                <a class="btn btn-sm btn-primary-soft" href="{{ route('who_to_follow.index') }}">View more</a>
            </div>
        </div>
        <!-- Card body END -->
    </div>
</div>
<!-- Card follow START -->
