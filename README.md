# LMS BLKK Tanwiriyyah

Sistem Learning Management System untuk Balai Latihan Kerja Komunitas (BLKK) Tanwiriyyah.

## Persyaratan

- PHP 8.2+
- Composer
- Node.js 18+
- MySQL / MariaDB (atau SQLite untuk development)

## Instalasi

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

Upload logo ke `storage/app/public/images/Logo.png`, lalu pastikan symlink `public/storage` aktif.

```bash
npm install
node --max-old-space-size=8192 ./node_modules/vite/bin/vite.js build
```

## Menjalankan

```bash
php artisan serve
```

## Akun Default

Setelah `php artisan db:seed`, login admin:

- Email: `admin@blkk.test`
- Password: (lihat `database/seeders/AdminSeeder.php`)

## Deploy Production

1. Set `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL` ke domain production
2. `php artisan migrate --force`
3. `php artisan storage:link`
4. Build assets Vite
5. Set permission `storage/` dan `bootstrap/cache/` writable
6. Konfigurasi mail SMTP untuk notifikasi (opsional)

## Fitur Utama

- Manajemen program, kelas, peserta, instruktur
- Materi, tugas, submission, penilaian
- Absensi dan laporan Excel
- Sertifikat PDF + verifikasi QR
- Laporan peserta data lengkap dari database
- Dukungan bahasa Indonesia / English

## Bahasa

Pengguna dapat mengganti bahasa via tombol **ID / EN** di appbar atau halaman guest.
