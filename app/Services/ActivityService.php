<?php

namespace App\Services;

class ActivityService
{
    public function storeActivity($performedOn, $route, $routeId,  $icon, $log)
    {
        activity()
            ->performedOn($performedOn)
            ->withProperties([
                'route' => route($route, $routeId),
                'icon' => $icon
            ])
            ->log($log);
    }
}
