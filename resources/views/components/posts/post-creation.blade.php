<!-- Share feed START -->
<div class="card card-body @if($onProfile) my-4 @endif">
    <div class="d-flex mb-3">
        <!-- Avatar -->
        <div class="avatar avatar-xs me-2">
            <a href="#">
                <img class="avatar-img rounded-circle" src="{{ $user->profile_picture ? asset($user->profile_picture) : ''}}" alt=""> </a>
        </div>
        <!-- Post input -->
        <form id="post-creation-form" class="w-100" method="post" action="{{route('posts.store')}}" onsubmit="submitPost(event)">
            @csrf
            <input type="hidden" name="user_id" value="{{$user->id}}"/>
            <input type="hidden" name="is_feeling" value="0"/>
            @isset($profile)
                <input type="hidden" name="profile_id" value="{{$profile->id}}"/>
            @endisset
            @isset($group)
                <input type="hidden" name="group_id" value="{{$group->id}}"/>
            @endisset
            <textarea class="form-control pe-4 border-0 pb-0" rows="2" data-autoresize placeholder="Share your thoughts..." name="content" required></textarea>
            @if($onProfile)
                <hr class="m-0"/>
            @endif
        </form>
    </div>
    <!-- Share feed toolbar START -->
    <ul class="nav nav-pills nav-stack small fw-normal">
        @if(!$onProfile)
            <li class="nav-item">
                <a class="nav-link bg-light py-1 px-2 mb-0" href="#!" data-bs-toggle="modal" data-bs-target="#feedActionPhoto">
                    <i class="bi bi-image-fill text-success pe-2"></i>Photo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link bg-light py-1 px-2 mb-0" href="#!" data-bs-toggle="modal" data-bs-target="#modalCreateFeed">
                    <i class="bi bi-emoji-smile-fill text-warning pe-2"></i>Feeling</a>
            </li>
        @endif
        <li class="nav-item float-end ms-auto">
            <button type="submit" class="btn btn-sm btn-success-soft py-1 px-2 mb-0" form="post-creation-form">
                <i class="bi bi-box-arrow-in-right pe-2"></i>Post
            </button>
        </li>
    </ul>
    <!-- Share feed toolbar END -->
</div>
<!-- Share feed END -->
