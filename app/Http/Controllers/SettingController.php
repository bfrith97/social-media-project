<?php

namespace App\Http\Controllers;

use App\Models\Relationship;
use App\Models\User;
use App\Services\SettingService;
use App\Services\UserService;
use ConsoleTVs\Profanity\Facades\Profanity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    private SettingService $settingService;
    private UserService $userService;

    public function __construct(SettingService $settingService, UserService $userService)
    {
        $this->settingService = $settingService;
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
        [$user, $conversations, $notificationsCount] = $this->userService->getUserInformation();

        $relationshipOptions = $this->settingService->getRelationships();

        return view('settings.edit')->with([
            'relationshipOptions' => $relationshipOptions,
            'notificationsCount' => $notificationsCount,
            'user' => $user,
            'conversations' => $conversations,
        ]);
    }

    public function accountUpdate(Request $request): ?RedirectResponse
    {
        try {
            $this->settingService->handleAccountUpdate($request);

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
