<div class="col-sm-6 col-xl-4">
    <!-- Event item START -->
    <div class="card h-100">
        <div class="position-relative">
            <img class="img-fluid rounded-top" src="{{ asset('assets/images/events/01.jpg') }}" alt="">
            <div class="badge bg-danger text-white mt-2 me-2 position-absolute top-0 end-0">
                {{$eventDate->event->eventType->name}}
            </div>
        </div>
        <!-- Card body START -->
        <div class="card-body position-relative pt-0">
            <!-- Tag -->
            <a class="btn btn-xs btn-primary mt-n3" href="">{{$eventDate->event->eventLocation->name}} </a>
            <h6 class="mt-2">
                <a href="{{ route('events.show', $eventDate->event->id) }}">{{$eventDate->event->name}}</a>
            </h6>
            <!-- Date time -->
            <p class="mb-0 small"><i class="bi bi-calendar-date pe-1"></i>
                @php
                    $roundedDaysUntil = round(\Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::createFromDate($eventDate->date)));
                    $roundedDaysUntil = $roundedDaysUntil <= 0 ? 'Today' : $roundedDaysUntil . ' days from now';
                @endphp
                {{$roundedDaysUntil}}</p>
            <p class="mb-0 small"><i class="bi bi-calendar-check pe-1"></i>
                {{\Carbon\Carbon::createFromDate($eventDate->date)->format('D, d M Y - H:i')}}
            </p>
            <p class="small"><i class="bi bi-geo-alt pe-1"></i> San francisco
            </p>
            <!-- Avatar group START -->
            <ul class="avatar-group list-unstyled align-items-center mb-0">
                <li class="avatar avatar-xs">
                    <img class="avatar-img rounded-circle" src="{{ asset('assets/images/avatar/01.jpg') }}" alt="avatar">
                </li>
                <li class="avatar avatar-xs">
                    <img class="avatar-img rounded-circle" src="{{ asset('assets/images/avatar/03.jpg') }}" alt="avatar">
                </li>
                <li class="avatar avatar-xs">
                    <img class="avatar-img rounded-circle" src="{{ asset('assets/images/avatar/04.jpg') }}" alt="avatar">
                </li>
                <li class="avatar avatar-xs">
                    <div class="avatar-img rounded-circle bg-primary">
                        <span class="smaller text-white position-absolute top-50 start-50 translate-middle">+78</span>
                    </div>
                </li>
                <li class="ms-3">
                    <small> are attending</small>
                </li>
            </ul>
            <!-- Avatar group END -->
            <!-- Button -->
            <div class="d-flex mt-3 justify-content-between">
                <!-- Interested button -->
                <div class="w-100">
                    <input type="checkbox" class="btn-check d-block" id="Interested1">
                    <label class="btn btn-sm btn-outline-success d-block" for="Interested1"><i class="fa-solid fa-thumbs-up me-1"></i>
                        Interested</label>
                </div>
                <div class="dropdown ms-3">
                    <a href="#" class="btn btn-sm btn-primary-soft" id="eventActionShare" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-share-fill"></i>
                    </a>
                    <!-- Dropdown menu -->
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="eventActionShare">
                        <li><a class="dropdown-item" href="#">
                                <i class="bi bi-envelope fa-fw pe-1"></i> Send
                                via
                                Direct Message</a></li>
                        <li><a class="dropdown-item" href="#">
                                <i class="bi bi-bookmark-check fa-fw pe-1"></i>
                                Share to News Feed </a></li>
                        <li><a class="dropdown-item" href="#">
                                <i class="bi bi-people fa-fw pe-1"></i> Share to
                                a
                                group</a></li>
                        <li><a class="dropdown-item" href="#">
                                <i class="bi bi-share fa-fw pe-1"></i> Share
                                post
                                via …</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">
                                <i class="bi bi-person fa-fw pe-1"></i> Share on
                                a
                                friend's profile</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Card body END -->
    </div>
    <!-- Event item END -->
</div>
