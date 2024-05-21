<div class="col-sm-6 col-xl-4">
    <!-- Event item START -->
    <div class="card h-100">
        <div class="position-relative">
            <img class="img-fluid rounded-top" src="{{ asset('assets/images/events/01.jpg') }}" alt="">
            <div class="badge bg-danger text-white mt-2 me-2 position-absolute top-0 end-0">
                {{$event->eventType->name}}
            </div>
        </div>
        <!-- Card body START -->
        <div class="card-body position-relative pt-0">
            <!-- Tag -->
            <a class="btn btn-xs btn-primary mt-n3" href="">{{$event->eventLocation->name}} </a>
            <h6 class="mt-2">
                <a href="{{ route('events.show', $event->id) }}">{{$event->name}}</a>
            </h6>
            <!-- Date time -->
            <p class="small mb-0"><i class="bi bi-geo-alt pe-1"></i> San francisco
            </p>
            <!-- Button -->
        </div>
        <!-- Card body END -->
    </div>
    <!-- Event item END -->
</div>
