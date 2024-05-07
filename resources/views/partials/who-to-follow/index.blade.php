<main>
    <!-- Container START -->
    <div class="container">
        <div class="row g-4">

            <div class="col-lg-3">
                <x-shared.side-nav :user="$user"/>
            </div>
            <div class="col-lg-9">

                <div class="card mb-4">
                    <div class="card-body pb-0">
                        <h4 class="mb-4">Who to follow</h4>
                        <div class="row">
                            @foreach($usersToFollow as $userToFollow)
                                <div class="col-4 hstack gap-2 mb-5">
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
                                    <a class="btn btn-primary-soft rounded-circle icon-md ms-auto" href="#"><i class="fa-solid fa-plus"> </i></a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
