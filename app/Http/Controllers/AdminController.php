<?php

// namespace App\Http\Controllers;

// use App\Models\Admins;
// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\File;

// class AdminController extends Controller
// {

//     public function login()
//     {
//         return view('admin.auth.login');
//     }

//     public function login_submit(Request $request)
//     {
//         $validatedData = $request->validate([
//             'username' => 'required|string',
//             'password' => 'required|string',
//         ]);

//         $admin = Admins::where("username", $validatedData["username"])->first();

//         if ($admin && $admin->password === $validatedData["password"]) {
//             return redirect()->route('admin.dashboard');
//         }
//         return response()->json(['message' => 'Invalid credentials'], 401);

//     }
//     public function dashboard()
//     {
//         return view('admin.dashboard');
//     }

//     public function users()
//     {
//         $users = User::get();

//         return view('admin.users', compact('users'));
//     }

//     public function delete($id)
//     {
//         $user = User::where('id', $id)->first();
//         $user->delete();

//         return redirect()->route('admin.users');
//     }


//     public function data_source()
//     {
//         return view('admin.selections.index');
//     }


//     public function open_meteo()
//     {
//         return view('admin.selections.open-meteo');
//     }

//     public function update_options_open_meteo(Request $request)
//     {
//         $options = [];

//         foreach ($request->option_label as $index => $label) {
//             $key = $request->option_value[$index];
//             $options[$key] = $label;
//         }

//         // Update the config file
//         $configContent = '<?php return ' . var_export(['daily' => $options], true) . ';';
//         File::put(config_path('weather_options.php'), $configContent);

//         return redirect()->back()->with('success', 'Options updated successfully!');
//     }

//     public function stocks()
//     {
//         return view('admin.selections.stocks');
//     }


//     public function update_options_stocks(Request $request)
//     {
//         $options = [];

//         foreach ($request->option_label as $index => $label) {
//             $key = $request->option_value[$index];
//             $options[$key] = $label;
//         }

//         // Update the config file
//         $configContent = '<?php return ' . var_export(['stocks' => $options], true) . ';';
//         File::put(config_path('stock_options.php'), $configContent);

//         return redirect()->back()->with('success', 'Options updated successfully!');
//     }

// }

namespace App\Http\Controllers;

use App\Models\Admins;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    // Show the login form
    public function login()
    {
        // If admin is already logged in, redirect to dashboard
        if (Session::has('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    // Handle login submission
    public function login_submit(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = Admins::where("username", $validatedData["username"])->first();

        // Check credentials (for now, no hashing for dev purposes)
        if ($admin && $admin->password === $validatedData["password"]) {
            // Store admin login state in session
            Session::put('admin_logged_in', true);
            Session::put('admin_id', $admin->id); // You can store admin ID if needed

            return redirect()->route('admin.dashboard');
        }

        // return response()->json(['message' => 'Invalid credentials'], 401);
        return redirect()->back()->withErrors(['credentials' => 'Invalid username or password.']);

    }

    // Admin logout function
    public function logout()
    {
        // Clear session
        Session::forget('admin_logged_in');
        Session::forget('admin_id');

        return redirect()->route('admin.login');
    }

    // Ensure user is logged in before accessing this route
    public function dashboard()
    {
        if (!Session::has('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.dashboard');
    }

    // Ensure user is logged in before accessing this route
    public function users()
    {
        if (!Session::has('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $users = User::get();
        return view('admin.users', compact('users'));
    }

    // Ensure user is logged in before accessing this route
    public function delete($id)
    {
        if (!Session::has('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $user = User::where('id', $id)->first();
        $user->delete();

        return redirect()->route('admin.users');
    }

    // Other methods which should be accessible for logged-in admins only
    public function data_source()
    {
        if (!Session::has('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.selections.index');
    }

    public function open_meteo()
    {
        if (!Session::has('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.selections.open-meteo');
    }

    public function update_options_open_meteo(Request $request)
    {
        if (!Session::has('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

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
        if (!Session::has('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.selections.stocks');
    }

    public function update_options_stocks(Request $request)
    {
        if (!Session::has('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

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