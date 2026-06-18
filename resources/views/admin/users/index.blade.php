<x-app-layout>
    <div class="user-management-wrapper lms-page-shell space-y-5">
        <x-lms-page-header :title="__('lms.nav.user_management')" :subtitle="__('lms.common.manage_users_desc')">
            <x-slot:actions>
                <x-ds.button tag="a" :href="route('admin.users.create')" variant="primary">{{ __('lms.common.create_user_btn') }}</x-ds.button>
            </x-slot:actions>
        </x-lms-page-header>

        <x-lms-session-flash />

        <x-lms-stat-grid>
            <x-lms-stat-card
                :label="__('lms.common.total_users')"
                :value="$users->total()"
                icon="👥"
                tone="blue"
            />
            <x-lms-stat-card
                :label="__('lms.active')"
                :value="$userStats['active']"
                icon="✅"
                tone="green"
            />
            <x-lms-stat-card
                :label="__('lms.common.pending')"
                :value="$userStats['pending']"
                icon="⏳"
                tone="amber"
            />
            <x-lms-stat-card
                :label="__('lms.common.instructors')"
                :value="$userStats['instructors']"
                icon="👨‍🏫"
                tone="indigo"
            />
        </x-lms-stat-grid>

        <x-lms-filter-bar :reset-url="route('admin.users.index')">
            <x-lms-filter-field
                :label="__('lms.common.search')"
                name="search"
                :value="request('search')"
                :placeholder="__('lms.common.search_placeholder')"
                class="flex-1 min-w-[150px]"
            />
            <x-lms-filter-field
                :label="__('lms.common.role')"
                name="role"
                type="select"
                class="w-40"
            >
                <option value="">{{ __('lms.common.all') }}</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>{{ __('lms.roles.admin') }}</option>
                <option value="instruktur" {{ request('role') == 'instruktur' ? 'selected' : '' }}>{{ __('lms.roles.instruktur') }}</option>
                <option value="peserta" {{ request('role') == 'peserta' ? 'selected' : '' }}>{{ __('lms.roles.peserta') }}</option>
            </x-lms-filter-field>
        </x-lms-filter-bar>

        <x-lms-data-table :paginator="$users" :skeleton-cols="6">
            <x-slot:head>
                <tr>
                    <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.common.user') }}</th>
                    <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.role') }}</th>
                    <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.report.phone') }}</th>
                    <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.approval') }}</th>
                    <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.status') }}</th>
                    <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.actions') }}</th>
                </tr>
            </x-slot:head>

            @forelse($users as $user)
                <tr class="transition">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $user->profilePhotoUrl() }}" class="w-8 h-8 rounded-lg object-cover border border-slate-200 dark:border-slate-600 shadow-sm" alt="">
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
                        <x-lms-status-badge :status="$user->approval_status" type="approval" />
                    </td>
                    <td class="px-4 py-3 text-center">
                        <x-lms-status-badge :status="$user->is_active" type="boolean" />
                    </td>
                    <td class="px-4 py-3">
                        <x-lms-row-actions>
                            @if($user->approval_status === 'pending' && $user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.update-status', $user) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="approval_status" value="approved">
                                    <x-lms-action-btn variant="approve" type="submit">{{ __('lms.common.approve') }}</x-lms-action-btn>
                                </form>
                                <form method="POST" action="{{ route('admin.users.update-status', $user) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="approval_status" value="rejected">
                                    <x-lms-action-btn variant="reject" type="submit">{{ __('lms.common.reject') }}</x-lms-action-btn>
                                </form>
                            @endif
                            <x-lms-action-btn variant="view" :href="route('admin.users.show', $user)">{{ __('lms.view') }}</x-lms-action-btn>
                            <x-lms-action-btn variant="edit" :href="route('admin.users.edit', $user)">{{ __('lms.edit') }}</x-lms-action-btn>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline">
                                @csrf @method('DELETE')
                                <x-lms-action-btn variant="delete" type="submit" :confirm="__('lms.common.delete_user')">{{ __('lms.common.del') }}</x-lms-action-btn>
                            </form>
                        </x-lms-row-actions>
                    </td>
                </tr>
            @empty
                <x-lms-table-empty :colspan="6" :message="__('lms.common.no_users')" />
            @endforelse
        </x-lms-data-table>
    </div>
</x-app-layout>
