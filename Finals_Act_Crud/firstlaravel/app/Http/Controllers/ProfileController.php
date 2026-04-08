<?php

namespace App\Http\Controllers;

use App\Helpers\SystemLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.settings', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'course' => ['required', 'string', 'max:255'],
            'year_level' => ['required', 'string', 'max:50'],
            'birthdate' => ['required', 'date'],
            'gender' => ['required', 'string'],
            'phone_number' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update($request->only([
            'first_name', 'middle_name', 'last_name', 'course', 'year_level',
            'birthdate', 'gender', 'phone_number', 'address', 'email'
        ]));

        SystemLogger::log('Profile Update', 'Student updated their profile details.');

        return back()->with('status', 'profile-updated');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        SystemLogger::log('Security Update', 'Student changed their password.');

        return back()->with('status', 'password-updated');
    }
}
