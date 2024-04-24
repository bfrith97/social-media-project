<!-- Navbar START-->
<nav class="navbar navbar-expand-lg mx-0">
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSideNavbar">
        <!-- Offcanvas header -->
        <div class="offcanvas-header">
            <button type="button" class="btn-close text-reset ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <!-- Offcanvas body -->
        <div class="offcanvas-body d-block px-2 px-lg-0">
            <!-- Card START -->
            <div class="card overflow-hidden">
                <!-- Cover image -->
                <div class="h-50px" style="background-image:url(assets/images/bg/01.jpg); background-position: center; background-size: cover; background-repeat: no-repeat;"></div>
                <!-- Card body START -->
                <div class="card-body pt-0">
                    <div class="text-center">
                        <!-- Avatar -->
                        <div class="avatar avatar-lg mt-n5 mb-3">
                            <a href="#!"><img class="avatar-img rounded border border-white border-3" src="{{ asset($user->picture) }}" alt=""></a>
                        </div>
                        <!-- Info -->
                        <h5 class="mb-0"><a href="{{ route('profiles.show', $user->id) }}">{{$user->name}}</a></h5>
                        @isset($user->role)
                            <small>{{$user->role}} @isset($user->company)
                                    at {{$user->company}}
                                @endisset</small>
                        @endisset

                        @isset($user->info)
                            <p class="mt-3">{{$user->info}}
                            </p>
                        @endisset

                        <!-- User stat START -->
                        <div class="hstack gap-2 gap-xl-3 justify-content-center mt-3">
                            <!-- User stat item -->
                            <div>
                                <h6 class="mb-0">{{$user->posts->count()}}</h6>
                                <small>Posts</small>
                            </div>
                            <!-- Divider -->
                            <div class="vr"></div>
                            <!-- User stat item -->
                            <div>
                                <h6 class="mb-0">{{$user->followers->count()}}</h6>
                                <small>Followers</small>
                            </div>
                            <!-- Divider -->
                            <div class="vr"></div>
                            <!-- User stat item -->
                            <div>
                                <h6 class="mb-0">{{$user->followings->count()}}</h6>
                                <small>Following</small>
                            </div>
                        </div>
                        <!-- User stat END -->
                    </div>

                    <!-- Divider -->
                    <hr>

                    <!-- Side Nav START -->
                    <ul class="nav nav-link-secondary flex-column fw-bold gap-2">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('posts.index')}}">
                                <img class="me-2 h-20px fa-fw" src="assets/images/icon/home-outline-filled.svg" alt=""><span>Feed </span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profiles.show', $user->id) . '#followers-tab' }}">
                                <img class="me-2 h-20px fa-fw" src="assets/images/icon/person-outline-filled.svg" alt=""><span>Connections </span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('news.index')}}">
                                <img class="me-2 h-20px fa-fw" src="assets/images/icon/earth-outline-filled.svg" alt=""><span>Latest News </span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('events.index')}}">
                                <img class="me-2 h-20px fa-fw" src="assets/images/icon/calendar-outline-filled.svg" alt=""><span>Events </span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('groups.index')}}">
                                <img class="me-2 h-20px fa-fw" src="assets/images/icon/chat-outline-filled.svg" alt=""><span>Groups </span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="notifications.html">
                                <img class="me-2 h-20px fa-fw" src="assets/images/icon/notification-outlined-filled.svg" alt=""><span>Notifications </span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('settings.edit')}}">
                                <img class="me-2 h-20px fa-fw" src="assets/images/icon/cog-outline-filled.svg" alt=""><span>Settings </span></a>
                        </li>
                    </ul>
                    <!-- Side Nav END -->
                </div>
                <!-- Card body END -->
                <!-- Card footer -->
                <div class="card-footer text-center py-2">
                    <a class="btn btn-link btn-sm" href="{{ route('profiles.show', $user->id) }}">View Profile </a>
                </div>
            </div>
            <!-- Card END -->
        </div>
    </div>
</nav>
<!-- Navbar END-->
