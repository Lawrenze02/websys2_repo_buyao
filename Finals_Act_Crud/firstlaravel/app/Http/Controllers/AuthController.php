<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\SystemLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'student_id' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            SystemLogger::log('Login', 'Student logged in successfully.');

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'student_id' => 'The provided credentials do not match our records.',
        ])->onlyInput('student_id');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'student_id' => ['required', 'string', 'max:20', 'unique:users'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'course' => ['required', 'string', 'max:255'],
            'year_level' => ['required', 'string', 'max:50'],
            'birthdate' => ['required', 'date'],
            'gender' => ['required', 'string'],
            'phone_number' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'student_id' => $request->student_id,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'course' => $request->course,
            'year_level' => $request->year_level,
            'birthdate' => $request->birthdate,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        SystemLogger::log('Registration', "New student registered: {$user->student_id}", $user->id);

        Auth::login($user);

        SystemLogger::log('Login', 'Student logged in after registration.');

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        SystemLogger::log('Logout', 'Student logged out.');

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
