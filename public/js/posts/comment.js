let commentForms = document.querySelectorAll('.comment-form');
commentForms.forEach((form, index) => {
    form.addEventListener('submit', (e) => {
        e.preventDefault();

        let body = new FormData(form);
        const csrfToken = body.get('_token');

        submitComment(form, body, csrfToken);
    })
})

function submitComment(form, body, csrfToken) {
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
            addNewCommentHtml(form, data.comment);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function addNewCommentHtml(form, comment) {
    let formContainer = form.closest('.card-body'); // Use a class that wraps both the form and the comment list
    let commentList = formContainer ? formContainer.querySelector('.comment-wrap') : null;

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
                        <li class="nav-item">
                            <a class="nav-link" href="#!">Like 0</a>
                        </li>
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

    form.closest('.card-body').querySelector('.comment-count').innerHTML = `<i class="bi bi-chat-fill pe-1"></i>Comments
                    (${comment.comment_count})`;
}
