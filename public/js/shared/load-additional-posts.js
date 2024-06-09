function loadAdditionalPosts(button) {
    let offset = button.dataset.offset;

    fetch(`/posts/load-additional/${offset}`, {
        method: 'GET',
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok.');
            }
            return response.json();
        })
        .then(data => {
            console.log(data)
            addPostHtml(data, button)
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function generateCommentsHtml(comments, user, data) {
    return comments.map(comment => `
        <li class="comment-item">
            <div class="d-flex position-relative">
                <!-- Avatar -->
                <div class="avatar avatar-xs">
                    <a href="${comment.user.profile_route}"><img class="avatar-img rounded-circle" src="${comment.user.profile_picture}" alt=""></a>
                </div>
                <div class="ms-2 mb-2">
                    <!-- Comment by -->
                    <div class="bg-light rounded-start-top-0 p-2 rounded">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-1">
                                <a href="${comment.user.profile_route}"> ${comment.user.name} </a></h6>
                            <small class="ms-2">${comment.created_at_formatted}</small>
                        </div>
                        <p class="small mb-0 text-break"> ${comment.content} </p>
                    </div>
                    <!-- Comment react -->
                    <ul class="nav nav-divider pb-2 pt-1 small">
                        <form class="post-like-form" action="${data['like_comment_route']}" method="post" onsubmit="submitLike(event)">
                            ${comment.liked_by_current_user ? '<input class="delete_method" type="hidden" name="_method" value="DELETE">' : ''}
                            <input type="hidden" name="_token" value="${data['csrf']}" autocomplete="off">
                            <input type="hidden" id="comment_id" name="comment_id" value="${comment.id}">
                            <input type="hidden" id="user_id" name="user_id" value="1">
                            <li class="nav-item">
                                <button type="submit" class="nav-link like-button comment-like like-event-bound ${comment.liked_by_current_user ? 'active' : ''}">
                                   ${comment.liked_by_current_user ? 'Liked' : 'Like'} (${comment.comment_likes.length})
                                </button>
                            </li>
                        </form>
                    </ul>
                </div>
            </div>
        </li>
  `).join('');
}

function addPostHtml(data, button) {
    let postList = document.querySelector('#posts') ?? null;

    if (data['message'] === 'Posts retrieved successfully') {
        data['posts'].forEach(function (post) {
            const newPostHtml = `
              <div class="card  mb-4 ">
                <!-- Card header START -->
                <div class="card-header border-0 pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <!-- Avatar -->
                            <div class="avatar me-2">
                                <a href="123">
                                    <img class="avatar-img rounded-circle" src="${post.user.profile_picture}" alt="">
                                </a>
                            </div>
                            <!-- Info -->
                            <div>
                                <div class="nav nav-divider">
                                    <h6 class="nav-item card-title mb-0">
                                        <a href="${post.user.profile_route}"> ${post.user.name} </a></h6>
                                    <span class="nav-item small"> ${post.created_at_formatted} </span>
                                </div>
                                <p class="mb-0 small">
                                    ${post.user.role}
                                    at
                                    ${post.user.company}
                                </p>

                            </div>
                        </div>
                        <!-- Card feed action dropdown START -->
                        <div class="dropdown">
                            <a href="#" class="text-secondary btn btn-secondary-soft-hover py-1 px-2" id="cardFeedAction" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </a>
                            <!-- Card feed action dropdown menu -->
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardFeedAction">
                                <li><a class="dropdown-item" href="#"> <i class="bi bi-bookmark fa-fw pe-2"></i>Save post</a></li>
                                <li><a class="dropdown-item" href="#">
                                        <i class="bi bi-person-x fa-fw pe-2"></i> ${post.user.name} </a></li>
                                <li><a class="dropdown-item" href="#"> <i class="bi bi-x-circle fa-fw pe-2"></i>Hide post</a></li>
                                <li><a class="dropdown-item" href="#"> <i class="bi bi-slash-circle fa-fw pe-2"></i>Block</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#"> <i class="bi bi-flag fa-fw pe-2"></i>Report post</a></li>
                            </ul>
                        </div>
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
                        <form class="post-like-form" action="${data['like_post_route']}" method="post" onsubmit="submitLike(event)">
                            <input type="hidden" name="_token" value="${data['csrf']}" autocomplete="off">
                            ${post.liked_by_current_user ? '<input class="delete_method" type="hidden" name="_method" value="DELETE">' : ''}
                            <input type="hidden" id="post_id" name="post_id" value="${post.id}">
                            <input type="hidden" id="user_id" name="user_id" value="${data['user'].id}">
                            <li class="nav-item">
                                <button class="nav-link ${post.liked_by_current_user ? 'active' : ''} like-button like-event-bound" type="submit" data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-custom-class="tooltip-text-start" data-bs-title="">
                                    <i class="bi bi-hand-thumbs-up-fill pe-1"></i>${post.liked_by_current_user ? 'Liked' : 'Like'}
                                    (${post.post_likes_count})
                                </button>
                            </li>
                        </form>
                        <span class="comment-count"> <i class="bi bi-chat-fill pe-1"></i>Comments (${post.comments_count})</span>
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
                    <div class="d-flex mb-3">
                <!-- Avatar -->
                <div class="avatar avatar-xs me-2">
                    <a href="123">
                        <img class="avatar-img rounded-circle" src="${data['user'].profile_picture}" alt="">
                    </a>
                </div>
                <!-- Comment box  -->
                  <form class="nav nav-item w-100 position-relative comment-form" action="${data['comment_post_route']}" method="post" onsubmit="submitComment(event)">
                    <input type="hidden" name="_token" value="${data['csrf']}" autocomplete="off">
                    <input type="hidden" id="item_id" name="item_id" value="${post.id}">
                    <input type="hidden" id="item_type" name="item_type" value="App\\Models\\Post">
                    <input type="hidden" id="user_id" name="user_id" value="${data['user'].id}">
                    <input type="text" class="form-control pe-5 bg-light" placeholder="Add a comment..." id="content" name="content" required>
                    <button class="nav-link bg-transparent px-3 position-absolute top-50 end-0 translate-middle-y border-0 comment-submit-btn" type="submit">
                        <i class="bi bi-send-fill"> </i>
                    </button>
                </form>
            </div>

                <ul class="comment-wrap list-unstyled mb-0">
                    ${generateCommentsHtml(post.comments, data['user'], data)}
                </ul>
                </div>
                <!-- Card body END -->
                <!-- Card footer START -->
                <div class="card-footer border-0 py-0">
                ${post.has_more_than_five_comments ? '     <button type="button" onclick="loadAdditionalComments(this)" class="btn btn-link btn-link-loader btn-sm text-secondary d-flex align-items-center pb-3" data-offset="5">\n                    <input class="postId" type="hidden" name="post" value="88">\n                    <div class="spinner-dots me-2">\n                        <span class="spinner-dot"></span>\n                        <span class="spinner-dot"></span>\n                        <span class="spinner-dot"></span>\n                    </div>\n                    Load more comments\n                </button>' : ''}

                </div>
                <!-- Card footer END -->
            </div>
            `;

            // Convert the HTML string into a DOM element
            const range = document.createRange();
            const documentFragment = range.createContextualFragment(newPostHtml);

            // Append the new comment to the comment list
            postList.append(documentFragment);
        })

        if (!data['morePostsAvailable']) {
            button.classList.add('d-none');
        } else {
            button.dataset.offset = data['newOffset'];
        }
    }
}
