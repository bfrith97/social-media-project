document.addEventListener('DOMContentLoaded', function () {
    let followButtons = document.querySelectorAll('.follow-button');

    followButtons.forEach((btn) => {
        // Add a check to ensure the event is only bound once
        if (!btn.classList.contains('follow-event-bound')) {
            btn.classList.add('follow-event-bound');
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();

                let form = btn.closest('.follow-form');
                let body = new FormData(form);
                const csrfToken = body.get('_token');

                submitFollow(form, body, csrfToken, btn);
            });
        }
    });
});

function submitFollow(form, body, csrfToken, followBtn) {
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
            changeFollowHtml(followBtn, data, form);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function changeFollowHtml(followBtn, data, form) {
    if (data['message'] === 'Follow added successfully') {
        console.log('follow added')
        followBtn.classList.remove('btn-success-soft');
        followBtn.classList.add('btn-danger-soft');
        followBtn.textContent = 'Unfollow'

        let methodInput = document.createElement('input');
        methodInput.setAttribute('type', 'hidden');
        methodInput.setAttribute('name', '_method');
        methodInput.setAttribute('value', 'DELETE');
        methodInput.classList.add('delete_method');

        form.appendChild(methodInput);
    } else {
        console.log('follow removed')
        followBtn.classList.add('btn-success-soft');
        followBtn.classList.remove('btn-danger-soft');
        followBtn.textContent = 'Follow'

        form.querySelector('.delete_method').remove();
    }
}
