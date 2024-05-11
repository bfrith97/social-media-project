<main>
    <!-- Container START -->
    <div class="container">
        <div class="row g-4">

            <div class="col-lg-3">
                <x-shared.left-side-nav :user="$user"/>
            </div>
            <div class="col-lg-9">

                <div class="card mb-4 w-75">
                    <div class="card-body py-0">
                        <div class="d-flex justify-content-between">

                            <h4 class="mb-4 pt-4">Notifications</h4>
                            <button class="btn btn-sm text-primary p-0 mark-notifications-read-button" type="submit">
                                Mark all as read
                            </button>
                        </div>
                        <ul class="list-group list-group-flush list-unstyled p-2">
                            @foreach($user->notifications as $notification)
                                <!-- Notification item -->
                                <li>
                                    <a href="{!! $notification->data['href']!!}" class="notification list-group-item list-group-item-action rounded d-flex border-0 mb-1 p-3 @if(!$notification->read_at) badge-unread @endif">
                                        <div class="avatar text-center d-none d-sm-inline-block">
                                            <img class="avatar-img rounded-circle" src="{{asset($notification->data['picture'])}}">
                                        </div>
                                        <div class="ms-sm-3">
                                            <div class="d-flex">
                                                <p class="small mb-2">{{$notification->data['message']}}</p>
                                                <p class="small ms-3" style="white-space: nowrap">{{Carbon\Carbon::parse($notification->created_at)->timezone('Europe/London')->diffForHumans()}}</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
