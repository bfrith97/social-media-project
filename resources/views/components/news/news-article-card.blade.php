<div class="card bg-transparent border-0">
    <div class="row g-3">
        <div class="col-4">
            <!-- Blog image -->
            <img class="rounded" src="assets/images/post/4by3/03.jpg" alt="">
        </div>
        <div class="col-8">
            <!-- Blog caption -->
            <a href="#" class="badge bg-{{$newsArticle->newsArticleCategory?->badge_colour}} bg-opacity-10 text-{{$newsArticle->newsArticleCategory?->badge_colour}} mb-2 fw-bold">{{$newsArticle->newsArticleCategory?->name}}</a>
            <h5><a href="{{ route('news.show', $newsArticle->id) }}" class="btn-link stretched-link text-reset fw-bold">{{$newsArticle->title}}</a></h5>
            <div class="d-none d-sm-inline-block">
                <p class="mb-2">{{$newsArticle->description}}</p>
                <!-- BLog date -->
                <a class="small text-secondary" href="#!"> <i class="bi bi-calendar-date pe-1"></i>
                    {{Carbon\Carbon::parse($newsArticle->published_at)->format('D, d M Y H:i:s')}}</a>
            </div>
        </div>
    </div>
</div>
