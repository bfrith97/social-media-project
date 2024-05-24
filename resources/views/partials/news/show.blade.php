<main>

    <!-- Container START -->
    <div class="container">
        <div class="row g-4">
            <!-- Main content START -->
            <div class="col-lg-8 mx-auto">
                <div class="vstack gap-4">
                    <!-- Blog single START -->
                    <div class="card card-body pb-0">
                        <div>
                            <!-- Tag -->
                            <div class="d-flex justify-content-between">
                            <a href="#" class="badge bg-{{$newsArticle->newsArticleCategory?->badge_colour}} bg-opacity-10 text-{{$newsArticle->newsArticleCategory?->badge_colour}} mb-2 fw-bold">{{$newsArticle->newsArticleCategory?->name}}</a>
                            <a href="{{ route('news.index') }}" class="btn btn-sm btn-light p-1">Return</a>
                            </div>
                            <!-- Title info -->
                            <h1 class="mb-2 h2">{{$newsArticle->title}}</h1>
                            <ul class="nav nav-stack gap-3 align-items-center">
                                <li class="nav-item">
                                    <i class="bi bi-calendar-date pe-1"></i>{{Carbon\Carbon::parse($newsArticle->published_at)->format('D, d M Y H:i:s')}}
                                </li>
                            </ul>
                            <!-- description -->
                            <p class="mt-4">{{$newsArticle->description}} </p>
                            <!-- Blockquote START -->
                            <figure class="bg-light rounded p-3 p-sm-4 my-3">
                                <a class="mb-0" href="{{$newsArticle->url}}"> {{$newsArticle->url}} </a>
                            </figure>
                        </div>
                        <hr class="mb-3 mt-0">
                        <x-comments.comment-input :user="$user" :item="$newsArticle" :itemTypeId="2" />

                        <ul class="comment-wrap list-unstyled mb-0">
                            @foreach($newsArticle->comments as $comment)
                                <x-comments.comment :comment="$comment" :user="$user"/>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Card END -->
                    <!-- Add comment -->

                </div>
                <!-- Blog single END -->
            </div>
        </div>
        <!-- Main content END -->
    </div> <!-- Row END -->
    </div>
    <!-- Container END -->

</main>
