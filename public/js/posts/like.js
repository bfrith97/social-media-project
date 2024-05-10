document.addEventListener('DOMContentLoaded', function () {
    let likeButtons = document.querySelectorAll('.like-button');

    likeButtons.forEach((btn) => {
        // Add a check to ensure the event is only bound once
        if (!btn.classList.contains('like-event-bound')) {
            btn.classList.add('like-event-bound');
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();

                let form = btn.closest('.post-like-form');
                let body = new FormData(form);
                const csrfToken = body.get('_token');

                submitLike(form, body, csrfToken, btn);
            });
        }
    });
});

function submitLike(form, body, csrfToken, likeBtn) {
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
            changeLikeHtml(likeBtn, data, form);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function changeLikeHtml(likeBtn, data, form) {
    let likeBtnHTML = likeBtn.innerHTML;
    let parts = likeBtnHTML.split("(");
    let likeCountNumber;

    if (data['message'] === 'Like added successfully') {
        likeCountNumber = parseInt(parts[1]) + 1

        likeBtn.classList.add('active');
        likeBtn.innerHTML = '';
        if (!likeBtn.classList.contains('comment-like')) {
            likeBtn.innerHTML = `<i class="bi bi-hand-thumbs-up-fill pe-1"></i>`
        }
        likeBtn.innerHTML += `Liked (${likeCountNumber})`

        let methodInput = document.createElement('input');
        methodInput.setAttribute('type', 'hidden');
        methodInput.setAttribute('name', '_method');
        methodInput.setAttribute('value', 'DELETE');
        methodInput.classList.add('delete_method');

        form.appendChild(methodInput);
    } else if (data['message'] === 'Like removed successfully') {
        likeCountNumber = parseInt(parts[1]) - 1

        likeBtn.classList.remove('active');
        likeBtn.innerHTML = '';
        if (!likeBtn.classList.contains('comment-like')) {
            likeBtn.innerHTML = `<i class="bi bi-hand-thumbs-up-fill pe-1"></i>`
        }
        likeBtn.innerHTML += `Like (${likeCountNumber})`


        form.querySelector('.delete_method').remove();
    }
}
