<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LMS BLKK Tanwiriyyah Cianjur</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-slate-50 text-slate-800">

    <!-- NAVBAR -->
    <nav
        class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200">

        <div
            class="max-w-7xl mx-auto px-6 lg:px-10">

            <div
                class="h-20 flex items-center justify-between">

                <div class="flex items-center gap-4">

                    <div
                        class="w-12 h-12 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-700 flex items-center justify-center text-white text-xl shadow-lg">

                        🎓

                    </div>

                    <div>

                        <h1
                            class="font-bold text-lg text-slate-800">

                            LMS BLKK Tanwiriyyah

                        </h1>

                        <p
                            class="text-xs text-slate-500">

                            Balai Latihan Kerja Komunitas

                        </p>

                    </div>

                </div>

                <div
                    class="hidden lg:flex items-center gap-8">

                    <a href="#tentang"
                        class="text-slate-600 hover:text-blue-600 font-medium">
                        Tentang
                    </a>

                    <a href="#program"
                        class="text-slate-600 hover:text-blue-600 font-medium">
                        Program
                    </a>

                    <a href="#fasilitas"
                        class="text-slate-600 hover:text-blue-600 font-medium">
                        Fasilitas
                    </a>

                    <a href="#kontak"
                        class="text-slate-600 hover:text-blue-600 font-medium">
                        Kontak
                    </a>

                </div>

                <div class="flex items-center gap-3">

                    <a
                        href="{{ route('login') }}"
                        class="px-5 py-2.5 rounded-xl border border-blue-600 text-blue-600 hover:bg-blue-50 font-semibold">

                        Login

                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-semibold shadow-lg">

                        Register

                    </a>

                </div>

            </div>

        </div>

    </nav>

    <!-- HERO -->
    <section
        class="pt-32 pb-24 bg-gradient-to-br from-blue-900 via-indigo-800 to-sky-900 text-white overflow-hidden">

        <div
            class="max-w-7xl mx-auto px-6 lg:px-10">

            <div
                class="grid lg:grid-cols-2 gap-16 items-center">

                <div>

                    <span
                        class="inline-flex px-4 py-2 rounded-full bg-white/10 border border-white/20 text-sm">

                        Kementerian Ketenagakerjaan RI
                    </span>

                    <h1
                        class="text-5xl lg:text-7xl font-extrabold mt-8 leading-tight">

                        BLKK
                        <br>
                        Tanwiriyyah
                        <br>
                        Cianjur

                    </h1>

                    <p
                        class="mt-8 text-xl text-blue-100 leading-relaxed">

                        Balai Latihan Kerja Komunitas yang berfokus
                        pada peningkatan kompetensi, keterampilan,
                        dan daya saing tenaga kerja melalui
                        pelatihan vokasi berbasis kebutuhan industri.

                    </p>

                    <div
                        class="flex flex-wrap gap-4 mt-10">

                        <a
                            href="{{ route('register') }}"
                            class="px-8 py-4 rounded-2xl bg-white text-blue-700 font-bold shadow-xl">

                            Daftar Sekarang

                        </a>

                        <a
                            href="{{ route('login') }}"
                            class="px-8 py-4 rounded-2xl border border-white/30 bg-white/10 backdrop-blur-md font-semibold">

                            Masuk LMS

                        </a>

                    </div>

                </div>

                <div>

                    <div
                        class="grid grid-cols-2 gap-6">

                        <div
                            class="bg-white/10 backdrop-blur-md rounded-3xl p-6 border border-white/20">

                            <div class="text-5xl mb-4">
                                🎓
                            </div>

                            <h3
                                class="font-bold text-xl">
                                Pelatihan
                            </h3>

                            <p
                                class="text-blue-100 mt-2">
                                Berbasis kompetensi kerja.
                            </p>

                        </div>

                        <div
                            class="bg-white/10 backdrop-blur-md rounded-3xl p-6 border border-white/20">

                            <div class="text-5xl mb-4">
                                🏆
                            </div>

                            <h3
                                class="font-bold text-xl">
                                Sertifikasi
                            </h3>

                            <p
                                class="text-blue-100 mt-2">
                                Mendukung pengakuan kompetensi.
                            </p>

                        </div>

                        <div
                            class="bg-white/10 backdrop-blur-md rounded-3xl p-6 border border-white/20">

                            <div class="text-5xl mb-4">
                                💻
                            </div>

                            <h3
                                class="font-bold text-xl">
                                Multimedia
                            </h3>

                            <p
                                class="text-blue-100 mt-2">
                                Kompetensi digital modern.
                            </p>

                        </div>

                        <div
                            class="bg-white/10 backdrop-blur-md rounded-3xl p-6 border border-white/20">

                            <div class="text-5xl mb-4">
                                🚀
                            </div>

                            <h3
                                class="font-bold text-xl">
                                Karir
                            </h3>

                            <p
                                class="text-blue-100 mt-2">
                                Meningkatkan peluang kerja.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>
        <!-- ABOUT -->
    <section
        id="tentang"
        class="py-24 bg-white">

        <div
            class="max-w-7xl mx-auto px-6 lg:px-10">

            <div
                class="grid lg:grid-cols-2 gap-16 items-center">

                <div>

                    <span
                        class="text-blue-600 font-bold uppercase tracking-wider">

                        Tentang BLKK

                    </span>

                    <h2
                        class="text-4xl lg:text-5xl font-extrabold mt-4 text-slate-800">

                        BLKK Tanwiriyyah Cianjur

                    </h2>

                    <p
                        class="mt-8 text-lg text-slate-600 leading-relaxed">

                        Balai Latihan Kerja Komunitas (BLKK)
                        Tanwiriyyah Cianjur merupakan lembaga
                        pelatihan vokasi yang didukung oleh
                        Kementerian Ketenagakerjaan Republik Indonesia.

                    </p>

                    <p
                        class="mt-6 text-lg text-slate-600 leading-relaxed">

                        BLKK hadir sebagai sarana pengembangan
                        kompetensi masyarakat agar memiliki
                        keterampilan kerja yang relevan dengan
                        kebutuhan dunia industri serta mampu
                        menciptakan peluang usaha secara mandiri.

                    </p>

                    <p
                        class="mt-6 text-lg text-slate-600 leading-relaxed">

                        Melalui pelatihan berbasis kompetensi,
                        peserta memperoleh pengalaman belajar
                        yang terstruktur, praktik langsung,
                        serta pendampingan dari instruktur
                        yang berpengalaman.

                    </p>

                </div>

                <div>

                    <div
                        class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl p-10 text-white shadow-2xl">

                        <h3
                            class="text-3xl font-bold">

                            Visi

                        </h3>

                        <p
                            class="mt-5 text-blue-100 leading-relaxed">

                            Menjadi pusat pelatihan kerja
                            komunitas yang unggul dalam
                            mencetak sumber daya manusia
                            kompeten, produktif, dan
                            berdaya saing tinggi.

                        </p>

                        <hr
                            class="my-8 border-white/20">

                        <h3
                            class="text-3xl font-bold">

                            Misi

                        </h3>

                        <ul
                            class="mt-5 space-y-4 text-blue-100">

                            <li>
                                ✓ Menyelenggarakan pelatihan
                                berbasis kompetensi.
                            </li>

                            <li>
                                ✓ Mendukung peningkatan
                                keterampilan masyarakat.
                            </li>

                            <li>
                                ✓ Mendorong kemandirian
                                ekonomi dan kewirausahaan.
                            </li>

                            <li>
                                ✓ Menyiapkan tenaga kerja
                                yang siap bersaing.
                            </li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- STATISTICS -->
    <section
        class="py-20 bg-slate-100">

        <div
            class="max-w-7xl mx-auto px-6 lg:px-10">

            <div
                class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">

                <div
                    class="bg-white rounded-3xl p-8 text-center shadow-lg">

                    <div
                        class="text-5xl mb-4">
                        👨‍🎓
                    </div>

                    <h3
                        class="text-4xl font-extrabold text-blue-700">

                        500+

                    </h3>

                    <p
                        class="mt-3 text-slate-500">

                        Alumni Pelatihan

                    </p>

                </div>

                <div
                    class="bg-white rounded-3xl p-8 text-center shadow-lg">

                    <div
                        class="text-5xl mb-4">
                        📚
                    </div>

                    <h3
                        class="text-4xl font-extrabold text-blue-700">

                        20+

                    </h3>

                    <p
                        class="mt-3 text-slate-500">

                        Kelas Pelatihan

                    </p>

                </div>

                <div
                    class="bg-white rounded-3xl p-8 text-center shadow-lg">

                    <div
                        class="text-5xl mb-4">
                        🎯
                    </div>

                    <h3
                        class="text-4xl font-extrabold text-blue-700">

                        90%

                    </h3>

                    <p
                        class="mt-3 text-slate-500">

                        Tingkat Kelulusan

                    </p>

                </div>

                <div
                    class="bg-white rounded-3xl p-8 text-center shadow-lg">

                    <div
                        class="text-5xl mb-4">
                        🏆
                    </div>

                    <h3
                        class="text-4xl font-extrabold text-blue-700">

                        100+

                    </h3>

                    <p
                        class="mt-3 text-slate-500">

                        Sertifikasi

                    </p>

                </div>

            </div>

        </div>

    </section>

    <!-- PROGRAM -->
    <section
        id="program"
        class="py-24 bg-white">

        <div
            class="max-w-7xl mx-auto px-6 lg:px-10">

            <div
                class="text-center">

                <span
                    class="text-blue-600 font-bold uppercase">

                    Program Pelatihan

                </span>

                <h2
                    class="text-5xl font-extrabold mt-4">

                    Bidang Kompetensi

                </h2>

                <p
                    class="max-w-3xl mx-auto mt-6 text-slate-600 text-lg">

                    Program pelatihan yang diselenggarakan
                    dirancang untuk memenuhi kebutuhan
                    dunia kerja dan perkembangan teknologi.

                </p>

            </div>

            <div
                class="grid lg:grid-cols-3 gap-8 mt-16">

                <div
                    class="bg-slate-50 rounded-3xl p-8 border">

                    <div class="text-5xl">
                        💻
                    </div>

                    <h3
                        class="text-2xl font-bold mt-6">

                        Multimedia

                    </h3>

                    <p
                        class="mt-4 text-slate-600">

                        Desain grafis, editing video,
                        fotografi, dan produksi media digital.

                    </p>

                </div>

                <div
                    class="bg-slate-50 rounded-3xl p-8 border">

                    <div class="text-5xl">
                        🎥
                    </div>

                    <h3
                        class="text-2xl font-bold mt-6">

                        Content Creator

                    </h3>

                    <p
                        class="mt-4 text-slate-600">

                        Produksi konten kreatif,
                        branding digital,
                        dan pemasaran media sosial.

                    </p>

                </div>

                <div
                    class="bg-slate-50 rounded-3xl p-8 border">

                    <div class="text-5xl">
                        🌐
                    </div>

                    <h3
                        class="text-2xl font-bold mt-6">

                        Teknologi Informasi

                    </h3>

                    <p
                        class="mt-4 text-slate-600">

                        Kompetensi komputer,
                        internet, aplikasi perkantoran,
                        dan teknologi digital.

                    </p>

                </div>

            </div>

        </div>

    </section>
        <!-- FACILITIES -->
    <section
        id="fasilitas"
        class="py-24 bg-slate-100">

        <div
            class="max-w-7xl mx-auto px-6 lg:px-10">

            <div class="text-center">

                <span
                    class="text-blue-600 font-bold uppercase">

                    Fasilitas

                </span>

                <h2
                    class="text-5xl font-extrabold mt-4 text-slate-800">

                    Sarana Pendukung Pelatihan

                </h2>

                <p
                    class="mt-6 text-lg text-slate-600 max-w-3xl mx-auto">

                    Lingkungan belajar yang nyaman dan
                    fasilitas pendukung yang memadai
                    untuk meningkatkan efektivitas pelatihan.

                </p>

            </div>

            <div
                class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mt-16">

                <div
                    class="bg-white rounded-3xl p-8 shadow-lg">

                    <div class="text-5xl">
                        💻
                    </div>

                    <h3
                        class="font-bold text-xl mt-5">

                        Laboratorium Komputer

                    </h3>

                    <p
                        class="mt-3 text-slate-600">

                        Perangkat komputer untuk
                        praktik pembelajaran digital.

                    </p>

                </div>

                <div
                    class="bg-white rounded-3xl p-8 shadow-lg">

                    <div class="text-5xl">
                        🎥
                    </div>

                    <h3
                        class="font-bold text-xl mt-5">

                        Studio Multimedia

                    </h3>

                    <p
                        class="mt-3 text-slate-600">

                        Mendukung produksi konten
                        kreatif dan multimedia.

                    </p>

                </div>

                <div
                    class="bg-white rounded-3xl p-8 shadow-lg">

                    <div class="text-5xl">
                        📶
                    </div>

                    <h3
                        class="font-bold text-xl mt-5">

                        Internet

                    </h3>

                    <p
                        class="mt-3 text-slate-600">

                        Akses internet untuk
                        mendukung proses pembelajaran.

                    </p>

                </div>

                <div
                    class="bg-white rounded-3xl p-8 shadow-lg">

                    <div class="text-5xl">
                        👨‍🏫
                    </div>

                    <h3
                        class="font-bold text-xl mt-5">

                        Instruktur Kompeten

                    </h3>

                    <p
                        class="mt-3 text-slate-600">

                        Dibimbing oleh tenaga
                        pelatih berpengalaman.

                    </p>

                </div>

            </div>

        </div>

    </section>

    <!-- ADVANTAGES -->
    <section
        class="py-24 bg-white">

        <div
            class="max-w-7xl mx-auto px-6 lg:px-10">

            <div
                class="grid lg:grid-cols-2 gap-16 items-center">

                <div>

                    <span
                        class="text-blue-600 font-bold uppercase">

                        Mengapa Memilih Kami

                    </span>

                    <h2
                        class="text-5xl font-extrabold mt-4">

                        Siapkan Masa Depan
                        Bersama BLKK Tanwiriyyah

                    </h2>

                    <div class="space-y-6 mt-10">

                        <div
                            class="flex gap-4">

                            <div
                                class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">

                                ✅

                            </div>

                            <div>

                                <h3
                                    class="font-bold text-lg">

                                    Pelatihan Berbasis Kompetensi

                                </h3>

                                <p
                                    class="text-slate-600">

                                    Materi dirancang sesuai
                                    kebutuhan dunia kerja.

                                </p>

                            </div>

                        </div>

                        <div
                            class="flex gap-4">

                            <div
                                class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">

                                ✅

                            </div>

                            <div>

                                <h3
                                    class="font-bold text-lg">

                                    Dukungan Sertifikasi

                                </h3>

                                <p
                                    class="text-slate-600">

                                    Membantu meningkatkan
                                    kredibilitas kompetensi peserta.

                                </p>

                            </div>

                        </div>

                        <div
                            class="flex gap-4">

                            <div
                                class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">

                                ✅

                            </div>

                            <div>

                                <h3
                                    class="font-bold text-lg">

                                    Lingkungan Belajar Modern

                                </h3>

                                <p
                                    class="text-slate-600">

                                    Mendukung pembelajaran
                                    yang efektif dan nyaman.

                                </p>

                            </div>

                        </div>

                    </div>

                </div>

                <div
                    class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-[40px] p-12 text-white shadow-2xl">

                    <h3
                        class="text-4xl font-extrabold">

                        LMS BLKK Tanwiriyyah

                    </h3>

                    <p
                        class="mt-6 text-blue-100 leading-relaxed text-lg">

                        Sistem Learning Management System
                        yang membantu peserta, instruktur,
                        dan administrator mengelola proses
                        pembelajaran secara efektif,
                        transparan, dan terintegrasi.

                    </p>

                    <a
                        href="{{ route('register') }}"
                        class="inline-block mt-10 px-8 py-4 bg-white text-blue-700 rounded-2xl font-bold shadow-lg">

                        Mulai Belajar

                    </a>

                </div>

            </div>

        </div>

    </section>

    <!-- CTA -->
    <section
        class="py-24 bg-gradient-to-r from-blue-700 to-indigo-800 text-white">

        <div
            class="max-w-5xl mx-auto text-center px-6">

            <h2
                class="text-5xl font-extrabold">

                Tingkatkan Kompetensi Anda Hari Ini

            </h2>

            <p
                class="mt-8 text-xl text-blue-100">

                Bergabung bersama BLKK Tanwiriyyah Cianjur
                dan kembangkan keterampilan untuk
                masa depan yang lebih baik.

            </p>

            <div
                class="flex flex-wrap justify-center gap-5 mt-12">

                <a
                    href="{{ route('register') }}"
                    class="px-8 py-4 rounded-2xl bg-white text-blue-700 font-bold shadow-xl">

                    Register

                </a>

                <a
                    href="{{ route('login') }}"
                    class="px-8 py-4 rounded-2xl border border-white/30 bg-white/10 backdrop-blur-md font-semibold">

                    Login

                </a>

            </div>

        </div>

    </section>

    <!-- FOOTER -->
    <footer
        id="kontak"
        class="bg-slate-900 text-slate-300">

        <div
            class="max-w-7xl mx-auto px-6 lg:px-10 py-16">

            <div
                class="grid lg:grid-cols-3 gap-12">

                <div>

                    <h3
                        class="text-2xl font-bold text-white">

                        BLKK Tanwiriyyah

                    </h3>

                    <p
                        class="mt-5 leading-relaxed">

                        Balai Latihan Kerja Komunitas
                        yang mendukung peningkatan
                        kualitas sumber daya manusia
                        melalui pelatihan dan pengembangan
                        kompetensi kerja.

                    </p>

                </div>

                <div>

                    <h3
                        class="text-xl font-bold text-white">

                        Menu

                    </h3>

                    <ul
                        class="space-y-3 mt-5">

                        <li>
                            <a href="#tentang"
                                class="hover:text-white">
                                Tentang
                            </a>
                        </li>

                        <li>
                            <a href="#program"
                                class="hover:text-white">
                                Program
                            </a>
                        </li>

                        <li>
                            <a href="#fasilitas"
                                class="hover:text-white">
                                Fasilitas
                            </a>
                        </li>

                    </ul>

                </div>

                <div>

                    <h3
                        class="text-xl font-bold text-white">

                        Informasi

                    </h3>

                    <p class="mt-5">
                        Kabupaten Cianjur
                    </p>

                    <p class="mt-2">
                        Jawa Barat
                    </p>

                    <p class="mt-2">
                        Indonesia
                    </p>

                </div>

            </div>

            <div
                class="border-t border-slate-800 mt-12 pt-8 text-center text-slate-500">

                © {{ date('Y') }}
                LMS BLKK Tanwiriyyah Cianjur.
                All Rights Reserved.

            </div>

        </div>

    </footer>

</body>
</html>