<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    /**
     * Show forgot password form.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Reset password.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'nik' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $messages = [];

        // Check Email
        $emailExists = User::where(
            'email',
            $request->email
        )->exists();

        if (!$emailExists) {
            $messages[] = 'Email is incorrect.';
        }

        // Check NIK
        $nikExists = User::where(
            'nik',
            $request->nik
        )->exists();

        if (!$nikExists) {
            $messages[] = 'NIK is incorrect.';
        }

        // Check Email + NIK
        $user = User::where('email', $request->email)
            ->where('nik', $request->nik)
            ->first();

        // Check Account Status
        if ($user && !$user->is_active) {
            $messages[] = 'Account is inactive.';
        }

        // If Error Exists
        if (!empty($messages)) {

            return redirect()
                ->route('login')
                ->with(
                    'error',
                    implode(' ', $messages)
                );
        }

        // Update Password
        $user->update([
            'password' => Hash::make(
                $request->password
            ),
        ]);

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Password has been reset successfully.'
            );
    }
}