<?php

namespace App\Services;

use App\Http\Requests\AccountRequest;
use App\Models\Relationship;
use App\Models\User;
use ConsoleTVs\Profanity\Facades\Profanity;
use Illuminate\Support\Facades\DB;

class SettingService extends ParentService
{
    public function getRelationships()
    {
        return Relationship::all();
    }

    public function handleAccountUpdate(AccountRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $validatedData = $request->validated();
            $this->validateUser($request);

            foreach ($validatedData as $key => &$value) {
                if ($key !== 'profile_picture' && $key !== 'cover_picture' && is_string($value)) {
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

            return User::find($request->user_id)
                ->update($validatedData);
        });

    }
}
