<?php

namespace App\Http\Controllers;

use App\Models\UserQueries;
use Illuminate\Http\Request;

class UserQueriesController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            "name" => 'required|string',
            "email" => 'required|string',
            "message" => 'required|string',
        ]);


        UserQueries::create([
            "name" => $request->name,
            "email" => $request->email,
            "message" => $request->message,
        ]);

        // return redirect()->route('home');
        return back();
    }
}