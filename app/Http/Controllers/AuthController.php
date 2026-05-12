<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showAuthForm(): View
    {
        return view('auth');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('register', [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)->letters()->numbers()],
            'terms' => ['accepted'],
        ]);

        $user = User::create([
            'name' => trim($validated['first_name'].' '.$validated['last_name']),
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->intended(route('dashboard'))
            ->with('status', 'Account created successfully. Welcome to TripTailor.');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validateWithBag('login', [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ], 'login')->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        return redirect()
            ->intended(route('dashboard'))
            ->with('status', 'Signed in successfully.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('status', 'You have been signed out.');
    }

    public function showForgotPasswordForm(): View
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)])->onlyInput('email');
    }

    public function showResetPasswordForm(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'email' => $request->email,
            'token' => $token,
        ]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)->letters()->numbers()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password): void {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => __($status)])->onlyInput('email');
    }
}
