<x-app-layout>
    <x-lms-page-shell class="show-user-wrapper space-y-6">
        <x-lms-page-header
            :title="$user->name"
            :subtitle="__('lms.admin_page.user_profile')"
            :back-url="route('admin.users.index')"
        >
            <x-slot:actions>
                <a href="{{ route('admin.users.edit', $user) }}" class="lms-btn-warning inline-flex items-center gap-1.5">
                    <x-lms-icon name="edit" class="w-4 h-4" />
                    {{ __('lms.common.edit_user') }}
                </a>
            </x-slot:actions>
        </x-lms-page-header>

        <div class="grid lg:grid-cols-3 gap-6 lms-detail-grid">
            <x-lms-panel>
                <div class="flex flex-col items-center">
                    <img src="{{ $user->profilePhotoUrl() }}"
                         class="w-32 h-32 rounded-xl object-cover border shadow-sm" alt="">
                    <h2 class="mt-4 text-xl font-bold text-slate-800">{{ $user->name }}</h2>
                    <p class="text-sm text-slate-500">{{ $user->email }}</p>
                    <div class="flex flex-wrap justify-center gap-2 mt-3">
                        @php
                            $roleVariant = match ($user->role) {
                                'admin' => 'danger',
                                'instruktur' => 'info',
                                default => 'info',
                            };
                        @endphp
                        <x-ds.badge :variant="$roleVariant">{{ __('lms.roles.' . $user->role) }}</x-ds.badge>
                        <x-lms-status-badge :status="$user->approval_status" type="approval" />
                    </div>
                </div>

                <div class="mt-5 pt-4 border-t border-slate-100">
                    <x-lms-section :title="__('lms.admin_page.account_status')" icon="info" compact>
                        <div class="lms-detail-list">
                            <div class="lms-detail-row">
                                <span class="lms-detail-row__label">{{ __('lms.common.status') }}</span>
                                <span class="lms-detail-row__value">
                                    <x-lms-status-badge :status="$user->is_active" type="boolean" />
                                </span>
                            </div>
                            <div class="lms-detail-row">
                                <span class="lms-detail-row__label">{{ __('lms.common.role') }}</span>
                                <span class="lms-detail-row__value">{{ __('lms.roles.' . $user->role) }}</span>
                            </div>
                            <div class="lms-detail-row">
                                <span class="lms-detail-row__label">{{ __('lms.common.registered') }}</span>
                                <span class="lms-detail-row__value">{{ $user->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </x-lms-section>
                </div>
            </x-lms-panel>

            <div class="lg:col-span-2 space-y-5">
                <x-lms-section :title="__('lms.admin_page.personal_info')" icon="users">
                    <x-lms-panel>
                        <div class="lms-detail-grid md:grid-cols-2">
                            <div class="lms-detail-list">
                                <div class="lms-detail-row">
                                    <span class="lms-detail-row__label">{{ __('lms.auth.full_name') }}</span>
                                    <span class="lms-detail-row__value">{{ $user->name ?: '-' }}</span>
                                </div>
                                <div class="lms-detail-row">
                                    <span class="lms-detail-row__label">{{ __('lms.admin_page.email_address') }}</span>
                                    <span class="lms-detail-row__value">{{ $user->email ?: '-' }}</span>
                                </div>
                                <div class="lms-detail-row">
                                    <span class="lms-detail-row__label">{{ __('lms.auth.nik') }}</span>
                                    <span class="lms-detail-row__value">{{ $user->nik ?: '-' }}</span>
                                </div>
                                <div class="lms-detail-row">
                                    <span class="lms-detail-row__label">{{ __('lms.common.phone_number') }}</span>
                                    <span class="lms-detail-row__value">{{ $user->phone ?: '-' }}</span>
                                </div>
                            </div>
                            <div class="lms-detail-list">
                                <div class="lms-detail-row">
                                    <span class="lms-detail-row__label">{{ __('lms.auth.gender') }}</span>
                                    <span class="lms-detail-row__value">@if($user->gender == 'L') {{ __('lms.auth.male') }} @elseif($user->gender == 'P') {{ __('lms.auth.female') }} @else - @endif</span>
                                </div>
                                <div class="lms-detail-row">
                                    <span class="lms-detail-row__label">{{ __('lms.auth.birth_place') }}</span>
                                    <span class="lms-detail-row__value">{{ $user->birth_place ?: '-' }}</span>
                                </div>
                                <div class="lms-detail-row">
                                    <span class="lms-detail-row__label">{{ __('lms.auth.birth_date') }}</span>
                                    <span class="lms-detail-row__value">{{ $user->birth_date ? $user->birth_date->format('d M Y') : '-' }}</span>
                                </div>
                                <div class="lms-detail-row">
                                    <span class="lms-detail-row__label">{{ __('lms.admin_page.approval_status') }}</span>
                                    <span class="lms-detail-row__value">
                                        <x-lms-status-badge :status="$user->approval_status" type="approval" />
                                    </span>
                                </div>
                            </div>
                        </div>
                    </x-lms-panel>
                </x-lms-section>

                <x-lms-section :title="__('lms.auth.address')" icon="building">
                    <x-lms-panel>
                        <p class="text-sm text-slate-600">{{ $user->address ?: __('lms.common.no_address') }}</p>
                    </x-lms-panel>
                </x-lms-section>

                <x-lms-section :title="__('lms.common.biography')" icon="document">
                    <x-lms-panel>
                        <p class="text-sm text-slate-600 whitespace-pre-line">{{ $user->bio ?: __('lms.common.no_bio') }}</p>
                    </x-lms-panel>
                </x-lms-section>
            </div>
        </div>
    </x-lms-page-shell>
</x-app-layout>
