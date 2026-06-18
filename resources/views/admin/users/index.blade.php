<x-app-layout>
    <div class="user-management-wrapper lms-page-shell space-y-5">
        <x-lms-page-header :title="__('lms.nav.user_management')" :subtitle="__('lms.common.manage_users_desc')">
            <x-slot:actions>
                <a href="{{ route('admin.users.create') }}" class="lms-btn-primary btn-3d">{{ __('lms.common.create_user_btn') }}</a>
            </x-slot:actions>
        </x-lms-page-header>

        @if(session('success'))
            <x-lms-flash type="success">{{ session('success') }}</x-lms-flash>
        @endif

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="stat-card p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase">{{ __('lms.common.total_users') }}</p>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">{{ $users->total() }}</p>
                    </div>
                    <div class="lms-kpi-icon bg-blue-50 dark:bg-blue-950/40">👥</div>
                </div>
            </div>
            <div class="stat-card p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase">{{ __('lms.active') }}</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">{{ \App\Models\User::where('is_active',1)->count() }}</p>
                    </div>
                    <div class="lms-kpi-icon bg-green-50 dark:bg-green-950/40">✅</div>
                </div>
            </div>
            <div class="stat-card p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase">{{ __('lms.common.pending') }}</p>
                        <p class="text-2xl font-bold text-amber-500 dark:text-amber-400 mt-1">{{ \App\Models\User::where('approval_status','pending')->count() }}</p>
                    </div>
                    <div class="lms-kpi-icon bg-amber-50 dark:bg-amber-950/40">⏳</div>
                </div>
            </div>
            <div class="stat-card p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-slate-400 uppercase">{{ __('lms.common.instructors') }}</p>
                        <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 mt-1">{{ \App\Models\User::where('role','instruktur')->count() }}</p>
                    </div>
                    <div class="lms-kpi-icon bg-indigo-50 dark:bg-indigo-950/40">👨‍🏫</div>
                </div>
            </div>
        </div>

        <div class="filter-card p-4">
            <form method="GET" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-1">{{ __('lms.common.search') }}</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('lms.common.search_placeholder') }}"
                           class="input-3d w-full rounded-lg border-slate-200 text-sm">
                </div>
                <div class="w-40">
                    <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-1">{{ __('lms.common.role') }}</label>
                    <select name="role" class="input-3d w-full rounded-lg border-slate-200 text-sm">
                        <option value="">{{ __('lms.common.all') }}</option>
                        <option value="admin" {{ request('role')=='admin' ? 'selected' : '' }}>{{ __('lms.roles.admin') }}</option>
                        <option value="instruktur" {{ request('role')=='instruktur' ? 'selected' : '' }}>{{ __('lms.roles.instruktur') }}</option>
                        <option value="peserta" {{ request('role')=='peserta' ? 'selected' : '' }}>{{ __('lms.roles.peserta') }}</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="lms-btn-primary btn-3d">{{ __('lms.common.search') }}</button>
                    <a href="{{ route('admin.users.index') }}" class="lms-btn-secondary btn-3d">{{ __('lms.common.reset') }}</a>
                </div>
            </form>
        </div>

        <div class="table-card overflow-hidden p-0">
            <div class="overflow-x-auto">
                <table class="w-full text-sm table-auto">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left w-[30%]">{{ __('lms.common.user') }}</th>
                            <th class="px-4 py-3 text-center w-[12%]">{{ __('lms.common.role') }}</th>
                            <th class="px-4 py-3 text-center w-[15%]">{{ __('lms.report.phone') }}</th>
                            <th class="px-4 py-3 text-center w-[12%]">{{ __('lms.common.approval') }}</th>
                            <th class="px-4 py-3 text-center w-[10%]">{{ __('lms.common.status') }}</th>
                            <th class="px-4 py-3 text-center w-[21%]">{{ __('lms.common.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/55">
                        @forelse($users as $user)
                            <tr class="transition">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        @if($user->photo)
                                            <img src="{{ asset('storage/'.$user->photo) }}" class="w-8 h-8 rounded-lg object-cover border border-slate-200 dark:border-slate-600 shadow-sm" alt="">
                                        @else
                                            <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-slate-500 to-slate-600 text-white flex items-center justify-center text-xs font-bold shadow-sm">
                                                {{ strtoupper(substr($user->name,0,1)) }}
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <div class="font-medium text-slate-800 dark:text-slate-100 truncate max-w-[180px]">{{ $user->name }}</div>
                                            <div class="text-xs text-slate-400 truncate max-w-[180px]">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="lms-badge {{ $user->role === 'admin' ? 'lms-badge--danger' : ($user->role === 'instruktur' ? 'lms-badge--info' : '') }}">{{ __('lms.roles.' . $user->role) }}</span>
                                </td>
                                <td class="px-4 py-3 text-center text-slate-600 dark:text-slate-300 truncate max-w-[120px]">{{ $user->phone ?: '-' }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if($user->approval_status == 'approved')
                                        <span class="lms-badge lms-badge--success">{{ __('lms.common.approved') }}</span>
                                    @elseif($user->approval_status == 'rejected')
                                        <span class="lms-badge lms-badge--danger">{{ __('lms.common.rejected') }}</span>
                                    @else
                                        <span class="lms-badge lms-badge--warning">{{ __('lms.common.pending') }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($user->is_active)
                                        <span class="lms-badge lms-badge--success">{{ __('lms.active') }}</span>
                                    @else
                                        <span class="lms-badge">{{ __('lms.inactive') }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-center gap-1.5 flex-wrap">
                                        <a href="{{ route('admin.users.show', $user) }}" class="action-btn px-2 py-1 bg-sky-500 hover:bg-sky-600 text-white rounded-md text-xs">{{ __('lms.view') }}</a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="action-btn px-2 py-1 bg-amber-500 hover:bg-amber-600 text-white rounded-md text-xs">{{ __('lms.edit') }}</a>
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" data-lms-confirm="{{ __('lms.common.delete_user') }}" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="action-btn px-2 py-1 bg-red-500 hover:bg-red-600 text-white rounded-md text-xs">{{ __('lms.common.del') }}</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-500 dark:text-slate-400">{{ __('lms.common.no_users') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-slate-100 dark:border-slate-700/55 bg-slate-50 dark:bg-slate-800/40 text-xs">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
