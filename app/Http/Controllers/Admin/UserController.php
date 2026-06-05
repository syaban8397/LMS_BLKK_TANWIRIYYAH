<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display users list.
     */
    public function index(): View
    {
        $users = User::latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Update approval status.
     */
    public function updateStatus(
        Request $request,
        User $user
    ): RedirectResponse
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
            ->with(
                'success',
                'User status updated successfully.'
            );
    }
}