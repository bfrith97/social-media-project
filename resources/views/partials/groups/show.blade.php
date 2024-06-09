<main class="flex-grow-1">
    <!-- Container START -->
    <div class="container">
        <div class="row g-4">

            <!-- Sidenav START -->
            <div class="col-lg-3">

                <!-- Advanced filter responsive toggler START -->
                <div class="d-flex align-items-center d-lg-none">
                    <button class="border-0 bg-transparent" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSideNavbar" aria-controls="offcanvasSideNavbar">
                        <span class="btn btn-primary"><i class="fa-solid fa-sliders-h"></i></span>
                        <span class="h6 mb-0 fw-bold d-lg-none ms-2">My profile</span>
                    </button>
                </div>
                <!-- Advanced filter responsive toggler END -->

                <!-- Navbar START-->
                <x-shared.left-side-nav :user="$user"/>
                <!-- Navbar END-->
            </div>
            <!-- Sidenav END -->

            <!-- Main content START -->
            <div class="col-md-8 col-lg-9 vstack gap-4">
                <!-- Card START -->
                <div class="card">
                    <!-- Card body START -->
                    <div class="card-body">
                        <div class="d-md-flex flex-wrap align-items-start text-center text-md-start">
                            <div class="mb-2">
                                <!-- Avatar -->
                                <div class="avatar avatar-xl">
                                    <img class="avatar-img border-0" src="" alt="">
                                </div>
                            </div>
                            <div class="ms-md-4 mt-3">
                                <!-- Info -->
                                <h1 class="h5 mb-0">{{$group->name}}
                                    <i class="bi bi-patch-check-fill text-success small"></i></h1>
                                <ul class="nav nav-divider justify-content-center justify-content-md-start">
                                    <li class="nav-item"> {{$group->private ? 'Private' : 'Public'}} group</li>
                                    <li class="nav-item"> {{$group->members->count()}} members</li>
                                </ul>
                            </div>
                            <!-- Button -->
                            <div class="d-flex justify-content-center justify-content-md-start align-items-center mt-3 ms-lg-auto">
                                <form action="{{ route('group_users.store') }}" method="post" class="follow-form" onsubmit="submitJoin(event)">
                                    @csrf
                                    @if($group->joined_by_current_user)
                                        <input type="hidden" name="_method" value="DELETE" class="delete_method">
                                    @endif
                                    <input type="hidden" name="group_id" value="{{$group->id}}"/>
                                    <input type="hidden" name="user_id" value="{{$user->id}}"/>
                                    @if($group->joined_by_current_user)
                                        <button type="submit" class="btn btn-danger-soft btn-sm join-button">
                                            Leave group
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-success-soft btn-sm join-button">
                                            Join group
                                        </button>
                                    @endif
                                </form>
                                <button class="btn btn-sm btn-success mx-2" type="button">
                                    <i class="fa-solid fa-plus pe-1"></i> Invite
                                </button>
                                <div class="dropdown">
                                    <!-- Group share action menu -->
                                    <button class="icon-sm btn btn-dark-soft" type="button" id="groupAction" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <!-- Group share action dropdown menu -->
                                    <ul class="dropdown-menu dropdown-menu-end py-2" aria-labelledby="groupAction">
                                        <li><a class="dropdown-item" href="#">
                                                <i class="bi bi-chat-left-text fa-fw pe-2"></i>Share
                                                as a message</a>
                                        </li>
                                        <li><a class="dropdown-item" href="#"> <i class="bi bi-share fa-fw pe-2"></i>Share
                                                as a post<a>
                                        </li>
                                        @if($group->current_user_is_admin)
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="#"> <i class="bi bi-gear fa-fw pe-2"></i>Group
                                                    settings</a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Join group START -->
                        <ul class="avatar-group list-unstyled justify-content-center justify-content-md-start align-items-center mb-0 mt-3 flex-wrap">
                            @if($group->members_count >= 1)
                                @foreach($group->members->take(3) as $member)
                                    <li class="avatar avatar-xs">
                                        <img class="avatar-img rounded-circle" src="{{ asset($member->profile_picture) }}" alt="Image of {{$member->name}}">
                                    </li>
                                @endforeach
                            @endif
                            <li class="small text-center ms-3">
                                @if ($group->members_count == 1)
                                    {{$memberNames->first()}} is a member
                                @elseif ($group->members_count == 2)
                                    {{$memberNames->join(' and ')}} are members
                                @elseif ($group->members_count >2)
                                    {{ $memberNames->take(2)->join(', ') }},
                                    @if($group->members_count > 2)
                                        and {{ $group->members_count - 2 }} others are members
                                    @endif
                                @endif
                            </li>

                        </ul>
                        <!-- Join group END -->
                    </div>
                    <!-- Card body END -->
                    <div class="card-footer pb-0">
                        <ul class="nav nav-tabs nav-bottom-line justify-content-center justify-content-md-start mb-0">
                            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#group-tab-1">
                                    Feed </a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#group-tab-2">
                                    About </a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#group-tab-3">
                                    Members
                                    <span class="badge bg-success bg-opacity-10 text-success small"> {{$group->members_count}}</span>
                                </a>
                            </li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#group-tab-4"> Media</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#group-tab-5">
                                    Videos</a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#group-tab-6">
                                    Events</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Card END -->

                <div class="tab-content pt-0 pb-0 mb-0">

                    <!-- Gruop Feed tab START -->
                    <div class="tab-pane show active fade" id="group-tab-1">
                        <div class="row g-4">
                            <div class="col-lg-8 vstack gap-4">
                                <x-posts.post-creation :user="$user" :group="$group" :onProfile="false"/>

                                <div id="posts">
                                    @foreach($group->posts as $post)
                                        <x-posts.post-card :post="$post" :user="$user" has-margin="true"/>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <!-- About START -->
                                <div class="card">
                                    <!-- Title -->
                                    <div class="card-header border-0 pb-0">
                                        <h5 class="card-title">About</h5>
                                    </div>
                                    <!-- Card body START -->
                                    <div class="card-body position-relative pt-0">
                                        <p>{{$group->description}}</p>
                                        <!-- info -->
                                        <ul class="list-unstyled mt-3 mb-0">
                                            <li class="mb-2"><i class="bi bi-calendar-date fa-fw pe-1"></i> Members:
                                                <strong> {{$group->members->count()}} </strong></li>
                                            <li class="mb-2"><i class="bi bi-heart fa-fw pe-1"></i> Status:
                                                <strong> {{$group->private ? 'Private' : 'Public'}} </strong></li>
                                            <li class="mb-2"><i class="bi bi-globe2 fa-fw pe-1"></i>
                                                <strong> {{$group->website}} </strong></li>
                                        </ul>
                                    </div>
                                    <!-- Card body END -->
                                </div>
                                <!-- About END -->
                            </div>
                        </div>
                    </div>
                    <!-- Gruop Feed tab END -->

                    <!-- Gruop About tab END -->
                    <div class="tab-pane fade show" id="group-tab-2">
                        <div class="card">
                            <div class="card-header border-0 pb-0">
                                <h5 class="card-title"> About</h5>
                            </div>
                            <div class="card-body">
                                <div class="rounded border px-3 py-2 mb-3">
                                    <p class="my-1">{{ $group->description }}</p>
                                </div>
                                <div class="row g-4">
                                    <div class="col-sm-6">
                                        <!-- Members START -->
                                        <div class="d-flex align-items-center rounded border px-3 py-2">
                                            <!-- Date -->
                                            <p class="my-1">
                                                <i class="bi bi-people fa-fw me-2"></i> Members:
                                                <strong> {{ $group->members_count }} </strong>
                                            </p>
                                        </div>
                                        <!-- Members END -->
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- Posts START -->
                                        <div class="d-flex align-items-center rounded border px-3 py-2">
                                            <!-- Date -->
                                            <p class="my-1">
                                                <i class="bi bi-body-text fa-fw me-2"></i> Posts:
                                                <strong> {{ $group->posts_count }} </strong>
                                            </p>
                                        </div>
                                        <!-- Posts END -->
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- Created START -->
                                        <div class="d-flex align-items-center rounded border px-3 py-2">
                                            <!-- Date -->
                                            <p class="my-1">
                                                <i class="bi bi-calendar-date fa-fw me-2"></i> Created on:
                                                <strong>{{ $group->created_at->format('jS \\o\\f F, Y') }}</strong>
                                            </p>
                                        </div>
                                        <!-- Created END -->
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- Website START -->
                                        <div class="d-flex align-items-center rounded border px-3 py-2">
                                            <!-- Date -->
                                            <p class="my-1">
                                                <i class="bi bi-globe fa-fw me-2"></i> Website:
                                                <strong> {{ $group->website }} </strong>
                                            </p>
                                        </div>
                                        <!-- Website END -->
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- Type START -->
                                        <div class="d-flex align-items-center rounded border px-3 py-2">
                                            <!-- Date -->
                                            <p class="my-1">
                                                <i class="bi bi-tag fa-fw me-2"></i> Type:
                                                <strong> {{ $group->is_private ? 'Private' : 'Public' }} </strong>
                                            </p>
                                        </div>
                                        <!-- Type END -->
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- Category on START -->
                                        <div class="d-flex align-items-center rounded border px-3 py-2">
                                            <!-- Date -->
                                            <p class="my-1">
                                                <i class="bi bi-activity fa-fw me-2"></i> Category:
                                                <strong> {{ $group->groupCategory?->name }} </strong>
                                            </p>
                                        </div>
                                        <!-- Category on END -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Gruop About tab END -->

                    <!-- Gruop Connections tab END -->
                    <div class="tab-pane fade show" id="group-tab-3">
                        <div class="card">
                            <div class="card-header border-0 pb-0">
                                @if($group->members_count >= 1)
                                    <h5 class="card-title mb-3"> Members</h5>
                                @endif
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    @if($group->members_count >= 1)
                                        @foreach($group->members as $member)
                                            <div class="col-sm-6 col-lg-6 mt-0">
                                                <x-groups.member-card-row :otherUser="$member" :user="$user"/>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="my-sm-5 py-sm-5 text-center">
                                            <!-- Icon -->
                                            <i class="display-1 text-body-secondary bi bi-people"> </i>
                                            <!-- Title -->
                                            <h4 class="mt-2 mb-3 text-body">No members</h4>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Gruop Connections tab END -->

                    <!-- Gruop Media tab END -->
                    <div class="tab-pane fade show" id="group-tab-4">
                        <div class="card card-body">
                            <div class="my-sm-5 py-sm-5 text-center">
                                <!-- Icon -->
                                <i class="display-1 text-body-secondary bi bi-film"> </i>
                                <!-- Title -->
                                <h4 class="mt-2 mb-3 text-body">No media</h4>
                            </div>
                        </div>
                    </div>
                    <!-- Gruop Media tab END -->

                    <!-- Gruop Videos tab END -->
                    <div class="tab-pane fade show" id="group-tab-5">
                        <div class="card card-body">
                            <div class="my-sm-5 py-sm-5 text-center">
                                <!-- Icon -->
                                <i class="display-1 text-body-secondary bi bi-camera-reels"> </i>
                                <!-- Title -->
                                <h4 class="mt-2 mb-3 text-body">No videos</h4>
                            </div>
                        </div>
                    </div>
                    <!-- Gruop Videos tab END -->

                    <!-- Gruop Events tab END -->
                    <div class="tab-pane fade show" id="group-tab-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-4">
                                    @if($group->events_count >= 1)
                                        <div class="row g-4">
                                            @foreach($group->events as $event)
                                                <x-groups.event-card :event="$event" />
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="my-sm-5 py-sm-5 text-center">
                                            <!-- Icon -->
                                            <i class="display-1 text-body-secondary bi bi-people"> </i>
                                            <!-- Title -->
                                            <h4 class="mt-2 mb-3 text-body">No events</h4>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Gruop Events tab END -->
                </div>

            </div>
        </div> <!-- Row END -->
    </div>
    <!-- Container END -->

