<!-- Timeline item START -->
<div class="timeline-item mb-3">
    <!-- Timeline content -->
    <div class="timeline-content">


        <div class="d-sm-flex justify-content-between">
            <div>
                <p class="small mb-0">
                    <i class="{{$properties->icon}}

                    me-1"></i><b>{{$activityItem->causer->name}}</b> <a href="{{$properties->route}}">{{$activityItem->description}} </a>
                </p>
            </div>
            <p class="small mb-0 text-nowrap">{{ Carbon\Carbon::parse($activityItem->created_at)->timezone('Europe/London')->diffForHumans() }}</p>
        </div>

    </div>
</div>
<!-- Timeline item END -->
