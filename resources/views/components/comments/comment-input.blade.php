<div class="d-flex mb-3">
    <!-- Avatar -->
    <div class="avatar avatar-xs me-2">
        <a href="#!">
            <img class="avatar-img rounded-circle" src="{{ $user->profile_picture ? asset($user->profile_picture) : ''}}" alt="">
        </a>
    </div>
    <!-- Comment box  -->
    <form class="nav nav-item w-100 position-relative comment-form" action="{{ route('comments.store') }}" method="post" onsubmit="submitComment(event)">
        @csrf
        <input type="hidden" id="item_id" name="item_id" value="{{$item->id}}"/>
        <input type="hidden" id="item_type" name="item_type" value="{{$itemType}}"/>
        <input type="hidden" id="user_id" name="user_id" value="{{$user->id}}"/>
        <input type="text" class="form-control pe-5 bg-light" placeholder="Add a comment..." id="content" name="content" required>
        <button class="nav-link bg-transparent px-3 position-absolute top-50 end-0 translate-middle-y border-0 comment-submit-btn" type="submit">
            <i class="bi bi-send-fill"> </i>
        </button>
    </form>
</div>
