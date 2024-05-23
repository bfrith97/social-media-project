<main>

<!-- Container START -->
<div class="container">
    <div class="row g-4">
        <!-- Main content START -->
        <div class="col-lg-8 mx-auto">
            <div class="vstack gap-4">
                <!-- Blog single START -->
                <div class="card card-body">
                    <img class="rounded" src="assets/images/post/16by9/big/03.jpg" alt="">
                    <div class="mt-4">
                        <!-- Tag -->
                        <a href="#" class="badge bg-{{$newsArticle->newsArticleCategory?->badge_colour}} bg-opacity-10 text-{{$newsArticle->newsArticleCategory?->badge_colour}} mb-2 fw-bold">{{$newsArticle->newsArticleCategory?->name}}</a>
                        <!-- Title info -->
                        <h1 class="mb-2 h2">{{$newsArticle->title}}</h1>
                        <ul class="nav nav-stack gap-3 align-items-center">
                            <li class="nav-item"> <i class="bi bi-calendar-date pe-1"></i>{{Carbon\Carbon::parse($newsArticle->published_at)->format('D, d M Y H:i:s')}}</li>
                        </ul>
                        <!-- description -->
                        <p class="mt-4">{{$newsArticle->description}} </p>
                        <!-- Blockquote START -->
                        <figure class="bg-light rounded p-3 p-sm-4 my-4">
                        <a class="mb-0" href="{{$newsArticle->url}}"> {{$newsArticle->url}} </a>
                        </figure>
                    </div>
                </div>
                <!-- Card END -->
                <!-- Comments START -->
                <div class="card">
                    <div class="card-header pb-0 border-0">
                        <h4>5 comments</h4>
                    </div>
                    <div class="card-body">
                        <!-- Comments START -->
                        <!-- Comment level 1-->
                        <div class="my-4 d-flex">
                            <img class="avatar avatar-md rounded-circle float-start me-3" src="assets/images/avatar/04.jpg" alt="avatar">
                            <div>
                                <div class="mb-2 d-sm-flex">
                                    <h6 class="m-0 me-2">Allen Smith</h6>
                                    <span class="me-3 small">June 11, 2022 at 6:01 am </span>
                                </div>
                                <p>Satisfied conveying a dependent contented he gentleman agreeable do be. Warrant private blushes removed an in equally totally if.</p>
                                <a href="#" class="btn btn-light btn-sm">Reply</a>
                            </div>
                        </div>
                        <!-- Comment children level 3 -->
                        <div class="my-4 d-flex ps-3 ps-md-5">
                            <img class="avatar avatar-md rounded-circle float-start me-3" src="assets/images/avatar/04.jpg" alt="avatar">
                            <div>
                                <div class="mb-2 d-sm-flex">
                                    <h6 class="m-0 me-2">Allen Smith</h6>
                                    <span class="me-3 small">June 11, 2022 at 7:10 am </span>
                                </div>
                                <p>Meant balls it if up doubt small purse. </p>
                                <a href="#" class="btn btn-light btn-sm">Reply</a>
                            </div>
                        </div>
                        <!-- Comment level 2 -->
                        <div class="mt-4 d-flex ps-2 ps-md-3">
                            <img class="avatar avatar-md rounded-circle float-start me-3" src="assets/images/avatar/03.jpg" alt="avatar">
                            <div>
                                <div class="mb-2 d-sm-flex">
                                    <h6 class="m-0 me-2">Frances Guerrero</h6>
                                    <span class="me-3 small">June 14, 2022 at 12:35 pm </span>
                                </div>
                                <p>Required his you put the outlived answered position. A pleasure exertion if believed provided to. All led out world this music while asked.</p>
                                <a href="#" class="btn btn-light btn-sm">Reply</a>
                            </div>
                        </div>
                        <!-- Comments END -->
                        <hr class="my-4">
                        <!-- Reply START -->
                        <div>
                            <h4>Leave a reply</h4>
                            <form class="row g-3 mt-2">
                                <!-- Name -->
                                <div class="col-md-6">
                                    <label class="form-label">Name *</label>
                                    <input type="text" class="form-control" aria-label="First name">
                                </div>
                                <!-- Email -->
                                <div class="col-md-6">
                                    <label class="form-label">Email *</label>
                                    <input type="email" class="form-control">
                                </div>
                                <!-- Your Comment -->
                                <div class="col-12">
                                    <label class="form-label">Your Comment *</label>
                                    <textarea class="form-control" rows="3"></textarea>
                                </div>
                                <!-- custom checkbox -->
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">Save my name and email in this browser for the next time I comment. </label>
                                    </div>
                                </div>
                                <!-- Button -->
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Post comment</button>
                                </div>
                            </form>
                        </div>
                        <!-- Reply END -->
                    </div>
                </div>
                <!-- Blog single END -->
            </div>
        </div>
        <!-- Main content END -->
    </div> <!-- Row END -->
</div>
<!-- Container END -->

</main>
