@php

$activeClass =
'bg-white text-blue-900 shadow-lg font-semibold';

$normalClass =
'text-white hover:bg-white/10';

@endphp

<nav class="h-screen flex flex-col">


<!-- LOGO -->
<div class="px-3 py-5 border-b border-white/10">

    <div class="flex items-center justify-center">

        <div
            class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center text-2xl">

            🎓

        </div>

        <div class="logo-text ml-3">

            <h1 class="text-white text-xl font-bold">
                LMS BLKK
            </h1>

            <p class="text-blue-200 text-xs">
                Tanwiriyyah
            </p>

        </div>

    </div>

</div>

<!-- MENU -->
<div class="flex-1 px-3 py-4">

    <div class="space-y-2">

        <!-- DASHBOARD -->
        <a
            href="{{ route(auth()->user()->role.'.dashboard') }}"
            class="flex items-center gap-4 px-4 py-3 rounded-2xl transition
            {{ request()->routeIs(auth()->user()->role.'.dashboard') ? $activeClass : $normalClass }}">

            <span class="text-xl">📊</span>

            <span class="menu-text">
                Dashboard
            </span>

        </a>

        @if(auth()->user()->role == 'admin')

            <!-- USER MANAGEMENT -->
            <a
                href="{{ route('admin.users.index') }}"
                class="flex items-center gap-4 px-4 py-3 rounded-2xl transition
                {{ request()->routeIs('admin.users.*') ? $activeClass : $normalClass }}">

                <span class="text-xl">👥</span>

                <span class="menu-text">
                    User Management
                </span>

            </a>

            <a
                href="{{ route('admin.programs.index') }}"
                class="flex items-center gap-4 px-4 py-3 rounded-2xl transition
                {{ request()->routeIs('admin.programs.*') ? $activeClass : $normalClass }}">

                <span class="text-xl">📚</span>

                <span class="menu-text">
                    Training Programs
                </span>

            </a>

            <a href="#"
                class="flex items-center gap-4 px-4 py-3 rounded-2xl transition {{ $normalClass }}">

                <span class="text-xl">🏫</span>

                <span class="menu-text">
                    Classes
                </span>

            </a>

            <a href="#"
                class="flex items-center gap-4 px-4 py-3 rounded-2xl transition {{ $normalClass }}">

                <span class="text-xl">📖</span>

                <span class="menu-text">
                    Learning Materials
                </span>

            </a>

            <a href="#"
                class="flex items-center gap-4 px-4 py-3 rounded-2xl transition {{ $normalClass }}">

                <span class="text-xl">📝</span>

                <span class="menu-text">
                    Assignments
                </span>

            </a>

            <a href="#"
                class="flex items-center gap-4 px-4 py-3 rounded-2xl transition {{ $normalClass }}">

                <span class="text-xl">📅</span>

                <span class="menu-text">
                    Attendance
                </span>

            </a>

            <a href="#"
                class="flex items-center gap-4 px-4 py-3 rounded-2xl transition {{ $normalClass }}">

                <span class="text-xl">📜</span>

                <span class="menu-text">
                    Certificates
                </span>

            </a>

            <a href="#"
                class="flex items-center gap-4 px-4 py-3 rounded-2xl transition {{ $normalClass }}">

                <span class="text-xl">📈</span>

                <span class="menu-text">
                    Reports
                </span>

            </a>

        @endif

        @if(auth()->user()->role == 'instruktur')

            <a href="#"
                class="flex items-center gap-4 px-4 py-3 rounded-2xl transition {{ $normalClass }}">

                <span class="text-xl">🏫</span>

                <span class="menu-text">
                    My Classes
                </span>

            </a>

            <a href="#"
                class="flex items-center gap-4 px-4 py-3 rounded-2xl transition {{ $normalClass }}">

                <span class="text-xl">📖</span>

                <span class="menu-text">
                    Learning Materials
                </span>

            </a>

            <a href="#"
                class="flex items-center gap-4 px-4 py-3 rounded-2xl transition {{ $normalClass }}">

                <span class="text-xl">📝</span>

                <span class="menu-text">
                    Assignments
                </span>

            </a>

            <a href="#"
                class="flex items-center gap-4 px-4 py-3 rounded-2xl transition {{ $normalClass }}">

                <span class="text-xl">📅</span>

                <span class="menu-text">
                    Attendance
                </span>

            </a>

            <a href="#"
                class="flex items-center gap-4 px-4 py-3 rounded-2xl transition {{ $normalClass }}">

                <span class="text-xl">🎯</span>

                <span class="menu-text">
                    Grades
                </span>

            </a>

        @endif

        @if(auth()->user()->role == 'peserta')

            <a href="#"
                class="flex items-center gap-4 px-4 py-3 rounded-2xl transition {{ $normalClass }}">

                <span class="text-xl">🏫</span>

                <span class="menu-text">
                    My Classes
                </span>

            </a>

            <a href="#"
                class="flex items-center gap-4 px-4 py-3 rounded-2xl transition {{ $normalClass }}">

                <span class="text-xl">📖</span>

                <span class="menu-text">
                    Learning Materials
                </span>

            </a>

            <a href="#"
                class="flex items-center gap-4 px-4 py-3 rounded-2xl transition {{ $normalClass }}">

                <span class="text-xl">📝</span>

                <span class="menu-text">
                    Assignments
                </span>

            </a>

            <a href="#"
                class="flex items-center gap-4 px-4 py-3 rounded-2xl transition {{ $normalClass }}">

                <span class="text-xl">📅</span>

                <span class="menu-text">
                    Attendance
                </span>

            </a>

            <a href="#"
                class="flex items-center gap-4 px-4 py-3 rounded-2xl transition {{ $normalClass }}">

                <span class="text-xl">🎯</span>

                <span class="menu-text">
                    Grades
                </span>

            </a>

            <a href="#"
                class="flex items-center gap-4 px-4 py-3 rounded-2xl transition {{ $normalClass }}">

                <span class="text-xl">📜</span>

                <span class="menu-text">
                    Certificates
                </span>

            </a>

        @endif

    </div>

</div>

<!-- FOOTER -->
<div class="border-t border-white/10 p-4">

    <div class="logo-text text-center">

        <p class="text-xs text-blue-300">
            LMS BLKK Tanwiriyyah
        </p>

        <p class="text-xs text-blue-400">
            Version 1.0
        </p>

    </div>

</div>


</nav>
