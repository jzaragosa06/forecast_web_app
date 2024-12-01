<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function landing()
    {
        $reviews = Review::latest()->get();
        return view('welcome', compact('reviews'));
    }
}