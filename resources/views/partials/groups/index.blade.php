<main>

    <!-- Container START -->
    <div class="container">
        <div class="row g-4">

            <!-- Sidenav START -->
            <div class="col-lg-3">
                <x-shared.side-nav :user="$user"/>
            </div>
            <!-- Sidenav END -->

            <!-- Main content START -->
            <div class="col-md-8 col-lg-6 vstack gap-4">
                <!-- Card START -->
                <div class="card">
                    <!-- Card header START -->
                    <div class="card-header border-0 pb-0">
                        <div class="row g-2">
                            <div class="col-lg-2">
                                <!-- Card title -->
                                <h1 class="h4 card-title mb-lg-0">Groups</h1>
                            </div>
                            <div class="col-sm-6 col-lg-3 ms-lg-auto">
                                <!-- Select Groups -->
                                <select class="form-select js-choice choice-select-text-none" data-search-enabled="false">
                                    <option value="AB">Alphabetical</option>
                                    <option value="NG">Newest group</option>
                                    <option value="RA">Recently active</option>
                                    <option value="SG">Suggested</option>
                                </select>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <!-- Button modal -->
                                <a class="btn btn-primary-soft ms-auto w-100" href="#" data-bs-toggle="modal" data-bs-target="#modalCreateGroup">
                                    <i class="fa-solid fa-plus pe-1"></i> Create group</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card header START -->
                    <!-- Card body START -->
                    <div class="card-body">
                        <!-- Tab nav line -->
                        <ul class="nav nav-tabs nav-bottom-line justify-content-center justify-content-md-start">
                            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab-1">
                                    Suggested for you </a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-2"> Most
                                    popular </a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-3"> All Groups </a>
                            </li>
                        </ul>
                        <div class="tab-content mb-0 pb-0">

                            <!-- Suggested for you START -->
                            <div class="tab-pane fade show active" id="tab-1">
                                <div class="row g-4">
                                    <div class="col-sm-6 col-lg-4">
                                        <!-- Card START -->
                                        <div class="card">
                                            <div class="h-80px rounded-top" style="background-image:url(assets/images/bg/02.jpg); background-position: center; background-size: cover; background-repeat: no-repeat;"></div>
                                            <!-- Card body START -->
                                            <div class="card-body text-center pt-0">
                                                <!-- Avatar -->
                                                <div class="avatar avatar-lg mt-n5 mb-3">
                                                    <a href="group-details.html"><img class="avatar-img rounded-circle border border-white border-3 bg-white" src="assets/images/logo/03.svg" alt=""></a>
                                                </div>
                                                <!-- Info -->
                                                <h5 class="mb-0"><a href="group-details.html">Strong signals</a></h5>
                                                <small> <i class="bi bi-lock pe-1"></i> Private Group</small>
                                                <!-- Group stat START -->
                                                <div class="hstack gap-2 gap-xl-3 justify-content-center mt-3">
                                                    <!-- Group stat item -->
                                                    <div>
                                                        <h6 class="mb-0">45k</h6>
                                                        <small>Members</small>
                                                    </div>
                                                    <!-- Divider -->
                                                    <div class="vr"></div>
                                                    <!-- Group stat item -->
                                                    <div>
                                                        <h6 class="mb-0">16</h6>
                                                        <small>Post per day</small>
                                                    </div>
                                                </div>
                                                <!-- Group stat END -->
                                                <!-- Avatar group START -->
                                                <ul class="avatar-group list-unstyled align-items-center justify-content-center mb-0 mt-3">
                                                    <li class="avatar avatar-xs">
                                                        <img class="avatar-img rounded-circle" src="assets/images/avatar/11.jpg" alt="avatar">
                                                    </li>
                                                    <li class="avatar avatar-xs">
                                                        <img class="avatar-img rounded-circle" src="assets/images/avatar/10.jpg" alt="avatar">
                                                    </li>
                                                    <li class="avatar avatar-xs">
                                                        <div class="avatar-img rounded-circle bg-primary">
                                                            <span class="smaller text-white position-absolute top-50 start-50 translate-middle">+05</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <!-- Avatar group END -->
                                            </div>
                                            <!-- Card body END -->
                                            <!-- Card Footer START -->
                                            <div class="card-footer text-center">
                                                <a class="btn btn-success-soft btn-sm" href="#!"> Join group </a>
                                            </div>
                                            <!-- Card Footer END -->
                                        </div>
                                        <!-- Card END -->
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <!-- Card START -->
                                        <div class="card">
                                            <div class="h-80px rounded-top" style="background-image:url(assets/images/bg/03.jpg); background-position: center; background-size: cover; background-repeat: no-repeat;"></div>
                                            <!-- Card body START -->
                                            <div class="card-body text-center pt-0">
                                                <!-- Avatar -->
                                                <div class="avatar avatar-lg mt-n5 mb-3">
                                                    <a href="group-details.html"><img class="avatar-img rounded-circle border border-white border-3 bg-white" src="assets/images/logo/05.svg" alt=""></a>
                                                </div>
                                                <!-- Info -->
                                                <h5 class="mb-0"><a href="group-details.html">Team yes, we can</a></h5>
                                                <small> <i class="bi bi-lock pe-1"></i> Private Group</small>
                                                <!-- Group stat START -->
                                                <div class="hstack gap-2 gap-xl-3 justify-content-center mt-3">
                                                    <!-- Group stat item -->
                                                    <div>
                                                        <h6 class="mb-0">32k</h6>
                                                        <small>Members</small>
                                                    </div>
                                                    <!-- Divider -->
                                                    <div class="vr"></div>
                                                    <!-- Group stat item -->
                                                    <div>
                                                        <h6 class="mb-0">05</h6>
                                                        <small>Post per day</small>
                                                    </div>
                                                </div>
                                                <!-- Group stat END -->
                                                <!-- Avatar group START -->
                                                <ul class="avatar-group list-unstyled align-items-center justify-content-center mb-0 mt-3">
                                                    <li class="avatar avatar-xs">
                                                        <img class="avatar-img rounded-circle" src="assets/images/avatar/10.jpg" alt="avatar">
                                                    </li>
                                                    <li class="avatar avatar-xs">
                                                        <img class="avatar-img rounded-circle" src="assets/images/avatar/14.jpg" alt="avatar">
                                                    </li>
                                                    <li class="avatar avatar-xs">
                                                        <img class="avatar-img rounded-circle" src="assets/images/avatar/13.jpg" alt="avatar">
                                                    </li>
                                                    <li class="avatar avatar-xs">
                                                        <img class="avatar-img rounded-circle" src="assets/images/avatar/12.jpg" alt="avatar">
                                                    </li>
                                                    <li class="avatar avatar-xs">
                                                        <img class="avatar-img rounded-circle" src="assets/images/avatar/11.jpg" alt="avatar">
                                                    </li>
                                                    <li class="avatar avatar-xs">
                                                        <div class="avatar-img rounded-circle bg-primary">
                                                            <span class="smaller text-white position-absolute top-50 start-50 translate-middle">+08</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <!-- Avatar group END -->
                                            </div>
                                            <!-- Card body END -->
                                            <!-- Card Footer START -->
                                            <div class="card-footer text-center">
                                                <a class="btn btn-success-soft btn-sm" href="#!"> Join group </a>
                                            </div>
                                            <!-- Card Footer END -->
                                        </div>
                                        <!-- Card END -->
                                    </div>
                                </div>
                            </div>
                            <!-- Suggested for you END -->

                            <!-- Popular near you START -->
                            <div class="tab-pane fade" id="tab-2">
                                <!-- Add group -->
                                <div class="my-sm-5 py-sm-5 text-center">
                                    <i class="display-1 text-body-secondary bi bi-people"> </i>
                                    <h4 class="mt-2 mb-3 text-body">No groups found</h4>
                                    <button class="btn btn-primary-soft btn-sm" data-bs-toggle="modal" data-bs-target="#modalCreateGroup">
                                        Click here to add
                                    </button>
                                </div>
                            </div>
                            <!-- Popular near you END -->

                            <!-- More suggestions START -->
                            <div class="tab-pane fade" id="tab-3">
                                @if(count($allGroups))
                                    <div class="row g-4">
                                        @foreach($allGroups as $group)
                                            <div class="col-sm-6 col-lg-4">
                                                <!-- Card START -->
                                                <div class="card">
                                                    <div class="h-80px rounded-top" style="background-image:url(assets/images/bg/02.jpg); background-position: center; background-size: cover; background-repeat: no-repeat;"></div>
                                                    <!-- Card body START -->
                                                    <div class="card-body text-center pt-0">
                                                        <!-- Avatar -->
                                                        <div class="avatar avatar-lg mt-n5 mb-3">
                                                            <a href="{{route('groups.show', $group->id)}}"><img class="avatar-img rounded-circle border border-white border-3 bg-white" src="assets/images/logo/03.svg" alt=""></a>
                                                        </div>
                                                        <!-- Info -->
                                                        <h5 class="mb-0">
                                                            <a href="{{route('groups.show', $group->id)}}">{{$group->name}}</a>
                                                        </h5>
                                                        <small>
                                                            <i class="bi bi-{{$group->private ? 'lock' : 'globe'}} pe-1"></i> {{$group->private ? 'Private' : 'Public'}}
                                                            Group</small>
                                                        <!-- Group stat START -->
                                                        <div class="hstack gap-2 gap-xl-3 justify-content-center mt-3">
                                                            <!-- Group stat item -->
                                                            <div>
                                                                <h6 class="mb-0">{{$group->members->count()}}</h6>
                                                                <small>Members</small>
                                                            </div>
                                                            <!-- Divider -->
                                                            <div class="vr"></div>
                                                            <!-- Group stat item -->
                                                            <div>
                                                                <h6 class="mb-0">{{$group->posts->count()}}</h6>
                                                                <small>Total posts</small>
                                                            </div>
                                                        </div>
                                                        <!-- Group stat END -->
                                                        <!-- Avatar group START -->
                                                        <ul class="avatar-group list-unstyled align-items-center justify-content-center mb-0 mt-3">
                                                            <li class="avatar avatar-xs">
                                                                <img class="avatar-img rounded-circle" src="assets/images/avatar/11.jpg" alt="avatar">
                                                            </li>
                                                            <li class="avatar avatar-xs">
                                                                <img class="avatar-img rounded-circle" src="assets/images/avatar/10.jpg" alt="avatar">
                                                            </li>
                                                            <li class="avatar avatar-xs">
                                                                <div class="avatar-img rounded-circle bg-primary">
                                                                    <span class="smaller text-white position-absolute top-50 start-50 translate-middle">+05</span>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <!-- Avatar group END -->
                                                    </div>
                                                    <!-- Card body END -->
                                                    <!-- Card Footer START -->
                                                    <div class="card-footer text-center">
                                                        <a class="btn btn-success-soft btn-sm" href="#!"> Join
                                                            group </a>
                                                    </div>
                                                    <!-- Card Footer END -->
                                                </div>
                                                <!-- Card END -->
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <!-- Add group -->
                                    <div class="my-sm-5 py-sm-5 text-center">
                                        <i class="display-1 text-body-secondary bi bi-people"> </i>
                                        <h4 class="mt-2 mb-3 text-body">No groups found</h4>
                                        <button class="btn btn-primary-soft btn-sm" data-bs-toggle="modal" data-bs-target="#modalCreateGroup">
                                            Click here to add
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <!-- More suggestions END -->

                        </div>
                    </div>
                    <!-- Card body END -->
                </div>
                <!-- Card END -->
            </div>
            <!-- Right sidebar END -->

        </div> <!-- Row END -->
    </div>
    <!-- Container END -->

