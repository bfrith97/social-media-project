<!-- Main Chat START -->
<div class="d-none d-lg-block">
    <!-- Button -->
    <a class="icon-md btn btn-primary position-fixed end-0 bottom-0 me-3 mb-3" data-bs-toggle="offcanvas" href="#offcanvasChat" role="button" aria-controls="offcanvasChat">
        <i class="bi bi-chat-left-text-fill"></i>
    </a>
    <!-- Chat sidebar START -->
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasChat">
        <!-- Offcanvas header -->
        <div class="offcanvas-header d-flex justify-content-between">
            <h5 class="offcanvas-title">Messaging</h5>
            <div class="d-flex">
                <!-- New chat box open button -->
                <a href="#" class="btn btn-secondary-soft-hover py-1 px-2">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <!-- Chat action START -->
                <div class="dropdown">
                    <a href="#" class="btn btn-secondary-soft-hover py-1 px-2" id="chatAction" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots"></i>
                    </a>
                    <!-- Chat action menu -->
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="chatAction">
                        <li><a class="dropdown-item" href="#"> <i class="bi bi-check-square fa-fw pe-2"></i>Mark all as
                                read</a></li>
                        <li><a class="dropdown-item" href="#"> <i class="bi bi-gear fa-fw pe-2"></i>Chat setting </a>
                        </li>
                        <li><a class="dropdown-item" href="#"> <i class="bi bi-bell fa-fw pe-2"></i>Disable
                                notifications</a></li>
                        <li><a class="dropdown-item" href="#"> <i class="bi bi-volume-up-fill fa-fw pe-2"></i>Message
                                sounds</a></li>
                        <li><a class="dropdown-item" href="#"> <i class="bi bi-slash-circle fa-fw pe-2"></i>Block
                                setting</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#"> <i class="bi bi-people fa-fw pe-2"></i>Create a group
                                chat</a></li>
                    </ul>
                </div>
                <!-- Chat action END -->

                <!-- Close  -->
                <a href="#" class="btn btn-secondary-soft-hover py-1 px-2" data-bs-dismiss="offcanvas" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </a>

            </div>
        </div>
        <!-- Offcanvas body START -->
        <div class="offcanvas-body pt-0 custom-scrollbar">
            <!-- Search contact START -->
            <form class="rounded position-relative">
                <input class="form-control ps-5 bg-light" type="search" placeholder="Search..." aria-label="Search">
                <button class="btn bg-transparent px-3 py-0 position-absolute top-50 start-0 translate-middle-y" type="submit">
                    <i class="bi bi-search fs-5"> </i></button>
            </form>
            <!-- Search contact END -->
            <ul class="list-unstyled">
                @foreach($conversations as $key => $conversation)
                    <!-- Contact item -->
                    <li class="chat-selector mt-3 hstack gap-3 align-items-center position-relative toast-btn" data-target="chatToast{{!$loop->first ? $key+1 : ''}}" data-conversation-id="{{$conversation->id}}">
                        <!-- Avatar -->
                        <div class="avatar status-online">
                            <img class="avatar-img rounded-circle" src="{{asset($conversation->conversationParticipants->first()->profile_picture)}}" alt="">
                        </div>
                        <!-- Info -->
                        <div class="overflow-hidden">
                            <a class="h6 mb-0 stretched-link" href="#!">{{$conversation->conversationParticipants->first()->name}}</a>
                            <div class="small text-secondary text-truncate">{{$conversation->messages->last()->content}}</div>
                        </div>
                        <!-- Chat time -->
                        <div class="small ms-auto text-nowrap">{{Carbon\Carbon::parse($conversation->messages->last()->created_at)->timezone('Europe/London')->diffForHumans()}}</div>
                    </li>
                @endforeach
                <!-- Button -->
                <li class="mt-3 d-grid">
                    <a class="btn btn-primary-soft" href="{{ route('messages.index') }}"> See all messages </a>
                </li>

            </ul>
        </div>
        <!-- Offcanvas body END -->
    </div>
    <!-- Chat sidebar END -->

    <!-- Chat END -->

    <!-- Chat START -->
    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container toast-chat d-flex gap-3 align-items-end">
            @foreach($conversations as $key => $conversation)
                <!-- Chat toast START -->
                <div id="chatToast{{!$loop->first ? $key+1 : ''}}" class="toast mb-0 bg-mode" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                    <div class="toast-header bg-mode">
                        <!-- Top avatar and status START -->
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar me-2">
                                    <img class="avatar-img rounded-circle" src="{{asset($conversation->conversationParticipants->first()->profile_picture)}}" alt="">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 mt-1">{{$conversation->conversationParticipants->first()->name}}</h6>
                                    <div class="small text-secondary">
                                        <i class="fa-solid fa-circle text-success me-1"></i>Online
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <a class="btn btn-secondary-soft-hover py-1 px-2" data-bs-toggle="collapse" href="#collapseChat" aria-expanded="false" aria-controls="collapseChat"><i class="bi bi-dash-lg"></i></a>
                                <button class="btn btn-secondary-soft-hover py-1 px-2" data-bs-dismiss="toast" aria-label="Close">
                                    <i class="fa-solid fa-xmark"></i></button>
                            </div>
                        </div>
                        <!-- Top avatar and status END -->

                    </div>
                    <div class="toast-body collapse show" id="collapseChat-{{$conversation->id}}">
                        <!-- Chat conversation START -->
                        <div class="chat-conversation-content chat-messages-{{$conversation->id}} custom-scrollbar h-200px">
                            <!-- Chat time -->
                            <div class="text-center small my-2">Jul 16, 2022, 06:15 am</div>
                            @foreach($conversation->messages as $message)
                                @if($message->user_id === $user->id)
                                    <x-messages.message-right :message="$message"/>
                                @else
                                    <x-messages.message-left :message="$message"/>
                                @endif
                            @endforeach
                        </div>
                        <!-- Chat conversation END -->
                        <!-- Chat bottom START -->
                        <div class="mt-2">
                            <form class="message-form" action="{{ route('messages.store') }}" method="post">
                                @csrf
                                <input type="hidden" id="conversation_id" name="conversation_id" value="{{$conversation->id}}"/>
                                <input type="hidden" name="user_id" value="{{$user->id}}"/>
                                <!-- Chat textarea -->
                                <input type="text" class="content-input form-control mb-sm-0 mb-3" name="content" placeholder="Type a message"/>
                                <!-- Button -->
                                <div class="d-sm-flex align-items-end mt-2">
                                    <button class="btn btn-sm btn-danger-soft me-2">
                                        <i class="fa-solid fa-face-smile fs-6"></i>
                                    </button>
                                    <button class="btn btn-sm btn-success-soft me-2"> Gif</button>
                                    <button class="btn btn-sm btn-primary ms-auto"> Send</button>
                                </div>
                            </form>

                        </div>
                        <!-- Chat bottom START -->
                    </div>
                </div>
                <!-- Chat toast END -->
            @endforeach

        </div>
    </div>
    <!-- Chat END -->
</div>
<!-- Main Chat END -->

