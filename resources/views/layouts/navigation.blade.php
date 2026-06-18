@php
    $role = auth()->user()->role;
@endphp

<nav class="relative z-10 h-screen flex flex-col">
    <div class="px-3 py-5 border-b border-white/10">
        <div class="flex items-center justify-center px-1">
            <img src="{{ asset('storage/images/Logo.png') }}" alt="{{ __('lms.app_name') }}" class="logo-text h-9 w-auto max-w-[11rem] object-contain">
            <div class="sidebar-logo-mark hidden w-10 h-10 rounded-lg bg-white p-1 items-center justify-center shadow-sm ring-1 ring-white/20 overflow-hidden">
                <img src="{{ asset('storage/images/Logo.png') }}" alt="{{ __('lms.app_name') }}" class="h-full w-auto max-w-none object-contain object-left origin-left scale-[2.2]">
            </div>
        </div>
    </div>

    <div class="flex-1 px-3 py-4 overflow-y-auto">
        <div class="space-y-1.5">
            <a href="{{ route($role.'.dashboard') }}"
               class="sidebar-nav-link {{ request()->routeIs($role.'.dashboard') ? 'sidebar-nav-link--active' : '' }}">
                <span class="sidebar-nav-icon">📊</span>
                <span class="menu-text">{{ __('lms.dashboard.menu') }}</span>
            </a>

            @if($role == 'admin')
                <a href="{{ route('admin.users.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('admin.users.*') ? 'sidebar-nav-link--active' : '' }}">
                    <span class="sidebar-nav-icon">👥</span>
                    <span class="menu-text">{{ __('lms.nav.user_management') }}</span>
                </a>
                <a href="{{ route('admin.programs.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('admin.programs.*') ? 'sidebar-nav-link--active' : '' }}">
                    <span class="sidebar-nav-icon">📚</span>
                    <span class="menu-text">{{ __('lms.nav.training_programs') }}</span>
                </a>
                <a href="{{ route('admin.classes.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('admin.classes.*') ? 'sidebar-nav-link--active' : '' }}">
                    <span class="sidebar-nav-icon">🏫</span>
                    <span class="menu-text">{{ __('lms.nav.classes') }}</span>
                </a>
                <a href="{{ route('admin.announcements.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('admin.announcements.*') ? 'sidebar-nav-link--active' : '' }}">
                    <span class="sidebar-nav-icon">📢</span>
                    <span class="menu-text">{{ __('lms.nav.announcements') }}</span>
                </a>
                <a href="{{ route('admin.certificates.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('admin.certificates.*') ? 'sidebar-nav-link--active' : '' }}">
                    <span class="sidebar-nav-icon">📜</span>
                    <span class="menu-text">{{ __('lms.nav.certificates') }}</span>
                </a>
                <a href="{{ route('admin.reports.classes') }}"
                   class="sidebar-nav-link {{ request()->routeIs('admin.reports.classes*') ? 'sidebar-nav-link--active' : '' }}">
                    <span class="sidebar-nav-icon">📖</span>
                    <span class="menu-text">{{ __('lms.nav.report_classes') }}</span>
                </a>
                <a href="{{ route('admin.reports.grades') }}"
                   class="sidebar-nav-link {{ request()->routeIs('admin.reports.grades*') ? 'sidebar-nav-link--active' : '' }}">
                    <span class="sidebar-nav-icon">📝</span>
                    <span class="menu-text">{{ __('lms.nav.report_grades') }}</span>
                </a>
                <a href="{{ route('admin.reports.attendance') }}"
                   class="sidebar-nav-link {{ request()->routeIs('admin.reports.attendance*') ? 'sidebar-nav-link--active' : '' }}">
                    <span class="sidebar-nav-icon">📅</span>
                    <span class="menu-text">{{ __('lms.nav.report_attendance') }}</span>
                </a>
                <a href="{{ route('admin.reports.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('admin.reports.index') || request()->routeIs('admin.reports.participants*') || request()->routeIs('admin.reports.instructors*') || request()->routeIs('admin.reports.certificates*') ? 'sidebar-nav-link--active' : '' }}">
                    <span class="sidebar-nav-icon">📈</span>
                    <span class="menu-text">{{ __('lms.nav.reports') }}</span>
                </a>
            @endif

            @if($role == 'instruktur')
                <a href="{{ route('instruktur.classes.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('instruktur.classes.*') ? 'sidebar-nav-link--active' : '' }}">
                    <span class="sidebar-nav-icon">🏫</span>
                    <span class="menu-text">{{ __('lms.nav.my_classes') }}</span>
                </a>
                <a href="{{ route('instruktur.certificates.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('instruktur.certificates.*') ? 'sidebar-nav-link--active' : '' }}">
                    <span class="sidebar-nav-icon">📜</span>
                    <span class="menu-text">{{ __('lms.nav.certificates') }}</span>
                </a>
            @endif

            @if($role == 'peserta')
                <a href="{{ route('peserta.classes.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('peserta.classes.*') ? 'sidebar-nav-link--active' : '' }}">
                    <span class="sidebar-nav-icon">🏫</span>
                    <span class="menu-text">{{ __('lms.nav.my_classes') }}</span>
                </a>
                <a href="{{ route('peserta.certificates.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('peserta.certificates.*') ? 'sidebar-nav-link--active' : '' }}">
                    <span class="sidebar-nav-icon">📜</span>
                    <span class="menu-text">{{ __('lms.nav.certificates') }}</span>
                </a>
            @endif
        </div>
    </div>

    <div class="border-t border-white/10 p-4">
        <div class="logo-text text-center">
            <p class="text-[10px] text-blue-200/70 uppercase tracking-wider">{{ __('lms.app_name') }}</p>
            <p class="text-[10px] text-blue-300/50 mt-0.5">{{ __('lms.version') }} 1.0</p>
        </div>
    </div>
</nav>
