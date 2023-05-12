<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateAccountRequest;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function showRegistrationForm()
    {
        return view('register');
    }

    public function login(LoginRequest $request)
    {
        $loginData = $request->only('email', 'password');

        if (Auth::attempt($loginData)) {
            $user = Auth::user();
            $token = $user->createToken('access_token')->accessToken;
            return redirect()->route('start');
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function register(CreateAccountRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        $token = $user->createToken('Register')->accessToken;
        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
