<main class="flex-grow-1">

    <!-- Container START -->
    <div class="container">
        <div class="row g-4">
            <!-- Main content START -->
            <div class="col-lg-8">
                <div class="bg-mode p-4">
                    <h1 class="h4 mb-4">Latest news</h1>
                    @foreach($newsArticles as $newsArticle)
                        <!-- Blog item START -->
                        <x-news.news-article-card :newsArticle="$newsArticle"/>
                        <hr class="my-4">
                        <!-- Blog item END -->
                    @endforeach
                    <!-- Pagination -->
                    <div class="mt-4">
                        <nav aria-label="navigation">
                            <ul class="pagination pagination-light d-inline-block d-md-flex justify-content-center">
                                @foreach($newsArticles->linkCollection() as $link)
                                    <li class="text-nowrap page-item {{ !$link['url'] ? 'disabled' : '' }} {{ $link['active'] ? 'active' : '' }}"><a class="page-link" href="{{$link['url']}}">{!! $link['label']!!}</a></li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- Main content END -->

            <!-- Right sidebar START -->
            <div class="col-lg-4">
                <div class="row g-4">
                    <!-- Card News START -->
                    <div class="col-sm-6 col-lg-12">
                        <div class="card">
                            <!-- Card header START -->
                            <div class="card-header pb-0 border-0">
                                <h5 class="card-title mb-0">Tags</h5>
                            </div>
                            <!-- Card header END -->
                            <!-- Card body START -->
                            <div class="card-body">
                                <!-- Tag list START -->
                                <ul class="list-inline mb-0 d-flex flex-wrap gap-2">
                                    <li class="list-inline-item m-0">
                                        <a class="badge bg-danger text bg-opacity-10 text-danger {{$tag == '1' ? 'fw-bold' : 'fw-normal'}}" href="?tag=1">Health</a>
                                    </li>
                                    <li class="list-inline-item m-0">
                                        <a class="badge bg-primary text bg-opacity-10 text-primary {{$tag == '2' ? 'fw-bold' : 'fw-normal'}}" href="?tag=2">Business</a>
                                    </li>
                                    <li class="list-inline-item m-0">
                                        <a class="badge bg-success text bg-opacity-10 text-success {{$tag == '3' ? 'fw-bold' : 'fw-normal'}}" href="?tag=3">Science</a>
                                    </li>
                                    <li class="list-inline-item m-0">
                                        <a class="badge bg-info text bg-opacity-10 text-info {{$tag == '4' ? 'fw-bold' : 'fw-normal'}}" href="?tag=4">Sports</a>
                                    </li>
                                    <li class="list-inline-item m-0">
                                        <a class="badge bg-warning text bg-opacity-10 text-warning {{$tag == '5' ? 'fw-bold' : 'fw-normal'}}" href="?tag=5">Technology</a>
                                    </li>
                                    <li class="list-inline-item m-0">
                                        <a class="badge bg-secondary text bg-opacity-10 text-secondary {{$tag == 'all' || !$tag ? 'fw-bold' : 'fw-normal'}}" href="?tag=all">All</a>
                                    </li>
                                </ul>
                                <!-- Tag list END -->
                                <!-- Card body END -->
                            </div>
                        </div>
                        <!-- Card News END -->
                    </div>
                </div>
                <!-- Right sidebar END -->
            </div> <!-- Row END -->
        </div>
    </div>
    <!-- Container END -->

</main>
<!-- **************** MAIN CONTENT END **************** -->

