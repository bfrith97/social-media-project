<?php

namespace App\Listeners;

use App\Models\Login as LoginModel;
use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;

class LogSuccessfulLogout
{
    protected Request $request;

    /**
     * Create the event listener.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(Logout $event)
    {
        $login = LoginModel::where('user_id', $event->user->id)
            ->orderByDesc('login_at')
            ->first();

        $time1 = Carbon::parse($login->login_at);
        $time2 = Carbon::parse(now());

        $login->update([
                'logout_at' => now(),
                'minutes_logged_in' => $time1->diffInMinutes($time2),
            ]);
    }
}
