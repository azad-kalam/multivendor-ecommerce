<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
        // return view('homepage.index');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate(); //only authenticated user
        $request->session()->regenerate();

        $user = Auth::user();
        $ip = $request->ip();
        $time = now();

        $user->update([
            'last_login_time' => $time,  // লগইন করার সময় লগইন টাইম
            'last_ip_address' => $ip,    // লগইন করার সময় ইউজারের IP
        ]);

        $authRole = $user->role;

        if ($authRole === 'admin') {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        } elseif ($authRole === 'vendor') {
            return redirect()->intended(route('vendor.dashboard', absolute: false));
        } else {
            return redirect()->intended(route('homepage.index', absolute: false));
        }
    }


    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
