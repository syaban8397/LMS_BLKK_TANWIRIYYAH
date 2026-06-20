@php
    $role = auth()->user()->role;
@endphp

<nav class="relative z-10 h-screen flex flex-col" aria-label="{{ __('lms.app_name') }}">
    <div class="lms-sidebar-header">
        <div class="lms-sidebar-logo logo-text">
            <img src="{{ asset('storage/images/Logo.png') }}"
                 alt="{{ __('lms.app_name') }}"
                 class="lms-sidebar-logo__img">
        </div>
        <div class="lms-sidebar-logo__mark sidebar-logo-mark hidden">
            <img src="{{ asset('storage/images/Logo.png') }}" alt="{{ __('lms.app_name') }}">
        </div>
    </div>

    <div class="lms-sidebar-nav flex-1 overflow-y-auto">
        <div class="space-y-0.5">
            <a href="{{ route($role.'.dashboard') }}"
               class="sidebar-nav-link {{ request()->routeIs($role.'.dashboard') ? 'sidebar-nav-link--active' : '' }}">
                <x-lms-nav-icon name="dashboard" class="sidebar-nav-icon" />
                <span class="menu-text">{{ __('lms.dashboard.menu') }}</span>
            </a>

            @if($role == 'admin')
                <a href="{{ route('admin.users.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('admin.users.*') ? 'sidebar-nav-link--active' : '' }}">
                    <x-lms-nav-icon name="users" class="sidebar-nav-icon" />
                    <span class="menu-text">{{ __('lms.nav.user_management') }}</span>
                </a>
                <a href="{{ route('admin.programs.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('admin.programs.*') ? 'sidebar-nav-link--active' : '' }}">
                    <x-lms-nav-icon name="programs" class="sidebar-nav-icon" />
                    <span class="menu-text">{{ __('lms.nav.training_programs') }}</span>
                </a>
                <a href="{{ route('admin.classes.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('admin.classes.*') ? 'sidebar-nav-link--active' : '' }}">
                    <x-lms-nav-icon name="classes" class="sidebar-nav-icon" />
                    <span class="menu-text">{{ __('lms.nav.classes') }}</span>
                </a>
                <a href="{{ route('admin.announcements.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('admin.announcements.*') ? 'sidebar-nav-link--active' : '' }}">
                    <x-lms-nav-icon name="announcements" class="sidebar-nav-icon" />
                    <span class="menu-text">{{ __('lms.nav.announcements') }}</span>
                </a>
                <a href="{{ route('admin.certificates.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('admin.certificates.*') ? 'sidebar-nav-link--active' : '' }}">
                    <x-lms-nav-icon name="certificates" class="sidebar-nav-icon" />
                    <span class="menu-text">{{ __('lms.nav.certificates') }}</span>
                </a>
                <a href="{{ route('admin.reports.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('admin.reports.*') ? 'sidebar-nav-link--active' : '' }}">
                    <x-lms-nav-icon name="reports" class="sidebar-nav-icon" />
                    <span class="menu-text">{{ __('lms.nav.reports') }}</span>
                </a>
                <a href="{{ route('admin.settings.edit') }}"
                   class="sidebar-nav-link {{ request()->routeIs('admin.settings.*') ? 'sidebar-nav-link--active' : '' }}">
                    <x-lms-nav-icon name="settings" class="sidebar-nav-icon" />
                    <span class="menu-text">{{ __('lms.nav.settings') }}</span>
                </a>
            @endif

            @if($role == 'instruktur')
                <a href="{{ route('instruktur.classes.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('instruktur.classes.*') ? 'sidebar-nav-link--active' : '' }}">
                    <x-lms-nav-icon name="classes" class="sidebar-nav-icon" />
                    <span class="menu-text">{{ __('lms.nav.my_classes') }}</span>
                </a>
                <a href="{{ route('instruktur.certificates.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('instruktur.certificates.*') ? 'sidebar-nav-link--active' : '' }}">
                    <x-lms-nav-icon name="certificates" class="sidebar-nav-icon" />
                    <span class="menu-text">{{ __('lms.nav.certificates') }}</span>
                </a>
            @endif

            @if($role == 'peserta')
                <a href="{{ route('peserta.classes.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('peserta.classes.*') ? 'sidebar-nav-link--active' : '' }}">
                    <x-lms-nav-icon name="classes" class="sidebar-nav-icon" />
                    <span class="menu-text">{{ __('lms.nav.my_classes') }}</span>
                </a>
                <a href="{{ route('peserta.certificates.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('peserta.certificates.*') ? 'sidebar-nav-link--active' : '' }}">
                    <x-lms-nav-icon name="certificates" class="sidebar-nav-icon" />
                    <span class="menu-text">{{ __('lms.nav.certificates') }}</span>
                </a>
            @endif
        </div>
    </div>

    <div class="lms-sidebar-footer">
        <div class="logo-text">
            <p class="lms-sidebar-footer__title">{{ $lmsAppDisplayName ?? __('lms.app_name') }}</p>
            <p class="lms-sidebar-footer__version">{{ __('lms.version') }} 1.0</p>
        </div>
    </div>
</nav>
