<!-- Card feed item START -->
<div class="card @isset($hasMargin) mb-4 @endisset">
    <!-- Card header START -->
    <div class="card-header border-0 pb-0">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <!-- Avatar -->
                <div class="avatar avatar-story me-2">
                    <a href="#!">
                        <img class="avatar-img rounded-circle" src="{{ asset($post->user->profile_picture) }}" alt="">
                    </a>
                </div>
                <!-- Info -->
                <div>
                    <div class="nav nav-divider">
                        <h6 class="nav-item card-title mb-0">
                            <a href="{{ route('profiles.show', $post->user->id) }}"> {{ $post->user->name }} </a></h6>
                        <span class="nav-item small"> {{ Carbon\Carbon::parse($post->created_at)->timezone('Europe/London')->diffForHumans() }} </span>
                    </div>
                    <p class="mb-0 small">
                        {{ $post->user->role ?? '' }}
                        {{ ($post->user->role && $post->user->company) ? 'at' : '' }}
                        {{ $post->user->company ?? '' }}
                    </p>

                </div>
            </div>
            <!-- Card feed action dropdown START -->
{{--            TODO--}}
{{--            <div class="dropdown">--}}
{{--                <a href="#" class="text-secondary btn btn-secondary-soft-hover py-1 px-2" id="cardFeedAction" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                    <i class="bi bi-three-dots"></i>--}}
{{--                </a>--}}
{{--                <!-- Card feed action dropdown menu -->--}}
{{--                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardFeedAction">--}}
{{--                    <li><a class="dropdown-item" href="#"> <i class="bi bi-bookmark fa-fw pe-2"></i>Save post</a></li>--}}
{{--                    <li><a class="dropdown-item" href="#">--}}
{{--                            <i class="bi bi-person-x fa-fw pe-2"></i>Unfollow {{$post->user->name}} </a></li>--}}
{{--                    <li><a class="dropdown-item" href="#"> <i class="bi bi-x-circle fa-fw pe-2"></i>Hide post</a></li>--}}
{{--                    <li><a class="dropdown-item" href="#"> <i class="bi bi-slash-circle fa-fw pe-2"></i>Block</a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <hr class="dropdown-divider">--}}
{{--                    </li>--}}
{{--                    <li><a class="dropdown-item" href="#"> <i class="bi bi-flag fa-fw pe-2"></i>Report post</a></li>--}}
{{--                </ul>--}}
{{--            </div>--}}
            <!-- Card feed action dropdown END -->
        </div>
    </div>
    <!-- Card header END -->
    <!-- Card body START -->
    <div class="card-body pb-0">
        <p>{{$post->content}}
        @if($post->image_path)
            <br>
            <img src="{{ asset($post->image_path) }}" class="mt-2" alt="">
        @endif
        </p>
        <!-- Feed react START -->
        <ul class="nav nav-stack pb-2 small">
            <form class="post-like-form" action="{{ $post->liked_by_current_user ? route('post_likes.destroy') : route('post_likes.store')}}" method="post" onsubmit="submitLike(event)">
                @csrf
                @if($post->liked_by_current_user)
                    <input class="delete_method" type="hidden" name="_method" value="DELETE">
                @endif
                <input type="hidden" id="post_id" name="post_id" value="{{$post->id}}"/>
                <input type="hidden" id="user_id" name="user_id" value="{{$user->id}}"/>
                <li class="nav-item">
                    <button class="nav-link {{$post->liked_by_current_user ? 'active' : ''}} like-button" type="submit" @if(count($post->postLikes)) data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-custom-class="tooltip-text-start" data-bs-title=" @foreach($post->postLikes as $postLike) {{$postLike->user->name}}<br> @endforeach "@endif>
                        <i class="bi bi-hand-thumbs-up-fill pe-1"></i>{{$post->liked_by_current_user ? 'Liked' : 'Like'}}
                        ({{ $post->postLikes->count() }})
                    </button>
                </li>
            </form>
            <span class="comment-count"> <i class="bi bi-chat-fill pe-1"></i>Comments ({{$post->comments->count()}})</span>
            <!-- Card share action START -->
            <li class="nav-item dropdown ms-sm-auto">
                <a class="nav-link mb-0" href="#" id="cardShareAction" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-reply-fill flip-horizontal ps-1"></i>Share (0)
                </a>
                <!-- Card share action dropdown menu -->
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardShareAction">
                    <li><a class="dropdown-item" href="#"> <i class="bi bi-envelope fa-fw pe-2"></i>Send via Direct
                            Message</a></li>
                    <li><a class="dropdown-item" href="#">
                            <i class="bi bi-bookmark-check fa-fw pe-2"></i>Bookmark </a></li>
                    <li><a class="dropdown-item" href="#"> <i class="bi bi-link fa-fw pe-2"></i>Copy link to post</a>
                    </li>
                    <li><a class="dropdown-item" href="#"> <i class="bi bi-share fa-fw pe-2"></i>Share post via …</a>
                    </li>
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
        <x-comments.comment-input :user="$user" :item="$post" itemType="App\Models\Post"/>

        <ul class="comment-wrap list-unstyled mb-0">
            @foreach($post->comments as $comment)
                <x-comments.comment :comment="$comment" :user="$user"/>
            @endforeach
        </ul>
    </div>
    <!-- Card body END -->
    <!-- Card footer START -->
    <div class="card-footer border-0 py-0">
        @if($post->has_more_than_five_comments)
            <!-- Load more comments -->
            <button type="button" onclick="loadAdditionalComments(this)" class="btn btn-link btn-link-loader btn-sm text-secondary d-flex align-items-center pb-3" data-offset="5">
                <input class="postId" type="hidden" name="post" value="{{$post->id}}"/>
                <div class="spinner-dots me-2">
                    <span class="spinner-dot"></span>
                    <span class="spinner-dot"></span>
                    <span class="spinner-dot"></span>
                </div>
                Load more comments
            </button>
        @endif
    </div>
    <!-- Card footer END -->
</div>
<!-- Card feed item END -->