</main>
<!-- **************** MAIN CONTENT END **************** -->

<!-- Modal create Feed START -->
<div class="modal fade" id="modalCreateFeed" tabindex="-1" aria-labelledby="modalLabelCreateFeed" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Modal feed header START -->
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelCreateFeed">Create post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal feed header END -->

            <!-- Modal feed body START -->
            <div class="modal-body">
                <!-- Add Feed -->
                <div class="d-flex mb-3">
                    <!-- Avatar -->
                    <div class="avatar avatar-xs me-2">
                        <img class="avatar-img rounded-circle mt-2" src="{{ $user->profile_picture ? asset($user->profile_picture) : ''}}" alt="">
                    </div>
                    <!-- Feed box  -->
                    <form id="feeling-form" class="w-100 input-group" action="{{ route('posts.store') }}" method="post" onsubmit="submitPost(event)">
                        @csrf
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text bg-white border-0 fs-3">I'm Feeling:</span>
                            <input type="hidden" name="user_id" value="{{$user->id}}"/>
                            <input type="hidden" name="is_feeling" value="1"/>
                            <input type="text" class="form-control border-0 fs-3" placeholder="Happy? Sad?" name="content" required maxlength="14">
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal feed body END -->

            <!-- Modal feed footer -->
            <div class="modal-footer row justify-content-between">
                <!-- Select -->
                <div class="col-lg-3">
                    <select class="form-select js-choice choice-select-text-none" data-position="top" data-search-enabled="false">
                        <option value="PB">Public</option>
                        <option value="PV">Friends</option>
                        <option value="PV">Only me</option>
                        <option value="PV">Custom</option>
                    </select>
                    <!-- Button -->
                </div>
                <div class="col-lg-8 text-sm-end">
                    <button type="submit" class="btn btn-sm btn-success-soft" form="feeling-form">Post</button>
                </div>
            </div>
            <!-- Modal feed footer -->

        </div>
    </div>
