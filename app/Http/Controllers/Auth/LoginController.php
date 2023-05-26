<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLogin()
    {
        return response()->view('crm.pages.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $loginInfo = ["email" => $request->input('email'), "password" => $request->input('password')];
        if (Auth::attempt($loginInfo, $request->input('remember'))) {
            return response()->json([
                'message' => 'Logged in Successfully!',
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'message' => 'Wrong email or password.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function showRegister()
    {
        return response()->view('crm.pages.auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        if($user) {
            Auth::login($user);
        }
        return response()->json([
            'message' => $user ? 'Registed Successfully!' : 'failed to register, please try again.',
        ], $user ? Response::HTTP_CREATED : Response::HTTP_BAD_GATEWAY);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }
}
