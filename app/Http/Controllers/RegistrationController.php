<?php

namespace App\Http\Controllers;

use App\Mail\AcceptedEmail;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        parent::saveLog('Opened all registration page', auth()->user()->id);

        $users = User::when($request->search, function ($q) use ($request) {
            return $q->where('name', 'LIKE', "%$request->search%");
        })->where('verified_at', null)->where('id_card', '!=', null)->where('role', 'trainee')->paginate(10);
        return response()->view('crm.pages.registrations.index', compact('users'));
    }

    public function user(User $user)
    {
        parent::saveLog('Opened a user page', auth()->user()->id);
        $logs = $user->logs()->orderBy('id', 'DESC')->paginate(10);
        return response()->view('crm.pages.users.show', compact('user', 'logs'));
    }

    public function accept(User $user)
    {
        $user->verified_at = now();
        $isSaved = $user->save();
        if ($isSaved) {
            parent::saveLog('Accepted a registration', auth()->user()->id);
            Mail::to($user->email)->send(new AcceptedEmail($user->id));
        }
        return response()->json([
            'message' => $isSaved ? 'User Registration accepted!' : 'Failed, please try again.',
        ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function deny(User $user)
    {
        $deleted = $user->delete();
        if ($deleted) {
            parent::saveLog('Denied a registration', auth()->user()->id);
        }
        return response()->json([
            'message' => $deleted ? 'User Registration denied!' : 'Failed, please try again.',
        ], $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function underReview(Request $request)
    {
        if ($request->user()->verified_at) {
            return redirect()->route('crm.home');
        }
        return view('crm.pages.auth.under-review');
    }
}