</div>
<!-- Modal create feed END -->

<!-- Modal create Feed photo START -->
<div class="modal fade" id="feedActionPhoto" tabindex="-1" aria-labelledby="feedActionPhotoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal feed header START -->
            <div class="modal-header">
                <h5 class="modal-title" id="feedActionPhotoLabel">Add post photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal feed header END -->

            <!-- Modal feed body START -->
            <div class="modal-body">
                <form id="post-image-form" class="w-100" action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <input type="hidden" name="is_feeling" value="0">

                    <!-- Add Feed -->
                    <div class="d-flex mb-3">
                        <!-- Avatar -->
                        <div class="avatar avatar-xs me-2">
                            <img class="avatar-img rounded-circle" src="{{ $user->profile_picture ? asset($user->profile_picture) : ''}}" alt="">
                        </div>
                        <!-- Feed box  -->
                        @csrf
                        <textarea name="content" required class="form-control pe-4 fs-3 lh-1 border-0 pb-0" rows="2" placeholder="This image's caption..."></textarea>

                    </div>
                    <div class="input-group">
                        <input type="file" class="form-control" id="image" name="image_path" accept="image/*">
                    </div>

                    <div class="preview mt-3">
                    </div>

                </form>
            </div>
            <!-- Modal feed body END -->

            <!-- Modal feed footer -->
            <div class="modal-footer ">
                <!-- Button -->
                <button type="button" class="btn btn-sm btn-danger-soft me-2" data-bs-dismiss="modal">Cancel</button>
                <button id="post-image-form-submit" type="submit" class="btn btn-sm btn-success-soft" form="post-image-form">Post</button>
            </div>
            <!-- Modal feed footer -->
        </div>
    </div>
