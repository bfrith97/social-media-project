<main>

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
                                    <img class="avatar-img border-0" src="assets/images/logo/13.svg" alt="">
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
                                <form action="{{ route('group_users.store') }}" method="post" class="follow-form">
                                    @csrf
                                    @if($group->joined_by_current_user)
                                        <input type="hidden" name="_method" value="DELETE" class="delete_method">
                                    @endif
                                    <input type="hidden" name="group_id" value="{{$group->id}}"/>
                                    <input type="hidden" name="user_id" value="{{$user->id}}"/>
                                    @if($group->joined_by_current_user)
                                        <button type="button" class="btn btn-danger-soft btn-sm join-button">
                                            Leave group
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-success-soft btn-sm join-button">
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
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="groupAction">
                                        <li><a class="dropdown-item" href="#"> <i class="bi bi-bookmark fa-fw pe-2"></i>Share
                                                profile in a message</a></li>
                                        <li><a class="dropdown-item" href="#">
                                                <i class="bi bi-file-earmark-pdf fa-fw pe-2"></i>Save your profile to
                                                PDF</a></li>
                                        <li><a class="dropdown-item" href="#"> <i class="bi bi-lock fa-fw pe-2"></i>Lock
                                                profile</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="#"> <i class="bi bi-gear fa-fw pe-2"></i>Profile
                                                settings</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Join group START -->
                        <ul class="avatar-group list-unstyled justify-content-center justify-content-md-start align-items-center mb-0 mt-3 flex-wrap">
                            <li class="avatar avatar-xs">
                                <img class="avatar-img rounded-circle" src="assets/images/avatar/01.jpg" alt="avatar">
                            </li>
                            <li class="avatar avatar-xs">
                                <img class="avatar-img rounded-circle" src="assets/images/avatar/02.jpg" alt="avatar">
                            </li>
                            <li class="avatar avatar-xs">
                                <img class="avatar-img rounded-circle" src="assets/images/avatar/03.jpg" alt="avatar">
                            </li>
                            <li class="avatar avatar-xs">
                                <img class="avatar-img rounded-circle" src="assets/images/avatar/04.jpg" alt="avatar">
                            </li>
                            <li class="avatar avatar-xs">
                                <img class="avatar-img rounded-circle" src="assets/images/avatar/05.jpg" alt="avatar">
                            </li>
                            <li class="avatar avatar-xs">
                                <img class="avatar-img rounded-circle" src="assets/images/avatar/06.jpg" alt="avatar">
                            </li>
                            <li class="avatar avatar-xs">
                                <img class="avatar-img rounded-circle" src="assets/images/avatar/07.jpg" alt="avatar">
                            </li>
                            <li class="avatar avatar-xs">
                                <img class="avatar-img rounded-circle" src="assets/images/avatar/08.jpg" alt="avatar">
                            </li>
                            <li class="avatar avatar-xs">
                                <img class="avatar-img rounded-circle" src="assets/images/avatar/09.jpg" alt="avatar">
                            </li>
                            <li class="avatar avatar-xs">
                                <img class="avatar-img rounded-circle" src="assets/images/avatar/10.jpg" alt="avatar">
                            </li>
                            <li class="avatar avatar-xs me-2">
                                <div class="avatar-img rounded-circle bg-primary">
                                    <span class="smaller text-white position-absolute top-50 start-50 translate-middle">+19</span>
                                </div>
                            </li>
                            <li class="small text-center">
                                Carolyn Ortiz, Frances Guerrero, and 20 joined group
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
                                    Connections
                                    <span class="badge bg-success bg-opacity-10 text-success small"> 230</span> </a>
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
                                <x-posts.post-creation :user="$user" :group="$group"/>

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
                                            <li class="mb-2"><i class="bi bi-calendar-date fa-fw pe-1"></i> People:
                                                <strong> {{$group->members->count()}} Members </strong></li>
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
                        <div class="card card-body">
                            <div class="my-sm-5 py-sm-5 text-center">
                                <!-- Icon -->
                                <i class="display-1 text-body-secondary bi bi-person"> </i>
                                <!-- Title -->
                                <h4 class="mt-2 mb-3 text-body">No about details</h4>
                                <button class="btn btn-primary-soft btn-sm"> Click here to add</button>
                            </div>
                        </div>
                    </div>
                    <!-- Gruop About tab END -->

                    <!-- Gruop Connections tab END -->
                    <div class="tab-pane fade show" id="group-tab-3">
                        <div class="card card-body">
                            <div class="my-sm-5 py-sm-5 text-center">
                                <!-- Icon -->
                                <i class="display-1 text-body-secondary bi bi-people"> </i>
                                <!-- Title -->
                                <h4 class="mt-2 mb-3 text-body">No connections founds</h4>
                                <button class="btn btn-primary-soft btn-sm"> Click here to add</button>
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
                                <h4 class="mt-2 mb-3 text-body">No media founds</h4>
                                <button class="btn btn-primary-soft btn-sm"> Click here to add</button>
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
                                <h4 class="mt-2 mb-3 text-body">No videos founds</h4>
                                <button class="btn btn-primary-soft btn-sm"> Click here to add</button>
                            </div>
                        </div>
                    </div>
                    <!-- Gruop Videos tab END -->

                    <!-- Gruop Events tab END -->
                    <div class="tab-pane fade show" id="group-tab-6">
                        <div class="card card-body">
                            <div class="my-sm-5 py-sm-5 text-center">
                                <!-- Icon -->
                                <i class="display-1 text-body-secondary bi bi-calendar-plus"> </i>
                                <!-- Title -->
                                <h4 class="mt-2 mb-3 text-body">No events founds</h4>
                                <button class="btn btn-primary-soft btn-sm"> Click here to add</button>
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
                        <img class="avatar-img rounded-circle" src="assets/images/avatar/03.jpg" alt="">
                    </div>
                    <!-- Feed box  -->
                    <form class="w-100">
                        <textarea class="form-control pe-4 fs-3 lh-1 border-0" rows="4" placeholder="Share your thoughts..." autofocus></textarea>
                    </form>
                </div>
                <!-- Feed rect START -->
                <div class="hstack gap-2">
                    <a class="icon-md bg-success bg-opacity-10 text-success rounded-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Photo">
                        <i class="bi bi-image-fill"></i> </a>
                    <a class="icon-md bg-info bg-opacity-10 text-info rounded-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Video">
                        <i class="bi bi-camera-reels-fill"></i> </a>
                    <a class="icon-md bg-danger bg-opacity-10 text-danger rounded-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Events">
                        <i class="bi bi-calendar2-event-fill"></i> </a>
                    <a class="icon-md bg-warning bg-opacity-10 text-warning rounded-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Feeling/Activity">
                        <i class="bi bi-emoji-smile-fill"></i> </a>
                    <a class="icon-md bg-light text-secondary rounded-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Check in">
                        <i class="bi bi-geo-alt-fill"></i> </a>
                    <a class="icon-md bg-primary bg-opacity-10 text-primary rounded-circle" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Tag people on top">
                        <i class="bi bi-tag-fill"></i> </a>
                </div>
                <!-- Feed rect END -->
            </div>
            <!-- Modal feed body END -->

            <!-- Modal feed footer -->
            <div class="modal-footer row justify-content-between">
                <!-- Select -->
                <div class="col-lg-3">
                    <select class="form-select js-choice" data-position="top" data-search-enabled="false">
                        <option value="PB">Public</option>
                        <option value="PV">Friends</option>
                        <option value="PV">Only me</option>
                        <option value="PV">Custom</option>
                    </select>
                </div>
                <!-- Button -->
                <div class="col-lg-8 text-sm-end">
                    <button type="button" class="btn btn-danger-soft me-2"><i class="bi bi-camera-video-fill pe-1"></i>
                        Live video
                    </button>
                    <button type="button" class="btn btn-success-soft">Post</button>
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
                <!-- Add Feed -->
                <div class="d-flex mb-3">
                    <!-- Avatar -->
                    <div class="avatar avatar-xs me-2">
                        <img class="avatar-img rounded-circle" src="assets/images/avatar/03.jpg" alt="">
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
                            <i class="bi bi-images display-3"></i>
                            <p>Drag here or click to upload photo.</p>
                        </div>
                    </div>
                </div>
                <!-- Dropzone photo END -->

            </div>
            <!-- Modal feed body END -->

            <!-- Modal feed footer -->
            <div class="modal-footer ">
                <!-- Button -->
                <button type="button" class="btn btn-danger-soft me-2" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success-soft">Post</button>
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
                        <img class="avatar-img rounded-circle" src="assets/images/avatar/03.jpg" alt="">
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
                                <img class="avatar-img rounded-circle" src="assets/images/avatar/01.jpg" alt="avatar">
                            </li>
                            <li class="avatar avatar-xs">
                                <img class="avatar-img rounded-circle" src="assets/images/avatar/02.jpg" alt="avatar">
                            </li>
                            <li class="avatar avatar-xs">
                                <img class="avatar-img rounded-circle" src="assets/images/avatar/03.jpg" alt="avatar">
                            </li>
                            <li class="avatar avatar-xs">
                                <img class="avatar-img rounded-circle" src="assets/images/avatar/04.jpg" alt="avatar">
                            </li>
                            <li class="avatar avatar-xs">
                                <img class="avatar-img rounded-circle" src="assets/images/avatar/05.jpg" alt="avatar">
                            </li>
                            <li class="avatar avatar-xs">
                                <img class="avatar-img rounded-circle" src="assets/images/avatar/06.jpg" alt="avatar">
                            </li>
                            <li class="avatar avatar-xs">
                                <img class="avatar-img rounded-circle" src="assets/images/avatar/07.jpg" alt="avatar">
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
