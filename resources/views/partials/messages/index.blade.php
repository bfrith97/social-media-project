<main class="flex-grow-1">

    <!-- Container START -->
    <div class="container">
        <div class="row gx-0">
            <!-- Sidebar START -->
            <div class="col-lg-4 col-xxl-3" id="chatTabs" role="tablist">

                <!-- Divider -->
                <div class="d-flex align-items-center mb-4 d-lg-none">
                    <button class="border-0 bg-transparent" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                        <span class="btn btn-primary"><i class="fa-solid fa-sliders-h"></i></span>
                        <span class="h6 mb-0 fw-bold d-lg-none ms-2">Chats</span>
                    </button>
                </div>
                <!-- Advanced filter responsive toggler END -->
                <div class="card card-body border-end-0 border-bottom-0 rounded-bottom-0">
                    <div class=" d-flex justify-content-between align-items-center">
                        <h1 class="h5 mb-0">Active chats
                            <span class="badge bg-success bg-opacity-10 text-success">{{$conversations_count}}</span>
                        </h1>
                        <!-- Chat new create message item START -->
                        <div class="dropend position-relative">
                            <div class="nav">
                                <a class="icon-md rounded-circle btn btn-sm btn-primary-soft nav-link toast-btn" data-target="chatToast" href="#">
                                    <i class="bi bi-pencil-square"></i> </a>
                            </div>
                        </div>
                        <!-- Chat new create message item END -->
                    </div>
                </div>

                <nav class="navbar navbar-light navbar-expand-lg mx-0">
                    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar">
                        <!-- Offcanvas header -->
                        <div class="offcanvas-header">
                            <button type="button" class="btn-close text-reset ms-auto" data-bs-dismiss="offcanvas"></button>
                        </div>

                        <!-- Offcanvas body -->
                        <div class="offcanvas-body p-0">
                            <div class="card card-chat-list rounded-end-lg-0 card-body border-end-lg-0 rounded-top-0">

                                <!-- Search chat START -->
                                <form class="position-relative">
                                    <input id="chat-search-input" class="form-control py-2" type="search" placeholder="Search for chats" aria-label="Search">
                                    <button class="btn bg-transparent text-secondary px-2 py-0 position-absolute top-50 end-0 translate-middle-y" type="submit">
                                    </button>
                                </form>
                                <!-- Search chat END -->
                                <!-- Chat list tab START -->
                                <div class="mt-4 h-100">
                                    <div class="chat-tab-list custom-scrollbar">
                                        <ul id="conversation-list" class="nav flex-column nav-pills nav-pills-soft">
                                            @foreach($conversations as $key => $conversation)
                                                <li data-bs-dismiss="offcanvas">
                                                    <!-- Chat user tab item -->
                                                    <a href="#chat-{{$conversation->id}}" class="nav-link text-start chat-selector chat-{{$conversation->id}} mb-1 px-0 person-id-{{$conversation->conversationParticipants->first()?->id}}" id="chat-{{$conversation->id}}-tab" data-bs-toggle="pill" role="tab"  onclick="changeConversationId(this)">
                                                        <div class="d-flex">
                                                            <div class="flex-shrink-0 avatar me-2 status-online">
                                                                <img class="avatar-img rounded-circle" src="{{asset($conversation->conversationParticipants->first()?->profile_picture)}}" alt="">
                                                            </div>
                                                            <div class="flex-grow-1 d-block">
                                                                <h6 class="mb-0 mt-1 text-nowrap">{{$conversation->conversationParticipants->first()?->name}}</h6>
                                                                <div class="small text-secondary">{{$conversation->messages->last()?->content}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <!-- Chat list tab END -->
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <!-- Sidebar START -->

            <!-- Chat conversation START -->
            <div class="col-lg-8 col-xxl-9">
                <div class="card card-chat rounded-start-lg-0 border-start-lg-0">
                    <div class="card-body h-100">
                        <div id="message-greeting" class="d-flex justify-content-center align-items-center h-100">
                            <p>Please select a chat</p>
                        </div>
                        <div class="tab-content py-0 mb-0 h-100" id="chat_tabs_content">
                            @foreach($conversations as $key => $conversation)
                                <!-- Conversation item START -->
                                <div class="fade tab-pane h-100" id="chat-{{$conversation->id}}" role="tabpanel" aria-labelledby="chat-{{$conversation->id}}-tab">
                                    <!-- Top avatar and status START -->
                                    <div class="d-sm-flex justify-content-between align-items-center">
                                        <a href="{{ $conversation->conversationParticipants->first() != null ? route('profiles.show', $conversation->conversationParticipants->first()?->id) : '' }}" class="d-flex mb-2 mb-sm-0">
                                            <div class="flex-shrink-0 avatar me-2">
                                                <img class="avatar-img rounded-circle" src="{{asset($conversation->conversationParticipants->first()?->profile_picture)}}" alt="">
                                            </div>
                                            <div class="d-block flex-grow-1">
                                                <h6 class="mb-0 mt-1">{{$conversation->conversationParticipants->first()?->name}}</h6>
                                                <div class="small text-secondary">
                                                    <i class="fa-solid fa-circle text-success me-1"></i>Online
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <!-- Top avatar and status END -->
                                    <hr>
                                    <!-- Chat conversation START -->
                                    <div class="chat-conversation-content custom-scrollbar chat-messages-{{$conversation->id}}">
                                        <!-- Chat time -->
                                        <div class="text-center small my-2">{{\Carbon\Carbon::createFromDate($conversation->created_at)->format('D, d M Y - H:i')}}</div>
                                        @foreach($conversation->messages as $message)
                                            @if($message->user_id === $user->id)
                                                <x-messages.message-right :message="$message"/>
                                            @else
                                                <x-messages.message-left :message="$message"/>
                                            @endif
                                        @endforeach
                                    </div>
                                    <!-- Chat conversation END -->
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer">
                        <form id="message-form" action="{{ route('messages.store') }}" method="post">
                            @csrf
                            <input type="hidden" id="conversation_id" name="conversation_id" value="" />
                            <input type="hidden" name="user_id" value="{{$user->id}}" />
                            <div class="d-sm-flex align-items-end">
                                <input id="content-input" type="text" class="form-control mb-sm-0 mb-3" name="content" placeholder="Type a message" disabled/>
                                <button id="emoji-btn" class="btn btn-sm btn-danger-soft ms-sm-2" disabled>
                                    <i class="fa-solid fa-face-smile fs-6"></i></button>
                                <button id="send-btn" class="btn btn-sm btn-primary ms-2" disabled><i class="fa-solid fa-paper-plane fs-6"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Chat conversation END -->
        </div> <!-- Row END -->
        <!-- =======================
        Chat END -->

    </div>
    <!-- Container END -->

</main>
<!-- **************** MAIN CONTENT END **************** -->

<!-- Chat START -->
<div class="position-fixed bottom-0 end-0 p-3">

    <!-- Chat toast START -->
    <div id="chatToast" class="toast bg-mode" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
        <div class="toast-header bg-mode d-flex justify-content-between">
            <!-- Title -->
            <h6 class="mb-0">Start a new chat</h6>
            <button class="btn btn-secondary-soft-hover py-1 px-2" data-bs-dismiss="toast" aria-label="Close">
                <i class="fa-solid fa-xmark"></i></button>
        </div>
        <!-- Top avatar and status END -->
        <div class="toast-body collapse show pb-0 pt-2" id="collapseChat">
            <!-- Chat conversation START -->
            <!-- Form -->
            <form id="new-chat-form" method="post" action="{{ route('messages.messages.get_chat_new_for_users') }}">
                <div class="input-group mb-2">
                    <span class="input-group-text border-0">To</span>
                    <input id="search-users-input" class="form-control" name="search" type="text" placeholder="Type a name">
                </div>
                <ul class="ps-0 mb-0" id="user-results" style="overflow-y: auto; " data-bs-popper="static">
                </ul>
            </form>
            <!-- Chat conversation END -->
        </div>
    </div>
    <!-- Chat toast END -->

</div>
<!-- Chat END -->

<script>


</script>
