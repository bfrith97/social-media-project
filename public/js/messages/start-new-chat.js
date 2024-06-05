function submitConversation(event) {
    event.preventDefault();
    console.log('hello');
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
            console.log(data);
            changeJoinHtml(event.submitter, data, form);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function changeJoinHtml(joinBtn, data, form) {
    if (data['message'] === 'Group member added successfully') {
        joinBtn.classList.add('btn-danger-soft');
        joinBtn.classList.remove('btn-success-soft');
        joinBtn.textContent = 'Leave group'

        let methodInput = document.createElement('input');
        methodInput.setAttribute('type', 'hidden');
        methodInput.setAttribute('name', '_method');
        methodInput.setAttribute('value', 'DELETE');
        methodInput.classList.add('delete_method');

        form.appendChild(methodInput);
    } else {
        joinBtn.classList.remove('btn-danger-soft');
        joinBtn.classList.add('btn-success-soft');
        joinBtn.textContent = 'Join group'

        form.querySelector('.delete_method').remove();
    }
}
