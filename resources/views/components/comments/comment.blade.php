<!-- Comment item START -->
<li class="comment-item">
    <div class="d-flex position-relative">
        <!-- Avatar -->
        <div class="avatar avatar-xs">
            <a href="{{ route('profiles.show', $comment->user->id) }}"><img class="avatar-img rounded-circle" src="{{ asset($comment->user->profile_picture) }}" alt=""></a>
        </div>
        <div class="ms-2 mb-2">
            <!-- Comment by -->
            <div class="bg-light rounded-start-top-0 p-2 rounded">
                <div class="d-flex justify-content-between">
                    <h6 class="mb-1">
                        <a href="{{ route('profiles.show', $comment->user->id) }}"> {{$comment->user->name}} </a></h6>
                    <small class="ms-2">{{ Carbon\Carbon::parse($comment->created_at)->timezone('Europe/London')->diffForHumans() }}</small>
                </div>
                <p class="small mb-0 text-break"> {{$comment->content}} </p>
            </div>
            <!-- Comment react -->
            <ul class="nav nav-divider pb-2 pt-1 small">
                <form class="post-like-form" action="{{ $comment->liked_by_current_user ? route('comment_likes.destroy') : route('comment_likes.store')}}" method="post" onsubmit="submitLike(event)">
                    @csrf
                    @if($comment->liked_by_current_user)
                        <input class="delete_method" type="hidden" name="_method" value="DELETE">
                    @endif
                    <input type="hidden" id="comment_id" name="comment_id" value="{{$comment->id}}"/>
                    <input type="hidden" id="user_id" name="user_id" value="{{$user->id}}"/>
                    <li class="nav-item">
                        <button type="submit" class="nav-link {{$comment->liked_by_current_user ? 'active' : ''}} like-button comment-like" @if(count($comment->commentLikes)) data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-custom-class="tooltip-text-start" data-bs-title=" @foreach($comment->commentLikes as $likeUser) {{$likeUser->user->name}}<br> @endforeach " @endif>
                           {{$comment->liked_by_current_user ? 'Liked' : 'Like'}} ({{ $comment->commentLikes->count() }})
                        </button>
                    </li>
                </form>
            </ul>
        </div>
    </div>
    <!-- Load more replies -->
</li>
<!-- Comment item END -->
