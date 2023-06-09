<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class CompleteResgistrationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Route::currentRouteName() == 'account.profile') return $next($request);
        if (Auth::check()) {
            if (in_array(auth()->user()->role, ['trainee', 'advisor']) && !auth()->user()->id_card) {
                return redirect('/account-settings/profile');
            }
            if (auth()->user()->role == 'trainee' && !auth()->user()->verified_at) {
                return redirect('/under-review');
            }
        }
        return $next($request);
    }
}
