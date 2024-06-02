<?php

namespace App\Http\Controllers;

use App\Models\Relationship;
use App\Models\User;
use App\Services\UserService;
use ConsoleTVs\Profanity\Facades\Profanity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        [
            $user,
            $conversations,
            $notificationsCount,
        ] = $this->userService->getUserInformation();

        $relationshipOptions = Relationship::all();

        return view('settings.edit')->with([
            'relationshipOptions' => $relationshipOptions,
            'notificationsCount' => $notificationsCount,
            'user' => $user,
            'conversations' => $conversations,
        ]);
    }

    public function accountUpdate(Request $request)
    {
        try {
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

            return redirect()
                ->route('settings.edit')
                ->with([
                    'accountSuccessMessage' => 'Your account has been updated.',
                ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('settings.edit')
                ->with([
                    'accountErrorMessage' => $e->getMessage(),
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
