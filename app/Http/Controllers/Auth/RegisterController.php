<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Logs;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\File;



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'min:9',
                'confirmed',
                'regex:/^(?=(?:.*[a-z]){3})(?=(?:.*[A-Z]){3})(?=(?:.*[0-9]){2})(?=.*[\W_]).{9,}$/'
            ],
        ], [
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 9 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.regex' => 'The password must contain at least 3 lowercase letters, 3 uppercase letters, 2 numbers, and 1 special character.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {


        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),


        ]);
    }

    protected function registered(Request $request, $user)
    {
        Logs::create([
            'user_id' => Auth::id(),
            'action' => 'Register',
            'description' => 'Registered a new user account',
        ]);
    }

    public function showRegistrationForm()
    {
        // Load the terms.html file (adjust the path if necessary)
        $termsHtml = File::get(resource_path('views/auth/terms.html'));

        // Return the registration view with terms HTML
        return view('auth.register', compact('termsHtml'));
    }
}