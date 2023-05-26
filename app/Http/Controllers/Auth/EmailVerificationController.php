<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmailVerificationController extends Controller
{
    public function showVerifyEmail()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return redirect()->route('crm.home');
        }
        return response()->view('crm.pages.auth.verify-email');
    }

    public function verifyEmail(EmailVerificationRequest $request)
    {
        if (!auth()->user()->hasVerifiedEmail()) {
            $request->fulfill();
        }
        return redirect()->route('crm.home');
    }

    public function resendVerificationEmail(Request $request)
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Your email has been already verified'
            ], Response::HTTP_BAD_REQUEST);
        }
        $request->user()->sendEmailVerificationNotification();
        return response()->json([
            'message' => 'Verification link sent!',
        ], Response::HTTP_OK);
    }

    public function hasVerifiedEmail()
    {
        return response()->json([
            'message' => auth()->user()->hasVerifiedEmail() ? 'Email has been verified!' : 'Email is not verified, please check your email for verification',
        ], auth()->user()->hasVerifiedEmail() ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
