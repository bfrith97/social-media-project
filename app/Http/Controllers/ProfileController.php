<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Spatie\Activitylog\Models\Activity;

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
                $query->whereNull('group_id');
                $query->where(function($subQuery) use ($id) {
                    $subQuery->whereNull('profile_id')
                    ->orWhere('profile_id', $id);
                });
                $query->orderBy('created_at', 'desc');
            },
            'otherPosts',
            'groups.members'
        ])
            ->find($id);

        if(!$profile) {
            return redirect()->back();
        }

        $combinedPosts = $profile->ownPosts->merge($profile->otherPosts);
        $combinedPosts = $combinedPosts->sortByDesc('created_at');

        $activity = Activity::with('causer')->where('causer_id', $id)->get();

        return view('profiles.show')->with([
            'profile' => $profile,
            'combinedPosts' => $combinedPosts,
            'activity' => $activity,
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
