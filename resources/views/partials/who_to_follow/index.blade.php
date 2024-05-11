<main>
    <!-- Container START -->
    <div class="container">
        <div class="row g-4">

            <div class="col-lg-3">
                <x-shared.left-side-nav :user="$user"/>
            </div>
            <div class="col-lg-9">

                <div class="card mb-4">
                    <div class="card-body pb-0">
                        <h4 class="mb-4">Who to follow</h4>
                        <div class="row">
                            @foreach($usersToFollow as $userToFollow)
                                <form action="{{route('follows.store')}}" method="post" class="follow-form col-4 hstack gap-2 mb-5">
                                    @csrf
                                    <input type="hidden" name="followee_id" value="{{$userToFollow->id}}">
                                    <input type="hidden" name="follower_id" value="{{$user->id}}">
                                    @if($userToFollow->followed_by_current_user)
                                        <input class="delete_method" type="hidden" name="_method" value="DELETE">
                                    @endif

                                    <!-- Avatar -->
                                    <div class="avatar">
                                        <a href="{{ route('profiles.show', $userToFollow->id) }}"><img class="avatar-img rounded-circle" src="{{ asset($userToFollow->picture) }}" alt=""></a>
                                    </div>
                                    <!-- Title -->
                                    <div class="overflow-hidden">
                                        <a class="h6 mb-0" href="{{ route('profiles.show', $userToFollow->id) }}"> {{ $userToFollow->name }} </a>
                                        <p class="mb-0 small text-truncate">{{ $userToFollow->role }}</p>
                                    </div>
                                    <!-- Button -->

                                    <button type="submit" class="btn btn-primary-soft rounded-circle icon-md ms-auto follow-button float-end">
                                        <i class="fa-solid fa-plus"> </i></button>

                                    <input type="hidden" name="followee_id" value="{{$userToFollow->id}}">
                                    <input type="hidden" name="follower_id" value="{{$user->id}}">
                                </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