</div>
<!-- Modal create Feed photo END -->

<!-- Modal create Feed video START -->
<div class="modal fade" id="feedActionVideo" tabindex="-1" aria-labelledby="feedActionVideoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal feed header START -->
            <div class="modal-header">
                <h5 class="modal-title" id="feedActionVideoLabel">Add post video</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal feed header END -->

            <!-- Modal feed body START -->
            <div class="modal-body">
                <!-- Add Feed -->
                <div class="d-flex mb-3">
                    <!-- Avatar -->
                    <div class="avatar avatar-xs me-2">
                        <img class="avatar-img rounded-circle" src="" alt="">
                    </div>
                    <!-- Feed box  -->
                    <form class="w-100">
                        <textarea class="form-control pe-4 fs-3 lh-1 border-0" rows="2" placeholder="Share your thoughts..."></textarea>
                    </form>
                </div>

                <!-- Dropzone photo START -->
                <div>
                    <label class="form-label">Upload attachment</label>
                    <div class="dropzone dropzone-default card shadow-none" data-dropzone='{"maxFiles":2}'>
                        <div class="dz-message">
                            <i class="bi bi-camera-reels display-3"></i>
                            <p>Drag here or click to upload video.</p>
                        </div>
                    </div>
                </div>
                <!-- Dropzone photo END -->

            </div>
            <!-- Modal feed body END -->

            <!-- Modal feed footer -->
            <div class="modal-footer">
                <!-- Button -->
                <button type="button" class="btn btn-danger-soft me-2"><i class="bi bi-camera-video-fill pe-1"></i> Live
                    video
                </button>
                <button type="button" class="btn btn-success-soft">Post</button>
            </div>
            <!-- Modal feed footer -->
        </div>
    </div>
