<?php

namespace Modules\Frontend\Http\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('frontend::layout.login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request)
    {
        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ])) {
            if (Auth::user()->locked == null || Auth::user()->locked !== 'normal') {
                Auth::logout();
                $request->session()->invalidate();

                $request->session()->regenerateToken();
                return back()->with('no', 'User have been locked !');
            }
            return redirect('/')->with('ok', 'Login success !');
        }

        return back()->with('no', 'Login failed !')->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect('/')->with('ok', 'Logout success!');;
    }
}
