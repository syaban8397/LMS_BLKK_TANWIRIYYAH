<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>LMS BLKK Tanwiriyyah Cianjur | Modern Learning Platform</title>
    <meta name="description" content="Platform Learning Management System modern untuk pelatihan vokasi berkualitas.">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f0f9ff 0%, #e6f0fa 100%);
            overflow-x: hidden;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
            100% { transform: translateY(0px); }
        }

        @keyframes pulseGlow {
            0% { box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.08); }
            50% { box-shadow: 0 20px 40px -8px rgba(37, 99, 235, 0.15); }
            100% { box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.08); }
        }

        /* Modern Card */
        .modern-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.08);
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }

        .modern-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 25px 40px -12px rgba(0, 0, 0, 0.15);
        }

        /* Glass card for hero */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border-radius: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        /* Floating animation for specific cards */
        .float-card {
            animation: fadeInUp 0.6s ease-out forwards, float 5s ease-in-out infinite;
        }

        /* Stagger animation delays */
        .card-1 { animation-delay: 0.1s; }
        .card-2 { animation-delay: 0.2s; }
        .card-3 { animation-delay: 0.3s; }
        .card-4 { animation-delay: 0.4s; }
        .card-5 { animation-delay: 0.5s; }
        .card-6 { animation-delay: 0.6s; }

        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(120deg, #1e3c72, #2b4f8c, #0f2b4d);
            background-size: 200% auto;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: shimmer 6s linear infinite;
        }

        @keyframes shimmer {
            0% { background-position: 0% 50%; }
            100% { background-position: 200% 50%; }
        }

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #e2e8f0;
        }
        ::-webkit-scrollbar-thumb {
            background: #2b4f8c;
            border-radius: 10px;
        }
    </style>
