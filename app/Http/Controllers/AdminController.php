<?php

namespace App\Http\Controllers;

use App\Models\Admins;
use App\Models\Comment;
use App\Models\FileAssociation;
use App\Models\Post;
use App\Models\User;
use App\Models\UserQueries;
use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;


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
    // public function dashboard()
    // {
    //     if (!Session::has('admin_logged_in')) {
    //         return redirect()->route('admin.login');
    //     }

    //     return view('admin.dashboard');
    // }

    public function dashboard()
    {

        if (!Session::has('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        // Get the number of users and files analyzed
        $numberOfUsers = User::count();
        $numberOfFilesAnalyzed = FileAssociation::count();

        // Data for the graph
        $dateRange = Carbon::now()->subDays(30); // Last 30 days

        $filesAnalyzed = FileAssociation::where('created_at', '>=', $dateRange)->selectRaw('DATE(created_at) as date, count(*) as count')->groupBy('date')->pluck('count', 'date');
        $postsMade = Post::where('created_at', '>=', $dateRange)->selectRaw('DATE(created_at) as date, count(*) as count')->groupBy('date')->pluck('count', 'date');
        $commentsMade = Comment::where('created_at', '>=', $dateRange)->selectRaw('DATE(created_at) as date, count(*) as count')->groupBy('date')->pluck('count', 'date');
        $newAccounts = User::where('created_at', '>=', $dateRange)->selectRaw('DATE(created_at) as date, count(*) as count')->groupBy('date')->pluck('count', 'date');
        $filesCreated = File::where('created_at', '>=', $dateRange)->selectRaw('DATE(created_at) as date, count(*) as count')->groupBy('date')->pluck('count', 'date');

        return view('admin.dashboard', compact(
            'numberOfUsers',
            'numberOfFilesAnalyzed',
            'filesAnalyzed',
            'postsMade',
            'commentsMade',
            'newAccounts',
            'filesCreated'
        ));
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

    public function queries()
    {
        $userQueries = UserQueries::all(); // Fetch all queries from the database
        return view('admin.queries', compact('userQueries'));
    }

    public function respond(Request $request, $id)
    {
        $query = UserQueries::find($id);

        if ($query) {
            $query->has_responded = $request->responded;
            $query->save();
        }

        return redirect()->route('admin.queries');
    }

}