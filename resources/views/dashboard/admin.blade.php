<x-app-layout>
    <style>
        /* Animasi 3D untuk container utama */
        @keyframes fadeInUp3D {
            0% {
                opacity: 0;
                transform: translateY(30px) rotateX(10deg);
            }
            100% {
                opacity: 1;
                transform: translateY(0) rotateX(0);
            }
        }

        /* Animasi untuk setiap card (staggered) */
        @keyframes cardPop3D {
            0% {
                opacity: 0;
                transform: scale(0.9) translateY(20px) rotateX(5deg);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0) rotateX(0);
            }
        }

        /* Wrapper utama dengan perspektif 3D */
        .dashboard-wrapper {
            animation: fadeInUp3D 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
            transform-style: preserve-3d;
            perspective: 800px;
        }

        /* Efek 3D pada card (hover dan animasi masuk) */
        .dashboard-card {
            animation: cardPop3D 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            opacity: 0; /* default hidden, animasi akan muncul */
            transform-style: preserve-3d;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.2);
        }

        /* Staggered delay untuk card pertama sampai keempat */
        .dashboard-card:nth-child(1) { animation-delay: 0.1s; }
        .dashboard-card:nth-child(2) { animation-delay: 0.2s; }
        .dashboard-card:nth-child(3) { animation-delay: 0.3s; }
        .dashboard-card:nth-child(4) { animation-delay: 0.4s; }

        /* Efek hover 3D pada card */
        .dashboard-card:hover {
            transform: translateY(-8px) rotateX(3deg) rotateY(2deg) scale(1.02);
            box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        /* Untuk section lain yang juga ingin efek muncul */
        .analytics-card {
            animation: cardPop3D 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            opacity: 0;
            animation-delay: 0.5s;
        }

        .program-stats-card {
            animation: cardPop3D 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            opacity: 0;
            animation-delay: 0.6s;
        }
    </style>

    <div class="dashboard-wrapper space-y-8">
        <!-- Welcome Section (simple) -->
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
            <p class="text-slate-500 mt-1">Selamat datang kembali, {{ auth()->user()->name }}. Berikut ringkasan aktivitas LMS.</p>
        </div>

        <!-- KPI Cards Grid - 4 cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="dashboard-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Total Peserta</p>
                        <h3 class="text-3xl font-bold text-blue-600 counter mt-1" data-value="{{ $participants ?? 0 }}">0</h3>
                        <p class="text-xs text-green-500 mt-2">▲ +12% dari bulan lalu</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-2xl">👨‍🎓</div>
                </div>
            </div>
            <div class="dashboard-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Instruktur Aktif</p>
                        <h3 class="text-3xl font-bold text-green-600 counter mt-1" data-value="{{ $instructors ?? 0 }}">0</h3>
                        <p class="text-xs text-green-500 mt-2">▲ +3%</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center text-2xl">👨‍🏫</div>
                </div>
            </div>
            <div class="dashboard-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Kelas Berjalan</p>
                        <h3 class="text-3xl font-bold text-purple-600 counter mt-1" data-value="{{ $classes ?? 0 }}">0</h3>
                        <p class="text-xs text-blue-500 mt-2">● Semester ini</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center text-2xl">🏫</div>
                </div>
            </div>
            <div class="dashboard-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Sertifikat Terbit</p>
                        <h3 class="text-3xl font-bold text-orange-500 counter mt-1" data-value="{{ $certificates ?? 0 }}">0</h3>
                        <p class="text-xs text-yellow-500 mt-2">★ Sepanjang tahun</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center text-2xl">📜</div>
                </div>
            </div>
        </div>

        <!-- Analytics & Performance Section -->
        <div class="grid lg:grid-cols-3 gap-6">
            <!-- Left: Activity Overview -->
            <div class="lg:col-span-2 analytics-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                        <span>📊</span> Aktivitas Terkini
                    </h3>
                    <span id="lastUpdate" class="text-xs text-slate-400 bg-slate-100 px-3 py-1 rounded-full">Memuat...</span>
                </div>
                <div class="space-y-5">
                    <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                        <span class="text-slate-600">Sesi Kehadiran</span>
                        <span class="font-semibold text-slate-800" id="attendanceSessions">{{ $attendanceSessions ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                        <span class="text-slate-600">Total Kehadiran</span>
                        <span class="font-semibold text-slate-800" id="attendances">{{ $attendances ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                        <span class="text-slate-600">Nilai Diproses</span>
                        <span class="font-semibold text-slate-800" id="grades">{{ $grades ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Notifikasi Terkirim</span>
                        <span class="font-semibold text-slate-800" id="notifications">{{ $notifications ?? 0 }}</span>
                    </div>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Rata-rata Kehadiran per Kelas</span>
                        <span class="font-medium text-slate-700">84%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2 mt-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 84%"></div>
                    </div>
                </div>
            </div>

            <!-- Right: System Health -->
            <div class="analytics-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <h3 class="font-bold text-slate-800 text-lg mb-5 flex items-center gap-2">
                    <span>⚙️</span> Kinerja Sistem
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl">
                        <span class="text-slate-600 text-sm">API Server</span>
                        <span class="text-green-600 font-semibold text-sm">Operasional</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl">
                        <span class="text-slate-600 text-sm">Database</span>
                        <span class="text-green-600 font-semibold text-sm">Terhubung</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl">
                        <span class="text-slate-600 text-sm">Realtime Engine</span>
                        <span class="text-green-600 font-semibold text-sm">Aktif</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl">
                        <span class="text-slate-600 text-sm">Uptime (Hari Ini)</span>
                        <span class="text-blue-600 font-semibold text-sm">99.98%</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl">
                        <span class="text-slate-600 text-sm">Response Time Rata-rata</span>
                        <span class="text-blue-600 font-semibold text-sm">124 ms</span>
                    </div>
                </div>
                <div class="mt-5 pt-3 border-t border-slate-100 text-center">
                    <span class="text-green-600 text-xs font-medium">✓ Semua sistem berjalan normal</span>
                </div>
            </div>
        </div>

        <!-- Additional Stats: Enrollment by Program -->
        <div class="program-stats-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <h3 class="font-bold text-slate-800 text-lg mb-5 flex items-center gap-2">
                <span>📋</span> Distribusi Peserta per Program
            </h3>
            <div class="grid md:grid-cols-3 gap-5">
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-slate-600">Multimedia</span>
                        <span class="font-medium">156 Peserta</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 65%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-slate-600">Content Creator</span>
                        <span class="font-medium">98 Peserta</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: 41%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-slate-600">Teknologi Informasi</span>
                        <span class="font-medium">127 Peserta</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="bg-purple-500 h-2 rounded-full" style="width: 53%"></div>
                    </div>
                </div>
            </div>
            <div class="mt-5 text-right">
                <a href="{{ route('admin.programs.index') }}" class="text-sm text-blue-600 hover:underline">Lihat detail program →</a>
            </div>
        </div>
    </div>

    <script>
        function animateCounter(el, value) {
            let start = 0;
            let end = parseInt(value);
            let step = Math.ceil(end / 40);
            let interval = setInterval(() => {
                start += step;
                if (start >= end) {
                    start = end;
                    clearInterval(interval);
                }
                el.innerText = start;
            }, 20);
        }

        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll('.counter').forEach(el => {
                animateCounter(el, el.dataset.value);
            });
            setInterval(() => {
                const updateEl = document.getElementById('lastUpdate');
                if (updateEl) updateEl.innerText = "Diperbarui: " + new Date().toLocaleTimeString('id-ID');
            }, 1000);
        });
    </script>
</x-app-layout>