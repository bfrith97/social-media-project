document.addEventListener('DOMContentLoaded', function () {
    let messageForms = document.querySelectorAll('.message-form');

    messageForms.forEach(function (messageForm) {
        messageForm.addEventListener('submit', (e) => {
            e.preventDefault();

            let body = new FormData(messageForm);
            const csrfToken = body.get('_token');

            submitMessage(messageForm, body, csrfToken);
        })
    })


    document.querySelectorAll('.chat-selector').forEach(function (chat, index) {
        chat.addEventListener('click', function (e) {
            let conversationId = chat.dataset.conversationId;
            let chatToast = document.querySelector(`.chat-messages-${conversationId}`);
            let chatToastContainer = document.querySelector(`#collapseChat-${conversationId}`);
            let instance = OverlayScrollbars(chatToast, {});

            focusTextInput(chatToastContainer);
            scrollToBottom(instance);
        })
    })

    const searchContactBox = document.querySelector('#search-contact-box');
    const contactListItems = document.querySelectorAll('.offcanvas-body .list-unstyled li.chat-selector');

    searchContactBox.addEventListener('input', function () {
        const searchText = searchContactBox.value.toLowerCase();

        contactListItems.forEach(item => {
            // Assumes that the contact name is within an <a> tag with class 'h6'
            const contactName = item.querySelector('a.h6').textContent.toLowerCase();
            if (contactName.includes(searchText)) {
                item.style.display = ''; // Show contact if it matches
            } else {
                item.style.display = 'none'; // Hide contact if it doesn't match
            }
        });
    });
});

function scrollToBottom(instance) {
    setTimeout(function () {
        instance.scroll({y: "100%"});
    }, 150);
    instance.scroll({y: "100%"});
}

function focusTextInput(container) {
    setTimeout(function () {
        container.querySelector('.content-input').focus();
    }, 150);
    container.querySelector('.content-input').focus();
}

function submitMessage(form, body, csrfToken) {
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
            addNewMessageHtml(form, data, data.conversationId);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function addNewMessageHtml(form, data, conversationId) {
    let chatWindow = form.closest('.toast-body').querySelector('.os-content');
    let instance = OverlayScrollbars(form.closest('.toast-body').querySelector('.chat-conversation-content'), {});

    const newMessageHtml = `
            <div class="d-flex justify-content-end text-end mb-1">
            <div class="w-100">
                <div class="d-flex flex-column align-items-end">
                    <div class="bg-primary text-white p-2 px-3 rounded-2"
                         data-bs-toggle="tooltip"
                         data-bs-placement="bottom"
                         data-bs-custom-class="custom-tooltip"
                         data-bs-title="{{\Carbon\Carbon::createFromDate($message->created_at)->format('d/m/y')}}">${data.content.content}
                    </div>
                    <div class="small my-1"></div>
                </div>
            </div>
        </div>
    `;

    // Convert the HTML string into a DOM element
    const range = document.createRange();
    const documentFragment = range.createContextualFragment(newMessageHtml);

    // Append the new comment to the comment list
    chatWindow.append(documentFragment);
    form.reset();

    scrollToBottom(instance);
}
