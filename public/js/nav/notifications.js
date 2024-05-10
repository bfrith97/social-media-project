document.addEventListener('DOMContentLoaded', function () {
    let markAsReadButtons = document.querySelectorAll('.mark-notifications-read-button');

    markAsReadButtons.forEach(function (markAsReadButton) {
        if (!markAsReadButton.classList.contains('mark-read-event-bound')) {
            markAsReadButton.classList.add('mark-read-event-bound');
            markAsReadButton.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();

                let form = document.querySelector('#mark-notifications-read-form');
                let body = new FormData(form);
                const csrfToken = body.get('_token');

                markAsRead(form, body, csrfToken, markAsReadButton);
            });
        }
    })
});

function markAsRead(form, body, csrfToken, likeBtn) {
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
            changeNotificationsHtml(likeBtn, data, form);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function changeNotificationsHtml(likeBtn, data, form) {
    if (data['message'] === 'Notifications have been marked as read') {
        document.querySelectorAll('.notification').forEach(function (notification) {
            notification.classList.remove('badge-unread');
        })

        let notificationCount = form.querySelector('#notifcation-count');
        notificationCount.textContent = '0 new';
        notificationCount.classList.remove('text-danger');
        notificationCount.classList.remove('bg-danger');
        notificationCount.classList.add('text-success');
        notificationCount.classList.add('bg-success');

        let notificationBadge = form.querySelector('.badge-notif');
        notificationBadge.classList.add('d-none');
    }
}
