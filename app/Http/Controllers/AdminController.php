<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function users()
    {
        $users = User::get();

        return view('admin.users', compact('users'));
    }

    public function delete($id)
    {
        $user = User::where('id', $id)->first();
        $user->delete();

        return redirect()->route('admin.users');
    }


    public function data_source()
    {
        return view('admin.selections.index');
    }


    public function open_meteo()
    {
        return view('admin.selections.open-meteo');
    }
}