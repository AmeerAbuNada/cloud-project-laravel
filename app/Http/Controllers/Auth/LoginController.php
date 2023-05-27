<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLogin()
    {
        return response()->view('crm.pages.auth.login');
    }

    public function login(LoginRequest $request)
    {
        if (is_int($request->input('email'))) {
            $user = User::where('id', $request->input('email'))->first();
        } else {
            $user = User::where('email', $request->input('email'))->first();
        }
        if (!$user) {
            return response()->json([
                'message' => 'Wrong login info.',
            ], Response::HTTP_BAD_REQUEST);
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'message' => 'Wrong login info.',
            ], Response::HTTP_BAD_REQUEST);
        }

        Auth::login($user, $request->input('remember'));
        parent::saveLog('Logged in', auth()->user()->id);
        return response()->json([
            'message' => 'Logged in Successfully!',
        ], Response::HTTP_OK);
    }

    public function showRegister()
    {
        return response()->view('crm.pages.auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        if ($user) {
            Auth::login($user);
            parent::saveLog('Registed new account', auth()->user()->id);
        }
        return response()->json([
            'message' => $user ? 'Registed Successfully!' : 'failed to register, please try again.',
        ], $user ? Response::HTTP_CREATED : Response::HTTP_BAD_GATEWAY);
    }

    public function logout(Request $request)
    {
        parent::saveLog('Logged out', auth()->user()->id);
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }
}
