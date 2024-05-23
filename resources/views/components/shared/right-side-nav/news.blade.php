<!-- Card News START -->
<div class="col-sm-6 col-lg-12">
    <div class="card">
        <!-- Card header START -->
        <div class="card-header pb-0 border-0">
            <h5 class="card-title mb-0">Today’s news</h5>
        </div>
        <!-- Card header END -->
        <!-- Card body START -->
        <div class="card-body">
            <!-- News item -->
            @foreach($news as $newsItem)
            <div class="mb-3">
                <h6 class="mb-0"><a href="{{ route('news.show', $newsItem['id']) }}">{{$newsItem['title']}}</a></h6>
                <small>{{ Carbon\Carbon::parse($newsItem['published_at'])->timezone('Europe/London')->diffForHumans() }}</small>
            </div>
            @endforeach
            <!-- Load more comments -->
            <div class="d-grid mt-3">
                <a class="btn btn-sm btn-primary-soft" href="{{ route('news.index') }}">View all latest news</a>
            </div>
        </div>
        <!-- Card body END -->
    </div>
</div>
<!-- Card News END -->
