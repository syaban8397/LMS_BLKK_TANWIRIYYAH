# LMS BLKK Tanwiriyyah

Sistem Learning Management System untuk **Balai Latihan Kerja Komunitas (BLKK) Tanwiriyyah** — platform pembelajaran vokasi di bawah naungan **Kementerian Ketenagakerjaan RI**.

## Persyaratan

- PHP 8.2+
- Composer
- Node.js 18+
- MySQL / MariaDB (SQLite untuk development/testing)

## Instalasi (Development)

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm install
npm run build
```

Upload logo ke `storage/app/public/images/Logo.png`.

```bash
php artisan serve
# Terminal terpisah: npm run dev
```

## Akun Default (Setelah Seed)

| Field | Nilai |
|---|---|
| Email | `admin@blkk.test` |
| Password | `ChangeMeOnFirstLogin!` |

**Ganti password admin segera setelah login pertama.**

## Deploy Production

### Checklist

```bash
# 1. Environment
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-anda.go.id
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true

# 2. Perintah deploy
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan storage:link
npm ci && npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Verifikasi
php artisan lms:doctor
```

Pastikan `storage/` dan `bootstrap/cache/` writable oleh web server.

### Aset Wajib

| Aset | Lokasi |
|---|---|
| Logo instansi | `storage/app/public/images/Logo.png` |
| Template sertifikat | `public/images/certificates/` |
| Build frontend | `public/build/` (dari `npm run build`) |

### Keamanan File

File sensitif (submission, materi, tugas, foto profil, PDF sertifikat) disimpan di disk **private** dan diunduh lewat route autentikasi `/secure/*`. Symlink `public/storage` hanya untuk logo publik.

## Fitur Utama

- Manajemen program, kelas, peserta, instruktur
- Stream kelas: materi, tugas, pengumuman, absensi
- Penilaian manual instruktur (tanpa ujian online)
- Sertifikat PDF bilingual + verifikasi QR publik
- Laporan Excel & PDF
- Dukungan bahasa Indonesia / English
- Reset password via **Email + NIK** (tanpa ketergantungan SMTP)

## Reset Password

Alur: verifikasi Email + NIK → token aman (15 menit) → buat password baru.  
SMTP **tidak wajib** untuk fitur ini. Konfigurasi SMTP di Admin Settings hanya untuk kebutuhan email opsional ke depan.

## Pemeriksaan Kesiapan

```bash
php artisan lms:doctor
```

Memeriksa APP_KEY, storage link, logo, asset sertifikat, dan build Vite.

## Testing

```bash
php artisan test
```

72+ automated tests: auth, role access, enrollment, tugas, absensi, sertifikat, laporan, keamanan file.

## Health Check

Endpoint bawaan Laravel: `GET /up`

## Lisensi & Naungan

Platform ini dikembangkan untuk operasional BLKK Tanwiriyyah. Penyelenggaraan pelatihan mengacu pada ketentuan **Kementerian Ketenagakerjaan RI**.
