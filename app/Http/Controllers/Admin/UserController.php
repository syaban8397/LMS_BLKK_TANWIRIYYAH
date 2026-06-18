<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\SecureStorage;
use App\Support\UploadRules;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%")
                    ->orWhere('nik', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $userStats = [
            'active' => User::where('is_active', 1)->count(),
            'pending' => User::where('approval_status', 'pending')->count(),
            'instructors' => User::where('role', 'instruktur')->count(),
        ];

        return view(
            'admin.users.index',
            compact('users', 'userStats')
        );
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'role' => 'required|in:admin,instruktur,peserta',
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'nik' => 'nullable|string|max:30',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:L,P',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'bio' => 'nullable|string',
            'approval_status' => 'nullable|in:pending,approved,rejected',
            'is_active' => 'nullable|boolean',
            'photo' => UploadRules::profilePhoto(2048),
        ]);

        $photo = null;

        if ($request->hasFile('photo')) {
            $photo = SecureStorage::storeUploadedFile($request->file('photo'), 'users');
        }

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nik' => $request->nik,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'bio' => $request->bio,
            'photo' => $photo,
            'approval_status' => $request->approval_status ?? 'approved',
            'is_active' => $request->boolean('is_active', true),
        ]);
        $user->role = $request->role;
        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success', __('lms.flash.user_created'));
    }

    public function show(User $user): View
    {
        return view(
            'admin.users.show',
            compact('user')
        );
    }

    public function edit(User $user): View
    {
        return view(
            'admin.users.edit',
            compact('user')
        );
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'role' => 'required|in:admin,instruktur,peserta',
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nik' => 'nullable|max:50',
            'phone' => 'nullable|max:30',
            'gender' => 'nullable|in:L,P',
            'birth_place' => 'nullable|max:100',
            'birth_date' => 'nullable|date',
            'address' => 'nullable',
            'bio' => 'nullable',
            'photo' => UploadRules::profilePhoto(2048),
            'approval_status' => 'required|in:pending,approved,rejected',
            'is_active' => 'nullable|boolean',
            'password' => 'nullable|min:8',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'nik' => $request->nik,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'bio' => $request->bio,
            'approval_status' => $request->approval_status,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('photo')) {
            SecureStorage::delete($user->photo);
            $data['photo'] = SecureStorage::storeUploadedFile($request->file('photo'), 'users');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->fill($data);
        $user->role = $request->role;
        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success', __('lms.flash.user_updated'));
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', __('lms.flash.user_cannot_delete_self'));
        }

        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', __('lms.flash.user_cannot_delete_last_admin'));
        }

        SecureStorage::delete($user->photo);

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', __('lms.flash.user_deleted'));
    }

    public function updateStatus(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'approval_status' => [
                'required',
                'in:pending,approved,rejected',
            ],
        ]);

        $status = $request->approval_status;

        $user->update([
            'approval_status' => $status,
            'is_active' => $status === 'approved',
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', __('lms.flash.user_status_updated'));
    }
}
