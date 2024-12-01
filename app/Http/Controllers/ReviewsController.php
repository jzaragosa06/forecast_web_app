<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class ReviewsController extends Controller
{
    public function index()
    {

        $user = User::where('id', Auth::id())->first();
        //this gets the previous review made by the same user
        $prev_reviews = Review::where('user_id', Auth::id())->get();

        return view('reviews.index', compact('user', 'prev_reviews'));
    }


    public function add(Request $request)
    {

        Review::create([
            'user_id' => Auth::id(),
            'name' => $request->get('name'),
            'affiliation' => $request->get('affiliation'),
            'position' => $request->get('position'),
            'review' => $request->get('review'),

        ]);

        session()->flash('success', 'Review successfully added');
        return redirect()->route('reviews.index');
    }
}