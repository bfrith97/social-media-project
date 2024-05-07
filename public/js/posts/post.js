document.addEventListener('DOMContentLoaded', function () {

    let postForm = document.querySelector('#post-creation-form');
    let postFormSubmitBtn = document.querySelector('#post-creation-form-submit');

    postFormSubmitBtn.addEventListener('click', (e) => {
        e.preventDefault();
        console.log('submitting');

        let body = new FormData(postForm);
        const csrfToken = body.get('_token');

        submitPost(postForm, body, csrfToken);
    })

    postForm.addEventListener('submit', (e) => {
        e.preventDefault();
        console.log('submitting');

        let body = new FormData(postForm);
        const csrfToken = body.get('_token');

        submitPost(postForm, body, csrfToken);
    })
});

function submitPost(form, body, csrfToken) {
    fetch(form.action, {
        method: 'POST', body: body, headers: {
            'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok.');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            addNewPostHtml(form, data.post);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function addNewPostHtml(form, post) {
    let formContainer = form.closest('#main-content').querySelector('#posts') // Use a class that wraps both the form and the comment list

    // Create the new comment HTML
    const newCommentHtml = `
      <!-- Card feed item START -->
        <div class="card mb-4">
            <!-- Card header START -->
            <div class="card-header border-0 pb-0">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <!-- Avatar -->
                        <div class="avatar avatar-story me-2">
                            <a href="#!">
                                <img class="avatar-img rounded-circle" src="${post.user.picture}" alt="">
                            </a>
                        </div>
                        <!-- Info -->
                        <div>
                            <div class="nav nav-divider">
                                <h6 class="nav-item card-title mb-0">
                                    <a href="{{ route('profiles.show', $post->user->id) }}"> ${post.user.name} </a></h6>
                                <span class="nav-item small"> Just now </span>
                            </div>
                            <p class="mb-0 small">${post.user.role} at ${post.user.company}</p>
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
                <p>${post.content}</p>
                <!-- Feed react START -->
                <ul class="nav nav-stack pb-2 small">
                    <li class="nav-item">
                        <a class="nav-link" href="#!" data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-custom-class="tooltip-text-start" data-bs-title="">
                            <i class="bi bi-hand-thumbs-up-fill pe-1"></i>Like (0)</a>
                    </li>
                        <span class="comment-count"> <i class="bi bi-chat-fill pe-1"></i>Comments (0)</span>
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
                            <img class="avatar-img rounded-circle" src="${post.user.picture}" alt="">
                        </a>
                    </div>
                    <!-- Comment box  -->
                    <form class="nav nav-item w-100 position-relative comment-form" action="${post.comment_route}" method="post">
                        <input type="hidden" name="_token" value="${post.csrf}" autocomplete="off">
                        <input type="hidden" id="post_id" name="post_id" value="${post.id}"/>
                        <input type="hidden" id="user_id" name="user_id" value="${post.user.id}"/>
                        <input type="text" class="form-control pe-5 bg-light" placeholder="Add a comment..." id="content" name="content">
                        <button class="nav-link bg-transparent px-3 position-absolute top-50 end-0 translate-middle-y border-0 comment-submit-btn" type="submit">
                            <i class="bi bi-send-fill"> </i>
                        </button>
                    </form>
                </div>

                <ul class="comment-wrap list-unstyled">
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



        `;

    // Convert the HTML string into a DOM element
    const range = document.createRange();
    const documentFragment = range.createContextualFragment(newCommentHtml);

    // Append the new comment to the comment list
    formContainer.prepend(documentFragment);
    form.reset();

    form.closest('.card-body').querySelector('.comment-count').innerHTML = `<i class="bi bi-chat-fill pe-1"></i>Comments
                    (${comment.comment_count})`;
}
