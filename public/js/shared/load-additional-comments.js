function loadAdditionalComments(button) {
    let post = button.querySelector('.postId').value;
    let offset = button.dataset.offset;

    fetch(`/comments/load-additional/${post}/${offset}`, {
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
            addCommentHtml(data, button)
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function addCommentHtml(data, button) {
    let card = button.closest('.card'); // Use a class that wraps both the form and the comment list
    let commentList = card ? card.querySelector('.comment-wrap') : null;
    console.log(data)

    if (data['message'] === 'Comments retrieved successfully') {
        data['comments'].forEach(function (msg) {
            const newCommentHtml = `
                <li class="comment-item">
                    <div class="d-flex position-relative">
                        <div class="avatar avatar-xs">
                            <a href="/profiles/${msg.user.id}"><img class="avatar-img rounded-circle" src="${msg.user.profile_picture}" alt=""></a>
                        </div>
                        <div class="ms-2">
                            <div class="bg-light rounded-start-top-0 p-2 rounded">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1"><a href="/profiles/${msg.user.id}">${msg.user.name}</a></h6>
                                    <small class="ms-2">${msg.created_at_formatted}</small>
                                </div>
                                <p class="small mb-0">${msg.content}</p>
                            </div>
                             <ul class="nav nav-divider pb-2 pt-1 small">
                                <form class="post-like-form" action="${data['likeCommentRoute']}" method="post" onsubmit="submitLike(event)">
                                    ${msg.liked_by_current_user ? '<input class="delete_method" type="hidden" name="_method" value="DELETE">' : ''}
                                    <input type="hidden" name="_token" value="9ReFPuM55VL7v9OBHvOPCSbNBtQ5erTsVOCIhEgK" autocomplete="off">
                                    <input type="hidden" id="comment_id" name="comment_id" value="${msg.id}">
                                    <input type="hidden" id="user_id" name="user_id" value="1">
                                    <li class="nav-item">
                                        <button type="submit" class="nav-link like-button comment-like like-event-bound ${msg.liked_by_current_user ? 'active' : ''}">
                                           ${msg.liked_by_current_user ? 'Liked' : 'Like'} (${msg.comment_likes.length})
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
            commentList.append(documentFragment);
        })

        if (!data['moreCommentsAvailable']) {
            button.classList.add('d-none');
        } else {
            button.dataset.offset = data['newOffset'];
        }
    }
}
