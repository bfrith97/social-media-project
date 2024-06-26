document.addEventListener('DOMContentLoaded', function () {
    let messageForm = document.querySelector('#message-form');
    let conversationInput = document.querySelector('#conversation_id');

    messageForm.addEventListener('submit', (e) => {
        e.preventDefault();

        let body = new FormData(messageForm);
        const csrfToken = body.get('_token');

        submitMessage(messageForm, body, csrfToken);
    })


    document.querySelectorAll('.chat-selector').forEach(function (chat, index) {
        chat.addEventListener('click', function (e) {
            let conversationInputVal = chat.id.split('-')[1];
            let instance = OverlayScrollbars(document.querySelector(`.chat-messages-${conversationInputVal}`), {});

            scrollToBottom(instance);
            setTimeout(function () {
                scrollToBottom(instance)
            }, 100);
        })
    })

    const searchBox = document.querySelector('#chat-search-input');
    const chatList = document.querySelectorAll('#conversation-list .nav-link');

    searchBox.addEventListener('input', function () {
        const searchText = searchBox.value.toLowerCase();
        chatList.forEach(chat => {
            const chatName = chat.querySelector('h6').textContent.toLowerCase();
            if (chatName.includes(searchText)) {
                chat.parentElement.style.display = "";
            } else {
                chat.parentElement.style.display = "none";
            }
        });
    });
});

function changeConversationId(button) {
    let conversationInput = document.querySelector('#conversation_id');
    conversationInput.value = button.id.split('-')[1];

    document.querySelector('#content-input').disabled = false
    document.querySelector('#emoji-btn').disabled = false
    document.querySelector('#send-btn').disabled = false
    document.querySelector('#message-greeting').classList.add('d-none')
}

function scrollToBottom(instance) {
    instance.scroll({y: "100%"});
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
    let chatWindow = document.querySelector(`.chat-messages-${conversationId}`).querySelector('.os-content');
    let instance = OverlayScrollbars(document.querySelector(`.chat-messages-${conversationId}`), {});

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
    setTimeout(function () {
        scrollToBottom(instance)
    }, 100);
}
