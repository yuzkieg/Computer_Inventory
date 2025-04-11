<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('inventory.register');  // Update this line
    }

    public function register(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|unique:users|max:255',
            'password' => 'required|string|min:1|confirmed',
        ]);

        // Create a new user
        try {
            $user = User::create($validatedData);
            $user->password = Hash::make($request->password);
            $user->save();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        return redirect()->route('login')->with('success', 'Registration successful! You can now log in.');
    }
}