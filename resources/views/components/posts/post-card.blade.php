<!-- Card feed item START -->
<div class="card mb-4">
    <!-- Card header START -->
    <div class="card-header border-0 pb-0">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <!-- Avatar -->
                <div class="avatar avatar-story me-2">
                    <a href="#!">
                        <img class="avatar-img rounded-circle" src="{{ asset($post->user->picture) }}" alt="">
                    </a>
                </div>
                <!-- Info -->
                <div>
                    <div class="nav nav-divider">
                        <h6 class="nav-item card-title mb-0">
                            <a href="{{ route('profiles.show', $post->user->id) }}"> {{ $post->user->name }} </a></h6>
                        <span class="nav-item small"> {{ Carbon\Carbon::parse($post->created_at)->timezone('Europe/London')->diffForHumans() }} </span>
                    </div>
                    <p class="mb-0 small">{{ $post->user->role . ' at ' . $post->user-> company }}</p>
                </div>
            </div>
            <!-- Card feed action dropdown START -->
            <div class="dropdown">
                <a href="#" class="text-secondary btn btn-secondary-soft-hover py-1 px-2" id="cardFeedAction" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-three-dots"></i>
                </a>
                <!-- Card feed action dropdown menu -->
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardFeedAction">
                    <li><a class="dropdown-item" href="#"> <i class="bi bi-bookmark fa-fw pe-2"></i>Save
                            post</a></li>
                    <li><a class="dropdown-item" href="#"> <i class="bi bi-person-x fa-fw pe-2"></i>Unfollow
                            lori ferguson </a></li>
                    <li><a class="dropdown-item" href="#"> <i class="bi bi-x-circle fa-fw pe-2"></i>Hide
                            post</a></li>
                    <li><a class="dropdown-item" href="#"> <i class="bi bi-slash-circle fa-fw pe-2"></i>Block</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#"> <i class="bi bi-flag fa-fw pe-2"></i>Report
                            post</a></li>
                </ul>
            </div>
            <!-- Card feed action dropdown END -->
        </div>
    </div>
    <!-- Card header END -->
    <!-- Card body START -->
    <div class="card-body pb-0">
        <p>{{$post->content}}</p>
        <!-- Feed react START -->
        <ul class="nav nav-stack pb-2 small">
            <li class="nav-item">
                <a class="nav-link active" href="#!" @if(count($post->likes)) data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-custom-class="tooltip-text-start" data-bs-title=" @foreach($post->likes as $user) {{$user->name}}<br> @endforeach "@endif>
                    <i class="bi bi-hand-thumbs-up-fill pe-1"></i>Liked {{ $post->likes->count() }}</a>
            </li>
                <span class="comment-count"> <i class="bi bi-chat-fill pe-1"></i>Comments
                    ({{$post->comments->count()}})</span>
            <!-- Card share action START -->
            <li class="nav-item dropdown ms-sm-auto">
                <a class="nav-link mb-0" href="#" id="cardShareAction" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-reply-fill flip-horizontal ps-1"></i>Share (0)
                </a>
                <!-- Card share action dropdown menu -->
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardShareAction">
                    <li><a class="dropdown-item" href="#"> <i class="bi bi-envelope fa-fw pe-2"></i>Send
                            via Direct Message</a></li>
                    <li><a class="dropdown-item" href="#">
                            <i class="bi bi-bookmark-check fa-fw pe-2"></i>Bookmark </a></li>
                    <li><a class="dropdown-item" href="#"> <i class="bi bi-link fa-fw pe-2"></i>Copy
                            link to post</a></li>
                    <li><a class="dropdown-item" href="#"> <i class="bi bi-share fa-fw pe-2"></i>Share
                            post via …</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">
                            <i class="bi bi-pencil-square fa-fw pe-2"></i>Share to News Feed</a></li>
                </ul>
            </li>
            <!-- Card share action END -->
        </ul>
        <!-- Feed react END -->

        <!-- Add comment -->
        <div class="d-flex mb-3">
            <!-- Avatar -->
            <div class="avatar avatar-xs me-2">
                <a href="#!">
                    <img class="avatar-img rounded-circle" src="{{ asset($user->picture) }}" alt="">
                </a>
            </div>
            <!-- Comment box  -->
            <form class="nav nav-item w-100 position-relative comment-form" action="{{ route('comments.store') }}" method="post">
                @csrf
                <input type="hidden" id="post_id" name="post_id" value="{{$post->id}}"/>
                <input type="hidden" id="user_id" name="user_id" value="{{$user->id}}"/>
                <input type="text" class="form-control pe-5 bg-light" placeholder="Add a comment..." id="content" name="content">
                <button class="nav-link bg-transparent px-3 position-absolute top-50 end-0 translate-middle-y border-0 comment-submit-btn" type="submit">
                    <i class="bi bi-send-fill"> </i>
                </button>
            </form>
        </div>

        <ul class="comment-wrap list-unstyled">
            @foreach($post->comments as $comment)
                <x-posts.post-comment :comment="$comment"/>
            @endforeach
        </ul>
    </div>
    <!-- Card body END -->
    <!-- Card footer START -->
    <div class="card-footer border-0 pt-0">
        <!-- Load more comments -->
        <a href="#!" role="button" class="btn btn-link btn-link-loader btn-sm text-secondary d-flex align-items-center" data-bs-toggle="button" aria-pressed="true">
            <div class="spinner-dots me-2">
                <span class="spinner-dot"></span>
                <span class="spinner-dot"></span>
                <span class="spinner-dot"></span>
            </div>
            Load more comments
        </a>
    </div>
    <!-- Card footer END -->
</div>
<!-- Card feed item END -->


