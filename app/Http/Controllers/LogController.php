<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use Auth;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        $logs = Logs::where('user_id', Auth::id())->orderBy('created_at', 'desc')
            ->get();

        return view('logs.index', compact('logs'));
    }
}
