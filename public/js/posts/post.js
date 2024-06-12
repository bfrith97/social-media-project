function submitPost(event) {
    event.preventDefault();

    let form = event.target;
    let body = new FormData(form);
    const csrfToken = body.get('_token');

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
            addNewPostHtml(form, data.post, data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function addContent(post) {
    if (post.is_feeling == 1) {
        return `
            <div>
                <div class="nav nav-divider">
                    <h6 class="nav-item card-title mb-0">
                        <a href="${post.user.profile_route}"> ${post.user.name} </a>
                        <span class="fw-normal ms-1">is feeling ${post.content}</span>
                        <br>
                    </h6>
                    <span class="nav-item small"> Just now </span>
                </div>
            </div>
        `
    } else {
        return `
        <div>
            <div class="nav nav-divider">
                <h6 class="nav-item card-title mb-0">
                    <a href="${post.user.profile_route}"> ${post.user.name} </a></h6>
                <span class="nav-item small"> Just now </span>
            </div>
            <p class="mb-0 small">${post.user.role} at ${post.user.company}</p>
        </div>
        `
    }
}

function addNewPostHtml(form, post, data) {
    let formContainer = form.closest('body').querySelector('#posts')

    // Create the new comment HTML
    const newCommentHtml = `
      <!-- Card feed item START -->
        <div class="card mb-4">
            <!-- Card header START -->
            <div class="card-header border-0 pb-0">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <!-- Avatar -->
                        <div class="avatar me-2">
                            <a href="${post.user.profile_route}">
                                <img class="avatar-img rounded-circle" src="${post.user.profile_picture}" alt="">
                            </a>
                        </div>
                        <!-- Info -->
                        ${addContent(post)}
                    </div>
                    <!-- Card feed action dropdown START -->
<!--                    TODO-->
<!--                    <div class="dropdown">-->
<!--                        <a href="#" class="text-secondary btn btn-secondary-soft-hover py-1 px-2" id="cardFeedAction" data-bs-toggle="dropdown" aria-expanded="false">-->
<!--                            <i class="bi bi-three-dots"></i>-->
<!--                        </a>-->
<!--                        &lt;!&ndash; Card feed action dropdown menu &ndash;&gt;-->
<!--                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardFeedAction">-->
<!--                            <li><a class="dropdown-item" href="#"> <i class="bi bi-bookmark fa-fw pe-2"></i>Save-->
<!--                                    post</a></li>-->
<!--                            <li><a class="dropdown-item" href="#"> <i class="bi bi-person-x fa-fw pe-2"></i>Unfollow-->
<!--                                    lori ferguson </a></li>-->
<!--                            <li><a class="dropdown-item" href="#"> <i class="bi bi-x-circle fa-fw pe-2"></i>Hide-->
<!--                                    post</a></li>-->
<!--                            <li><a class="dropdown-item" href="#"> <i class="bi bi-slash-circle fa-fw pe-2"></i>Block</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <hr class="dropdown-divider">-->
<!--                            </li>-->
<!--                            <li><a class="dropdown-item" href="#"> <i class="bi bi-flag fa-fw pe-2"></i>Report-->
<!--                                    post</a></li>-->
<!--                        </ul>-->
<!--                    </div>-->
                    <!-- Card feed action dropdown END -->
                </div>
            </div>
            <!-- Card header END -->
            <!-- Card body START -->
            <div class="card-body pb-0">
                ${post.is_feeling == 1 ? '' : `<p>${post.content}
                    ${post.image_path ? `<img src="${post.image_path}" class="mt-2" alt="">` : ''}
                </p>`}
                <!-- Feed react START -->
                <ul class="nav nav-stack pb-2 small">
                    <form class="post-like-form" action="${post.post_like_route}" method="post" onsubmit="submitLike(event)">
                            <input type="hidden" name="_token" value="${data['csrf']}" autocomplete="off">
                            ${post.liked_by_current_user ? '<input class="delete_method" type="hidden" name="_method" value="DELETE">' : ''}
                            <input type="hidden" id="post_id" name="post_id" value="${post.id}">
                            <input type="hidden" id="user_id" name="user_id" value="${post.user.id}">
                            <li class="nav-item">
                                <button class="nav-link like-button like-event-bound" type="submit" data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-custom-class="tooltip-text-start" data-bs-title="">
                                    <i class="bi bi-hand-thumbs-up-fill pe-1"></i>Like (0)
                                </button>
                            </li>
                        </form>
                        <span class="comment-count"> <i class="bi bi-chat-fill pe-1"></i>Comments (0)</span>
                    <!-- Card share action START -->
                    <li class="nav-item dropdown ms-sm-auto">
<!--                            TODO-->
<!--                        <a class="nav-link mb-0" href="#" id="cardShareAction" data-bs-toggle="dropdown" aria-expanded="false">-->
<!--                            <i class="bi bi-reply-fill flip-horizontal ps-1"></i>Share (0)-->
<!--                        </a>-->
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
                        <a href="${post.user.profile_route}">
                            <img class="avatar-img rounded-circle" src="${post.user.profile_picture}" alt="">
                        </a>
                    </div>
                    <!-- Comment box  -->
                    <form class="nav nav-item w-100 position-relative comment-form" action="${post.comment_route}" method="post" onsubmit="submitComment(event)">
                        <input type="hidden" name="_token" value="${data['csrf']}" autocomplete="off">
                        <input type="hidden" id="item_id" name="item_id" value="${post.id}"/>
                        <input type="hidden" id="item_type" name="item_type" value="App\\Models\\Post"/>
                        <input type="hidden" id="user_id" name="user_id" value="${post.user.id}"/>
                        <input type="text" class="form-control pe-5 bg-light" placeholder="Add a comment..." id="content" name="content" required>
                        <button class="nav-link bg-transparent px-3 position-absolute top-50 end-0 translate-middle-y border-0 comment-submit-btn" type="submit">
                            <i class="bi bi-send-fill"> </i>
                        </button>
                    </form>
                </div>

                <ul class="comment-wrap list-unstyled">
                </ul>
            </div>
            <!-- Card body END -->
        </div>
        <!-- Card feed item END -->



        `;

    // Convert the HTML string into a DOM element
    const range = document.createRange();
    const documentFragment = range.createContextualFragment(newCommentHtml);

    // Append the new comment to the comment list
    formContainer.prepend(documentFragment);
    form.reset();
}
