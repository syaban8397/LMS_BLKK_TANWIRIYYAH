<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserApprovalStatusRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use App\Support\SecureStorage;
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

        $userStatsRow = User::query()
            ->selectRaw('SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active')
            ->selectRaw("SUM(CASE WHEN approval_status = 'pending' THEN 1 ELSE 0 END) as pending")
            ->selectRaw("SUM(CASE WHEN role = 'instruktur' THEN 1 ELSE 0 END) as instructors")
            ->first();

        $userStats = [
            'active' => (int) ($userStatsRow->active ?? 0),
            'pending' => (int) ($userStatsRow->pending ?? 0),
            'instructors' => (int) ($userStatsRow->instructors ?? 0),
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

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $photo = null;

        if ($request->hasFile('photo')) {
            $photo = SecureStorage::storeUploadedFile($request->file('photo'), 'users');
        }

        $user = new User([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'nik' => $validated['nik'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'birth_place' => $validated['birth_place'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'address' => $validated['address'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'photo' => $photo,
            'approval_status' => $validated['approval_status'] ?? 'approved',
            'is_active' => $request->boolean('is_active', true),
        ]);
        $user->role = $validated['role'];
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

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nik' => $validated['nik'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'birth_place' => $validated['birth_place'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'address' => $validated['address'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'approval_status' => $validated['approval_status'],
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('photo')) {
            SecureStorage::delete($user->photo);
            $data['photo'] = SecureStorage::storeUploadedFile($request->file('photo'), 'users');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        if (
            $user->role === 'admin'
            && $validated['role'] !== 'admin'
            && User::where('role', 'admin')->count() <= 1
        ) {
            return back()
                ->withInput()
                ->with('error', __('lms.flash.user_cannot_demote_last_admin'));
        }

        $user->fill($data);
        $user->role = $validated['role'];
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

    public function updateStatus(UpdateUserApprovalStatusRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();
        $status = $validated['approval_status'];

        $user->update([
            'approval_status' => $status,
            'is_active' => $status === 'approved',
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', __('lms.flash.user_status_updated'));
    }
}
