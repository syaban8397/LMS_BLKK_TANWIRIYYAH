<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * User List
     */
    public function index(Request $request): View
    {
        $query = User::query();

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%")
                    ->orWhere('nik', 'like', "%{$request->search}%");
            });
        }

        // Filter Role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.users.index',
            compact('users')
        );
    }

    /**
     * Create Form
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store User
     */
    public function store(
    Request $request
): RedirectResponse {

    $validated = $request->validate([
        'role' => 'required|in:admin,instruktur,peserta',
        'name' => 'required|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',

        'nik' => 'nullable|string|max:30',
        'phone' => 'nullable|string|max:20',
        'gender' => 'nullable|in:L,P',
        'birth_place' => 'nullable|string|max:100',
        'birth_date' => 'nullable|date',
        'address' => 'nullable|string',
        'bio' => 'nullable|string',

        'approval_status' => 'nullable|in:pending,approved,rejected',
        'is_active' => 'nullable|boolean',

        'photo' => 'nullable|image|max:2048',
    ]);

    $photo = null;

    if ($request->hasFile('photo')) {

        $photo = $request
            ->file('photo')
            ->store('users', 'public');
    }

     User::create([
        'role' => $request->role,
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

        'approval_status' => $request->approval_status,
        'is_active' => $request->boolean('is_active'),
    ]);

    return redirect()
        ->route('admin.users.index')
        ->with('success', 'User created successfully.');
}
    /**
     * Show Detail
     */
    public function show(User $user): View
    {
        return view(
            'admin.users.show',
            compact('user')
        );
    }

    /**
     * Edit Form
     */
    public function edit(User $user): View
    {
        return view(
            'admin.users.edit',
            compact('user')
        );
    }

    /**
     * Update User
     */
    public function update(
    Request $request,
    User $user
): RedirectResponse {

    $validated = $request->validate([
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

        'photo' => 'nullable|image|max:2048',

        'approval_status' => 'required|in:pending,approved,rejected',
        'is_active' => 'nullable|boolean',

        'password' => 'nullable|min:6',
    ]);

    $data = [
        'role' => $request->role,
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

        $data['photo'] = $request
            ->file('photo')
            ->store('users', 'public');
    }

    if ($request->filled('password')) {

        $data['password'] = Hash::make(
            $request->password
        );
    }

    $user->update($data);

    return redirect()
        ->route('admin.users.index')
        ->with(
            'success',
            'User updated successfully.'
        );
}
    /**
     * Delete User
     */
    public function destroy(
        User $user
    ): RedirectResponse {

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'User deleted successfully.'
            );
    }

    /**
     * Approval Status
     */
    public function updateStatus(
        Request $request,
        User $user
    ): RedirectResponse {

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
            ->with(
                'success',
                'User status updated successfully.'
            );
    }
}