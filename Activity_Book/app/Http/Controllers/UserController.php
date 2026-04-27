<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
        return view('register');
    }

    public function store(Request $request)
    {

        $validated = $request->validate(
            [
                'name' => 'required|min:3|max:50',
                'email' => 'required|email',
                'password' => 'required|min:6|confirmed',
            ],
            [
                'name.required' => 'Please provide a fullname.',
                'name.min' => 'Fullname must be greater than 3.',
                'email.required' => 'Please provide an email.',
                'email' => 'Please provide an email.',
                'password.required' => 'Please provide a password.',
                'password.confirmed' => 'The password doesn\'t match',
            ]

        );

        return back()->with('success', 'Your account has been registered successfully.');
    }
}
