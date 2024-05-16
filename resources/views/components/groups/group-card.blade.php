<div class="col-sm-6 col-lg-4">
    <!-- Card START -->
    <div class="card">
        <div class="h-80px rounded-top" style="background-image:url(assets/images/bg/02.jpg); background-position: center; background-size: cover; background-repeat: no-repeat;"></div>
        <!-- Card body START -->
        <div class="card-body text-center pt-0">
            <!-- Avatar -->
            <div class="avatar avatar-lg mt-n5 mb-3">
                <a href="{{route('groups.show', $group->id)}}"><img class="avatar-img rounded-circle border border-white border-3 bg-white" src="assets/images/logo/03.svg" alt=""></a>
            </div>
            <!-- Info -->
            <h5 class="mb-0">
                <a href="{{route('groups.show', $group->id)}}">{{$group->name}}</a>
            </h5>
            <small>
                <i class="bi bi-{{$group->private ? 'lock' : 'globe'}} pe-1"></i> {{$group->private ? 'Private' : 'Public'}}
                Group</small>
            <!-- Group stat START -->
            <div class="hstack gap-2 gap-xl-3 justify-content-center mt-3">
                <!-- Group stat item -->
                <div>
                    <h6 class="mb-0">{{$group->members_count ?? 0}}</h6>
                    <small>Members</small>
                </div>
                <!-- Divider -->
                <div class="vr"></div>
                <!-- Group stat item -->
                <div>
                    <h6 class="mb-0">{{$group->posts_count ?? 0}}</h6>
                    <small>Total posts</small>
                </div>
            </div>
            <!-- Group stat END -->
            <!-- Avatar group START -->
            <ul class="avatar-group list-unstyled align-items-center justify-content-center mb-0 mt-3">
                <li class="avatar avatar-xs">
                    <img class="avatar-img rounded-circle" src="assets/images/avatar/11.jpg" alt="avatar">
                </li>
                <li class="avatar avatar-xs">
                    <img class="avatar-img rounded-circle" src="assets/images/avatar/10.jpg" alt="avatar">
                </li>
                <li class="avatar avatar-xs">
                    <div class="avatar-img rounded-circle bg-primary">
                        <span class="smaller text-white position-absolute top-50 start-50 translate-middle">+05</span>
                    </div>
                </li>
            </ul>
            <!-- Avatar group END -->
        </div>
        <!-- Card body END -->
        <!-- Card Footer START -->
        <div class="card-footer text-center">
            <form action="{{ route('group_users.store') }}" method="post" class="follow-form">
                @csrf
                @if($group->joined_by_current_user)
                    <input type="hidden" name="_method" value="DELETE" class="delete_method">
                @endif
                <input type="hidden" name="group_id" value="{{$group->id}}"/>
                <input type="hidden" name="user_id" value="{{$user->id}}"/>
                @if($group->joined_by_current_user)
                    <button type="button" class="btn btn-danger-soft btn-sm join-button">
                        Leave group
                    </button>
                @else
                    <button type="button" class="btn btn-success-soft btn-sm join-button">
                        Join group
                    </button>
                @endif
            </form>
        </div>
        <!-- Card Footer END -->
    </div>
    <!-- Card END -->
</div>
