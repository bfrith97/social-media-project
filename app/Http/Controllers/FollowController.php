<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use App\Notifications\NewFollower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $usersToFollow = User::where('id', '!=', $user->id)
            ->whereDoesntHave('followers', function ($query) use ($user) {
                $query->where('follower_id', $user->id);
            })
            ->inRandomOrder()
            ->get();

        return view('who-to-follow.index')->with([
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
        $validatedData = $request->validate([
            'follower_id' => 'required|integer|exists:users,id',
            'followee_id' => 'required|integer|exists:users,id',
        ]);

        $follow = Follow::create($validatedData);

        $follower = User::find($validatedData['follower_id']);
        $followee = User::find($validatedData['followee_id']);

        $followee->notify(new NewFollower($follower));

        if ($follow) {
            return response()->json([
                'message' => 'Follow added successfully',
            ]);
        } else {
            return response()->json([
                'message' => 'Follow not added',
            ]);
        }
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $validatedData = $request->validate([
            'follower_id' => 'required|integer|exists:users,id',
            'followee_id' => 'required|integer|exists:users,id',
        ]);

        $deleted = Follow::where($validatedData)->delete();

        if ($deleted) {
            return response()->json([
                'message' => 'Follow removed successfully',
            ]);
        } else {
            return response()->json([
                'message' => 'Follow not removed',
            ]);
        }
    }
}
