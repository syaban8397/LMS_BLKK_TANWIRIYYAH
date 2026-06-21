<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Support\SecureStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($request->hasFile('photo')) {
            SecureStorage::delete($user->photo);
            $user->photo = SecureStorage::storeUploadedFile($request->file('photo'), 'profile_photos');
        }

        $user->save();

        return Redirect::route('profile.edit')
            ->with('success', __('lms.flash.profile_updated'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return Redirect::route('profile.edit')
                ->withErrors([
                    'password' => __('lms.flash.user_cannot_delete_last_admin'),
                ], 'userDeletion');
        }

        Auth::logout();

        SecureStorage::delete($user->photo);
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
