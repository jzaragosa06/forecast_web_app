<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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

    public function update_options_open_meteo(Request $request)
    {
        $options = [];

        foreach ($request->option_label as $index => $label) {
            $key = $request->option_value[$index];
            $options[$key] = $label;
        }

        // Update the config file
        $configContent = '<?php return ' . var_export(['daily' => $options], true) . ';';
        File::put(config_path('weather_options.php'), $configContent);

        return redirect()->back()->with('success', 'Options updated successfully!');
    }

    public function stocks()
    {
        return view('admin.selections.stocks');
    }


    public function update_options_stocks(Request $request)
    {
        $options = [];

        foreach ($request->option_label as $index => $label) {
            $key = $request->option_value[$index];
            $options[$key] = $label;
        }

        // Update the config file
        $configContent = '<?php return ' . var_export(['stocks' => $options], true) . ';';
        File::put(config_path('stock_options.php'), $configContent);

        return redirect()->back()->with('success', 'Options updated successfully!');
    }
}