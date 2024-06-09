<?php

namespace App\Listeners;

use App\Models\Login as LoginModel;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;

class LogSuccessfulLogin
{
    protected Request $request;
    /**
     * Create the event listener.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(Login $event)
    {
        LoginModel::create([
            'user_id' => $event->user->id,
            'ip_address' => $this->request->ip(),
            'login_at' => now(),
        ]);
    }
}
