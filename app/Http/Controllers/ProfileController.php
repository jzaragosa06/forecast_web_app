<?php

namespace App\Http\Controllers;

use App\Models\FileAssociation;
use App\Models\FileUserShare;
use Auth;
use App\Models\Post;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Logs;


class ProfileController extends Controller
{
    public function index()
    {
        $user = User::where('id', Auth::id())->firstOrFail();
        // count of the results files created. 
        // $resultsCount = FileAssociation::where('user_id', Auth::id())->count();
        $resultCount = FileAssociation::distinct('file_assoc_id')->count('file_assoc_id');
        $collabCount = FileUserShare::distinct('shared_to_user_id')->count('shared_to_user_id');

        // Get the currently authenticated user ID
        $currentUserId = Auth::id();
        $file_assocs = FileAssociation::where('user_id', $currentUserId)->get();

        // Separate posts made by the current user and others
        $myPosts = Post::where('user_id', $currentUserId)->latest()->get();

        return view('profile.index', compact('user', 'resultCount', 'collabCount', 'myPosts'));

    }

    //This displays the profile for public view
    public function public($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        // count of the results files created. 
        // $resultsCount = FileAssociation::where('user_id', Auth::id())->count();
        $resultCount = FileAssociation::distinct('file_assoc_id')->count('file_assoc_id');
        $collabCount = FileUserShare::distinct('shared_to_user_id')->count('shared_to_user_id');

        // Get the currently authenticated user ID
        $userId = $id;
        $file_assocs = FileAssociation::where('user_id', $userId)->get();

        // Separate posts made by the current user and others
        $myPosts = Post::where('user_id', $userId)->latest()->get();

        return view('profile.public', compact('user', 'resultCount', 'collabCount', 'myPosts'));
    }

    public function update_photo(Request $request)
    {
        $user = User::where('id', Auth::id())->firstOrFail();

        if ($request->hasFile('new_profile_photo')) {
            $path = $request->file('new_profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }

        $user->save();


        Logs::create([
            'user_id' => Auth::id(),
            'action' => 'Updated Profile Photo',
            'description' => 'Successfully updated profile photo ',
        ]);

        return redirect()->back()->with('success', 'Profile photo updated successfully');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'headline' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'skills' => 'nullable|string',
            'social_links_linkedin' => 'nullable|string',
            'social_links_github' => 'nullable|string',
            'social_links_medium' => 'nullable|string',
            'social_links_kaggle' => 'nullable|string',
        ]);

        $user = User::where('id', Auth::id())->first();

        $user->update([
            'name' => $request->name,
            'headline' => $request->headline,
            'location' => $request->location,
            'about' => $request->about,
            'skills' => $request->skills,
            'social_links_linkedin' => $request->social_links_linkedin,
            'social_links_github' => $request->social_links_github,
            'social_links_medium' => $request->social_links_medium,
            'social_links_kaggle' => $request->social_links_kaggle,
            'contact_num' => $request->contact_num,
        ]);

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully!');
    }

}