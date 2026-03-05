<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Attempt to authenticate and store the user id in session.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Session::put('user_id', $user->id);
            return redirect('/documents');
        }

        return redirect('/login')->with('error', 'Identifiants invalides');
    }

    /**
     * Logout the current user and clear session.
     */
    public function logout()
    {
        Session::flush();
        return redirect('/')->with('success', 'Vous êtes déconnecté.');
    }
}
