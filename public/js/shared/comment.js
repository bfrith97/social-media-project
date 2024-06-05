function submitComment(event) {
    event.preventDefault();

    let form = event.target;
    let body = new FormData(form);
    const csrfToken = body.get('_token');

    fetch(form.action, {
        method: 'POST',
        body: body,
        headers: {
            'X-CSRF-TOKEN': csrfToken,  // Make sure the CSRF token header is correct
            'Accept': 'application/json'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok.');
            }
            return response.json();
        })
        .then(data => {
            addNewCommentHtml(form, data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function addNewCommentHtml(form, data) {
    let formContainer = form.closest('.card-body'); // Use a class that wraps both the form and the comment list
    let commentList = formContainer ? formContainer.querySelector('.comment-wrap') : null;
    let comment = data.comment;
    console.log(comment);

    // Create the new comment HTML
    const newCommentHtml = `
        <li class="comment-item">
            <div class="d-flex position-relative">
                <div class="avatar avatar-xs">
                    <a href="/profiles/${comment.user.id}"><img class="avatar-img rounded-circle" src="${comment.user.picture}" alt=""></a>
                </div>
                <div class="ms-2">
                    <div class="bg-light rounded-start-top-0 p-2 rounded">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-1"><a href="/profiles/${comment.user.id}">${comment.user.name}</a></h6>
                            <small class="ms-2">Just now</small>
                        </div>
                        <p class="small mb-0">${comment.content}</p>
                    </div>
                      <ul class="nav nav-divider pb-2 pt-1 small">
                            <form class="post-like-form" action="${comment.likeCommentRoute}" method="post" onsubmit="submitLike(event)">
                                ${comment.liked_by_current_user ? '<input class="delete_method" type="hidden" name="_method" value="DELETE">' : ''}
                                <input type="hidden" name="_token" value="${comment.csrf}" autocomplete="off">
                                <input type="hidden" id="comment_id" name="comment_id" value="${comment.id}">
                                <input type="hidden" id="user_id" name="user_id" value="1">
                                <li class="nav-item">
                                    <button type="submit" class="nav-link like-button comment-like like-event-bound">
                                       Like (0)
                                    </button>
                                </li>
                            </form>
                    </ul>
                </div>
            </div>
        </li>
        `;

    // Convert the HTML string into a DOM element
    const range = document.createRange();
    const documentFragment = range.createContextualFragment(newCommentHtml);

    // Append the new comment to the comment list
    commentList.prepend(documentFragment);
    form.reset();

    let commentCount = form.closest('.card-body').querySelector('.comment-count');
    let commentCountHTML = commentCount.innerHTML;
    let parts = commentCountHTML.split("(");
    let commentCountNumber = parseInt(parts[1]) + 1

    commentCount.innerHTML = parts[0] + '(' + commentCountNumber + ')';
}
