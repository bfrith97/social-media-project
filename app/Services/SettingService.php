<?php

namespace App\Services;

use App\Models\Follow;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\Relationship;
use App\Models\User;
use App\Notifications\NewComment;
use App\Notifications\NewFollower;
use App\Notifications\NewLike;
use App\Notifications\NewProfilePost;
use ConsoleTVs\Profanity\Facades\Profanity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class SettingService
{
    public function getRelationships()
    {
        return Relationship::all();
    }

    public function handleAccountUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:191',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cover_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role' => 'nullable|string|max:191',
            'company' => 'nullable|string|max:191',
            'info' => 'nullable|string|max:191',
            'number' => 'nullable|integer|min:0',
            'date_of_birth' => 'nullable|date',
            'relationship_id' => 'nullable|integer|exists:relationships,id',
        ]);

        foreach ($validatedData as $key => &$value) {
            if ($key !== 'profile_picture' && $key!== 'cover_picture' && is_string($value)) {
                $value = Profanity::blocker($value)
                    ->strict(false)
                    ->strictClean(true)
                    ->filter();
            }
        }

        if ($request->hasFile('profile_picture')) {
            $imageName = time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('assets/images/avatars'), $imageName);
            $validatedData['profile_picture'] = 'assets/images/avatars/' . $imageName;
        } else {
            unset($validatedData['profile_picture']);
        }

        if ($request->hasFile('cover_picture')) {
            $imageName = time() . '.' . $request->cover_picture->extension();
            $request->cover_picture->move(public_path('assets/images/covers'), $imageName);
            $validatedData['cover_picture'] = 'assets/images/covers/' . $imageName;
        } else {
            unset($validatedData['cover_picture']);
        }

        $user = User::find($request->user_id)
            ->update($validatedData);

        return $user;
    }
}
