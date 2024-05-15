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
        followBtn.classList.add('active');
        followBtn.innerHTML = `
            <button type="button" class="btn btn-primary rounded-circle icon-md ms-auto"><i class="bi bi-person-check-fill"> </i></button>
        `

        let methodInput = document.createElement('input');
        methodInput.setAttribute('type', 'hidden');
        methodInput.setAttribute('name', '_method');
        methodInput.setAttribute('value', 'DELETE');
        methodInput.classList.add('delete_method');

        form.appendChild(methodInput);
    } else {
        followBtn.innerHTML = `
              <button type="button" class="btn btn-primary-soft rounded-circle icon-md ms-auto follow-button"><i class="fa-solid fa-plus"></i></button>
        `

        form.querySelector('.delete_method').remove();
    }
}
