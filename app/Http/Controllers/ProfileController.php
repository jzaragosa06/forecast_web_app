<?php

namespace App\Http\Controllers;
use Auth;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::where('id', Auth::id())->firstOrFail();

        return view('profile.index', compact('user'));


    }

    public function update_photo(Request $request)
    {
        $user = User::where('id', Auth::id())->firstOrFail();

        if ($request->hasFile('new_profile_photo')) {
            $path = $request->file('new_profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }

        $user->save();
        return redirect()->back()->with('success', 'Profile photo updated successfully');


    }
}
