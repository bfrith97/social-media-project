<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $profile = User::with([
            'relationship',
            'partner',
            'followings',
            'followers',
            'ownPosts' => function ($query) use($id) {
                $query->whereNull('group_id'); // Exclude posts with a group_id
                $query->where(function($subQuery) use ($id) {
                    $subQuery->whereNull('profile_id') // Include posts without a profile_id (general posts)
                    ->orWhere('profile_id', $id); // Include posts where profile_id matches the current profile being viewed
                });
                $query->orderBy('created_at', 'desc');
            },
            'otherPosts'
        ])
            ->find($id);

        $combinedPosts = $profile->ownPosts->merge($profile->otherPosts);

        // Optionally, sort the combined collection by creation date if needed
        $combinedPosts = $combinedPosts->sortByDesc('created_at');

        return view('profiles.show')->with([
            'profile' => $profile,
            'combinedPosts' => $combinedPosts
        ]);
    }

    /**
     * Update the user's profiles-breeze information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()
            ->fill($request->validated());

        if ($request->user()
            ->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()
            ->save();

        return Redirect::route('profiles-breeze.edit')
            ->with('status', 'profiles-breeze-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => [
                'required',
                'current_password',
            ],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()
            ->invalidate();
        $request->session()
            ->regenerateToken();

        return Redirect::to('/');
    }
}
