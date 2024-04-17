<?php

namespace App\Http\Controllers;

use App\Models\Relationship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
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
        $relationshipOptions = Relationship::all();

        return view('settings.edit')->with([
            'user'                => Auth::user(),
            'relationshipOptions' => $relationshipOptions,
        ]);
    }

    public function accountUpdate(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name'            => 'required|string|max:191',
                'role'            => 'nullable|string|max:191',
                'company'         => 'nullable|string|max:191',
                'info'            => 'nullable|string|max:191',
                'number'          => 'nullable|integer|min:0',
                'date_of_birth'   => 'nullable|date',
                'relationship_id' => 'nullable|integer|exists:relationships,id',
            ]);

            User::find($request->user_id)->update($validatedData);

            return redirect()->route('settings.edit')->with([
                'accountSuccessMessage' => 'Your account has been updated.',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('settings.edit')->with([
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
