<?php

namespace App\Http\Controllers;

use App\Models\File;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $files = File::where('user_id', Auth::id())->get();
        return view('home', compact('files'));
    }
}
