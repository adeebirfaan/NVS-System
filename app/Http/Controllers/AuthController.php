<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if (!$user->is_active) {
            throw ValidationException::withMessages([
                'email' => ['Your account has been deactivated. Please contact administrator.'],
            ]);
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        Auth::login($user);

        $request->session()->regenerate();

        if ($user->must_change_password) {
            return redirect()->route('password.change');
        }

       return redirect($this->redirectTo($user));
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'role' => User::ROLE_PUBLIC,
            'is_active' => true,
            'must_change_password' => false,
        ]);

        Auth::login($user);

        $user->sendEmailVerificationNotification();

        return redirect()->route('login')->with('success', 'Registration successful! Please verify your email.');
    }

    public function verifyEmail(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect('/')->with('error', 'Invalid verification link.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect('/')->with('success', 'Email already verified.');
        }

        $user->markEmailAsVerified();

        return redirect('/')->with('success', 'Email verified successfully!');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

   public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'We cannot find a user with that email address.'
            ])->withInput();
        }

        $token = Password::broker()->createToken($user);

        return redirect()->route('password.link.sent', [
            'email' => $user->email,
            'token' => $token,
        ]);
    }

    public function showResetLinkSent(Request $request)
    {
        if (!$request->filled('email') || !$request->filled('token')) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Invalid password reset request.']);
        }

        return view('auth.reset-link-sent', [
            'email' => $request->email,
            'token' => $request->token,
        ]);
    }

    public function showResetPasswordForm(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Password has been reset successfully. Please log in with your new password.');
        }

        return back()->withErrors([
            'email' => __($status),
        ])->withInput();
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showPasswordChangeForm()
    {
        return view('auth.password-change');
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The current password is incorrect.'],
            ]);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
            'must_change_password' => false,
        ]);

       return redirect($this->redirectTo($user))
        ->with('success', 'Password changed successfully!');
    }

    protected function redirectTo($user): string
    {
        if ($user->isMcmc()) {
            return '/mcmc/dashboard';
        }

        if ($user->isAgency()) {
            return '/agency/dashboard';
        }

        return '/dashboard';
    }
}
