<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    /**
     * Form Verifikasi
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Verifikasi Email + NIK
     */
    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'nik' => 'required'
        ]);

        $emailExists = User::where(
            'email',
            $request->email
        )->exists();

        $nikExists = User::where(
            'nik',
            $request->nik
        )->exists();

        /*
        |--------------------------------------------------------------------------
        | Email & NIK tidak ditemukan
        |--------------------------------------------------------------------------
        */

        if (!$emailExists && !$nikExists) {

            return back()->with(
                'popup_error',
                'Email dan NIK tidak ditemukan.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Email tidak ditemukan
        |--------------------------------------------------------------------------
        */

        if (!$emailExists) {

            return back()->with(
                'popup_error',
                'Email tidak ditemukan.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | NIK tidak ditemukan
        |--------------------------------------------------------------------------
        */

        if (!$nikExists) {

            return back()->with(
                'popup_error',
                'NIK tidak ditemukan.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Email & NIK harus milik user yang sama
        |--------------------------------------------------------------------------
        */

        $user = User::where(
            'email',
            $request->email
        )
        ->where(
            'nik',
            $request->nik
        )
        ->first();

        if (!$user) {

            return back()->with(
                'popup_error',
                'Email dan NIK tidak sesuai.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Akun tidak aktif
        |--------------------------------------------------------------------------
        */

        if (!$user->is_active) {

            return back()->with(
                'popup_error',
                'Akun tidak aktif. Hubungi administrator.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan Session Reset
        |--------------------------------------------------------------------------
        */

        session([
            'reset_user_id' => $user->id
        ]);

        /*
        |--------------------------------------------------------------------------
        | Popup Success
        |--------------------------------------------------------------------------
        */

        return back()->with(
            'popup_success',
            'Email dan NIK berhasil diverifikasi.'
        );
    }

    /**
     * Form Reset Password
     */
    public function showResetForm()
    {
        if (!session()->has('reset_user_id')) {

            return redirect()->route(
                'password.request.custom'
            );
        }

        return view(
            'auth.reset-password'
        );
    }

    /**
     * Simpan Password Baru
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::find(
            session('reset_user_id')
        );

        if (!$user) {

            return redirect()->route(
                'password.request.custom'
            );
        }

        $user->update([
            'password' => Hash::make(
                $request->password
            )
        ]);

        session()->forget(
            'reset_user_id'
        );

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Password berhasil diubah.'
            );
    }
}