</head>
<body class="antialiased">

    <!-- Navbar -->
    <nav class="navbar fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="h-20 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-blue-700 to-indigo-800 flex items-center justify-center text-white text-xl shadow-md">
                        🎓
                    </div>
                    <div>
                        <h1 class="font-bold text-lg text-slate-800">LMS BLKK Tanwiriyyah</h1>
                        <p class="text-xs text-slate-500">Balai Latihan Kerja Komunitas</p>
                    </div>
                </div>

                <div class="hidden lg:flex items-center gap-7">
                    <a href="#tentang" class="text-slate-600 hover:text-blue-700 font-medium transition">Tentang</a>
                    <a href="#program" class="text-slate-600 hover:text-blue-700 font-medium transition">Program</a>
                    <a href="#fasilitas" class="text-slate-600 hover:text-blue-700 font-medium transition">Fasilitas</a>
                    <a href="#kontak" class="text-slate-600 hover:text-blue-700 font-medium transition">Kontak</a>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl text-blue-700 font-semibold hover:bg-blue-50 transition">Login</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-700 to-indigo-800 text-white font-semibold shadow-md hover:shadow-lg transition">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-24 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="animate__animated" style="animation: fadeInUp 0.6s ease-out forwards;">
                    <span class="inline-flex px-4 py-2 rounded-full bg-white/60 backdrop-blur-sm text-blue-800 text-sm font-medium border border-white/40">
                        <i class="fas fa-certificate mr-2 text-blue-600"></i> Kementerian Ketenagakerjaan RI
                    </span>
                    <h1 class="text-5xl lg:text-7xl font-extrabold mt-8 leading-tight">
                        <span class="gradient-text">BLKK Tanwiriyyah</span><br>
                        <span class="text-slate-800">Cianjur</span>
                    </h1>
                    <p class="mt-8 text-xl text-slate-600 leading-relaxed max-w-xl">
                        Balai Latihan Kerja Komunitas yang berfokus pada peningkatan kompetensi, keterampilan, dan daya saing tenaga kerja melalui pelatihan vokasi berbasis kebutuhan industri.
                    </p>
                    <div class="flex flex-wrap gap-5 mt-10">
                        <a href="{{ route('register') }}" class="px-8 py-4 rounded-2xl bg-gradient-to-r from-blue-700 to-indigo-800 text-white font-bold shadow-xl hover:shadow-2xl transition transform hover:-translate-y-1">
                            Daftar Sekarang <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                        <a href="{{ route('login') }}" class="px-8 py-4 rounded-2xl border border-slate-300 bg-white/60 backdrop-blur-sm text-slate-700 font-semibold hover:bg-white transition transform hover:-translate-y-1">
                            Masuk LMS
                        </a>
                    </div>
                </div>

                <div class="relative">
                    <div class="grid grid-cols-2 gap-5">
                        <div class="glass-card p-6 text-center float-card card-1">
                            <div class="text-5xl mb-3">🎓</div>
                            <h3 class="font-bold text-xl text-slate-800">Pelatihan</h3>
                            <p class="text-slate-500 text-sm mt-1">Berbasis kompetensi kerja</p>
                        </div>
                        <div class="glass-card p-6 text-center float-card card-2">
                            <div class="text-5xl mb-3">🏆</div>
                            <h3 class="font-bold text-xl text-slate-800">Sertifikasi</h3>
                            <p class="text-slate-500 text-sm mt-1">Pengakuan kompetensi</p>
                        </div>
                        <div class="glass-card p-6 text-center float-card card-3">
                            <div class="text-5xl mb-3">💻</div>
                            <h3 class="font-bold text-xl text-slate-800">Multimedia</h3>
                            <p class="text-slate-500 text-sm mt-1">Kompetensi digital modern</p>
                        </div>
                        <div class="glass-card p-6 text-center float-card card-4">
                            <div class="text-5xl mb-3">🚀</div>
                            <h3 class="font-bold text-xl text-slate-800">Karir</h3>
                            <p class="text-slate-500 text-sm mt-1">Meningkatkan peluang kerja</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Section -->
    <section id="tentang" class="py-24 bg-white/50 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div style="animation: fadeInUp 0.6s ease-out forwards 0.1s; opacity: 0;">
                    <span class="text-blue-700 font-bold uppercase tracking-wider text-sm"><i class="fas fa-info-circle mr-1"></i> Tentang BLKK</span>
                    <h2 class="text-4xl lg:text-5xl font-extrabold mt-4 text-slate-800">BLKK Tanwiriyyah <span class="gradient-text">Cianjur</span></h2>
                    <p class="mt-8 text-lg text-slate-600 leading-relaxed">
                        Balai Latihan Kerja Komunitas (BLKK) Tanwiriyyah Cianjur merupakan lembaga pelatihan vokasi yang didukung oleh Kementerian Ketenagakerjaan Republik Indonesia.
                    </p>
                    <p class="mt-6 text-lg text-slate-600 leading-relaxed">
                        BLKK hadir sebagai sarana pengembangan kompetensi masyarakat agar memiliki keterampilan kerja yang relevan dengan kebutuhan dunia industri serta mampu menciptakan peluang usaha secara mandiri.
                    </p>
                    <p class="mt-6 text-lg text-slate-600 leading-relaxed">
                        Melalui pelatihan berbasis kompetensi, peserta memperoleh pengalaman belajar yang terstruktur, praktik langsung, serta pendampingan dari instruktur yang berpengalaman.
                    </p>
                </div>
                <div class="modern-card p-10" style="animation-delay: 0.2s;">
                    <div class="bg-gradient-to-br from-blue-800 to-indigo-900 rounded-3xl p-10 text-white shadow-2xl">
                        <h3 class="text-3xl font-bold">Visi</h3>
                        <p class="mt-5 text-blue-100 leading-relaxed">
                            Menjadi pusat pelatihan kerja komunitas yang unggul dalam mencetak sumber daya manusia kompeten, produktif, dan berdaya saing tinggi.
                        </p>
                        <hr class="my-8 border-white/20">
                        <h3 class="text-3xl font-bold">Misi</h3>
                        <ul class="mt-5 space-y-3 text-blue-100">
                            <li class="flex items-start gap-2"><i class="fas fa-check-circle mt-1"></i> Menyelenggarakan pelatihan berbasis kompetensi.</li>
                            <li class="flex items-start gap-2"><i class="fas fa-check-circle mt-1"></i> Mendukung peningkatan keterampilan masyarakat.</li>
                            <li class="flex items-start gap-2"><i class="fas fa-check-circle mt-1"></i> Mendorong kemandirian ekonomi dan kewirausahaan.</li>
                            <li class="flex items-start gap-2"><i class="fas fa-check-circle mt-1"></i> Menyiapkan tenaga kerja yang siap bersaing.</li>
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
                <div class="modern-card p-8 text-center card-1">
                    <div class="text-5xl mb-4">👨‍🎓</div>
                    <h3 class="text-4xl font-extrabold text-blue-700">500+</h3>
                    <p class="mt-3 text-slate-500">Alumni Pelatihan</p>
                </div>
                <div class="modern-card p-8 text-center card-2">
                    <div class="text-5xl mb-4">📚</div>
                    <h3 class="text-4xl font-extrabold text-blue-700">20+</h3>
                    <p class="mt-3 text-slate-500">Kelas Pelatihan</p>
                </div>
                <div class="modern-card p-8 text-center card-3">
                    <div class="text-5xl mb-4">🎯</div>
                    <h3 class="text-4xl font-extrabold text-blue-700">90%</h3>
                    <p class="mt-3 text-slate-500">Tingkat Kelulusan</p>
                </div>
                <div class="modern-card p-8 text-center card-4">
                    <div class="text-5xl mb-4">🏆</div>
                    <h3 class="text-4xl font-extrabold text-blue-700">100+</h3>
                    <p class="mt-3 text-slate-500">Sertifikasi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Section -->
    <section id="program" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="text-center">
                <span class="text-blue-700 font-bold uppercase tracking-wider">Program Pelatihan</span>
                <h2 class="text-5xl font-extrabold mt-4 text-slate-800">Bidang Kompetensi</h2>
                <p class="max-w-3xl mx-auto mt-6 text-slate-600 text-lg">
                    Program pelatihan yang diselenggarakan dirancang untuk memenuhi kebutuhan dunia kerja dan perkembangan teknologi.
                </p>
            </div>
            <div class="grid lg:grid-cols-3 gap-8 mt-16">
                <div class="modern-card p-8 border border-slate-100 card-1">
                    <div class="text-5xl">💻</div>
                    <h3 class="text-2xl font-bold mt-6 text-slate-800">Multimedia</h3>
                    <p class="mt-4 text-slate-600">Desain grafis, editing video, fotografi, dan produksi media digital.</p>
                </div>
                <div class="modern-card p-8 border border-slate-100 card-2">
                    <div class="text-5xl">🎥</div>
                    <h3 class="text-2xl font-bold mt-6 text-slate-800">Content Creator</h3>
                    <p class="mt-4 text-slate-600">Produksi konten kreatif, branding digital, dan pemasaran media sosial.</p>
                </div>
                <div class="modern-card p-8 border border-slate-100 card-3">
                    <div class="text-5xl">🌐</div>
                    <h3 class="text-2xl font-bold mt-6 text-slate-800">Teknologi Informasi</h3>
                    <p class="mt-4 text-slate-600">Kompetensi komputer, internet, aplikasi perkantoran, dan teknologi digital.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Fasilitas -->
    <section id="fasilitas" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="text-center">
                <span class="text-blue-700 font-bold uppercase tracking-wider">Fasilitas</span>
                <h2 class="text-5xl font-extrabold mt-4 text-slate-800">Sarana Pendukung Pelatihan</h2>
                <p class="mt-6 text-lg text-slate-600 max-w-3xl mx-auto">
                    Lingkungan belajar yang nyaman dan fasilitas pendukung yang memadai untuk meningkatkan efektivitas pelatihan.
                </p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mt-16">
                <div class="modern-card p-8 text-center card-1">
                    <div class="text-5xl">💻</div>
                    <h3 class="font-bold text-xl mt-5 text-slate-800">Lab. Komputer</h3>
                    <p class="mt-3 text-slate-600">Perangkat komputer untuk praktik digital.</p>
                </div>
                <div class="modern-card p-8 text-center card-2">
                    <div class="text-5xl">🎥</div>
                    <h3 class="font-bold text-xl mt-5 text-slate-800">Studio Multimedia</h3>
                    <p class="mt-3 text-slate-600">Produksi konten kreatif.</p>
                </div>
                <div class="modern-card p-8 text-center card-3">
                    <div class="text-5xl">📶</div>
                    <h3 class="font-bold text-xl mt-5 text-slate-800">Internet</h3>
                    <p class="mt-3 text-slate-600">Akses internet cepat.</p>
                </div>
                <div class="modern-card p-8 text-center card-4">
                    <div class="text-5xl">👨‍🏫</div>
                    <h3 class="font-bold text-xl mt-5 text-slate-800">Instruktur Kompeten</h3>
                    <p class="mt-3 text-slate-600">Dibimbing tenaga ahli.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Keunggulan & LMS -->
    <section class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div style="animation: fadeInUp 0.6s ease-out forwards 0.1s; opacity: 0;">
                    <span class="text-blue-700 font-bold uppercase tracking-wider">Mengapa Memilih Kami</span>
                    <h2 class="text-5xl font-extrabold mt-4 text-slate-800">Siapkan Masa Depan Bersama BLKK Tanwiriyyah</h2>
                    <div class="space-y-6 mt-10">
                        <div class="flex gap-4 group transition-all duration-300 hover:translate-x-2">
                            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-700 group-hover:bg-blue-200 transition"><i class="fas fa-check text-xl"></i></div>
                            <div>
                                <h3 class="font-bold text-lg text-slate-800">Pelatihan Berbasis Kompetensi</h3>
                                <p class="text-slate-600">Materi dirancang sesuai kebutuhan dunia kerja.</p>
                            </div>
                        </div>
                        <div class="flex gap-4 group transition-all duration-300 hover:translate-x-2">
                            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-700 group-hover:bg-blue-200 transition"><i class="fas fa-certificate text-xl"></i></div>
                            <div>
                                <h3 class="font-bold text-lg text-slate-800">Dukungan Sertifikasi</h3>
                                <p class="text-slate-600">Membantu meningkatkan kredibilitas kompetensi peserta.</p>
                            </div>
                        </div>
                        <div class="flex gap-4 group transition-all duration-300 hover:translate-x-2">
                            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-700 group-hover:bg-blue-200 transition"><i class="fas fa-desktop text-xl"></i></div>
                            <div>
                                <h3 class="font-bold text-lg text-slate-800">Lingkungan Belajar Modern</h3>
                                <p class="text-slate-600">Mendukung pembelajaran yang efektif dan nyaman.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modern-card p-10" style="animation-delay: 0.2s;">
                    <div class="bg-gradient-to-br from-blue-700 to-indigo-800 rounded-3xl p-10 text-white shadow-2xl">
                        <h3 class="text-4xl font-extrabold">LMS BLKK Tanwiriyyah</h3>
                        <p class="mt-6 text-blue-100 leading-relaxed text-lg">
                            Sistem Learning Management System yang membantu peserta, instruktur, dan administrator mengelola proses pembelajaran secara efektif, transparan, dan terintegrasi.
                        </p>
                        <a href="{{ route('register') }}" class="inline-block mt-10 px-8 py-4 bg-white text-blue-700 rounded-2xl font-bold shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">Mulai Belajar <i class="fas fa-arrow-right ml-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-24 bg-gradient-to-r from-blue-800 to-indigo-900 text-white">
        <div class="max-w-5xl mx-auto text-center px-6">
            <h2 class="text-5xl font-extrabold">Tingkatkan Kompetensi Anda Hari Ini</h2>
            <p class="mt-8 text-xl text-blue-100">Bergabung bersama BLKK Tanwiriyyah Cianjur dan kembangkan keterampilan untuk masa depan yang lebih baik.</p>
            <div class="flex flex-wrap justify-center gap-5 mt-12">
                <a href="{{ route('register') }}" class="px-8 py-4 rounded-2xl bg-white text-blue-700 font-bold shadow-xl hover:shadow-2xl transition transform hover:-translate-y-1">Register <i class="fas fa-user-plus ml-2"></i></a>
                <a href="{{ route('login') }}" class="px-8 py-4 rounded-2xl border border-white/30 bg-white/10 backdrop-blur-md font-semibold hover:bg-white/20 transition transform hover:-translate-y-1">Login <i class="fas fa-sign-in-alt ml-2"></i></a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="bg-slate-900 text-slate-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-16">
            <div class="grid lg:grid-cols-3 gap-12">
                <div>
                    <h3 class="text-2xl font-bold text-white">BLKK Tanwiriyyah</h3>
                    <p class="mt-5 leading-relaxed">Balai Latihan Kerja Komunitas yang mendukung peningkatan kualitas sumber daya manusia melalui pelatihan dan pengembangan kompetensi kerja.</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">Menu</h3>
                    <ul class="space-y-3 mt-5">
                        <li><a href="#tentang" class="hover:text-white transition">Tentang</a></li>
                        <li><a href="#program" class="hover:text-white transition">Program</a></li>
                        <li><a href="#fasilitas" class="hover:text-white transition">Fasilitas</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">Informasi</h3>
                    <p class="mt-5">Kabupaten Cianjur, Jawa Barat, Indonesia</p>
                    <p class="mt-2"><i class="fas fa-envelope mr-2"></i> info@blkk-tanwiriyyah.id</p>
                    <p class="mt-2"><i class="fas fa-phone-alt mr-2"></i> +62 812 3456 7890</p>
                </div>
            </div>
            <div class="border-t border-slate-800 mt-12 pt-8 text-center text-slate-500">
                © {{ date('Y') }} LMS BLKK Tanwiriyyah Cianjur. All Rights Reserved.
            </div>
        </div>
    </footer>

    <script>
        // Optional: tambahkan efek scroll reveal sederhana jika diperlukan, tapi sudah ada fadeInUp
        document.addEventListener('DOMContentLoaded', function() {
            // Semua card sudah memiliki animasi fadeInUp dengan delay
        });
    </script>
</body>
</html>