</main>
<!-- **************** MAIN CONTENT END **************** -->

<!-- Modal create group START -->
<div class="modal fade" id="modalCreateGroup" tabindex="-1" aria-labelledby="modalLabelCreateGroup" aria-hidden="true">
    <form action="{{ route('groups.store') }}" method="post">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Title -->
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabelCreateGroup">Create Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form START -->
                    @csrf
                    <!-- Group name -->
                    <div class="mb-3">
                        <label class="form-label">Group name</label>
                        <input name="name" type="text" class="form-control" placeholder="Add Group name here" required>
                    </div>
                    <!-- Group picture -->
                    <div class="mb-3">
                        <label class="form-label">Group picture</label>
                        <!-- Avatar upload START -->
                        <div class="d-flex align-items-center">
                            <div class="avatar-uploader me-3">
                                <!-- Avatar edit -->
                                <div class="avatar-edit">
                                    <input type='file' id="avatarUpload" accept=".png, .jpg, .jpeg"/>
                                    <label for="avatarUpload"></label>
                                </div>
                                <!-- Avatar preview -->
                                <div class="avatar avatar-xl position-relative">
                                    <img id="avatar-preview" class="avatar-img rounded-circle border border-white border-3 shadow" src="assets/images/avatar/placeholder.jpg" alt="">
                                </div>
                            </div>
                            <!-- Avatar remove button -->
                            <div class="avatar-remove">
                                <button type="button" id="avatar-reset-img" class="btn btn-light">Delete</button>
                            </div>
                        </div>
                        <!-- Avatar upload END -->
                    </div>
                    <!-- Select audience -->
                    <div class="mb-3">
                        <label class="form-label d-block">Select audience</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="private" id="publicRadio1" value="0" checked>
                            <label class="form-check-label" for="publicRadio1">Public</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="private" id="privateRadio2" value="1">
                            <label class="form-check-label" for="privateRadio2">Private</label>
                        </div>
                    </div>
                    <!-- Invite friend -->
                    <div class="mb-3">
                        <label class="form-label">Invite friend </label>
                        <input type="text" class="form-control" placeholder="Add friend name here">
                    </div>
                    <!-- Group description -->
                    <div class="mb-3">
                        <label class="form-label">Group description </label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Description here" required></textarea>
                    </div>
                    <!-- Group website -->
                    <div class="mb-3">
                        <label class="form-label">Group website </label>
                        <input name="website" type="text" class="form-control" placeholder="Add website here" required>
                    </div>
                    <!-- Form END -->
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success-soft">Create now</button>
                </div>
            </div>
        </div>
    </form>
</div>
