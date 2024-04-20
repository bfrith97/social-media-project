    <!-- Comment item START -->
    <li class="comment-item">
        <div class="d-flex position-relative">
            <!-- Avatar -->
            <div class="avatar avatar-xs">
                <a href="{{ route('profiles.show', $comment->user->id) }}"><img class="avatar-img rounded-circle" src="{{ asset($comment->user->picture) }}" alt=""></a>
            </div>
            <div class="ms-2">
                <!-- Comment by -->
                <div class="bg-light rounded-start-top-0 p-2 rounded">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-1"><a href="{{ route('profiles.show', $comment->user->id) }}"> {{$comment->user->name}} </a></h6>
                        <small class="ms-2">{{ Carbon\Carbon::parse($comment->created_at)->timezone('Europe/London')->diffForHumans() }}</small>
                    </div>
                    <p class="small mb-0"> {{$comment->content}} </p>
                </div>
                <!-- Comment react -->
                <ul class="nav nav-divider pb-2 pt-1 small">
                    <li class="nav-item">
                        <a class="nav-link" href="#!" @if(count($comment->likes)) data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-custom-class="tooltip-text-start" data-bs-title=" @foreach($comment->likes as $user) {{$user->name}}<br> @endforeach " @endif> Like {{$comment->likes->count()}}</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Load more replies -->
    </li>
    <!-- Comment item END -->
