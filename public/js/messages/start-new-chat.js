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
            addChatHtml(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function addChatHtml(data) {
    let conversationList = document.querySelector('#conversation-list');
    let chatTabsContent = document.querySelector('#chat_tabs_content');

    let chatBtn = `
        <li data-bs-dismiss="offcanvas">
            <!-- Chat user tab item -->
            <a href="#chat-${data.conversation.id}" class="nav-link text-start chat-selector chat-${data.conversation.id}" id="chat-${data.conversation.id}-tab" data-bs-toggle="pill" role="tab" aria-selected="false" tabindex="-1" onclick="changeConversationId(this)">
                <div class="d-flex">
                    <div class="flex-shrink-0 avatar avatar-story me-2 status-online">
                        <img class="avatar-img rounded-circle" src="${data.participant.participant.profile_picture}" alt="">
                    </div>
                    <div class="flex-grow-1 d-block">
                        <h6 class="mb-0 mt-1">${data.participant.participant.name}</h6>
                        <div class="small text-secondary">
                        </div>
                    </div>
                </div>
            </a>
        </li>
    `

    const range = document.createRange();
    const documentFragment = range.createContextualFragment(chatBtn);
    conversationList.appendChild(documentFragment);

    let chat = `
       <div class="fade tab-pane h-100" id="chat-${data.conversation.id}" role="tabpanel" aria-labelledby="chat-${data.conversation.id}-tab">
            <!-- Top avatar and status START -->
            <div class="d-sm-flex justify-content-between align-items-center">
                <a href="${data.participant.participant.profile_route}" class="d-flex mb-2 mb-sm-0">
                    <div class="flex-shrink-0 avatar me-2">
                        <img class="avatar-img rounded-circle" src="${data.participant.participant.profile_picture}" alt="">
                    </div>
                    <div class="d-block flex-grow-1">
                        <h6 class="mb-0 mt-1">${data.participant.participant.name}</h6>
                        <div class="small text-secondary">
                            <i class="fa-solid fa-circle text-success me-1"></i>Online
                        </div>
                    </div>
                </a>
            </div>
            <!-- Top avatar and status END -->
            <hr>
            <!-- Chat conversation START -->
            <div class="chat-conversation-content custom-scrollbar chat-messages-${data.conversation.id} os-host os-theme-dark os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-scrollbar-vertical-hidden os-host-transition"><div class="os-resize-observer-host observed"><div class="os-resize-observer" style="left: 0px; right: auto;"></div></div><div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;"><div class="os-resize-observer"></div></div><div class="os-content-glue" style="margin: 0px;"></div><div class="os-padding"><div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow: visible;"><div class="os-content" style="padding: 0px; height: 100%; width: 100%;">
                <!-- Chat time -->
                <div class="text-center small my-2">${data.conversation.created_at_formatted}</div>
                                                    </div></div></div><div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden"><div class="os-scrollbar-track os-scrollbar-track-off"><div class="os-scrollbar-handle" style="transform: translate(0px, 0px); width: 100%;"></div></div></div><div class="os-scrollbar os-scrollbar-vertical os-scrollbar-unusable os-scrollbar-auto-hidden"><div class="os-scrollbar-track os-scrollbar-track-off"><div class="os-scrollbar-handle" style="transform: translate(0px, 0px); height: 100%;"></div></div></div><div class="os-scrollbar-corner"></div></div>
            <!-- Chat conversation END -->
        </div>
    `

    const range2 = document.createRange();
    const documentFragment2 = range2.createContextualFragment(chat);
    chatTabsContent.appendChild(documentFragment2);
}