</div>
<!-- Modal create Feed video END -->

<!-- Modal create events START -->
<div class="modal fade" id="modalCreateEvents" tabindex="-1" aria-labelledby="modalLabelCreateAlbum" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal feed header START -->
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelCreateAlbum">Create event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal feed header END -->
            <!-- Modal feed body START -->
            <div class="modal-body">
                <!-- Form START -->
                <form class="row g-4">
                    <!-- Title -->
                    <div class="col-12">
                        <label class="form-label">Title</label>
                        <input type="email" class="form-control" placeholder="Event name here">
                    </div>
                    <!-- Description -->
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="2" placeholder="Ex: topics, schedule, etc."></textarea>
                    </div>
                    <!-- Date -->
                    <div class="col-sm-4">
                        <label class="form-label">Date</label>
                        <input type="text" class="form-control flatpickr" placeholder="Select date">
                    </div>
                    <!-- Time -->
                    <div class="col-sm-4">
                        <label class="form-label">Time</label>
                        <input type="text" class="form-control flatpickr" data-enableTime="true" data-noCalendar="true" placeholder="Select time">
                    </div>
                    <!-- Duration -->
                    <div class="col-sm-4">
                        <label class="form-label">Duration</label>
                        <input type="email" class="form-control" placeholder="1hr 23m">
                    </div>
                    <!-- Location -->
                    <div class="col-12">
                        <label class="form-label">Location</label>
                        <input type="email" class="form-control" placeholder="Logansport, IN 46947">
                    </div>
                    <!-- Add guests -->
                    <div class="col-12">
                        <label class="form-label">Add guests</label>
                        <input type="email" class="form-control" placeholder="Guest email">
                    </div>
                    <!-- Avatar group START -->
                    <div class="col-12 mt-3">
                        <ul class="avatar-group list-unstyled align-items-center mb-0">
                            <li class="avatar avatar-xs">
                                <img class="avatar-img rounded-circle" src="" alt="avatar">
                            </li>
                            <li class="ms-3">
                                <small> +50 </small>
                            </li>
                        </ul>
                    </div>
                    <!-- Upload Photos or Videos -->
                    <!-- Dropzone photo START -->
                    <div>
                        <label class="form-label">Upload attachment</label>
                        <div class="dropzone dropzone-default card shadow-none" data-dropzone='{"maxFiles":2}'>
                            <div class="dz-message">
                                <i class="bi bi-file-earmark-text display-3"></i>
                                <p>Drop presentation and document here or click to upload.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Dropzone photo END -->
                </form>
                <!-- Form END -->
            </div>
            <!-- Modal feed body END -->
            <!-- Modal footer -->
            <!-- Button -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger-soft me-2" data-bs-dismiss="modal"> Cancel</button>
                <button type="button" class="btn btn-success-soft">Create now</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal create events END -->
