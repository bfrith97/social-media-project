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
                <div class="card card-body card-overlay-bottom border-0" style="background-image:url(assets/images/events/06.jpg); background-position: center; background-size: cover; background-repeat: no-repeat;">
                    <!-- Card body START -->
                    <div class="row g-3 justify-content-between">
                        <!-- Date START -->
                        <div class="col-lg-2">
                            <div class="bg-mode text-center rounded overflow-hidden p-1 d-inline-block">
                                <div class="bg-primary p-2 text-white rounded-top small lh-1">Wednesday</div>
                                <h5 class="mb-0 py-2 lh-1">Dec 08</h5>
                            </div>
                        </div>
                    </div>
                    <!-- Event name START -->
                    <div class="row g-3 justify-content-between align-items-center mt-5 pt-5 position-relative z-index-9">
                        <div class="col-lg-9">
                            <h1 class="h3 mb-1 text-white">{{$event->name}}</h1>
                            <a class="text-white" href="https://themes.getbootstrap.com/store/webestica" target="_blank">https://themes.getbootstrap.com/store/webestica</a>
                        </div>
                        <!-- Button -->
                        <div class="col-lg-3 text-lg-end">
                            <a class="btn btn-primary" href="#!"> Buy ticket </a>
                        </div>
                    </div>
                    <!-- Event name END -->
                </div>
                <!-- Card END -->

                <!-- Card About START -->
                <div class="card card-body">
                    <!-- Card body START -->
                    <div class="row g-4">
                        <!-- info -->
                        <div class="col-12">
                            <p class="mb-0">{{$event->description}}</p>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <!-- Timings -->
                            <h5>Timings</h5>
                            <p class="small mb-0">09:00 AM - 05:00 PM (Business)</p>
                            <p class="small mb-0"> 09:00 AM - 03:00 PM (Business)</p>
                        </div>
                        <!-- Entry Fees -->
                        <div class="col-sm-6 col-lg-4">
                            <h5>Entry fees</h5>
                            <p class="small mb-0"><a href="#!"> Free Ticket </a>For photography professionals check
                                official website</p>
                        </div>
                        <!-- Category & Type -->
                        <div class="col-sm-6 col-lg-4">
                            <h5>Category & type</h5>
                            <p class="small mb-0">{{$event->eventType->name}}</p>
                            <p class="small mb-0">{{$event->eventLocation->name}}</p>
                        </div>
                        <!-- Estimated Turnout -->
                        <div class="col-sm-6 col-lg-4">
                            <h5>Estimated turnout</h5>
                            <p class="small mb-0">140000 Visitors</p>
                            <p class="small mb-0"> 1800 Exhibitors</p>
                            <span class="badge bg-danger text-danger bg-opacity-10 small">Estimated Count</span>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <!-- Rating -->
                            <ul class="d-flex list-unstyled mb-1">
                                <li class="me-2">4.5</li>
                                <li><i class="fa-solid fa-star text-warning"></i></li>
                                <li><i class="fa-solid fa-star text-warning"></i></li>
                                <li><i class="fa-solid fa-star text-warning"></i></li>
                                <li><i class="fa-solid fa-star text-warning"></i></li>
                                <li><i class="fa-solid fa-star-half-stroke text-warning"></i></li>
                                <li class="ms-1 small">132 Ratings</li>
                            </ul>
                            <p class="mb-0 small"><strong> #2 of 3506</strong> Events in Photography & Prewedding</p>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <!-- Interested -->
                            <div class="d-flex">
                                <h6><i class="bi bi-hand-thumbs-up-fill text-success"></i> 50</h6>
                                <p class="small">People have shown interest recently</p>
                            </div>
                            <button class="btn btn-success-soft btn-sm">Interested?</button>
                        </div>
                    </div>
                    <hr class="mt-4">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h5>Attendees</h5>
                            <!-- Avatar group START -->
                            <ul class="avatar-group list-unstyled align-items-center">
                                <li class="avatar avatar-xs">
                                    <img class="avatar-img rounded-circle" src="assets/images/avatar/01.jpg" alt="avatar">
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
                                <li class="ms-4">
                                    <small> 148.9K people responded</small>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <!-- Avatar group END -->
                            <div class="row g-2">
                                <div class="col-sm-4">
                                    <!-- Visitors -->
                                    <div class="d-flex">
                                        <i class="bi bi-globe fs-4"></i>
                                        <div class="ms-3">
                                            <h5 class="mb-0">125</h5>
                                            <p class="mb-0">Visitors</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <!-- Registred -->
                                    <div class="d-flex">
                                        <i class="bi bi-person-plus fs-4"></i>
                                        <div class="ms-3">
                                            <h5 class="mb-0">356</h5>
                                            <p class="mb-0">Registred</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <!-- Attendance -->
                                    <div class="d-flex">
                                        <i class="bi bi-people fs-4"></i>
                                        <div class="ms-3">
                                            <h5 class="mb-0">350</h5>
                                            <p class="mb-0">Attendance</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card About END -->

                <!-- Related events START -->
                <div class="row g-4">
                    <div class="col-lg-6">
                        <!-- Card START -->
                        <div class="card">
                            <div class="card-header border-0">
                                <h5 class="card-title">Related events</h5>
                                <!-- Button modal -->
                            </div>
                            <!-- Card body START -->
                            <div class="card-body pt-0">
                                <!-- Related events item -->
                                <div class="d-sm-flex flex-wrap align-items-center mb-3">
                                    <!-- Avatar -->
                                    <div class="avatar avatar-md">
                                        <img class="avatar-img rounded-circle border border-white border-3" src="assets/images/logo/01.svg" alt="">
                                    </div>
                                    <!-- info -->
                                    <div class="ms-sm-2 my-2 my-sm-0">
                                        <h6 class="mb-0">Bone thugs-n-harmony</h6>
                                        <p class="small mb-0"><i class="bi bi-geo-alt pe-1"></i>San francisco </p>
                                    </div>
                                    <!-- Button -->
                                    <div class="ms-sm-auto mt-2 mt-sm-0">
                                        <!-- Interested button -->
                                        <input type="checkbox" class="btn-check" id="Interested1">
                                        <label class="btn btn-sm btn-outline-success" for="Interested1"><i class="fa-solid fa-thumbs-up me-1"></i>
                                            Interested</label>
                                    </div>
                                </div>
                                <!-- Related events item -->
                                <div class="d-sm-flex flex-wrap align-items-center mb-3">
                                    <!-- Avatar -->
                                    <div class="avatar avatar-md">
                                        <img class="avatar-img rounded-circle border border-white border-3" src="assets/images/logo/02.svg" alt="">
                                    </div>
                                    <!-- info -->
                                    <div class="ms-sm-2 my-2 my-sm-0">
                                        <h6 class="mb-0">Decibel magazine</h6>
                                        <p class="small mb-0"><i class="bi bi-geo-alt pe-1"></i>London </p>
                                    </div>
                                    <!-- Button -->
                                    <div class="ms-sm-auto mt-2 mt-sm-0">
                                        <!-- Interested button -->
                                        <input type="checkbox" class="btn-check" id="Interested2">
                                        <label class="btn btn-sm btn-outline-success" for="Interested2"><i class="fa-solid fa-thumbs-up me-1"></i>
                                            Interested</label>
                                    </div>
                                </div>
                                <!-- Related events item -->
                                <div class="d-sm-flex flex-wrap align-items-center mb-3">
                                    <!-- Avatar -->
                                    <div class="avatar avatar-md">
                                        <img class="avatar-img rounded-circle border border-white border-3" src="assets/images/logo/06.svg" alt="">
                                    </div>
                                    <!-- info -->
                                    <div class="ms-sm-2 my-2 my-sm-0">
                                        <h6 class="mb-0">Illenium: fallen embers</h6>
                                        <p class="small mb-0"><i class="bi bi-geo-alt pe-1"></i>Mumbai </p>
                                    </div>
                                    <!-- Button -->
                                    <div class="ms-sm-auto mt-2 mt-sm-0">
                                        <!-- Interested button -->
                                        <input type="checkbox" class="btn-check" id="Interested3" checked>
                                        <label class="btn btn-sm btn-outline-success" for="Interested3"><i class="fa-solid fa-thumbs-up me-1"></i>
                                            Interested</label>
                                    </div>
                                </div>
                                <!-- Related events item -->
                                <div class="d-sm-flex flex-wrap align-items-center">
                                    <!-- Avatar -->
                                    <div class="avatar avatar-md">
                                        <img class="avatar-img rounded-circle border border-white border-3" src="assets/images/logo/04.svg" alt="">
                                    </div>
                                    <!-- info -->
                                    <div class="ms-sm-2 my-2 my-sm-0">
                                        <h6 class="mb-0">Comedy on the green</h6>
                                        <p class="small mb-0"><i class="bi bi-geo-alt pe-1"></i>Miami </p>
                                    </div>
                                    <!-- Button -->
                                    <div class="ms-sm-auto mt-2 mt-sm-0">
                                        <!-- Interested button -->
                                        <input type="checkbox" class="btn-check" id="Interested4">
                                        <label class="btn btn-sm btn-outline-success" for="Interested4"><i class="fa-solid fa-thumbs-up me-1"></i>
                                            Interested</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Card body END -->
                        </div>
                        <!-- Card END -->
                    </div>
                    <div class="col-lg-6">
                        <!-- Card START -->
                        <div class="card">
                            <div class="card-header border-0 pb-0">
                                <h5 class="card-title mb-0">Event location</h5>
                                <p class="small"><i class="bi bi-geo-alt pe-1"></i>750 Sing Sing Rd, Horseheads, NY,
                                    14845 </p>
                                <!-- Button modal -->
                            </div>
                            <!-- Card body START -->
                            <div class="card-body pt-0">
                                <!-- Google map -->
                                <iframe class="w-100 d-block rounded-bottom grayscale" height="230" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.9663095343008!2d-74.00425878428698!3d40.74076684379132!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259bf5c1654f3%3A0xc80f9cfce5383d5d!2sGoogle!5e0!3m2!1sen!2sin!4v1586000412513!5m2!1sen!2sin" style="border:0;" aria-hidden="false" tabindex="0"></iframe>
                            </div>
                            <!-- Card body END -->
                        </div>
                        <!-- Card END -->
                    </div>
                </div>
                <!-- Related events END -->
            </div>
            <!-- Main content END -->

        </div> <!-- Row END -->
    </div>
    <!-- Container END -->

</main>
