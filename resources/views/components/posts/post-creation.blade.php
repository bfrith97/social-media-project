<!-- Share feed START -->
<div class="card card-body @if(isset($onProfile)) my-4 @endif">
    <div class="d-flex mb-3">
        <!-- Avatar -->
        <div class="avatar avatar-xs me-2">
            <a href="#">
                <img class="avatar-img rounded-circle" src="{{ asset($user->picture) }}" alt=""> </a>
        </div>
        <!-- Post input -->
        <form class="w-100" id="post-creation-form" method="post" action="{{route('posts.store')}}">
            @csrf
            <input type="hidden" name="user_id" value="{{$user->id}}" />
            <textarea class="form-control pe-4 border-0" rows="2" data-autoresize placeholder="Share your thoughts..." name="content"></textarea>
        </form>
    </div>
    <!-- Share feed toolbar START -->
    <ul class="nav nav-pills nav-stack small fw-normal">
        <li class="nav-item">
            <a class="nav-link bg-light py-1 px-2 mb-0" href="#!" data-bs-toggle="modal" data-bs-target="#feedActionPhoto">
                <i class="bi bi-image-fill text-success pe-2"></i>Photo</a>
        </li>
        <li class="nav-item">
            <a class="nav-link bg-light py-1 px-2 mb-0" href="#!" data-bs-toggle="modal" data-bs-target="#feedActionVideo">
                <i class="bi bi-camera-reels-fill text-info pe-2"></i>Video</a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link bg-light py-1 px-2 mb-0" data-bs-toggle="modal" data-bs-target="#modalCreateEvents">
                <i class="bi bi-calendar2-event-fill text-danger pe-2"></i>Event </a>
        </li>
        <li class="nav-item">
            <a class="nav-link bg-light py-1 px-2 mb-0" href="#!" data-bs-toggle="modal" data-bs-target="#modalCreateFeed">
                <i class="bi bi-emoji-smile-fill text-warning pe-2"></i>Feeling /Activity</a>
        </li>
        <li class="nav-item float-end ms-auto">
            <a class="btn btn-sm btn-success-soft py-1 px-2 mb-0" id="post-creation-form-submit" href="">
                <i class="bi bi-box-arrow-in-right pe-2"></i>Post</a>
        </li>
    </ul>
    <!-- Share feed toolbar END -->
</div>
<!-- Share feed END -->