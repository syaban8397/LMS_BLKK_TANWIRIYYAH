<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\PasswordResetToken;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function verify(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'nik' => ['required', 'string'],
        ]);

        $user = User::where('email', $validated['email'])
            ->where('nik', $validated['nik'])
            ->first();

        if (! $user || ! $user->is_active || $user->approval_status !== 'approved') {
            return back()
                ->withInput($request->only('email', 'nik'))
                ->with('popup_error', __('lms.auth_popup.verify_failed_generic'));
        }

        $previousToken = session('reset_token');
        if (is_string($previousToken) && $previousToken !== '') {
            PasswordResetToken::invalidate($previousToken);
        }

        $token = PasswordResetToken::create($user->id);
        session(['reset_token' => $token]);

        return back()
            ->withInput($request->only('email', 'nik'))
            ->with('popup_success', __('lms.auth_popup.verify_success'));
    }

    public function showResetForm(): View|RedirectResponse
    {
        $token = session('reset_token');

        if (! is_string($token) || $token === '' || PasswordResetToken::userIdFor($token) === null) {
            if (is_string($token) && $token !== '') {
                session()->forget('reset_token');
            }

            return redirect()
                ->route('password.request')
                ->with('error', __('lms.auth_popup.reset_expired'));
        }

        return view('auth.reset-password-custom', [
            'resetToken' => $token,
        ]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'reset_token' => ['required', 'string'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $sessionToken = session('reset_token');
        $requestToken = $request->input('reset_token');

        if (! is_string($sessionToken) || $sessionToken === '' || ! hash_equals($sessionToken, $requestToken)) {
            session()->forget('reset_token');

            return redirect()
                ->route('password.request')
                ->with('error', __('lms.auth_popup.reset_expired'));
        }

        $userId = PasswordResetToken::consume($requestToken);

        if ($userId === null) {
            session()->forget('reset_token');

            return redirect()
                ->route('password.request')
                ->with('error', __('lms.auth_popup.reset_expired'));
        }

        $user = User::find($userId);

        if (! $user) {
            session()->forget('reset_token');

            return redirect()->route('password.request');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        session()->forget('reset_token');

        return redirect()
            ->route('login')
            ->with('success', __('lms.auth_popup.password_changed'));
    }
}
