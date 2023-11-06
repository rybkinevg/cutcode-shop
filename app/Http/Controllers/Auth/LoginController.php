<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginFormRequest;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(LoginFormRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (!auth()->attempt($credentials)) {
            $errors = [
                'email' => 'The provided credentials do not match our records.',
            ];

            return back()->withErrors($errors)->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }
}