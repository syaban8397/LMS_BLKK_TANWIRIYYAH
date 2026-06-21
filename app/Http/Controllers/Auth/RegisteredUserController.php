<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(RegisterUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = new User([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nik' => $validated['nik'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'birth_place' => $validated['birth_place'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'address' => $validated['address'] ?? null,
            'photo' => null,
            'bio' => null,
            'is_active' => false,
            'approval_status' => 'pending',
            'password' => Hash::make($validated['password']),
        ]);
        $user->role = 'peserta';
        $user->save();

        event(new Registered($user));

        return redirect()
            ->route('login')
            ->with('success', __('lms.auth.registration_success'));
    }
}
