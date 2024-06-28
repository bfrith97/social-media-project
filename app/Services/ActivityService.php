<?php

namespace App\Services;

use InvalidArgumentException;
use Spatie\Activitylog\Models\Activity;

class ActivityService extends ParentService
{
    public function storeActivity($performedOn, $route, $routeId, $icon, $log): ?Activity
    {
        // Check if the route ID is available and not null
        if (empty($routeId)) {
            throw new InvalidArgumentException("Missing route ID for the activity log.");
        }

        return activity()
            ->performedOn($performedOn)
            ->withProperties([
                'route' => route($route, $routeId),
                'icon' => $icon,
            ])
            ->log($log);
    }
}
