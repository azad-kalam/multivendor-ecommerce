<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        //  লগইন চেক করা হয়েছে
        if (!Auth::check()) {
            return redirect()
                ->route('homepage.index')
                ->with('toastr_error', 'You are not authenticated !'); //আপনি লগইন করা নেই
        }

        //   role চেক করা হয়েছে
        if (Auth::user()->role != $role) {
            return redirect()
                ->route('homepage.index')
                ->with('toastr_error', 'Your access is denied !'); //আপনার প্রবেশাধিকার প্রত্যাখ্যান করা হয়েছে
        }

        // সব ঠিক → ঢুকতে দাও
        return $next($request);
    }
}
