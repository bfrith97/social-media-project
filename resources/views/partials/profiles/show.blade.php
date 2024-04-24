<main>

    <!-- Container START -->
    <div class="container">
        <div class="row g-4">

            <!-- Main content START -->
            <div class="col-lg-8 vstack" id="main-content">
                <div>
                    <!-- My profiles-breeze START -->
                    <div class="card mb-4">
                        <!-- Cover image -->
                        <div class="h-200px rounded-top" style="background-image:url({{asset('assets/images/bg/05.jpg')}}); background-position: center; background-size: cover; background-repeat: no-repeat;"></div>
                        <!-- Card body START -->
                        <div class="card-body py-0">
                            <div class="d-sm-flex align-items-start text-center text-sm-start">
                                <div>
                                    <!-- Avatar -->
                                    <div class="avatar avatar-xxl mt-n5 mb-3">
                                        <img class="avatar-img rounded-circle border border-white border-3" src="{{ asset($profile->picture) }}" alt="">
                                    </div>
                                </div>
                                <div class="ms-sm-4 mt-sm-3">
                                    <!-- Info -->
                                    <h1 class="mb-0 h5">{{ $profile->name }}
                                        <i class="bi bi-patch-check-fill text-success small"></i>
                                    </h1>
                                </div>
                                <!-- Button -->
                                <div class="d-flex mt-3 justify-content-center ms-sm-auto">
                                    @if($profile->id === $user->id)
                                        <a href="{{route('settings.edit')}}" class="btn btn-danger-soft">
                                            <i class="bi bi-pencil-fill pe-1"></i> Edit profile
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <!-- List profiles-breeze -->
                            <ul class="list-inline mb-0 text-center text-sm-start mt-3 mt-sm-0 d-flex justify-content-between">
                                @isset($profile->role)
                                    <li class="list-inline-item">
                                        <i class="bi bi-briefcase me-1"></i>{{ $profile->role  }} @if($profile->company)
                                            at {{$profile->company}}
                                        @endif
                                    </li>
                                @else
                                    <li></li>
                                @endisset
                                <li class="list-inline-item"><i class="bi bi-calendar2-plus me-1"></i> Member
                                    since {{ $profile->created_at->format('jS \\o\\f F, Y') }}
                                </li>
                            </ul>
                        </div>
                        <!-- Card body END -->
                        <div class="card-footer mt-3 pt-2 pb-0">
                            <!-- Nav profiles-breeze pages -->
                            <ul class="nav nav-bottom-line align-items-center justify-content-center justify-content-md-start mb-0 border-0">
                                <li class="nav-item"><a class="nav-link  profile-link active" href="#posts-tab">
                                        Posts </a></li>
                                <li class="nav-item"><a class="nav-link  profile-link" href="#about-tab"> About </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link profile-link" href="#followers-tab"> Following
                                        <span class="badge bg-success bg-opacity-10 text-success small"> {{$profile->followings->count()}}</span>
                                    </a>
                                </li>
                                <li class="nav-item"><a class="nav-link  profile-link" href="#media-tab">
                                        Media</a></li>
                                <li class="nav-item"><a class="nav-link  profile-link" href="#events-tab">
                                        Events</a></li>
                                <li class="nav-item"><a class="nav-link  profile-link" href="#activity-tab">
                                        Activity</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- My profiles-breeze END -->
                    <div class="profile-section" id="posts-tab" style="display: none">
                        @if($profile->id == $user->id)
                            <x-posts.post-creation :user="$user" onProfile="true"/>
                        @endif

                        <div id="posts">

                            <!-- Card feed item START -->
                            @if(count($profile->posts))
                                @foreach($profile->posts as $post)
                                    <x-posts.post-card :post="$post" :user="$user" onProfile="true"/>
                                @endforeach
                            @else
                                <div>
                                    <div class="card card-body my-4">
                                        This user does not have any posts :(
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>


                    <div class="profile-section" id="about-tab" style="display: none">
                        <!-- About content START -->
                        <div class="card my-4">
                            <!-- Card header START -->
                            <div class="card-header border-0 pb-0">
                                <h5 class="card-title"> Profile Info</h5>
                            </div>
                            <!-- Card header END -->
                            <!-- Card body START -->
                            <div class="card-body">
                                <div class="rounded border px-3 py-2 mb-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h6>Overview</h6>
                                        <div class="dropdown ms-auto">
                                            <!-- Card share action menu -->
                                            <a class="nav nav-link text-secondary mb-0" href="#" id="aboutAction" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots"></i>
                                            </a>
                                            <!-- Card share action dropdown menu -->
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="aboutAction">
                                                <li><a class="dropdown-item" href="#">
                                                        <i class="bi bi-pencil-square fa-fw pe-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item" href="#">
                                                        <i class="bi bi-trash fa-fw pe-2"></i>Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p>{{ $profile->info }}</p>
                                </div>
                                <div class="row g-4">
                                    <div class="col-sm-6">
                                        <!-- Birthday START -->
                                        <div class="d-flex align-items-center rounded border px-3 py-2">
                                            <!-- Date -->
                                            <p class="mb-0">
                                                <i class="bi bi-calendar-date fa-fw me-2"></i> Born:
                                                <strong> {{ \Carbon\Carbon::parse($profile->date_of_birth)->format('jS \\o\\f F, Y') }} </strong>
                                            </p>
                                            <div class="dropdown ms-auto">
                                                <!-- Card share action menu -->
                                                <a class="nav nav-link text-secondary mb-0" href="#" id="aboutAction2" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots"></i>
                                                </a>
                                                <!-- Card share action dropdown menu -->
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="aboutAction2">
                                                    <li><a class="dropdown-item" href="#">
                                                            <i class="bi bi-pencil-square fa-fw pe-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="#">
                                                            <i class="bi bi-trash fa-fw pe-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Birthday END -->
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- Status START -->
                                        <div class="d-flex align-items-center rounded border px-3 py-2">
                                            <!-- Date -->
                                            <p class="mb-0">
                                                <i class="bi bi-heart fa-fw me-2"></i> Status:
                                                <strong> {{ $profile->relationship->name }} </strong>
                                            </p>
                                            <div class="dropdown ms-auto">
                                                <!-- Card share action menu -->
                                                <a class="nav nav-link text-secondary mb-0" href="#" id="aboutAction3" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots"></i>
                                                </a>
                                                <!-- Card share action dropdown menu -->
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="aboutAction3">
                                                    <li><a class="dropdown-item" href="#">
                                                            <i class="bi bi-pencil-square fa-fw pe-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="#">
                                                            <i class="bi bi-trash fa-fw pe-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Status END -->
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- Designation START -->
                                        <div class="d-flex align-items-center rounded border px-3 py-2">
                                            <!-- Date -->
                                            <p class="mb-0">
                                                <i class="bi bi-briefcase fa-fw me-2"></i>
                                                <strong> {{ $profile->role . ' at ' . $profile->company }} </strong>
                                            </p>
                                            <div class="dropdown ms-auto">
                                                <!-- Card share action menu -->
                                                <a class="nav nav-link text-secondary mb-0" href="#" id="aboutAction4" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots"></i>
                                                </a>
                                                <!-- Card share action dropdown menu -->
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="aboutAction4">
                                                    <li><a class="dropdown-item" href="#">
                                                            <i class="bi bi-pencil-square fa-fw pe-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="#">
                                                            <i class="bi bi-trash fa-fw pe-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Designation END -->
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- Lives START -->
                                        <div class="d-flex align-items-center rounded border px-3 py-2">
                                            <!-- Date -->
                                            <p class="mb-0">
                                                <i class="bi bi-telephone fa-fw me-2"></i> Phone Number:
                                                <strong> {{ $profile->number }} </strong>
                                            </p>
                                            <div class="dropdown ms-auto">
                                                <!-- Card share action menu -->
                                                <a class="nav nav-link text-secondary mb-0" href="#" id="aboutAction5" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots"></i>
                                                </a>
                                                <!-- Card share action dropdown menu -->
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="aboutAction5">
                                                    <li><a class="dropdown-item" href="#">
                                                            <i class="bi bi-pencil-square fa-fw pe-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="#">
                                                            <i class="bi bi-trash fa-fw pe-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Lives END -->
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- Joined on START -->
                                        <div class="d-flex align-items-center rounded border px-3 py-2">
                                            <!-- Date -->
                                            <p class="mb-0">
                                                <i class="bi bi-geo-alt fa-fw me-2"></i> Joined on:
                                                <strong> {{ $profile->created_at->format('jS \\o\\f F, Y') }} </strong>
                                            </p>
                                            <div class="dropdown ms-auto">
                                                <!-- Card share action menu -->
                                                <a class="nav nav-link text-secondary mb-0" href="#" id="aboutAction6" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots"></i>
                                                </a>
                                                <!-- Card share action dropdown menu -->
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="aboutAction6">
                                                    <li><a class="dropdown-item" href="#">
                                                            <i class="bi bi-pencil-square fa-fw pe-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="#">
                                                            <i class="bi bi-trash fa-fw pe-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Joined on END -->
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- Joined on START -->
                                        <div class="d-flex align-items-center rounded border px-3 py-2">
                                            <!-- Date -->
                                            <p class="mb-0">
                                                <i class="bi bi-envelope fa-fw me-2"></i> Email: <strong>
                                                    {{ $profile->email }} </strong>
                                            </p>
                                            <div class="dropdown ms-auto">
                                                <!-- Card share action menu -->
                                                <a class="nav nav-link text-secondary mb-0" href="#" id="aboutAction7" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots"></i>
                                                </a>
                                                <!-- Card share action dropdown menu -->
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="aboutAction7">
                                                    <li><a class="dropdown-item" href="#">
                                                            <i class="bi bi-pencil-square fa-fw pe-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="#">
                                                            <i class="bi bi-trash fa-fw pe-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Joined on END -->
                                    </div>
                                </div>
                            </div>
                            <!-- Card body END -->
                        </div>
                        <!-- About content END -->

                        <!-- Card feed item START -->
                        <div class="card">
                            <!-- Card header START -->
                            <div class="card-header d-sm-flex justify-content-between border-0 pb-0">
                                <h5 class="card-title">Interests</h5>
                                <a class="btn btn-primary-soft btn-sm" href="#!"> See all</a>
                            </div>
                            <!-- Card header END -->
                            <!-- Card body START -->
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-sm-6 col-lg-4">
                                        <!-- Interests item START -->
                                        <div class="d-flex align-items-center position-relative">
                                            <div class="avatar">
                                                <img class="avatar-img" src="assets/images/logo/04.svg" alt="">
                                            </div>
                                            <div class="ms-2">
                                                <h6 class="mb-0"><a class="stretched-link" href="#"> Oracle </a></h6>
                                                <p class="small mb-0">7,546,224 followers</p>
                                            </div>
                                        </div>
                                        <!-- Interests item END -->
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <!-- Interests item START -->
                                        <div class="d-flex align-items-center position-relative">
                                            <div class="avatar">
                                                <img class="avatar-img" src="assets/images/logo/13.svg" alt="">
                                            </div>
                                            <div class="ms-2">
                                                <h6 class="mb-0"><a class="stretched-link" href="#"> Apple </a></h6>
                                                <p class="small mb-0">102B followers</p>
                                            </div>
                                        </div>
                                        <!-- Interests item END -->
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <!-- Interests item START -->
                                        <div class="d-flex align-items-center position-relative">
                                            <div class="avatar">
                                                <img class="avatar-img rounded-circle" src="assets/images/avatar/placeholder.jpg" alt="">
                                            </div>
                                            <div class="ms-2">
                                                <h6 class="mb-0"><a class="stretched-link" href="#"> Elon musk </a></h6>
                                                <p class="small mb-0"> CEO and Product Architect of Tesla, Inc 41B
                                                    followers</p>
                                            </div>
                                        </div>
                                        <!-- Interests item END -->
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <!-- Interests item START -->
                                        <div class="d-flex align-items-center position-relative">
                                            <div class="avatar">
                                                <img class="avatar-img" src="assets/images/events/04.jpg" alt="">
                                            </div>
                                            <div class="ms-2">
                                                <h6 class="mb-0"><a class="stretched-link" href="#"> The X Factor </a>
                                                </h6>
                                                <p class="small mb-0">9,654 followers</p>
                                            </div>
                                        </div>
                                        <!-- Interests item END -->
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <!-- Interests item START -->
                                        <div class="d-flex align-items-center position-relative">
                                            <div class="avatar">
                                                <img class="avatar-img rounded-circle" src="assets/images/logo/12.svg" alt="">
                                            </div>
                                            <div class="ms-2">
                                                <h6 class="mb-0"><a class="stretched-link" href="#"> Getbootstrap </a>
                                                </h6>
                                                <p class="small mb-0">8,457,224 followers</p>
                                            </div>
                                        </div>
                                        <!-- Interests item END -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card body END -->
                    </div>

                    <!-- Card Followers START -->
                    <div class="profile-section" id="followers-tab" style="display: none">
                        <div class="card my-4">
                            <!-- Card header START -->
                            <div class="card-header border-0 pb-0">
                                <h5 class="card-title"> Following ({{$profile->followings->count()}})</h5>
                            </div>
                            <!-- Card header END -->
                            <!-- Card body START -->
                            <div class="card-body">
                                @foreach($profile->followings as $following)
                                    <x-profile.following-card-row :user="$following" :profile="$profile" :self="$user"/>
                                @endforeach

                                <div class="d-grid">
                                    <!-- Load more button START -->
                                    <a href="#!" role="button" class="btn btn-sm btn-loader btn-primary-soft" data-bs-toggle="button" aria-pressed="true">
                                        <span class="load-text"> Load more followers </span>
                                        <div class="load-icon">
                                            <div class="spinner-grow spinner-grow-sm" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </a>
                                    <!-- Load more button END -->
                                </div>

                            </div>
                            <!-- Card body END -->
                        </div>

                        <div class="card my-4">
                            <!-- Card header START -->
                            <div class="card-header border-0 pb-0">
                                <h5 class="card-title"> Followers ({{$profile->followers->count()}})</h5>
                            </div>
                            <!-- Card header END -->
                            <!-- Card body START -->
                            <div class="card-body">
                                @foreach($profile->followers as $follower)
                                    <x-profile.following-card-row :user="$follower" :profile="$profile" :self="$user"/>
                                @endforeach

                                <div class="d-grid">
                                    <!-- Load more button START -->
                                    <a href="#!" role="button" class="btn btn-sm btn-loader btn-primary-soft" data-bs-toggle="button" aria-pressed="true">
                                        <span class="load-text"> Load more followers </span>
                                        <div class="load-icon">
                                            <div class="spinner-grow spinner-grow-sm" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </a>
                                    <!-- Load more button END -->
                                </div>

                            </div>
                            <!-- Card body END -->
                        </div>
                    </div>
                    <!-- Card Followers END -->


                    <div class="profile-section" id="media-tab" style="display: none">
                        <!-- media START -->
                        <div class="card">
                            <!-- Card header START -->
                            <div class="card-header d-sm-flex align-items-center justify-content-between border-0 pb-0">
                                <h5 class="card-title">Photos</h5>
                                <!-- Button modal -->
                                <a class="btn btn-sm btn-primary-soft" href="#" data-bs-toggle="modal" data-bs-target="#modalCreateAlbum">
                                    <i class="fa-solid fa-plus pe-1"></i> Create album</a>
                            </div>
                            <!-- Card header END -->
                            <!-- Card body START -->
                            <div class="card-body">
                                <!-- Photos of you tab START -->
                                <div class="row g-3">

                                    <!-- Add photo START -->
                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                        <div class="border border-2 py-5 border-dashed h-100 rounded text-center d-flex align-items-center justify-content-center position-relative">
                                            <a class="stretched-link" href="#!">
                                                <i class="fa-solid fa-camera-retro fs-1"></i>
                                                <h6 class="mt-2">Add photo</h6>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- Add photo END -->

                                    <!-- Photo item START -->
                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                        <!-- Photo -->
                                        <a href="assets/images/albums/01.jpg" data-gallery="image-popup" data-glightbox="description: .custom-desc2; descPosition: left;">
                                            <img class="rounded img-fluid" src="assets/images/albums/01.jpg" alt="">
                                        </a>
                                        <!-- likes -->
                                        <ul class="nav nav-stack py-2 small">
                                            <li class="nav-item">
                                                <a class="nav-link" href="#!">
                                                    <i class="bi bi-heart-fill text-danger pe-1"></i>22k </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#!">
                                                    <i class="bi bi-chat-left-text-fill pe-1"></i>3k </a>
                                            </li>
                                        </ul>
                                        <!-- glightbox Albums left bar START -->
                                        <div class="glightbox-desc custom-desc2">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <!-- Avatar -->
                                                    <div class="avatar me-2">
                                                        <img class="avatar-img rounded-circle" src="assets/images/avatar/04.jpg" alt="">
                                                    </div>
                                                    <!-- Info -->
                                                    <div>
                                                        <div class="nav nav-divider">
                                                            <h6 class="nav-item card-title mb-0">Lori Ferguson</h6>
                                                            <span class="nav-item small"> 2hr</span>
                                                        </div>
                                                        <p class="mb-0 small">Web Developer at Webestica</p>
                                                    </div>
                                                </div>
                                                <!-- Card feed action dropdown START -->
                                                <div class="dropdown">
                                                    <a href="#" class="text-secondary btn btn-secondary-soft-hover py-1 px-2" id="cardFeedAction" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots"></i>
                                                    </a>
                                                    <!-- Card feed action dropdown menu -->
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardFeedAction">
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-bookmark fa-fw pe-2"></i>Save post</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-person-x fa-fw pe-2"></i>Unfollow lori
                                                                ferguson </a></li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-x-circle fa-fw pe-2"></i>Hide post</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-slash-circle fa-fw pe-2"></i>Block</a>
                                                        </li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-flag fa-fw pe-2"></i>Report post</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <!-- Card feed action dropdown END -->
                                            </div>
                                            <p class="mt-3 mb-0">I'm so privileged to be involved in the @bootstrap
                                                hiring process! <a href="#">#internship #inclusivebusiness</a>
                                                <a href="#">#internship</a> <a href="#"> #hiring</a>
                                                <a href="#">#apply</a></p>
                                            <ul class="nav nav-stack py-3 small">
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="#!">
                                                        <i class="bi bi-hand-thumbs-up-fill pe-1"></i>Liked (56)</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#!"> <i class="bi bi-chat-fill pe-1"></i>Comments
                                                        (12)</a>
                                                </li>
                                                <!-- Card share action START -->
                                                <li class="nav-item dropdown ms-auto">
                                                    <a class="nav-link mb-0" href="#" id="cardShareAction" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-reply-fill fa-flip-horizontal pe-1"></i>Share
                                                        (3)
                                                    </a>
                                                    <!-- Card share action dropdown menu -->
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardShareAction">
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-envelope fa-fw pe-2"></i>Send via Direct
                                                                Message</a></li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-bookmark-check fa-fw pe-2"></i>Bookmark
                                                            </a></li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-link fa-fw pe-2"></i>Copy link to
                                                                post</a></li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-share fa-fw pe-2"></i>Share post via
                                                                …</a></li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-pencil-square fa-fw pe-2"></i>Share to
                                                                News Feed</a></li>
                                                    </ul>
                                                </li>
                                                <!-- Card share action END -->
                                            </ul>
                                            <!-- Add comment -->
                                            <div class="d-flex mb-3">
                                                <!-- Avatar -->
                                                <div class="avatar avatar-xs me-2">
                                                    <img class="avatar-img rounded-circle" src="assets/images/avatar/04.jpg" alt="">
                                                </div>
                                                <!-- Comment box  -->
                                                <form class="position-relative w-100">
                                                    <textarea class="one form-control pe-4 bg-light" data-autoresize rows="1" placeholder="Add a comment..."></textarea>
                                                    <!-- Emoji button -->
                                                    <div class="position-absolute top-0 end-0">
                                                        <button class="btn" type="button">🙂</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- Comment wrap START -->
                                            <ul class="comment-wrap list-unstyled ">
                                                <!-- Comment item START -->
                                                <li class="comment-item">
                                                    <div class="d-flex">
                                                        <!-- Avatar -->
                                                        <div class="avatar avatar-xs">
                                                            <img class="avatar-img rounded-circle" src="assets/images/avatar/05.jpg" alt="">
                                                        </div>
                                                        <div class="ms-2">
                                                            <!-- Comment by -->
                                                            <div class="bg-light rounded-start-top-0 p-3 rounded">
                                                                <div class="d-flex justify-content-center">
                                                                    <div class="me-2">
                                                                        <h6 class="mb-1"><a href="#!"> Frances
                                                                                Guerrero </a></h6>
                                                                        <p class="small mb-0">Removed demands expense
                                                                            account in outward tedious do.</p>
                                                                    </div>
                                                                    <small>5hr</small>
                                                                </div>
                                                            </div>
                                                            <!-- Comment react -->
                                                            <ul class="nav nav-divider py-2 small">
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#!"> Like (3)</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#!"> Reply</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#!"> View 5 replies</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <!-- Comment wrap END -->
                                        </div>
                                        <!-- glightbox Albums left bar END  -->
                                    </div>
                                    <!-- Photo item END -->

                                    <!-- Photo item START -->
                                    <div class="col-sm-6 col-md-4 col-lg-3 position-relative">
                                        <!-- Photo -->
                                        <a href="assets/images/albums/02.jpg" data-gallery="image-popup" data-glightbox="description: .custom-desc2; descPosition: left;">
                                            <img class="rounded img-fluid" src="assets/images/albums/02.jpg" alt="">
                                        </a>
                                        <!-- likes -->
                                        <ul class="nav nav-stack py-2 small">
                                            <li class="nav-item">
                                                <a class="nav-link" href="#!">
                                                    <i class="bi bi-heart-fill text-danger pe-1"></i>32k </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#!">
                                                    <i class="bi bi-chat-left-text-fill pe-1"></i>12k </a>
                                            </li>
                                        </ul>
                                        <!-- glightbox Albums left bar START -->
                                        <div class="glightbox-desc custom-desc2">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <!-- Avatar -->
                                                    <div class="avatar me-2">
                                                        <img class="avatar-img rounded-circle" src="assets/images/avatar/04.jpg" alt="">
                                                    </div>
                                                    <!-- Info -->
                                                    <div>
                                                        <div class="nav nav-divider">
                                                            <h6 class="nav-item card-title mb-0">Lori Ferguson</h6>
                                                            <span class="nav-item small"> 2hr</span>
                                                        </div>
                                                        <p class="mb-0 small">Web Developer at Webestica</p>
                                                    </div>
                                                </div>
                                                <!-- Card feed action dropdown START -->
                                                <div class="dropdown">
                                                    <a href="#" class="text-secondary btn btn-secondary-soft-hover py-1 px-2" id="cardFeedAction2" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots"></i>
                                                    </a>
                                                    <!-- Card feed action dropdown menu -->
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardFeedAction2">
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-bookmark fa-fw pe-2"></i>Save post</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-person-x fa-fw pe-2"></i>Unfollow lori
                                                                ferguson </a></li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-x-circle fa-fw pe-2"></i>Hide post</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-slash-circle fa-fw pe-2"></i>Block</a>
                                                        </li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-flag fa-fw pe-2"></i>Report post</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <!-- Card feed action dropdown END -->
                                            </div>
                                            <p class="mt-3 mb-0">I'm so privileged to be involved in the @bootstrap
                                                hiring process! <a href="#">#internship #inclusivebusiness</a>
                                                <a href="#">#internship</a> <a href="#"> #hiring</a>
                                                <a href="#">#apply</a></p>
                                            <ul class="nav nav-stack py-3 small">
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="#!">
                                                        <i class="bi bi-hand-thumbs-up-fill pe-1"></i>Liked (56)</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#!"> <i class="bi bi-chat-fill pe-1"></i>Comments
                                                        (12)</a>
                                                </li>
                                                <!-- Card share action START -->
                                                <li class="nav-item dropdown ms-auto">
                                                    <a class="nav-link mb-0" href="#" id="cardShareAction2" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-reply-fill fa-flip-horizontal pe-1"></i>Share
                                                        (3)
                                                    </a>
                                                    <!-- Card share action dropdown menu -->
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardShareAction2">
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-envelope fa-fw pe-2"></i>Send via Direct
                                                                Message</a></li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-bookmark-check fa-fw pe-2"></i>Bookmark
                                                            </a></li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-link fa-fw pe-2"></i>Copy link to
                                                                post</a></li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-share fa-fw pe-2"></i>Share post via
                                                                …</a></li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-pencil-square fa-fw pe-2"></i>Share to
                                                                News Feed</a></li>
                                                    </ul>
                                                </li>
                                                <!-- Card share action END -->
                                            </ul>
                                            <!-- Add comment -->
                                            <div class="d-flex mb-3">
                                                <!-- Avatar -->
                                                <div class="avatar avatar-xs me-2">
                                                    <img class="avatar-img rounded-circle" src="assets/images/avatar/04.jpg" alt="">
                                                </div>
                                                <!-- Comment box  -->
                                                <form class="position-relative w-100">
                                                    <textarea class="form-control pe-4 bg-light" rows="1" placeholder="Add a comment..."></textarea>
                                                </form>
                                            </div>
                                            <!-- Comment wrap START -->
                                            <ul class="comment-wrap list-unstyled ">
                                                <!-- Comment item START -->
                                                <li class="comment-item">
                                                    <div class="d-flex">
                                                        <!-- Avatar -->
                                                        <div class="avatar avatar-xs">
                                                            <img class="avatar-img rounded-circle" src="assets/images/avatar/05.jpg" alt="">
                                                        </div>
                                                        <div class="ms-2">
                                                            <!-- Comment by -->
                                                            <div class="bg-light rounded-start-top-0 p-3 rounded">
                                                                <div class="d-flex justify-content-center">
                                                                    <div class="me-2">
                                                                        <h6 class="mb-1"><a href="#!"> Frances
                                                                                Guerrero </a></h6>
                                                                        <p class="small mb-0">Removed demands expense
                                                                            account in outward tedious do.</p>
                                                                    </div>
                                                                    <small>5hr</small>
                                                                </div>
                                                            </div>
                                                            <!-- Comment react -->
                                                            <ul class="nav nav-divider py-2 small">
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#!"> Like (3)</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#!"> Reply</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#!"> View 5 replies</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <!-- Comment wrap END -->
                                        </div>
                                        <!-- glightbox Albums left bar END  -->
                                    </div>
                                    <!-- Photo item END -->

                                    <!-- Photo item START -->
                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                        <!-- PHoto -->
                                        <a href="assets/images/albums/03.jpg" data-gallery="image-popup" data-glightbox="description: .custom-desc2; descPosition: left;">
                                            <img class="rounded img-fluid" src="assets/images/albums/03.jpg" alt="">
                                        </a>
                                        <!-- likes -->
                                        <ul class="nav nav-stack py-2 small">
                                            <li class="nav-item">
                                                <a class="nav-link" href="#!">
                                                    <i class="bi bi-heart-fill text-danger pe-1"></i>21k </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#!">
                                                    <i class="bi bi-chat-left-text-fill pe-1"></i>4k </a>
                                            </li>
                                        </ul>
                                        <!-- glightbox Albums left bar START -->
                                        <div class="glightbox-desc custom-desc2">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <!-- Avatar -->
                                                    <div class="avatar me-2">
                                                        <img class="avatar-img rounded-circle" src="assets/images/avatar/04.jpg" alt="">
                                                    </div>
                                                    <!-- Info -->
                                                    <div>
                                                        <div class="nav nav-divider">
                                                            <h6 class="nav-item card-title mb-0">Lori Ferguson</h6>
                                                            <span class="nav-item small"> 2hr</span>
                                                        </div>
                                                        <p class="mb-0 small">Web Developer at Webestica</p>
                                                    </div>
                                                </div>
                                                <!-- Card feed action dropdown START -->
                                                <div class="dropdown">
                                                    <a href="#" class="text-secondary btn btn-secondary-soft-hover py-1 px-2" id="cardFeedAction3" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots"></i>
                                                    </a>
                                                    <!-- Card feed action dropdown menu -->
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardFeedAction3">
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-bookmark fa-fw pe-2"></i>Save post</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-person-x fa-fw pe-2"></i>Unfollow lori
                                                                ferguson </a></li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-x-circle fa-fw pe-2"></i>Hide post</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-slash-circle fa-fw pe-2"></i>Block</a>
                                                        </li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-flag fa-fw pe-2"></i>Report post</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <!-- Card feed action dropdown END -->
                                            </div>
                                            <p class="mt-3 mb-0">I'm so privileged to be involved in the @bootstrap
                                                hiring process! <a href="#">#internship #inclusivebusiness</a>
                                                <a href="#">#internship</a> <a href="#"> #hiring</a>
                                                <a href="#">#apply</a></p>
                                            <ul class="nav nav-stack py-3 small">
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="#!">
                                                        <i class="bi bi-hand-thumbs-up-fill pe-1"></i>Liked (56)</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#!"> <i class="bi bi-chat-fill pe-1"></i>Comments
                                                        (12)</a>
                                                </li>
                                                <!-- Card share action START -->
                                                <li class="nav-item dropdown ms-auto">
                                                    <a class="nav-link mb-0" href="#" id="cardShareAction3" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-reply-fill fa-flip-horizontal pe-1"></i>Share
                                                        (3)
                                                    </a>
                                                    <!-- Card share action dropdown menu -->
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardShareAction3">
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-envelope fa-fw pe-2"></i>Send via Direct
                                                                Message</a></li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-bookmark-check fa-fw pe-2"></i>Bookmark
                                                            </a></li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-link fa-fw pe-2"></i>Copy link to
                                                                post</a></li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-share fa-fw pe-2"></i>Share post via
                                                                …</a></li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-pencil-square fa-fw pe-2"></i>Share to
                                                                News Feed</a></li>
                                                    </ul>
                                                </li>
                                                <!-- Card share action END -->
                                            </ul>
                                            <!-- Add comment -->
                                            <div class="d-flex mb-3">
                                                <!-- Avatar -->
                                                <div class="avatar avatar-xs me-2">
                                                    <img class="avatar-img rounded-circle" src="assets/images/avatar/04.jpg" alt="">
                                                </div>
                                                <!-- Comment box  -->
                                                <form class="position-relative w-100">
                                                    <textarea class="form-control pe-4 bg-light" rows="1" placeholder="Add a comment..."></textarea>
                                                </form>
                                            </div>
                                            <!-- Comment wrap START -->
                                            <ul class="comment-wrap list-unstyled ">
                                                <!-- Comment item START -->
                                                <li class="comment-item">
                                                    <div class="d-flex">
                                                        <!-- Avatar -->
                                                        <div class="avatar avatar-xs">
                                                            <img class="avatar-img rounded-circle" src="assets/images/avatar/05.jpg" alt="">
                                                        </div>
                                                        <div class="ms-2">
                                                            <!-- Comment by -->
                                                            <div class="bg-light rounded-start-top-0 p-3 rounded">
                                                                <div class="d-flex justify-content-center">
                                                                    <div class="me-2">
                                                                        <h6 class="mb-1"><a href="#!"> Frances
                                                                                Guerrero </a></h6>
                                                                        <p class="small mb-0">Removed demands expense
                                                                            account in outward tedious do.</p>
                                                                    </div>
                                                                    <small>5hr</small>
                                                                </div>
                                                            </div>
                                                            <!-- Comment react -->
                                                            <ul class="nav nav-divider py-2 small">
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#!"> Like (3)</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#!"> Reply</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#!"> View 5 replies</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <!-- Comment wrap END -->
                                        </div>
                                        <!-- glightbox Albums left bar END  -->
                                    </div>
                                    <!-- Photo item END -->

                                    <!-- Photo item START -->
                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                        <!-- Photo -->
                                        <a href="assets/images/albums/04.jpg" data-gallery="image-popup" data-glightbox="description: .custom-desc2; descPosition: left;">
                                            <img class="rounded img-fluid" src="assets/images/albums/04.jpg" alt="">
                                        </a>
                                        <!-- likes -->
                                        <ul class="nav nav-stack py-2 small">
                                            <li class="nav-item">
                                                <a class="nav-link" href="#!">
                                                    <i class="bi bi-heart-fill text-danger pe-1"></i>32k </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#!">
                                                    <i class="bi bi-chat-left-text-fill pe-1"></i>16k </a>
                                            </li>
                                        </ul>
                                        <!-- glightbox Albums left bar START -->
                                        <div class="glightbox-desc custom-desc2">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <!-- Avatar -->
                                                    <div class="avatar me-2">
                                                        <img class="avatar-img rounded-circle" src="assets/images/avatar/04.jpg" alt="">
                                                    </div>
                                                    <!-- Info -->
                                                    <div>
                                                        <div class="nav nav-divider">
                                                            <h6 class="nav-item card-title mb-0">Lori Ferguson</h6>
                                                            <span class="nav-item small"> 2hr</span>
                                                        </div>
                                                        <p class="mb-0 small">Web Developer at Webestica</p>
                                                    </div>
                                                </div>
                                                <!-- Card feed action dropdown START -->
                                                <div class="dropdown">
                                                    <a href="#" class="text-secondary btn btn-secondary-soft-hover py-1 px-2" id="cardFeedAction4" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots"></i>
                                                    </a>
                                                    <!-- Card feed action dropdown menu -->
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardFeedAction4">
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-bookmark fa-fw pe-2"></i>Save post</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-person-x fa-fw pe-2"></i>Unfollow lori
                                                                ferguson </a></li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-x-circle fa-fw pe-2"></i>Hide post</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-slash-circle fa-fw pe-2"></i>Block</a>
                                                        </li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-flag fa-fw pe-2"></i>Report post</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <!-- Card feed action dropdown END -->
                                            </div>
                                            <p class="mt-3 mb-0">I'm so privileged to be involved in the @bootstrap
                                                hiring process! <a href="#">#internship #inclusivebusiness</a>
                                                <a href="#">#internship</a> <a href="#"> #hiring</a>
                                                <a href="#">#apply</a></p>
                                            <!-- likes -->
                                            <ul class="nav nav-stack py-3 small">
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="#!">
                                                        <i class="bi bi-hand-thumbs-up-fill pe-1"></i>Liked (56)</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#!"> <i class="bi bi-chat-fill pe-1"></i>Comments
                                                        (12)</a>
                                                </li>
                                                <!-- Card share action START -->
                                                <li class="nav-item dropdown ms-auto">
                                                    <a class="nav-link mb-0" href="#" id="cardShareAction4" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-reply-fill fa-flip-horizontal pe-1"></i>Share
                                                        (3)
                                                    </a>
                                                    <!-- Card share action dropdown menu -->
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardShareAction4">
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-envelope fa-fw pe-2"></i>Send via Direct
                                                                Message</a></li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-bookmark-check fa-fw pe-2"></i>Bookmark
                                                            </a></li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-link fa-fw pe-2"></i>Copy link to
                                                                post</a></li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-share fa-fw pe-2"></i>Share post via
                                                                …</a></li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-pencil-square fa-fw pe-2"></i>Share to
                                                                News Feed</a></li>
                                                    </ul>
                                                </li>
                                                <!-- Card share action END -->
                                            </ul>
                                            <!-- Add comment -->
                                            <div class="d-flex mb-3">
                                                <!-- Avatar -->
                                                <div class="avatar avatar-xs me-2">
                                                    <img class="avatar-img rounded-circle" src="assets/images/avatar/04.jpg" alt="">
                                                </div>
                                                <!-- Comment box  -->
                                                <form class="position-relative w-100">
                                                    <textarea class="form-control pe-4 bg-light" rows="1" placeholder="Add a comment..."></textarea>
                                                </form>
                                            </div>
                                            <!-- Comment wrap START -->
                                            <ul class="comment-wrap list-unstyled ">
                                                <!-- Comment item START -->
                                                <li class="comment-item">
                                                    <div class="d-flex">
                                                        <!-- Avatar -->
                                                        <div class="avatar avatar-xs">
                                                            <img class="avatar-img rounded-circle" src="assets/images/avatar/05.jpg" alt="">
                                                        </div>
                                                        <div class="ms-2">
                                                            <!-- Comment by -->
                                                            <div class="bg-light rounded-start-top-0 p-3 rounded">
                                                                <div class="d-flex justify-content-center">
                                                                    <div class="me-2">
                                                                        <h6 class="mb-1"><a href="#!"> Frances
                                                                                Guerrero </a></h6>
                                                                        <p class="small mb-0">Removed demands expense
                                                                            account in outward tedious do.</p>
                                                                    </div>
                                                                    <small>5hr</small>
                                                                </div>
                                                            </div>
                                                            <!-- Comment react -->
                                                            <ul class="nav nav-divider py-2 small">
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#!"> Like (3)</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#!"> Reply</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#!"> View 5 replies</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <!-- Comment wrap END -->
                                        </div>
                                        <!-- glightbox Albums left bar END  -->
                                    </div>
                                    <!-- Photo item END -->

                                    <!-- Photo item START -->
                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                        <!-- Photo -->
                                        <a href="assets/images/albums/05.jpg" data-gallery="image-popup" data-glightbox="description: .custom-desc2; descPosition: left;">
                                            <img class="rounded img-fluid" src="assets/images/albums/05.jpg" alt="">
                                        </a>
                                        <!-- likes -->
                                        <ul class="nav nav-stack py-2 small">
                                            <li class="nav-item">
                                                <a class="nav-link" href="#!">
                                                    <i class="bi bi-heart-fill text-danger pe-1"></i>20k </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#!">
                                                    <i class="bi bi-chat-left-text-fill pe-1"></i>8k </a>
                                            </li>
                                        </ul>
                                        <!-- glightbox Albums left bar START -->
                                        <div class="glightbox-desc custom-desc2">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <!-- Avatar -->
                                                    <div class="avatar me-2">
                                                        <img class="avatar-img rounded-circle" src="assets/images/avatar/04.jpg" alt="">
                                                    </div>
                                                    <!-- Info -->
                                                    <div>
                                                        <div class="nav nav-divider">
                                                            <h6 class="nav-item card-title mb-0">Lori Ferguson</h6>
                                                            <span class="nav-item small"> 2hr</span>
                                                        </div>
                                                        <p class="mb-0 small">Web Developer at Webestica</p>
                                                    </div>
                                                </div>
                                                <!-- Card feed action dropdown START -->
                                                <div class="dropdown">
                                                    <a href="#" class="text-secondary btn btn-secondary-soft-hover py-1 px-2" id="cardFeedAction5" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots"></i>
                                                    </a>
                                                    <!-- Card feed action dropdown menu -->
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardFeedAction5">
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-bookmark fa-fw pe-2"></i>Save post</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-person-x fa-fw pe-2"></i>Unfollow lori
                                                                ferguson </a></li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-x-circle fa-fw pe-2"></i>Hide post</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-slash-circle fa-fw pe-2"></i>Block</a>
                                                        </li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-flag fa-fw pe-2"></i>Report post</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <!-- Card feed action dropdown END -->
                                            </div>
                                            <p class="mt-3 mb-0">I'm so privileged to be involved in the @bootstrap
                                                hiring process! <a href="#">#internship #inclusivebusiness</a>
                                                <a href="#">#internship</a> <a href="#"> #hiring</a>
                                                <a href="#">#apply</a></p>
                                            <ul class="nav nav-stack py-3 small">
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="#!">
                                                        <i class="bi bi-hand-thumbs-up-fill pe-1"></i>Liked (56)</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#!"> <i class="bi bi-chat-fill pe-1"></i>Comments
                                                        (12)</a>
                                                </li>
                                                <!-- Card share action START -->
                                                <li class="nav-item dropdown ms-auto">
                                                    <a class="nav-link mb-0" href="#" id="cardShareAction5" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-reply-fill fa-flip-horizontal pe-1"></i>Share
                                                        (3)
                                                    </a>
                                                    <!-- Card share action dropdown menu -->
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardShareAction5">
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-envelope fa-fw pe-2"></i>Send via Direct
                                                                Message</a></li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-bookmark-check fa-fw pe-2"></i>Bookmark
                                                            </a></li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-link fa-fw pe-2"></i>Copy link to
                                                                post</a></li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-share fa-fw pe-2"></i>Share post via
                                                                …</a></li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-pencil-square fa-fw pe-2"></i>Share to
                                                                News Feed</a></li>
                                                    </ul>
                                                </li>
                                                <!-- Card share action END -->
                                            </ul>
                                            <!-- Add comment -->
                                            <div class="d-flex mb-3">
                                                <!-- Avatar -->
                                                <div class="avatar avatar-xs me-2">
                                                    <img class="avatar-img rounded-circle" src="assets/images/avatar/04.jpg" alt="">
                                                </div>
                                                <!-- Comment box  -->
                                                <form class="position-relative w-100">
                                                    <textarea class="form-control pe-4 bg-light" rows="1" placeholder="Add a comment..."></textarea>
                                                </form>
                                            </div>
                                            <!-- Comment wrap START -->
                                            <ul class="comment-wrap list-unstyled ">
                                                <!-- Comment item START -->
                                                <li class="comment-item">
                                                    <div class="d-flex">
                                                        <!-- Avatar -->
                                                        <div class="avatar avatar-xs">
                                                            <img class="avatar-img rounded-circle" src="assets/images/avatar/05.jpg" alt="">
                                                        </div>
                                                        <div class="ms-2">
                                                            <!-- Comment by -->
                                                            <div class="bg-light rounded-start-top-0 p-3 rounded">
                                                                <div class="d-flex justify-content-center">
                                                                    <div class="me-2">
                                                                        <h6 class="mb-1"><a href="#!"> Frances
                                                                                Guerrero </a></h6>
                                                                        <p class="small mb-0">Removed demands expense
                                                                            account in outward tedious do.</p>
                                                                    </div>
                                                                    <small>5hr</small>
                                                                </div>
                                                            </div>
                                                            <!-- Comment react -->
                                                            <ul class="nav nav-divider py-2 small">
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#!"> Like (3)</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#!"> Reply</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#!"> View 5 replies</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <!-- Comment wrap END -->
                                        </div>
                                        <!-- glightbox Albums left bar END  -->
                                    </div>
                                    <!-- Photo item END -->

                                    <!-- Photo item START -->
                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                        <!-- Photo -->
                                        <a href="assets/images/albums/06.jpg" data-gallery="image-popup" data-glightbox="description: .custom-desc2; descPosition: left;">
                                            <img class="rounded img-fluid" src="assets/images/albums/06.jpg" alt="">
                                        </a>
                                        <!-- likes -->
                                        <ul class="nav nav-stack py-2 small">
                                            <li class="nav-item">
                                                <a class="nav-link" href="#!">
                                                    <i class="bi bi-heart-fill text-danger pe-1"></i>56k </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#!">
                                                    <i class="bi bi-chat-left-text-fill pe-1"></i>12k </a>
                                            </li>
                                        </ul>
                                        <!-- glightbox Albums left bar START -->
                                        <div class="glightbox-desc custom-desc2">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <!-- Avatar -->
                                                    <div class="avatar me-2">
                                                        <img class="avatar-img rounded-circle" src="assets/images/avatar/04.jpg" alt="">
                                                    </div>
                                                    <!-- Info -->
                                                    <div>
                                                        <div class="nav nav-divider">
                                                            <h6 class="nav-item card-title mb-0">Lori Ferguson</h6>
                                                            <span class="nav-item small"> 2hr</span>
                                                        </div>
                                                        <p class="mb-0 small">Web Developer at Webestica</p>
                                                    </div>
                                                </div>
                                                <!-- Card feed action dropdown START -->
                                                <div class="dropdown">
                                                    <a href="#" class="text-secondary btn btn-secondary-soft-hover py-1 px-2" id="cardFeedAction6" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots"></i>
                                                    </a>
                                                    <!-- Card feed action dropdown menu -->
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardFeedAction6">
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-bookmark fa-fw pe-2"></i>Save post</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-person-x fa-fw pe-2"></i>Unfollow lori
                                                                ferguson </a></li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-x-circle fa-fw pe-2"></i>Hide post</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-slash-circle fa-fw pe-2"></i>Block</a>
                                                        </li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-flag fa-fw pe-2"></i>Report post</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <!-- Card feed action dropdown END -->
                                            </div>
                                            <p class="mt-3 mb-0">I'm so privileged to be involved in the @bootstrap
                                                hiring process! <a href="#">#internship #inclusivebusiness</a>
                                                <a href="#">#internship</a> <a href="#"> #hiring</a>
                                                <a href="#">#apply</a></p>
                                            <!-- likes -->
                                            <ul class="nav nav-stack py-3 small">
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="#!">
                                                        <i class="bi bi-hand-thumbs-up-fill pe-1"></i>Liked (56)</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#!"> <i class="bi bi-chat-fill pe-1"></i>Comments
                                                        (12)</a>
                                                </li>
                                                <!-- Card share action START -->
                                                <li class="nav-item dropdown ms-auto">
                                                    <a class="nav-link mb-0" href="#" id="cardShareAction6" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-reply-fill fa-flip-horizontal pe-1"></i>Share
                                                        (3)
                                                    </a>
                                                    <!-- Card share action dropdown menu -->
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardShareAction6">
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-envelope fa-fw pe-2"></i>Send via Direct
                                                                Message</a></li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-bookmark-check fa-fw pe-2"></i>Bookmark
                                                            </a></li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-link fa-fw pe-2"></i>Copy link to
                                                                post</a></li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-share fa-fw pe-2"></i>Share post via
                                                                …</a></li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">
                                                                <i class="bi bi-pencil-square fa-fw pe-2"></i>Share to
                                                                News Feed</a></li>
                                                    </ul>
                                                </li>
                                                <!-- Card share action END -->
                                            </ul>
                                            <!-- Add comment -->
                                            <div class="d-flex mb-3">
                                                <!-- Avatar -->
                                                <div class="avatar avatar-xs me-2">
                                                    <img class="avatar-img rounded-circle" src="assets/images/avatar/04.jpg" alt="">
                                                </div>
                                                <!-- Comment box  -->
                                                <form class="position-relative w-100">
                                                    <textarea class="form-control pe-4 bg-light" rows="1" placeholder="Add a comment..."></textarea>
                                                </form>
                                            </div>
                                            <!-- Comment wrap START -->
                                            <ul class="comment-wrap list-unstyled ">
                                                <!-- Comment item START -->
                                                <li class="comment-item">
                                                    <div class="d-flex">
                                                        <!-- Avatar -->
                                                        <div class="avatar avatar-xs">
                                                            <img class="avatar-img rounded-circle" src="assets/images/avatar/05.jpg" alt="">
                                                        </div>
                                                        <div class="ms-2">
                                                            <!-- Comment by -->
                                                            <div class="bg-light rounded-start-top-0 p-3 rounded">
                                                                <div class="d-flex justify-content-center">
                                                                    <div class="me-2">
                                                                        <h6 class="mb-1"><a href="#!"> Frances
                                                                                Guerrero </a></h6>
                                                                        <p class="small mb-0">Removed demands expense
                                                                            account in outward tedious do.</p>
                                                                    </div>
                                                                    <small>5hr</small>
                                                                </div>
                                                            </div>
                                                            <!-- Comment react -->
                                                            <ul class="nav nav-divider py-2 small">
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#!"> Like (3)</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#!"> Reply</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#!"> View 5 replies</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <!-- Comment wrap END -->
                                        </div>
                                        <!-- glightbox Albums left bar END  -->
                                    </div>
                                    <!-- Photo item END -->
                                </div>
                                <!-- Photos of you tab END -->
                            </div>
                            <!-- Card body END -->
                        </div>
                        <!-- media END -->
                    </div>

                    <div class="profile-section" id="events-tab" style="display: none">
                        <!-- Events START -->
                        <div class="card">
                            <!-- Card header START -->
                            <div class="card-header d-sm-flex align-items-center justify-content-between border-0 pb-0">
                                <h5 class="card-title mb-sm-0">Discover Events</h5>
                                <!-- Button modal -->
                                <a class="btn btn-primary-soft btn-sm" href="#"> <i class="fa-solid fa-plus pe-1"></i>
                                    Create events</a>
                            </div>
                            <!-- Card header END -->
                            <!-- Card body START -->
                            <div class="card-body">
                                <!-- Upcoming event START -->
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Upcoming event:</strong> The learning conference on Sep 19 2022
                                    <a href="events.html" class="btn btn-xs btn-success ms-md-4">View event</a>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <!-- Upcoming event END -->
                                <!-- Events list START -->
                                <div class="row">
                                    <div class="d-sm-flex align-items-center">
                                        <!-- Avatar -->
                                        <div class="avatar avatar-xl">
                                            <a href="#!"><img class="avatar-img rounded border border-white border-3" src="assets/images/events/01.jpg" alt=""></a>
                                        </div>
                                        <div class="ms-sm-4 mt-2 mt-sm-0">
                                            <!-- Info -->
                                            <h5 class="mb-1"><a href="event-details.html"> Comedy on the green </a></h5>
                                            <ul class="nav nav-stack small">
                                                <li class="nav-item">
                                                    <i class="bi bi-calendar-check pe-1"></i> Mon, Sep 25, 2020 at 9:30
                                                    AM
                                                </li>
                                                <li class="nav-item">
                                                    <i class="bi bi-geo-alt pe-1"></i> San francisco
                                                </li>
                                                <li class="nav-item">
                                                    <i class="bi bi-people pe-1"></i> 77 going
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- Button -->
                                        <div class="d-flex mt-3 ms-auto">
                                            <div class="dropdown">
                                                <!-- Card share action menu -->
                                                <button class="icon-md btn btn-secondary-soft" type="button" id="profileAction" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots"></i>
                                                </button>
                                                <!-- Card share action dropdown menu -->
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileAction">
                                                    <li><a class="dropdown-item" href="#">
                                                            <i class="bi bi-bookmark fa-fw pe-2"></i>Share profile in a
                                                            message</a></li>
                                                    <li><a class="dropdown-item" href="#">
                                                            <i class="bi bi-file-earmark-pdf fa-fw pe-2"></i>Save your
                                                            profile to PDF</a></li>
                                                    <li><a class="dropdown-item" href="#">
                                                            <i class="bi bi-lock fa-fw pe-2"></i>Lock profile</a></li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li><a class="dropdown-item" href="#">
                                                            <i class="bi bi-gear fa-fw pe-2"></i>Profile settings</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Events list END -->
                            </div>
                            <!-- Card body END -->
                        </div>
                        <!-- Events END -->


                    </div>
                    <div class="profile-section" id="activity-tab" style="display: none">
                        <!-- Activity feed START -->
                        <div class="card">
                            <!-- Card header START -->
                            <div class="card-header border-0 pb-0">
                                <h5 class="card-title"> Activity feed</h5>
                            </div>
                            <!-- Card header END -->
                            <!-- Card body START -->
                            <div class="card-body">
                                <div class="timeline">

                                    <!-- Timeline item START -->
                                    <div class="timeline-item">
                                        <!-- Timeline icon -->
                                        <div class="timeline-icon">
                                            <div class="avatar text-center">
                                                <img class="avatar-img rounded-circle" src="assets/images/avatar/07.jpg" alt="">
                                            </div>
                                        </div>
                                        <!-- Timeline content -->
                                        <div class="timeline-content">
                                            <div class="d-sm-flex justify-content-between">
                                                <div>
                                                    <p class="small mb-0"><b>Sam Lanson</b> update a playlist on
                                                        webestica.</p>
                                                    <p class="small mb-0"><i class="bi bi-unlock-fill pe-1"></i>Public
                                                    </p>
                                                </div>
                                                <p class="small ms-sm-3 mt-2 mt-sm-0 text-nowrap">Just now</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Timeline item END -->

                                    <!-- Timeline item START -->
                                    <div class="timeline-item">
                                        <!-- Timeline icon -->
                                        <div class="timeline-icon">
                                            <div class="avatar text-center">
                                                <img class="avatar-img rounded-circle" src="assets/images/avatar/01.jpg" alt="">
                                            </div>
                                        </div>
                                        <!-- Timeline content -->
                                        <div class="timeline-content">
                                            <div class="d-sm-flex justify-content-between">
                                                <div>
                                                    <p class="small mb-0"><b>Billy Vasquez</b> save a
                                                        <a href="#!">link.</a></p>
                                                    <p class="small mb-0"><i class="bi bi-lock-fill pe-1"></i>only me
                                                    </p>
                                                </div>
                                                <p class="small ms-sm-3 mt-2 mt-sm-0">2min</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Timeline item END -->

                                    <!-- Timeline item START -->
                                    <div class="timeline-item align-items-center">
                                        <!-- Timeline icon -->
                                        <div class="timeline-icon">
                                            <div class="avatar text-center">
                                                <div class="avatar-img rounded-circle bg-success">
                                                    <span class="text-white position-absolute top-50 start-50 translate-middle fw-bold">SM</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Timeline content -->
                                        <div class="timeline-content">
                                            <div class="d-sm-flex justify-content-between">
                                                <div>
                                                    <p class="small mb-0"><b>Sam Lanson</b> liked <b> Frances
                                                            Guerrero's </b> add comment.</p>
                                                    <p class="small mb-0">This is the best picture I have come across
                                                        today.... </p>
                                                </div>
                                                <p class="small mb-0 ms-sm-3">1hr</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Timeline item END -->

                                    <!-- Timeline item START -->
                                    <div class="timeline-item align-items-center">
                                        <!-- Timeline icon -->
                                        <div class="timeline-icon">
                                            <div class="avatar text-center">
                                                <img class="avatar-img rounded-circle" src="assets/images/avatar/02.jpg" alt="">
                                            </div>
                                        </div>
                                        <!-- Timeline content -->
                                        <div class="timeline-content">
                                            <div class="d-sm-flex justify-content-between">
                                                <div>
                                                    <p class="small mb-0"><b>Judy Nguyen</b> likes <b>Jacqueline
                                                            Miller</b> Photos. </p>
                                                    <p class="mb-0">✌️👌👍</p>
                                                </div>
                                                <p class="small ms-sm-3 mt-2 mt-sm-0">4hr</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Timeline item END -->

                                    <!-- Timeline item START -->
                                    <div class="timeline-item">
                                        <!-- Timeline icon -->
                                        <div class="timeline-icon">
                                            <div class="avatar text-center">
                                                <img class="avatar-img rounded-circle" src="assets/images/avatar/03.jpg" alt="">
                                            </div>
                                        </div>
                                        <!-- Timeline content -->
                                        <div class="timeline-content">
                                            <div class="d-sm-flex justify-content-between">
                                                <div>
                                                    <p class="small mb-0"><b>Larry Lawson</b></p>
                                                    <p class="small mb-2">Replied to your comment on Blogzine blog
                                                        theme</p>
                                                    <small class="bg-light rounded p-2 d-block">
                                                        Yes, I am so excited to see it live. 👍
                                                    </small>
                                                </div>
                                                <p class="small ms-sm-3 mt-2 mt-sm-0">10hr</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Timeline item END -->

                                </div>
                            </div>
                            <!-- Card body END -->
                            <!-- Card footer START -->
                            <div class="card-footer border-0 py-3 text-center position-relative d-grid pt-0">
                                <!-- Load more button START -->
                                <a href="#!" role="button" class="btn btn-sm btn-loader btn-primary-soft" data-bs-toggle="button" aria-pressed="true">
                                    <span class="load-text"> Load more activity </span>
                                    <div class="load-icon">
                                        <div class="spinner-grow spinner-grow-sm" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </a>
                                <!-- Load more button END -->
                            </div>
                            <!-- Card footer END -->
                        </div>
                        <!-- Activity feed END -->
                    </div>
                </div>
            </div>
            <!-- Main content END -->

            <!-- Right sidebar START -->
            <div class="col-lg-4">

                <div class="row g-4">

                    <!-- Card START -->
                    <div class="col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header border-0 pb-0">
                                <h5 class="card-title">About</h5>
                                <!-- Button modal -->
                            </div>
                            <!-- Card body START -->
                            <div class="card-body position-relative pt-0">
                                <p>{{ $profile->info }}</p>
                                <!-- Date time -->
                                <ul class="list-unstyled mt-3 mb-0">
                                    <li class="mb-2"><i class="bi bi-calendar-date fa-fw pe-1"></i> Born: <strong>
                                            {{ \Carbon\Carbon::parse($profile->date_of_birth)->format('jS \\o\\f F, Y') }} </strong>
                                    </li>
                                    @isset($profile->relationship)
                                        <li class="mb-2"><i class="bi bi-heart fa-fw pe-1"></i> Status: <strong>
                                                {{ $profile->relationship->name }} </strong>
                                        </li>
                                    @endisset
                                    <li><i class="bi bi-envelope fa-fw pe-1"></i> Email: <strong>
                                            {{ $profile->email }} </strong></li>
                                </ul>
                            </div>
                            <!-- Card body END -->
                        </div>
                    </div>
                    <!-- Card END -->

                    <!-- Card START -->
                    <div class="col-md-6 col-lg-12">
                        <div class="card">
                            <!-- Card header START -->
                            <div class="card-header d-flex justify-content-between border-0">
                                <h5 class="card-title">Experience</h5>
                                @if($profile->id === $user->id)
                                    <a class="btn btn-primary-soft btn-sm" href="#!"> <i class="fa-solid fa-plus"></i>
                                    </a>
                                @endif
                            </div>
                            <!-- Card header END -->
                            <!-- Card body START -->
                            <div class="card-body position-relative pt-0">
                                <!-- Experience item START -->
                                <div class="d-flex">
                                    <!-- Avatar -->
                                    <div class="avatar me-3">
                                        <a href="#!">
                                            <img class="avatar-img rounded-circle" src="{{asset('assets/images/logo/08.svg')}}" alt="">
                                        </a>
                                    </div>
                                    <!-- Info -->
                                    <div>
                                        <h6 class="card-title mb-0"><a href="#!"> Apple Computer, Inc. </a></h6>
                                        <p class="small">May 2015 – Present Employment Duration 8 mos
                                            @if($profile->id === $user->id)
                                                <a class="btn btn-primary-soft btn-xs ms-2" href="#!">Edit </a>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <!-- Experience item END -->

                                <!-- Experience item START -->
                                <div class="d-flex">
                                    <!-- Avatar -->
                                    <div class="avatar me-3">
                                        <a href="#!">
                                            <img class="avatar-img rounded-circle" src="{{asset('assets/images/logo/09.svg')}}" alt="">
                                        </a>
                                    </div>
                                    <!-- Info -->
                                    <div>
                                        <h6 class="card-title mb-0"><a href="#!"> Microsoft Corporation </a></h6>
                                        <p class="small">May 2017 – Present Employment Duration 1 yrs 5 mos
                                            @if($profile->id === $user->id)
                                                <a class="btn btn-primary-soft btn-xs ms-2" href="#!">Edit </a>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <!-- Experience item END -->

                                <!-- Experience item START -->
                                <div class="d-flex">
                                    <!-- Avatar -->
                                    <div class="avatar me-3">
                                        <a href="#!">
                                            <img class="avatar-img rounded-circle" src="{{asset('assets/images/logo/10.svg')}}" alt="">
                                        </a>
                                    </div>
                                    <!-- Info -->
                                    <div>
                                        <h6 class="card-title mb-0"><a href="#!"> Tata Consultancy Services. </a></h6>
                                        <p class="small mb-0">May 2022 – Present Employment Duration 6 yrs 10 mos
                                            @if($profile->id === $user->id)
                                                <a class="btn btn-primary-soft btn-xs ms-2" href="#!">Edit </a>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <!-- Experience item END -->

                            </div>
                            <!-- Card body END -->
                        </div>
                    </div>
                    <!-- Card END -->

                    <!-- Card START -->
                    <div class="col-md-6 col-lg-12">
                        <div class="card">
                            <!-- Card header START -->
                            <div class="card-header d-sm-flex justify-content-between border-0">
                                <h5 class="card-title">Photos</h5>
                                <a class="btn btn-primary-soft btn-sm" href="#!"> See all photo</a>
                            </div>
                            <!-- Card header END -->
                            <!-- Card body START -->
                            <div class="card-body position-relative pt-0">
                                <div class="row g-2">
                                    <!-- Photos item -->
                                    <div class="col-6">
                                        <a href="assets/images/albums/01.jpg" data-gallery="image-popup" data-glightbox="">
                                            <img class="rounded img-fluid" src="{{asset('assets/images/albums/01.jpg')}}" alt="">
                                        </a>
                                    </div>
                                    <!-- Photos item -->
                                    <div class="col-6">
                                        <a href="assets/images/albums/02.jpg" data-gallery="image-popup" data-glightbox="">
                                            <img class="rounded img-fluid" src="{{asset('assets/images/albums/02.jpg')}}" alt="">
                                        </a>
                                    </div>
                                    <!-- Photos item -->
                                    <div class="col-4">
                                        <a href="assets/images/albums/03.jpg" data-gallery="image-popup" data-glightbox="">
                                            <img class="rounded img-fluid" src="{{asset('assets/images/albums/03.jpg')}}" alt="">
                                        </a>
                                    </div>
                                    <!-- Photos item -->
                                    <div class="col-4">
                                        <a href="assets/images/albums/04.jpg" data-gallery="image-popup" data-glightbox="">
                                            <img class="rounded img-fluid" src="{{asset('assets/images/albums/04.jpg')}}" alt="">
                                        </a>
                                    </div>
                                    <!-- Photos item -->
                                    <div class="col-4">
                                        <a href="assets/images/albums/05.jpg" data-gallery="image-popup" data-glightbox="">
                                            <img class="rounded img-fluid" src="{{asset('assets/images/albums/05.jpg')}}" alt="">
                                        </a>
                                        <!-- glightbox Albums left bar END  -->
                                    </div>
                                </div>
                            </div>
                            <!-- Card body END -->
                        </div>
                    </div>
                    <!-- Card END -->

                    <!-- Card START -->
                    <div class="col-md-6 col-lg-12">
                        <div class="card">
                            <!-- Card header START -->
                            <div class="card-header d-sm-flex justify-content-between align-items-center border-0">
                                <h5 class="card-title">Following
                                    <span class="badge bg-success bg-opacity-10 text-success">{{$profile->followings->count()}}</span>
                                </h5>
                                <a class="btn btn-primary-soft btn-sm" href="#followers-tab"> See all follows</a>
                            </div>
                            <!-- Card header END -->
                            <!-- Card body START -->
                            <div class="card-body position-relative pt-0">
                                <div class="row g-3">

                                    @foreach($profile->followings->slice(0, 4) as $following)
                                        <x-profile.following-card :user="$following" :profile="$profile" :self="$user"/>
                                    @endforeach

                                </div>
                            </div>
                            <!-- Card body END -->
                        </div>
                    </div>
                    <!-- Card END -->
                </div>

            </div>
            <!-- Right sidebar END -->

        </div> <!-- Row END -->
    </div>
    <!-- Container END -->

</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navButtons = document.querySelectorAll('.profile-link');

        navButtons.forEach(function (button) {
            button.addEventListener('click', function (e) {
                updateActiveButton(navButtons, e.target);
            })
        });

        changeDisplay();
        updateActiveButton(navButtons);
        window.addEventListener('hashchange', function () {
            changeDisplay();
            updateActiveButton(navButtons);
        });
    });

    function changeDisplay() {
        const profileSections = document.querySelectorAll('.profile-section');
        const hash = window.location.hash;
        if (hash) {
            const section = document.querySelector(hash);
            if (section) {
                profileSections.forEach(function (profileSection) {
                    profileSection.style.display = 'none';
                })
                section.style.display = 'block';
            }
        } else {
            document.querySelector('#posts-tab').style.display = 'block';
        }
    }

    function updateActiveButton(navButtons, activeButton = null) {
        navButtons.forEach(button => {
            if (button === activeButton || button.hash === window.location.hash) {
                button.classList.add('active');
            } else {
                button.classList.remove('active');
            }
        });
    }

</script>

<script src="{{ asset('js/profile/post.js') }}"></script>
<script src="{{ asset('js/posts/comment.js') }}"></script>
