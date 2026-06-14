@php
$activeClass = 'bg-white/95 dark:bg-white/10 text-brand-900 dark:text-white shadow-3d-md font-semibold ring-1 ring-white/25 translate-x-0.5';
$normalClass = 'text-white/85 hover:bg-white/10 hover:shadow-3d-sm hover:translate-x-0.5';
$loaderLogo = asset('images/certificates/logo-blkk.png');
@endphp

<nav class="relative z-10 h-screen flex flex-col">
    <div class="px-3 py-5 border-b border-white/10">
        <div class="flex items-center justify-center">
            <div class="w-12 h-12 rounded-2xl bg-white/95 p-1.5 flex items-center justify-center shadow-3d-sm ring-1 ring-white/25 overflow-hidden">
                <img src="{{ $loaderLogo }}" alt="BLKK" class="w-full h-full object-contain">
            </div>
            <div class="logo-text ml-3">
                <h1 class="text-white text-lg font-bold tracking-tight">LMS BLKK</h1>
                <p class="text-blue-200/80 text-[10px] uppercase tracking-widest">Tanwiriyyah</p>
            </div>
        </div>
    </div>

    <div class="flex-1 px-3 py-4 overflow-y-auto">
        <div class="space-y-1.5">
            <a href="{{ route(auth()->user()->role.'.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs(auth()->user()->role.'.dashboard') ? $activeClass : $normalClass }}">
                <span class="text-lg w-6 text-center">📊</span>
                <span class="menu-text text-sm">Dashboard</span>
            </a>

            @if(auth()->user()->role == 'admin')
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.users.*') ? $activeClass : $normalClass }}">
                    <span class="text-lg w-6 text-center">👥</span>
                    <span class="menu-text text-sm">User Management</span>
                </a>
                <a href="{{ route('admin.programs.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.programs.*') ? $activeClass : $normalClass }}">
                    <span class="text-lg w-6 text-center">📚</span>
                    <span class="menu-text text-sm">Training Programs</span>
                </a>
                <a href="{{ route('admin.classes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.classes.*') ? $activeClass : $normalClass }}">
                    <span class="text-lg w-6 text-center">🏫</span>
                    <span class="menu-text text-sm">Classes</span>
                </a>
                <a href="{{ route('admin.announcements.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.announcements.*') ? $activeClass : $normalClass }}">
                    <span class="text-lg w-6 text-center">📢</span>
                    <span class="menu-text text-sm">Announcements</span>
                </a>
                <a href="{{ route('admin.certificates.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.certificates.*') ? $activeClass : $normalClass }}">
                    <span class="text-lg w-6 text-center">📜</span>
                    <span class="menu-text text-sm">Certificates</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ $normalClass }}">
                    <span class="text-lg w-6 text-center">📖</span>
                    <span class="menu-text text-sm">Learning Materials</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ $normalClass }}">
                    <span class="text-lg w-6 text-center">📝</span>
                    <span class="menu-text text-sm">Assignments</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ $normalClass }}">
                    <span class="text-lg w-6 text-center">📅</span>
                    <span class="menu-text text-sm">Attendance</span>
                </a>
                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.reports.*') ? $activeClass : $normalClass }}">
                    <span class="text-lg w-6 text-center">📈</span>
                    <span class="menu-text text-sm">Reports</span>
                </a>
            @endif

            @if(auth()->user()->role == 'instruktur')
                <a href="{{ route('instruktur.classes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('instruktur.classes.*') ? $activeClass : $normalClass }}">
                    <span class="text-lg w-6 text-center">🏫</span>
                    <span class="menu-text text-sm">My Classes</span>
                </a>
                <a href="{{ route('instruktur.certificates.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('instruktur.certificates.*') ? $activeClass : $normalClass }}">
                    <span class="text-lg w-6 text-center">📜</span>
                    <span class="menu-text text-sm">Certificates</span>
                </a>
            @endif

            @if(auth()->user()->role == 'peserta')
                <a href="{{ route('peserta.classes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('peserta.classes.*') ? $activeClass : $normalClass }}">
                    <span class="text-lg w-6 text-center">🏫</span>
                    <span class="menu-text text-sm">My Classes</span>
                </a>
                <a href="{{ route('peserta.certificates.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('peserta.certificates.*') ? $activeClass : $normalClass }}">
                    <span class="text-lg w-6 text-center">📜</span>
                    <span class="menu-text text-sm">Certificates</span>
                </a>
            @endif
        </div>
    </div>

    <div class="border-t border-white/10 p-4">
        <div class="logo-text text-center">
            <p class="text-[10px] text-blue-200/70 uppercase tracking-wider">LMS BLKK Tanwiriyyah</p>
            <p class="text-[10px] text-blue-300/50 mt-0.5">Version 1.0</p>
        </div>
    </div>
</nav>
