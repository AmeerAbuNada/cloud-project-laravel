<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPassword\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPassword\ResetPasswordRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordController extends Controller
{
    public function showForgotPassword()
    {
        return response()->view('crm.pages.auth.forgot-password');
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        $isSent =  $status === Password::RESET_LINK_SENT;
        return response()->json([
            'message' => __($status),
        ], $isSent ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function showResetPassword($token)
    {
        return response()->view('crm.pages.auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        $isReset =  $status === Password::PASSWORD_RESET;
        return response()->json([
            'message' => __($status),
        ], $isReset ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
