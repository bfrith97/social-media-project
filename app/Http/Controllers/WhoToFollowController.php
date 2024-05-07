<?php

namespace App\Http\Controllers;

use App\Models\Relationship;
use App\Models\User;
use ConsoleTVs\Profanity\Facades\Profanity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WhoToFollowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $usersToFollow = User::where('id', '!=', $user->id) // Exclude the current user
        ->whereDoesntHave('followers', function ($query) use ($user) {
            $query->where('follower_id', $user->id);
        })
            ->inRandomOrder()
            ->get();


        return view('who-to-follow.index')->with([
            'user' => Auth::user(),
            'usersToFollow' => $usersToFollow,
        ]);
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
        //
    }

    public function accountUpdate(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
