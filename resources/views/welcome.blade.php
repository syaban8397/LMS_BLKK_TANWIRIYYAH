<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>YMT Creator Base | Pusat Kreativitas & Skill Masa Depan</title>
    <meta name="description" content="YMT Creator Base – Ekosistem pembelajaran modern untuk mencetak talenta kreatif siap masa depan. #SkillUpFutureReady">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body {
            background: linear-gradient(135deg, #f0f9ff 0%, #e6f0fa 100%);
            overflow-x: hidden;
        }

        /* Animasi 3D utama */
        @keyframes fadeInUp3D {
            0% { opacity: 0; transform: translateY(40px) rotateX(10deg); }
            100% { opacity: 1; transform: translateY(0) rotateX(0); }
        }
        @keyframes cardPop3D {
            0% { opacity: 0; transform: scale(0.95) translateY(20px) rotateX(5deg); }
            100% { opacity: 1; transform: scale(1) translateY(0) rotateX(0); }
        }
        @keyframes fadeSlideUp {
            0% { opacity: 0; transform: translateY(15px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes float3D {
            0% { transform: translateY(0px) rotateX(0deg) rotateY(0deg); }
            50% { transform: translateY(-10px) rotateX(2deg) rotateY(2deg); }
            100% { transform: translateY(0px) rotateX(0deg) rotateY(0deg); }
        }

        /* Wrapper utama */
        .landing-wrapper {
            animation: fadeInUp3D 0.7s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        /* Kartu biru (statistik, program, dll) */
        .blue-card {
            background: rgba(255,255,255,0.95);
            border-radius: 2rem;
            border: 1px solid rgba(59,130,246,0.3);
            box-shadow: 0 20px 35px -12px rgba(0,0,0,0.1);
            transition: all 0.4s cubic-bezier(0.2,0.9,0.4,1.2);
            transform-style: preserve-3d;
            perspective: 1200px;
            animation: cardPop3D 0.6s ease forwards;
            opacity: 0;
        }
        .blue-card:hover {
            transform: translateY(-10px) rotateX(3deg) rotateY(2deg) scale(1.02);
            box-shadow: 0 30px 45px -15px rgba(0,0,0,0.25);
            border-color: rgba(37,99,235,0.6);
        }

        /* Glass hero kanan */
        .glass-blue {
            background: rgba(255,255,255,0.3);
            backdrop-filter: blur(12px);
            border-radius: 2rem;
            border: 1px solid rgba(59,130,246,0.4);
            transition: all 0.4s ease;
            animation: cardPop3D 0.6s ease forwards;
            opacity: 0;
        }
        .glass-blue:hover {
            transform: translateY(-8px) rotateX(2deg) rotateY(2deg);
            background: rgba(255,255,255,0.45);
            box-shadow: 0 25px 35px -12px rgba(0,0,0,0.2);
        }

        /* Tombol */
        .btn-primary {
            background: linear-gradient(135deg, #1e40af, #2563eb);
            color: white;
            transition: all 0.3s cubic-bezier(0.2,0.9,0.4,1.2);
            transform: translateY(0);
            box-shadow: 0 12px 20px -10px rgba(0,0,0,0.2);
        }
        .btn-primary:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 20px 30px -12px rgba(37,99,235,0.4);
            background: linear-gradient(135deg, #1e3a8a, #1d4ed8);
        }
        .btn-outline {
            background: rgba(255,255,255,0.8);
            backdrop-filter: blur(4px);
            border: 1px solid #93c5fd;
            color: #1e3a8a;
            transition: all 0.3s;
        }
        .btn-outline:hover {
            background: white;
            transform: translateY(-4px) scale(1.02);
            border-color: #2563eb;
            box-shadow: 0 15px 25px -12px rgba(0,0,0,0.15);
        }

        /* Navbar */
        .navbar {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 2px 20px rgba(0,0,0,0.03);
        }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #dbeafe; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #2563eb; border-radius: 10px; }

        .gradient-blue {
            background: linear-gradient(120deg, #1e40af, #3b82f6, #60a5fa);
            background-size: 200% auto;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: shimmer 5s linear infinite;
        }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }

        /* Stagger delay untuk kartu hero (4 buah) */
        .glass-blue:nth-child(1) { animation-delay: 0.1s; }
        .glass-blue:nth-child(2) { animation-delay: 0.2s; }
        .glass-blue:nth-child(3) { animation-delay: 0.3s; }
        .glass-blue:nth-child(4) { animation-delay: 0.4s; }

        /* Stagger untuk statistik */
        .stat-card { animation: cardPop3D 0.5s ease forwards; opacity: 0; }
        .stat-card:nth-child(1) { animation-delay: 0.05s; }
        .stat-card:nth-child(2) { animation-delay: 0.1s; }
        .stat-card:nth-child(3) { animation-delay: 0.15s; }
        .stat-card:nth-child(4) { animation-delay: 0.2s; }

        /* Stagger untuk program cards */
        .program-card { animation: cardPop3D 0.5s ease forwards; opacity: 0; }
        .program-card:nth-child(1) { animation-delay: 0.25s; }
        .program-card:nth-child(2) { animation-delay: 0.3s; }
        .program-card:nth-child(3) { animation-delay: 0.35s; }
        .program-card:nth-child(4) { animation-delay: 0.4s; }
        .program-card:nth-child(5) { animation-delay: 0.45s; }
        .program-card:nth-child(6) { animation-delay: 0.5s; }

        /* Stagger fasilitas */
        .facility-card { animation: cardPop3D 0.5s ease forwards; opacity: 0; }
        .facility-card:nth-child(1) { animation-delay: 0.4s; }
        .facility-card:nth-child(2) { animation-delay: 0.45s; }
        .facility-card:nth-child(3) { animation-delay: 0.5s; }
        .facility-card:nth-child(4) { animation-delay: 0.55s; }
    </style>
</head>
<body>

    <!-- Navbar dengan Logo Besar -->
    <nav class="navbar fixed top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="h-20 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('storage/images/Logo.png') }}" alt="YMT Creator Base" class="h-14 w-auto drop-shadow-lg">
                </div>
                <div class="hidden lg:flex items-center gap-8">
                    <a href="#tentang" class="text-slate-700 hover:text-blue-700 font-medium transition transform hover:-translate-y-0.5">Tentang</a>
                    <a href="#program" class="text-slate-700 hover:text-blue-700 font-medium transition transform hover:-translate-y-0.5">Program</a>
                    <a href="#fasilitas" class="text-slate-700 hover:text-blue-700 font-medium transition transform hover:-translate-y-0.5">Fasilitas</a>
                    <a href="#kontak" class="text-slate-700 hover:text-blue-700 font-medium transition transform hover:-translate-y-0.5">Kontak</a>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl text-blue-700 font-semibold hover:bg-blue-50 transition btn-outline">Login</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-700 to-blue-800 text-white font-semibold shadow-md hover:shadow-lg transition btn-primary">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="landing-wrapper">
        <!-- Hero Section -->
        <section class="relative pt-36 pb-24 overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 lg:px-10 relative z-10">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Kiri -->
                    <div style="animation: fadeSlideUp 0.6s ease forwards 0.05s; opacity: 0;">
                        <span class="inline-flex px-4 py-2 rounded-full bg-blue-100 text-blue-800 text-sm font-semibold">
                            <i class="fas fa-certificate mr-2 text-blue-600"></i> Powered by BLKK | Kemnaker RI
                        </span>
                        <h1 class="text-5xl lg:text-6xl font-extrabold mt-8 leading-tight">
                            <span class="gradient-blue">YMT Creator Base</span><br>
                            <span class="text-slate-800">#SkillUpFutureReady</span>
                        </h1>
                        <p class="mt-6 text-lg text-slate-600 leading-relaxed max-w-xl">
                            Pusat pengembangan kreativitas dan keterampilan masa depan. Bangun kompetensi, ciptakan karya, raih kesiapan menghadapi dunia industri.
                        </p>
                        <div class="flex flex-wrap gap-5 mt-10">
                            <a href="{{ route('register') }}" class="px-8 py-4 rounded-2xl bg-gradient-to-r from-blue-700 to-blue-800 text-white font-bold shadow-xl hover:shadow-2xl transition transform hover:-translate-y-1 btn-primary">
                                Daftar Sekarang <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                            <a href="{{ route('login') }}" class="px-8 py-4 rounded-2xl border border-blue-300 bg-white/60 backdrop-blur-sm text-blue-700 font-semibold hover:bg-white transition transform hover:-translate-y-1 btn-outline">
                                Masuk LMS
                            </a>
                        </div>
                    </div>

                    <!-- Kanan: Kartu 2x2 -->
                    <div class="relative">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="glass-blue p-6 text-center"><div class="text-5xl mb-3">🎨</div><h3 class="font-bold text-xl text-blue-800">Kreativitas</h3><p class="text-blue-700 text-sm mt-1">Eksplorasi ide tanpa batas</p></div>
                            <div class="glass-blue p-6 text-center"><div class="text-5xl mb-3">🚀</div><h3 class="font-bold text-xl text-blue-800">Skill Up</h3><p class="text-blue-700 text-sm mt-1">Tingkatkan kompetensi</p></div>
                            <div class="glass-blue p-6 text-center"><div class="text-5xl mb-3">💼</div><h3 class="font-bold text-xl text-blue-800">Future Ready</h3><p class="text-blue-700 text-sm mt-1">Siap hadapi masa depan</p></div>
                            <div class="glass-blue p-6 text-center"><div class="text-5xl mb-3">🎓</div><h3 class="font-bold text-xl text-blue-800">Sertifikasi</h3><p class="text-blue-700 text-sm mt-1">Diakui industri</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tentang -->
        <section id="tentang" class="py-24 bg-white/50">
            <div class="max-w-7xl mx-auto px-6 lg:px-10">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div style="animation: fadeSlideUp 0.6s ease forwards 0.1s; opacity:0;">
                        <span class="text-blue-700 font-bold uppercase tracking-wider">Tentang Kami</span>
                        <h2 class="text-4xl lg:text-5xl font-extrabold mt-4 text-slate-800">YMT Creator Base <span class="gradient-blue">#SkillUpFutureReady</span></h2>
                        <p class="mt-6 text-lg text-slate-600">YMT Creator Base merupakan identitas baru dari BLKK Tanwiriyyah, pusat pengembangan keterampilan dan talenta kreatif yang didukung oleh program Balai Latihan Kerja Komunitas (BLKK) Kementerian Ketenagakerjaan RI.</p>
                        <p class="mt-6 text-lg text-slate-600">Kami hadir sebagai ruang belajar, berkarya, dan bertumbuh bagi generasi muda. Dengan pendekatan modern, kolaboratif, dan berbasis praktik nyata.</p>
                    </div>
                    <div class="blue-card p-10" style="animation-delay: 0.15s;">
                        <div class="bg-gradient-to-br from-blue-800 to-blue-900 rounded-3xl p-10 text-white shadow-2xl">
                            <h3 class="text-3xl font-bold">Visi</h3>
                            <p class="mt-5 text-blue-100">Menjadi pusat pengembangan talenta kreatif terdepan yang mencetak individu adaptif, produktif, dan siap menghadapi dinamika industri kreatif.</p>
                            <hr class="my-8 border-white/20">
                            <h3 class="text-3xl font-bold">Misi</h3>
                            <ul class="mt-5 space-y-3 text-blue-100">
                                <li><i class="fas fa-check-circle mr-2 text-blue-300"></i> Pelatihan berbasis kompetensi kreatif.</li>
                                <li><i class="fas fa-check-circle mr-2 text-blue-300"></i> Ekosistem teori & praktik seimbang.</li>
                                <li><i class="fas fa-check-circle mr-2 text-blue-300"></i> Kemandirian melalui portofolio dan proyek nyata.</li>
                                <li><i class="fas fa-check-circle mr-2 text-blue-300"></i> Talenta siap kerja dan wirausaha digital.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Statistik -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-6 lg:px-10">
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="stat-card blue-card p-8 text-center"><div class="text-5xl mb-4">👨‍🎨</div><h3 class="text-4xl font-extrabold text-blue-700">500+</h3><p class="mt-3 text-slate-500">Alumni Kreatif</p></div>
                    <div class="stat-card blue-card p-8 text-center"><div class="text-5xl mb-4">📚</div><h3 class="text-4xl font-extrabold text-blue-700">20+</h3><p class="mt-3 text-slate-500">Program Pelatihan</p></div>
                    <div class="stat-card blue-card p-8 text-center"><div class="text-5xl mb-4">🎯</div><h3 class="text-4xl font-extrabold text-blue-700">92%</h3><p class="mt-3 text-slate-500">Tingkat Kepuasan</p></div>
                    <div class="stat-card blue-card p-8 text-center"><div class="text-5xl mb-4">🏆</div><h3 class="text-4xl font-extrabold text-blue-700">100+</h3><p class="mt-3 text-slate-500">Sertifikasi Terbit</p></div>
                </div>
            </div>
        </section>

        <!-- Program Unggulan -->
        <section id="program" class="py-24 bg-blue-50">
            <div class="max-w-7xl mx-auto px-6 lg:px-10 text-center">
                <span class="text-blue-700 font-bold uppercase">Program Unggulan</span>
                <h2 class="text-5xl font-extrabold mt-4 text-slate-800">Bidang Kompetensi Kreatif</h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-16">
                    <div class="program-card blue-card p-8">
                        <div class="text-5xl">📈</div>
                        <h3 class="text-2xl font-bold mt-6">Digital Marketing</h3>
                        <p class="mt-4 text-slate-600">Strategi pemasaran digital, media sosial, dan evaluasi skema kompetensi.</p>
                    </div>
                    <div class="program-card blue-card p-8">
                        <div class="text-5xl">🎬</div>
                        <h3 class="text-2xl font-bold mt-6">Content Creator</h3>
                        <p class="mt-4 text-slate-600">Produksi konten kreatif, personal branding, dan strategi media sosial.</p>
                    </div>
                    <div class="program-card blue-card p-8">
                        <div class="text-5xl">🎨</div>
                        <h3 class="text-2xl font-bold mt-6">Desain Grafis</h3>
                        <p class="mt-4 text-slate-600">Desain visual, tipografi, layout, dan aplikasi tools desain profesional.</p>
                    </div>
                    <div class="program-card blue-card p-8">
                        <div class="text-5xl">💻</div>
                        <h3 class="text-2xl font-bold mt-6">Web Developer</h3>
                        <p class="mt-4 text-slate-600">Pengembangan website, frontend, dan dasar-dasar pemrograman web.</p>
                    </div>
                    <div class="program-card blue-card p-8">
                        <div class="text-5xl">📷</div>
                        <h3 class="text-2xl font-bold mt-6">Fotografi</h3>
                        <p class="mt-4 text-slate-600">Teknik fotografi, komposisi, editing, dan visual storytelling.</p>
                    </div>
                    <div class="program-card blue-card p-8">
                        <div class="text-5xl">🎤</div>
                        <h3 class="text-2xl font-bold mt-6">Public Speaking</h3>
                        <p class="mt-4 text-slate-600">Komunikasi efektif, presentasi, dan kepercayaan diri di depan publik.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Fasilitas -->
        <section id="fasilitas" class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-6 lg:px-10 text-center">
                <span class="text-blue-700 font-bold uppercase">Fasilitas</span>
                <h2 class="text-5xl font-extrabold mt-4 text-slate-800">Sarana Pendukung</h2>
                <p class="mt-6 text-lg text-slate-600 max-w-3xl mx-auto">Lingkungan belajar modern dengan fasilitas lengkap untuk mendukung kreativitas.</p>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mt-16">
                    <div class="facility-card blue-card p-8 text-center"><div class="text-5xl">💻</div><h3 class="font-bold text-xl mt-5">Lab. Creative</h3><p class="mt-3 text-slate-600">Perangkat iMac & PC spesialisasi kreatif.</p></div>
                    <div class="facility-card blue-card p-8 text-center"><div class="text-5xl">🎥</div><h3 class="font-bold text-xl mt-5">Studio Multimedia</h3><p class="mt-3 text-slate-600">Green screen, lighting, audio profesional.</p></div>
                    <div class="facility-card blue-card p-8 text-center"><div class="text-5xl">📶</div><h3 class="font-bold text-xl mt-5">Internet Gigabit</h3><p class="mt-3 text-slate-600">Akses cepat stabil.</p></div>
                    <div class="facility-card blue-card p-8 text-center"><div class="text-5xl">👨‍🏫</div><h3 class="font-bold text-xl mt-5">Mentor Ahli</h3><p class="mt-3 text-slate-600">Instruktur praktisi industri.</p></div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="py-24 bg-gradient-to-r from-blue-800 to-blue-900 text-white">
            <div class="max-w-5xl mx-auto text-center px-6">
                <h2 class="text-5xl font-extrabold">#SkillUpFutureReady</h2>
                <p class="mt-8 text-xl text-blue-100">Tingkatkan keterampilan, bangun portofolio, dan raih peluang karir di industri kreatif.</p>
                <div class="flex flex-wrap justify-center gap-5 mt-12">
                    <a href="{{ route('register') }}" class="px-8 py-4 rounded-2xl bg-white text-blue-800 font-bold shadow-xl hover:shadow-2xl transition transform hover:-translate-y-1 btn-primary">Daftar Sekarang <i class="fas fa-user-plus ml-2"></i></a>
                    <a href="{{ route('login') }}" class="px-8 py-4 rounded-2xl border border-white/30 bg-white/10 backdrop-blur-md font-semibold hover:bg-white/20 transition transform hover:-translate-y-1 btn-outline">Masuk LMS <i class="fas fa-sign-in-alt ml-2"></i></a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer id="kontak" class="bg-slate-900 text-slate-300">
            <div class="max-w-7xl mx-auto px-6 lg:px-10 py-16">
                <div class="grid lg:grid-cols-3 gap-12">
                    <div><img src="{{ asset('storage/images/Logo.png') }}" alt="YMT Creator Base" class="h-14 w-auto mb-4"><p>Pusat pengembangan kreativitas dan keterampilan masa depan.</p></div>
                    <div><h3 class="text-xl font-bold text-white">Tautan</h3><ul class="space-y-3 mt-5"><li><a href="#tentang" class="hover:text-blue-400 transition">Tentang</a></li><li><a href="#program" class="hover:text-blue-400 transition">Program</a></li><li><a href="#fasilitas" class="hover:text-blue-400 transition">Fasilitas</a></li></ul></div>
                    <div><h3 class="text-xl font-bold text-white">Kontak</h3><p>Jl. Ariawiratanudatar KM.05, Sindanglaka, Karangtengah, Cianjur 43281</p><p class="mt-2"><i class="fas fa-envelope mr-2"></i> info@ymtcreatorbase.id</p><p class="mt-2"><i class="fas fa-phone-alt mr-2"></i> +62 857 9570 0651</p></div>
                </div>
                <div class="border-t border-slate-800 mt-12 pt-8 text-center">© {{ date('Y') }} YMT Creator Base. Formerly BLKK Tanwiriyyah.</div>
            </div>
        </footer>
    </div>

    <script>
        // Optional: tambahan efek scroll atau interaksi jika diperlukan
        document.addEventListener('DOMContentLoaded', function() {});
    </script>
</body>
</html>