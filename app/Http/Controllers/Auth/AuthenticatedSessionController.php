<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.log-in')->with([
            'user' => Auth::user(),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();

            $request->session()->regenerate();

            return redirect()->intended(route('posts.index', absolute: false));
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->getMessages();

            return redirect()->back()->withInput($request->only('email', 'remember'))
                ->withErrors($errors);
        } catch (Exception $e) {
            // General error handling for other exceptions
            return redirect()->back()->with('error', 'Your login details were incorrect. Please try again.');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')
            ->logout();

        $request->session()
            ->invalidate();

        $request->session()
            ->regenerateToken();

        return redirect('/');
    }
}
